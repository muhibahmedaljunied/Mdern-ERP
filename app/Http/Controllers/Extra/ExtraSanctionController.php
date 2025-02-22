<?php

namespace App\Http\Controllers\Extra;

use App\Exports\ExtraSanctionExport;
use App\Repository\StaffSaction\StaffExtraSanctionRepository;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Repository\HR\ExtraSanctionRepository;
use App\Services\CoreStaffService;
use App\Models\ExtraType;
use App\Models\Part;
use App\Models\SanctionDiscount;
use App\Http\Controllers\Controller;
use App\Imports\ExtraSanctionImport;
use App\Models\ExtraSanction;
use App\Models\Staff;
use App\Models\StaffSanction;
use App\Services\DailyStockService;
use App\Services\PayrollService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Facades\Excel;

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
        // $this->check_type($request);
        // ----------------------------------------------------------------------------------------------------------------
        // $this->filter_date($request);
        // ----------------------------------------------------------------------------------------------------------------
        $this->staff_attendance($request);
        // ----------------------------------------------------------------------------------------------------------------
        $this->final_sanction($request);

        // dd($this->core->attendances);
        return response()->json([
            'list' => $this->core->attendances,

        ]);
    }




    // public function check_type($request)
    // {

    //     $request->staff_id = collect($request->staff_id)->toArray();
    //     // ----------------------------------------------------------------------------------------------------------------

    //     if ($request->extra_type_code == 'before_work') {

    //         $this->core->attendances =  DB::table('attendances');

    //         $this->core->attendances = $this->core->attendances->where('attendance_status', 1)
    //             ->addSelect(['attendance_details' => function (Builder $builder) {
    //                 $builder->from('attendance_details')
    //                     ->selectRaw('sum(extra) as extra')
    //                     ->whereColumn('attendances.id', 'attendance_details.attendance_id');
    //             }])
    //             ->paginate();
    //     }

    //     if ($request->extra_type_code == 'after_work') {

    //         $this->core->attendances =  DB::table('attendances');

    //         $this->core->attendances = $this->core->attendances->where('attendance_status', 1)
    //             ->addSelect(['attendance_details' => function (Builder $builder) {
    //                 $builder->from('attendance_details')
    //                     ->selectRaw('sum(extra_after) as extra_after')
    //                     ->whereColumn('attendances.id', 'attendance_details.attendance_id');
    //             }])
    //             ->paginate();
    //     }
    // }


    // public function filter_date($request)
    // {



    //     $request->staff_id = collect($request->staff_id)->toArray();


    //     $this->core->array_filter = [];
    //     $year = intval(date("2024"));
    //     $month = intval(date("11"));
    //     $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);


    //     for ($i = 1; $i < $days; $i++) {

    //         if ($this->get_day_name("$year-$month-$i") == $request->extra_type_code) {

    //             $this->core->array_filter[$i] =  $year . '-' . $month . '-' . $i;
    //         }
    //     }
    // }

    public function staff_attendance($request)
    {






        $this->core_extra($request->date);
        $this->before_work($request->date);
        $this->after_work($request->date);




        $this->core->attendances = $this->core->attendances->where('revenue', $request->extra_part_duration)
            // ->whereIn('attendance_date', $this->core->array_filter)
            ->join('staff', 'staff.id', '=', 'attendances.staff_id');

        // if (count($request->staff_id) > 0) {
        if ($request->staff_id) {

            $this->core->attendances = $this->core->attendances->where('staff.id', $request->staff_id);
        }




        $this->core->attendances = $this->core->attendances->orderBy('revenue')
            ->paginate();
    }


    public function core_extra($date)
    {


        $this->core->attendances = DB::table('attendances')
            ->select(
                'staff.name',
                'staff.id as staff_id',
                DB::raw('count(attendances.id) as attendance'),
                'revenue',
            )
            ->groupBy(
                'staff.name',
                'staff.id',
                'revenue',
            );


        if ($date) {

            $this->core->attendances = $this->core->attendances->where('attendances.attendance_date', $date);
        }
    }
    public function after_work()
    {

        if ($request->extra_type_code == 'After_work') {

            $this->core->attendances = $this->core->attendances->Join(
                DB::raw('(SELECT attendance_id,SUM(extra_after) AS revenue FROM attendance_details 
                    GROUP BY attendance_id) AS n'),
                'n.attendance_id',
                '=',
                'attendances.id'
            );
        }
    }
    public function before_work()
    {
     
        if ($request->extra_type_code == 'Before_work') {

            $this->core->attendances = $this->core->attendances->Join(
                DB::raw('(SELECT attendance_id,SUM(extra) AS revenue FROM attendance_details 
                    GROUP BY attendance_id) AS n'),
                'n.attendance_id',
                '=',
                'attendances.id'
            );
        }
    }
    public function final_sanction($request)
    {

        // dd($request->extra_type_id);

        foreach ($this->core->attendances as $value) {





            $extra =  collect(ExtraSanction::join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
                ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
                ->where('extra_sanctions.part_id', $request->extra_part_id)
                ->where('extra_sanctions.extra_type_id', $request->extra_type_id)
                ->where('extra_sanctions.iteration', $value->attendance)
                ->select(
                    'extra_sanctions.*',
                    'sanction_discounts.name',
                    'extra_types.name as extra_name'
                )
                ->get())->toArray();



            if (count($extra) > 0) {


                foreach ($extra as $key => $value2) {

                    $staff_sanction =  collect(StaffSanction::where('sanctionable_type', 'App\Models\ExtraSanction')
                        ->where('sanctionable_id', $value2['id'])
                        ->where('staff_id', $value->staff_id)
                        ->select(
                            '*'
                        )
                        ->get())->toArray();



                    if (count($staff_sanction) > 0) {   //if found staff_sanction do not return sanction

                        $value->staff_sanction[$key] = $staff_sanction;
                    } else {

                        $value->extra[$key] = $value2;
                    }
                }
            }
        }



        // dd($this->core->attendances);
        // foreach ($this->core->attendances as $value) {

        //     $extra =  DelaySanction::with(['staff_sanction' => function ($query) use ($request) {

        //         $query->where('staff_sanctions.sanctionable_type', 'App\Models\DelaySanction')->select('*');
        //     }])
        //         ->join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
        //         ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
        //         ->where('extra_sanctions.part_id', $request->extra_part_id)
        //         ->where('extra_sanctions.extra_type_id', $request->extra_type_id)
        //         ->where('extra_sanctions.iteration', $value->attendance);

        //     $extra = $extra->select(
        //         'extra_sanctions.*',
        //         'sanction_discounts.*',
        //         'extra_types.name as extra_name'
        //     )
        //         ->get();

        //     $value->part = $request->extra_part_duration;

        //     if (count(collect($extra)->toArray()) > 0) {

        //         $value->extra = $extra;
        //     }
        // }

        // dd(count(collect($extra)->toArray()));
    }


    // public function filter_date($request)
    // {

    //     // ----------------------------------------------------------------------------------------------------------------

    //     foreach ($this->core->attendances as $key => $value) {

    //         // Tuesday,Thursday,Saturday,Monday,Wednesday,Friday,Sunday
    //         if (
    //             $value->attendance_details == $request->extra_part_duration
    //         ) {

    //             if (!in_array($value->attendance_date, $this->core->array_filter)) {

    //                 $this->core->array_filter[$key] =  $value->attendance_date;
    //             }
    //         }
    //     }

    //     // dd($array_filter);

    // }

    // public function staff_attendance($request)
    // {


    //     $this->core->attendances =  Staff::with('staff_sanction');
    //     if (count($request->staff_id) > 0) {

    //         $this->core->attendances = $this->core->attendances->where('staff.id', $request->staff_id[0]);
    //     }
    //     $this->core->attendances = $this->core->attendances->addSelect(['attendance' => function (Builder $builder) {
    //         $builder->from('attendances')
    //             ->selectRaw('count(*) as attendance')
    //             ->where('attendance_status',1)
    //             ->whereColumn('staff.id', 'attendances.staff_id')
    //             ->whereIn('attendance_date', $this->core->array_filter);
    //     }])


    //         ->paginate();

    //     // dd($attendances);

    // }




    // public function final_sanction($request)
    // {



    //     $extrat =  DB::table('extra_sanctions')
    //         ->join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
    //         ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
    //         ->where('extra_sanctions.part_id', $request->extrat_part_id)
    //         ->where('extra_sanctions.extra_type_id', $request->extrat_type_id)
    //         ->where('extra_sanctions.iteration', $value->attendance);

    //     if ($check == 'positive') {

    //         $extrat = $extrat->where('extra_sanctions.id', '!=', $value2->sanctionable_id);
    //     }

    //     $extrat = $extrat->select(
    //         'extra_sanctions.*',
    //         'sanction_discounts.*',
    //         'extra_types.name as extrat_name'
    //     )->get();

    //     $value->part = $request->extrat_part_duration;
    //     $value->extrat = $extrat;
    // }




    public function apply_extra_sanction_attendance(Request $request)
    {


        // unset( $array_name['key_to_be_removed'] );
        foreach ($request->sanction as $value) {

            // AbsenceSanction::find($value->id);
            // dd($value);
            $extra = new StaffSanction();
            $extra->staff_id = $request->staff_id;
            $extra->sanctionable()->associate(ExtraSanction::find($value['id']));
            $extra->date = $request->date;
            $extra->save();
        }
        // dd($request->all());
        return response()->json([
            'status' => 'successfully',

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
            ->join('group_account_details', 'group_account_details.group_account_id', '=', 'group_accounts.id')

            ->where('group_types.code', 'extra')
            ->select(
                'group_accounts.*',
                'group_account_details.account_id as account_second_id',

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
    public function import()
    {

        Excel::import(new ExtraSanctionImport, storage_path('extra_sanction.xlsx'));

        return response()->json([
            'status' =>
            'The file has been excel/csv imported'
        ]);
    }


    public function export()
    {

        Excel::download(new ExtraSanctionExport, 'extra_sanction.xlsx');

        return response()->json([
            'status' =>
            'The file has been excel/csv exporteded'
        ]);
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