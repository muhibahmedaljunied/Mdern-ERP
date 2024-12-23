<?php

namespace App\Http\Controllers\Extra;

use App\Repository\HR\ExtraSanctionRepository;
use App\Services\CoreStaffService;
use App\Models\ExtraType;
use App\Models\Part;
use App\Models\SanctionDiscount;
use App\Http\Controllers\Controller;
use App\Models\ExtraSanction;
use App\Models\StaffSanction;
use App\Repository\StaffSaction\StaffExtraSanctionRepository;
use App\Services\DailyStockService;
use App\Services\PayrollService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\Builder;

class ExtraSanctionController extends Controller
{


    public function __construct(
        protected CoreStaffService $core,
        protected ExtraSanctionRepository $hr,
        public DailyStockService $daily,
    ) {}
    public function index()
    {


        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });




        return response()->json([
            'list' => $this->get_extra_sanction(),
            'extra_types' => ExtraType::all(),
            'staffs' => $staffs,
            'discount_types' => SanctionDiscount::all(),
            'extra_parts' => Part::all(),
        ]);
    }


    public function extra_sanction_attendance(Request $request)
    {

        // dd(date('l', strtotime('2024-11-19')), '2024-11-19');


        // dd($request->all());
        $array_filter = [];
        if ($request->extra_type_code == 'before_work') {

            $attendances =  DB::table('attendances');

            if ($request->staff_id) {

                $attendances = $attendances->where('staff_id', $request->staff_id);
            }


            $attendances = $attendances->where('attendance_status', 1)
                ->addSelect(['attendance_details' => function (Builder $builder) {
                    $builder->from('attendance_details')
                        ->selectRaw('sum(extra) as extra')
                        ->whereColumn('attendances.id', 'attendance_details.attendance_id');
                }])
                ->get();
        }

        if ($request->extra_type_code == 'after_work') {

            $attendances =  DB::table('attendances');

            if ($request->staff_id) {

                $attendances = $attendances->where('staff_id', $request->staff_id);
            }
            $attendances = $attendances->where('attendance_status', 1)
                ->addSelect(['attendance_details' => function (Builder $builder) {
                    $builder->from('attendance_details')
                        ->selectRaw('sum(extra_after) as extra_after')
                        ->whereColumn('attendances.id', 'attendance_details.attendance_id');
                }])
                ->get();
        }


        // if ($request->extra_type_code != 'after_work' || $request->extra_type_code == 'before_work') {

        //     $attendances =  DB::table('attendances')
        //         ->where('attendance_status', 1)
        //         ->addSelect(['attendance_details' => function (Builder $builder) {
        //             $builder->from('attendance_details')
        //                 ->selectRaw('sum(extra_after) as extra_after')
        //                 ->whereColumn('attendances.id', 'attendance_details.attendance_id');
        //         }])
        //         ->paginate();
        // }


        // dd($attendances);
        // ----------------------------------------------------------------------------------------------------------------

        foreach ($attendances as $key => $value) {


            // Tuesday,Thursday,Saturday,Monday,Wednesday,Friday,Sunday
            if (
                $value->attendance_details == $request->extra_part_duration
            ) {

                if (!in_array($value->attendance_date, $array_filter)) {

                    $array_filter[$key] =  $value->attendance_date;
                }
            }
        }

        // dd($array_filter);

        // ----------------------------------------------------------------------------------------------------------------

        $attendances =  DB::table('staff')
            ->addSelect(['attendance' => function (Builder $builder) use ($array_filter) {
                $builder->from('attendances')
                    ->selectRaw('count(*) as attendance')
                    ->whereColumn('staff.id', 'attendances.staff_id')
                    ->whereIn('attendance_date', $array_filter);
            }])


            ->get();

        // dd($attendances);
        // ----------------------------------------------------------------------------------------------------------------

        foreach ($attendances as $key => $value) {


            // dd($request->extra_part_id, $request->extra_type_id, $value->attendance);
            $extra =  DB::table('extra_sanctions')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
                ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
                ->where('extra_sanctions.part_id', $request->extra_part_id)
                ->where('extra_sanctions.extra_type_id', $request->extra_type_id)
                ->where('extra_sanctions.iteration', $value->attendance)
                ->select(
                    'extra_sanctions.*',
                    'sanction_discounts.*',
                    'extra_types.name as extra_name'
                )->get();

            $value->part = $request->extra_part_duration;
            $value->extra = $extra;
            // dd($extra);
        }

        // ----------------------------------------------------------------------------------------------------------------


        return response()->json([
            'list' => $attendances,

        ]);
    }



    public function get_extra_sanction()
    {

        $extra_sanctions =  DB::table('extra_sanctions')
            ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
            ->join('parts', 'parts.id', '=', 'extra_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
            ->select('extra_sanctions.*', 'parts.name as duration', 'extra_types.name as extra', 'sanction_discounts.name as discount_name')
            ->paginate(10);

        return $extra_sanctions;
    }

    public function get_staff_extra_sanction(Request $request)
    {


        $group_account =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->join('group_accounts', 'groups.id', '=', 'group_accounts.group_id')
            ->where('group_types.code', 'extra')
            ->select(
                'group_accounts.*',

            )
            ->get();


        $staff = StaffSanction::with(['Sanctionable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                ExtraSanction::class => function ($query) {
                    $query->join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id');
                    $query->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id');
                    $query->join('parts', 'parts.id', '=', 'extra_sanctions.part_id');
                    $query->select(
                        'extra_sanctions.*',
                        'parts.name as part_name',
                        'extra_types.name as type_name',
                        'sanction_discounts.name as discount_name'
                    );
                },
            ]);
        }])
            ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')
            // ->join('extras', 'extras.staff_id', '=', 'staff.id')
            ->where('sanctionable_type', 'App\\Models\\ExtraSanction')
            ->select(
                'staff_sanctions.date as sanction_date',
                'staff_sanctions.sanctionable_type',
                'staff_sanctions.sanctionable_id',
                'staff.name',
                'staff.id',
                'staff_sanctions.status',
                // 'extras.id as extra_id'


            )
            ->paginate();

        return response()->json([
            'list' => $staff,
            'group_account' => $group_account,
        ]);
    }
    // public function get_staff_extra_sanction(Request $request)
    // {


    //     $staff_extra_sanction = DB::table('extras')
    //         ->join('staff', 'staff.id', '=', 'extras.staff_id')
    //         ->join('extra_types', 'extra_types.id', '=', 'extras.extra_type_id')
    //         ->join('extra_details', 'extra_details.extra_id', '=', 'extras.id')
    //         ->join('extra_sanctions', 'extra_sanctions.id', '=', 'extra_details.extra_sanction_id')
    //         ->select(
    //             'staff.id as staff_id',
    //             'staff.name as staff_name',
    //             'extras.id as extra_id',
    //             'extras.date',
    //             'extras.number_hours as number_hours',
    //             'extra_details.*', 
    //             'extra_sanctions.id as sanction_id', 
    //             'extra_sanctions.sanction',
    //             'extra_types.name as extra_type',
    //             'extra_types.id as extra_type_id'
    //             )
    //         ->get();


    //         // dd($staff_extra_sanction);
    //     return response()->json(['list' => $staff_extra_sanction]);
    // }




    public function store(Request $request)
    {

        $this->core->data = $request->all();

        // dd($this->core->data);

        try {

            DB::beginTransaction();

            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);
                $this->hr->handle();
            }
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "purchase created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }


        Cache::forget('extra_sanctions_index');
        Cache::forget('staff');
        return response()->json(['message' => $request->all()]);
    }

    public function change_status(
        Request $request,
        StaffExtraSanctionRepository $staff_sanction,
        PayrollService $payroll

    ) {


        $this->core->data = $request->all();

        // dd($request->all());
        try {




            DB::beginTransaction();

            $staff_sanction->update_sanction();
            $payroll->payroll('total_extra_sanction');

            $this->daily->daily()->exicute('debit')->exicute('credit');

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Extra Created Successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
    }
}


     // tap(StaffSanction::where([
            //     'staff_id' => $request->staff,
            //     'sanctionable_id' => $request->sanctionable_id,
            //     'sanctionable_type' => $request->sanctionable_type,
            //     'date' => $request->date


            // ]))
            //     ->update(['status' => $request->status])
            //     ->get('id');