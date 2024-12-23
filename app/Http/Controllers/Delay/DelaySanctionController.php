<?php

namespace App\Http\Controllers\Delay;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Models\SanctionDiscount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DelaySanction;
use Illuminate\Support\Facades\Cache;
use App\Services\CoreStaffService;
use App\Repository\HR\DelaySanctionRepository;
use App\Models\DelayType;
use App\Models\Part;
use App\Models\StaffSanction;
use App\Repository\StaffSaction\StaffDelaySanctionRepository;
use App\Services\PayrollService;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class DelaySanctionController extends Controller
{


    public function __construct(
        protected DelaySanctionRepository $hr,
        protected CoreStaffService $core,

    ) {}
    public function index()
    {


        $minutes = 60;
        $staffs = Cache::remember('staff', $minutes, function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------

        return response()->json([
            'list' => $this->get_delay_sanction(),
            'delay_types' => DelayType::all(),
            'delay_parts' => Part::all(),
            'staffs' => $staffs,
            'discount_types' => SanctionDiscount::all()
        ]);
    }


    public function delay_sanction_attendance(Request $request)
    {

        // dd(date('l', strtotime('2024-11-19')), '2024-11-19');           
        // Tuesday,Thursday,Saturday,Monday,Wednesday,Friday,Sunday

        // dd($request->staff_id);
        $array_filter = [];
        $array_filter2 = [];

        $attendances =  DB::table('attendances');

        if ($request->staff_id) {

            $attendances = $attendances->where('staff_id', $request->staff_id);
        }


        $attendances = $attendances->where('attendance_status', 1)
            ->addSelect(['attendance_details' => function (Builder $builder) {
                $builder->from('attendance_details')
                    ->selectRaw('sum(delay) as delay')
                    ->whereColumn('attendances.id', 'attendance_details.attendance_id');
            }])
            ->get();

        // dd($attendances);
        // ----------------------------------------------------------------------------------------------------------------

        foreach ($attendances as $key => $value) {

            // dd($value);
            if (
                date('l', strtotime($value->attendance_date)) == $request->delay_type_code &&
                $value->attendance_details == $request->delay_part_duration
            ) {

                if (!in_array($value->attendance_date, $array_filter)) {

                    $array_filter[$key] =  $value->attendance_date;
                    $array_filter2[$key] =  date('l', strtotime($value->attendance_date));
                }
            }
        }

        // dd($array_filter,$array_filter2);
        // ----------------------------------------------------------------------------------------------------------------

        $attendances =  DB::table('staff')
            ->addSelect(['attendance' => function (Builder $builder) use ($array_filter) {
                $builder->from('attendances')
                    ->selectRaw('count(*) as attendance')
                    ->whereColumn('staff.id', 'attendances.staff_id')
                    ->whereIn('attendance_date', $array_filter);
            }])
            ->paginate();

        // dd($attendances);
        // ----------------------------------------------------------------------------------------------------------------



        foreach ($attendances as $key => $value) {


            // dd($request->delay_part_id, $request->delay_type_id, $value->attendance);
            $delay =  DB::table('delay_sanctions')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
                ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
                ->where('delay_sanctions.part_id', $request->delay_part_id)
                ->where('delay_sanctions.delay_type_id', $request->delay_type_id)
                ->where('delay_sanctions.iteration', $value->attendance)
                ->select(
                    'delay_sanctions.*',
                    'sanction_discounts.*',
                    'delay_types.name as delay_name'
                )->get();

            $value->part = $request->delay_part_duration;
            $value->delay = $delay;
            // dd($delay);
        }

        // ----------------------------------------------------------------------------------------------------------------


        // dd($attendances);
        return response()->json([
            'list' => $attendances,

        ]);
    }

    public function get_delay_sanction()
    {


        $delay_sanctions =  DB::table('delay_sanctions')
            ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
            ->join('parts', 'parts.id', '=', 'delay_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
            ->select(
                'delay_sanctions.*',
                'delay_types.name as delay',
                'parts.name as duration',
                'sanction_discounts.name as discount_name'
            )
            ->paginate(10);


        $delay_sanctions = Cache::rememberForever('delay_sanctions_index', function () {

            return DB::table('delay_sanctions')
                ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
                ->join('parts', 'parts.id', '=', 'delay_sanctions.part_id')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
                ->select(
                    'delay_sanctions.*',
                    'delay_types.name as delay',
                    'parts.name as duration',
                    'sanction_discounts.name as discount_name'
                )
                ->paginate(10);
        });

        return $delay_sanctions;
    }


    public function get_staff_delay_sanction(Request $request)
    {


        $staff = StaffSanction::with(['Sanctionable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                DelaySanction::class => function ($query) {
                    $query->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id');
                    $query->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id');
                    $query->join('parts', 'parts.id', '=', 'delay_sanctions.part_id');
                    $query->select(
                        'delay_sanctions.*',
                        'delay_types.name as type_name',
                        'parts.name as part_name',
                        'sanction_discounts.name as discount_name'
                    );
                },
            ]);
        }])
            ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')


            ->where('sanctionable_type', 'App\\Models\\DelaySanction')
            ->select(
                'staff_sanctions.date as sanction_date',
                'staff_sanctions.sanctionable_type',
                'staff_sanctions.sanctionable_id',
                'staff.name',
                'staff.id',
                'staff_sanctions.status'

            )
            ->paginate();

        return response()->json(['list' => $staff]);
    }


    public function store(Request $request)
    {
        $this->core->data = $request->all();

        foreach ($request->post('count') as $value) {

            $this->core->value = $value;

            $this->hr->handle();

            // }
        }

        Cache::forget('delay_sanctions_index');
        return response()->json(['message' => $request->all()]);
    }

    public function change_status(
        Request $request,
        StaffDelaySanctionRepository $staff_sanction,
        PayrollService $payroll
    ) {

        // dd($request->all());
        $this->core->data = $request->all();

        try {

            DB::beginTransaction();

            $staff_sanction->update_sanction();

            $payroll->payroll('total_delay_sanction');



            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Delay Created Successfully",
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