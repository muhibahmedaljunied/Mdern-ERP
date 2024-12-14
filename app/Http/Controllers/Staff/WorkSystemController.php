<?php

namespace App\Http\Controllers\Staff;

use App\Traits\Staff\BasicData\StoreTrait;
use App\Http\Controllers\Controller;
use App\Models\WorkSystem;
use App\Models\PeriodTime;
use App\Models\WorkSystemType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Enums\Days;
use App\Models\Staff;

class WorkSystemController extends Controller
{

    use StoreTrait;
    public function index()
    {


        // $df = array();

        // foreach (Days::cases() as $key =>  $value) {

        //     $df[$value->name] = $value->value;

        // }


        $work_systems = WorkSystem::join('work_system_types', 'work_systems.work_system_type_id', '=', 'work_system_types.id')
            ->join('period_times', 'period_times.id', '=', 'work_systems.period_time_id')
            ->join('staff', 'work_systems.staff_id', '=', 'staff.id')
            ->select(
                'work_systems.*',
                'work_system_types.name as work_system_type_name',
                'period_times.*',
                'work_systems.days',
                'staff.*'

            )
            ->orderby('staff.name')
            ->paginate();


        // dd(Days::values());
        return response()->json([
            'work_system_types' => WorkSystemType::all(),
            'period_times' => PeriodTime::all(),
            'staffs' => Staff::all(),
            'work_systems' => $work_systems,
            'days' => Days::values(),
        ]);
    }

    public function get_period_time($id)
    {


        $period_times = PeriodTime::where('period_times.period_id', $id)
            // ->join('periods', 'periods.id', '=', 'period_times.period_id')
            ->select(
                'period_times.*',

            )
            ->get();

        return response()->json([
            'period_times' => $period_times,
        ]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {


        // dd($request->all());
        try {

            DB::beginTransaction();


            foreach ($request->post('count') as $value) {






                $enum = [];

                foreach ($request->day as $key => $value1) {

                    if ($value1 != null) {
                        foreach ($value1 as $key1 => $value2) {


                            if ($value2 == true) {

                                $enum[$key1] =  Days::cases()[$key1]->name;
                            }
                        }
                    }
                }




                WorkSystem::updateOrCreate(
                    [
                        'work_system_type_id' => $request['work_system_type'][$value],
                        'period_time_id' => $request['period'][$value],
                        'days' => json_encode($enum),


                    ]
                );
            }

            // dd(WorkSystem::all());
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "WorkSystem created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }

        return response()->json(['message' => $request->all()]);
    }
}
