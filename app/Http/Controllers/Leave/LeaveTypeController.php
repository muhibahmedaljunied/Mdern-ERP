<?php

namespace App\Http\Controllers\Leave;

use App\Services\Staff\LeaveService;
use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Cache;
use App\Repository\HR\LeaveRepository;
use App\Services\CoreStaffService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{


    public function __construct(

        protected CoreStaffService $core,
        protected LeaveService $leave_sanction,
        protected LeaveRepository $hr,



    ) {}


    public function index()
    {

        $minutes = 60;
        // $staffs = Cache::remember('staff', $minutes, function () {
        $staffs = DB::table('staff')->get();
        // });
        // --------------------------------------------------------------------------------------------------

        return response()->json([
            'leave_types' => LeaveType::all(),
            'staffs' => $staffs
        ]);
    }


    public function leaveout_type()
    {


        return response()->json([
            'leave_types' => LeaveType::all(),

        ]);
    }







    public function store(Request $request)
    {

  

        foreach ($request->post('count') as $value) {

            $work_systm = new LeaveType();
            $work_systm->name = $request->post('name')[$value];
            $work_systm->code = $request->post('code')[$value];
            $work_systm->save();
        }

        response()->json();
    }
}
