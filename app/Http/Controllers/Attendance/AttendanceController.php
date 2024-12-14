<?php

namespace App\Http\Controllers\Attendance;

use App\Services\core\CoreStaffAttendanceService;
use App\Traits\Details\DetailsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Services\AttendanceService;
use App\Models\Staff;
use App\Models\WorkSystem;
use App\Models\WorkType;


class AttendanceController extends Controller

{
    use DetailsTrait;




    public function index(Request $request)
    {


        $staff_list = Cache::rememberForever('staff_eager_load', function () {

            return DB::table('staff')
                ->select('staff.id as staff_id', 'staff.name')
                ->paginate(10);
        });

        $minutes = 60;
        $staffs = Cache::remember('staff', $minutes, function () {
            return DB::table('staff')->get();
        });

        $work_system_types = DB::table('work_system_types')
            ->select('work_system_types.name', 'work_system_types.id')
            ->get();



        return response()->json([

            'list' => $staff_list,
            'staffs' => $staffs,
            'work_system_types' => $work_system_types,

        ]);
    }


    public function report(Request $request)
    {

        $staffs = Staff::all();
        $work_systems = WorkType::all();
        $attenances = Cache::rememberForever('attenances', function () {
            return Attendance::with([

                'attendance_details' => function ($query) {
                    $query->select('*');
                }

            ])->paginate(10);
        });

        return response()->json(['staffs' => $staffs, 'list' => $attenances, 'work_systems' => $work_systems]);
    }
    public function get_period(Request $request)
    {



        $periods = WorkSystem::where('work_systems.work_system_type_id', $request->id)
            ->join('work_system_types', 'work_systems.work_system_type_id', '=', 'work_system_types.id')
            ->join('period_times', 'period_times.id', '=', 'work_systems.period_time_id')
            ->select(
                'period_times.id as period_id',
                'period_times.*',

            )
            ->get();

        return response()->json([
            'periods' => $periods,
        ]);
    }

    public function search(Request $request)
    {



        $all = array();

        // if ($request->post('work_system') != 0) {
        //     $s1 = ["attendances.work_id", $request->post('work_id')];
        //     $all[0] = $s1;
        // }

        if ($request->post('period') != 0) {
            $s1 = ["attendance_details.period_id", $request->post('period')];
            $all[0] = $s1;
        }


        if ($request->post('staff') != 0) {

            $s2 = ["attendances.staff_id", $request->post('staff')];
            $all[1] = $s2;
        }




        $attendances =  Attendance::where(["attendances.staff_id" => $request->post('staff')])
            ->whereBetween('attendances.attendance_date', array($request->post('from_date'), $request->post('into_date')))
            ->with([
                'attendance_details' => function ($query) use ($request) {
                    $query->where(["attendance_details.period_id" => $request->post('period')])->select('*');
                },
                'staff' => function ($query) {
                    $query->select('*');
                }
            ])
            ->paginate(10);


        $total_delay =  0;
        $total_leave =   0;
        $total_apsence = 0;
        $total_present = 0;



        foreach ($attendances as $value) {

            $day = $value->attendance_date;
            $date = strtotime($day);
            $date = date('l', $date);
            $day = $date;

            foreach ($value->attendance_details as $attenances) {


                $total_delay  = $total_delay + $attenances->delay;
                $total_leave  = $total_leave + $attenances->leave;

                if ($attenances->attendance_status == 0) {

                    $total_apsence  = $total_apsence + $attenances->apsence;
                } else {
                    $total_present  = $total_present + $attenances->present;
                }
            }


            $value->total_delay  = $total_delay;
            $value->total_leave  = $total_leave;
            $value->total_apsence  = $total_apsence;
            $value->total_present  = $total_present;
            $value->date  = $date;
        }


        return response()->json(['attendances' => $attendances]);
    }

    public function select_staff(Request $request)
    {


        $staffs =  Staff::where('id', $request->id)->with([
            'attendance' => function ($query) {
                $query->select('*');
            }

        ])->paginate(10);

        return response()->json(['list' => $staffs]);
    }


    // public function get_time(Request $request)
    // {



    //     $period = DB::table('attendances')->where([
    //         'attendances.attendance_date' => $request['date']
    //     ])
    //         ->join('staff', 'staff.id', '=', 'attendances.staff_id')
    //         ->select('staff.id as staff_id', 'staff.name', 'attendances.*')
    //         ->paginate(10);


