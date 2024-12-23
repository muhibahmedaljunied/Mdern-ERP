<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Http\Controllers\Controller;
use App\Models\StaffSanction;
use App\Models\LeaveSanction;
use Illuminate\Support\Facades\Cache;
use App\Repository\HR\LeaveSanctionRepository;
use App\Models\SanctionDiscount;
use App\Services\CoreStaffService;
use App\Models\Part;
use App\Models\LeaveType;
use App\Repository\StaffSaction\StaffLeaveSanctionRepository;
use App\Services\PayrollService;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveSanctionController extends Controller
{

    public function __construct(
        protected CoreStaffService $core,
        protected LeaveSanctionRepository $hr,
    ) {}

    public function index()
    {


        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });


        $this->get_attendance();

        return response()->json([
            'list' => $this->get_leaveout_sanction(),
            'leaveout_types' => LeaveType::all(),
            'staffs' => $staffs,
            'discount_types' => SanctionDiscount::all(),
            'leaveout_parts' => Part::all()
        ]);
    }

    public function get_staff_leaveout()
    {

        $minutes = 60;
        $staffs = Cache::remember('staff', $minutes, function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------

        return response()->json([
            'leaveout_types' => LeaveType::all(),
            'leaveout_parts' => Part::all(),
            'staffs' => $staffs
        ]);
    }


    public function leaveout_sanction_attendance(Request $request)
    {

        // dd(date('l', strtotime('2024-11-19')), '2024-11-19');           
        // Tuesday,Thursday,Saturday,Monday,Wednesday,Friday,Sunday

        // dd($request->all());
        $array_filter = [];
        $array_filter2 = [];

        $attendances =  DB::table('attendances');
        if ($request->staff_id) {

            $attendances = $attendances->where('staff_id', $request->staff_id);
        }
        $attendances = $attendances->where('staff_id', $request->staff_id)
            ->where('attendance_status', 1)
            ->addSelect(['attendance_details' => function (Builder $builder) {
                $builder->from('attendance_details')
                    ->selectRaw('sum(leaveout)')
                    ->whereColumn('attendances.id', 'attendance_details.attendance_id');
            }])
            ->get();

        // dd($attendances);
        // ----------------------------------------------------------------------------------------------------------------
        foreach ($attendances as $key => $value) {

            // dd($value);
            if (
                date('l', strtotime($value->attendance_date)) == $request->leaveout_type_code
                &&
                $value->attendance_details == $request->leaveout_part_duration
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
            ->get();

        // dd($attendances);
        // ----------------------------------------------------------------------------------------------------------------



        foreach ($attendances as $key => $value) {


            // dd($request->leaveout_part_id, $request->leaveout_type_id, $value->attendance);
            $leaveout =  DB::table('leave_sanctions')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'leave_sanctions.sanction_discount_id')
                ->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id')
                ->where('leave_sanctions.part_id', $request->leaveout_part_id)
                ->where('leave_sanctions.leave_type_id', $request->leaveout_type_id)
                ->where('leave_sanctions.iteration', $value->attendance)
                ->select(
                    'leave_sanctions.*',
                    'sanction_discounts.*',
                    'leave_types.name as leaveout_name'
                )->get();

            $value->part = $request->leaveout_part_duration;
            $value->leaveout = $leaveout;
            // dd($leaveout);
        }

        // ----------------------------------------------------------------------------------------------------------------


        // dd($attendances);
        return response()->json([
            'list' => $attendances,

        ]);
    }
    public function get_leaveout_sanction()
    {



        $leave_sanctions = DB::table('leave_sanctions')
            ->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id')
            ->join('parts', 'parts.id', '=', 'leave_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'leave_sanctions.sanction_discount_id')
            ->select('leave_sanctions.*', 'leave_types.name as leaveout', 'parts.name as duration', 'sanction_discounts.name as discount_name')
            ->paginate(10);



        return $leave_sanctions;
    }

    public function get_attendance()
    {


        $attendances = DB::table('attendances')
            ->join('attendance_details', 'attendances.id', '=', 'attendance_details.attendance_id')
            ->select(
                'attendances.*',

            )
            ->paginate(10);
    }


    public function get_staff_leaveout_sanction()
    {

        $staff = StaffSanction::with(['Sanctionable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                LeaveSanction::class => function ($query) {
                    $query->join('sanction_discounts', 'sanction_discounts.id', '=', 'leave_sanctions.sanction_discount_id');
                    $query->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id');
                    $query->join('parts', 'parts.id', '=', 'leave_sanctions.part_id');
                    $query->select(
                        'leave_sanctions.*',
                        'leave_types.name as type_name',
                        'parts.name as part_name',
                        'sanction_discounts.name as discount_name'
                    );
                },
            ]);
        }])
            ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')
            ->where('sanctionable_type', 'App\\Models\\LeaveSanction')
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

            $this->core->setValue($value);
            $this->hr->handle();
        }
        Cache::forget('leave_sanctions_index');

        return response()->json(['message' => $request->all()]);
    }

    public function change_status(
        Request $request,
        StaffLeaveSanctionRepository $staff_sanction,
        PayrollService $payroll
    ) {



        // dd($request->all());
        $this->core->data = $request->all();
        try {

            DB::beginTransaction();

            $staff_sanction->update_sanction();
            $payroll->payroll('total_leaveout_sanction');


            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Leave Created Successfully",
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
