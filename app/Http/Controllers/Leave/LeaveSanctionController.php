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
    function get_day_name($date)
    {
        // Convert the date to a timestamp
        $timestamp = strtotime($date);
        // Return the day name
        return date('D', $timestamp);
    }

    public function leaveout_sanction_attendance(Request $request)
    {

        // dd(date('l', strtotime('2024-11-19')), '2024-11-19');           
        // Tuesday,Thursday,Saturday,Monday,Wednesday,Friday,Sunday
        // dd($request->all());
        $this->filter_date($request);
        // ----------------------------------------------------------------------------------------------------------------
        $this->staff_attendance($request);
        // ----------------------------------------------------------------------------------------------------------------
        $this->final_sanction($request);



        // dd($this->core->attendances);
        return response()->json([
            'list' => $this->core->attendances,

        ]);
    }



    public function filter_date($request)
    {

        $request->staff_id = collect($request->staff_id)->toArray();



        $this->core->array_filter = [];
        $year = intval(date("2024"));
        $month = intval(date("11"));
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);


        for ($i = 1; $i < $days; $i++) {

            if ($this->get_day_name("$year-$month-$i") == $request->leaveout_type_code) {

                $this->core->array_filter[$i] =  $year . '-' . $month . '-' . $i;
            }
        }


    }

    public function staff_attendance($request)
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
            )
            ->Join(
                DB::raw('(SELECT attendance_id,SUM(Leaveout) AS revenue FROM attendance_details 
                GROUP BY attendance_id) AS n'),
                'n.attendance_id',
                '=',
                'attendances.id'
            )
            ->where('revenue', $request->leaveout_part_duration)
            ->whereIn('attendance_date', $this->core->array_filter)
            ->join('staff', 'staff.id', '=', 'attendances.staff_id');

        if (count($request->staff_id) > 0) {

            $this->core->attendances = $this->core->attendances->where('staff.id', $request->staff_id[0]);
        }
        $this->core->attendances = $this->core->attendances->orderBy('revenue')
            ->paginate();



    }


    public function final_sanction($request)
    {

     

        foreach ($this->core->attendances as $value) {





            $Leaveout =  collect(LeaveSanction::join('sanction_discounts', 'sanction_discounts.id', '=', 'Leave_sanctions.sanction_discount_id')
                ->join('Leave_types', 'Leave_types.id', '=', 'Leave_sanctions.Leave_type_id')
                ->where('Leave_sanctions.part_id', $request->leaveout_part_id)
                ->where('Leave_sanctions.Leave_type_id', $request->leaveout_type_id)
                ->where('Leave_sanctions.iteration', $value->attendance)
                ->select(
                    'Leave_sanctions.*',
                    'sanction_discounts.name',
                    'Leave_types.name as Leaveout_name'
                )
                ->get())->toArray();



            if (count($Leaveout) > 0) {


                foreach ($Leaveout as $key => $value2) {

                    $staff_sanction =  collect(StaffSanction::where('sanctionable_type', 'App\Models\LeaveSanction')
                        ->where('sanctionable_id', $value2['id'])
                        ->where('staff_id', $value->staff_id)
                        ->select(
                            '*'
                        )
                        ->get())->toArray();



                    if (count($staff_sanction) > 0) {   //if found staff_sanction do not return sanction

                        $value->staff_sanction[$key] = $staff_sanction;
                    } else {

                        $value->Leaveout[$key] = $value2;
                    }
                }
            }



        }




    }





  

    public function apply_leave_sanction_attendance(Request $request)
    {



        // dd($request->all());
        // unset( $array_name['key_to_be_removed'] );
        foreach ($request->sanction as $value) {

            // AbsenceSanction::find($value->id);
            // dd($value);
            $leave = new StaffSanction();
            $leave->staff_id = $request->staff_id;
            $leave->sanctionable()->associate(LeaveSanction::find($value['id']));
            $leave->date = $request->date;
            $leave->save();
        }

        // dd($request->all());
        return response()->json([
            'status' => 'successfully',

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
            $payroll->payroll('total_leave_sanction');


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