    //     foreach ($period as $key => $value) {


    //         $periods = DB::table('attendance_details')->where([
    //             'attendance_details.period_id' => $request->period_id,
    //             'attendance_details.attendance_id' => $value->id,
    //         ])
    //             ->select('attendance_details.*')
    //             ->get();

    //         $value->details = (count($periods) == 0) ? 0 : $periods;
    //     }


    //     if ($period->isEmpty()) {

    //         $period =  DB::table('staff')
    //             ->join('staff_work_systems', 'staff.id', '=', 'staff_work_systems.staff_id')
    //             ->where('staff_work_systems.work_system_id', $request->work_system_id)
    //             ->select('staff.id as staff_id', 'staff.name')
    //             ->paginate(10);
    //     }


    //     return response()->json(['periods' => $period]);
    // }


    public function get_time(Request $request)
    {

        // dd($request->all());
        // DB::enableQueryLog();
        $period = AttendanceDetail::with('attendance');

        if ($request->date) {

            $period = $period->whereHas('attendance', function ($query) use ($request) {

                $query->where('attendances.attendance_date', '=', $request->date);
            });
        }
        if ($request->period_id != null) {


            $period = $period->whereHas('attendance', function ($query) use ($request) {


                $query->where('period_id', '=', $request->period_id);
            });
        }
        if ($request->work_system_id) {


            $period = $period->whereHas('attendance.staff.work_system_type', function ($query) use ($request) {

                $query->where('work_system_types.id', '=', $request->work_system_id);
            });
        }

        $period = $period->with('attendance.staff');

        $period = $period->paginate();

        // dd(DB::getQueryLog());

        if ($period->isEmpty()) {


            // DB::enableQueryLog();

            $period = DB::table('staff')
                ->join('work_systems', 'work_systems.staff_id', '=', 'staff.id')
                ->join('work_system_types', 'work_systems.work_system_type_id', '=', 'work_system_types.id')
                ->join('period_times', 'period_times.id', '=', 'work_systems.period_time_id')
                ->where('work_system_types.id', $request->work_system_id)
                ->select(

                    'work_systems.sort',
                    'period_times.*',
                    'period_times.id as period_id',
                    'period_times.name as period',
                    'work_system_types.*',
                    'work_system_types.name as type',
                    'staff.*',
                    'staff.id as staff_id',


                )
                ->paginate();

            //    --------------------------------------------------------------------------------------
            // $period = Staff::with(['period_time.work_system_type' => function ($query) use ($request) {

            //     $query->where('work_system_types.id', $request->work_system_id);
            // }])
            //     // ->with('period_time')
            //     ->select()
            //     ->paginate();

            // dd(DB::getQueryLog());
        }


        return response()->json(['periods' => $period]);
    }

    public function staff_attendance(Request $request)
    {



        $staffs = DB::table('staff')->get();


        $work_system_types = DB::table('work_system_types')
            ->select('work_system_types.name', 'work_system_types.id')
            ->get();

        $staff_attendance = AttendanceDetail::with('attendance', 'attendance.staff', 'period')
            ->select('attendance_details.*')
            ->paginate(10);


        return response()->json([
            'staff_attendance' => $staff_attendance,
            'staffs' => $staffs,
            'work_system_types' => $work_system_types,
        ]);
    }
    public function get_staff_attendance()
    {


        $staff_attendance = AttendanceDetail::with('attendance', 'attendance.staff', 'period')
            ->select('attendance_details.*')
            ->paginate(10);

        return response()->json([
            'staff_attendance' => $staff_attendance,
        ]);
    }


    public function store(
        Request $request,
        CoreStaffAttendanceService $attendance_core,
        AttendanceService $service,
    ) {


        // $request['sort_period'] = 2;
        $attendance_core->data = $request->all();



        // dd($attendance_core->data);

        try {

            DB::beginTransaction();



            foreach ($request->post('count') as $value) {



                $attendance_core->setValue($value);

                // if ($attendance_core->data['attendance_status'] == 1) {



                $service->attende();


                // } else {

                //     $attendance_core->data['attendance_final'] = 'complete';

                //     $service->absence();
                // }
            }
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "attendance created successfully",
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
