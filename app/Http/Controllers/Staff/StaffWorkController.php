<?php

namespace App\Http\Controllers\Staff;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\StaffWorkSystem;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class StaffWorkController extends Controller
{

    public function index()
    {

     

        $staff_work = DB::table('staff_work_systems')
            ->join('staff', 'staff.id', '=', 'staff_work_systems.staff_id')
            ->join('work_system_types', 'work_system_types.id', '=', 'staff_work_systems.work_system_type_id')
            ->select(
                'staff.name as staff_name',
                'work_system_types.name as work_system'
            )
            ->paginate(6);


   


        $work_systems = DB::table('work_system_types')
            ->select('work_system_types.*')
            ->get();




        return response()->json([

            'list' => $staff_work,
            'work_systems' => $work_systems,
            'staffs' => $this->get_staff(),

        ]);
    }


    public function get_staff()
    {

        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });

        return $staffs;
    }

    public function create()
    {
    }

    public function store(Request $request)
    {

        // dd($request->all());
        foreach ($request->post('count') as $value) {

            $staff = new StaffWorkSystem();
            $staff->staff_id = $request['staff'][$value];
            $staff->work_system_type_id = $request['work_type'][$value];
            $staff->save();
        }
        Cache::forget('staff_work');

        return response()->json($request->all());
    }

    public function show(Request $request)
    {
    }

    public function edit(Staff $staff)
    {
        //
    }

    public function update(Request $request, Staff $staff)
    {
        //
    }

    public function destroy($id)
    {

        // DB::table('payrolls')->where('staff_id', '=', $id)->delete();

        // $store = staff::find($id);

        // $store->delete();

        // Cache::forget('staff');
        // Cache::forget('staff_eager_load');
        // return response()->json('successfully deleted');

    }
}
