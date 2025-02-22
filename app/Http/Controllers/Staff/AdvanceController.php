<?php

namespace App\Http\Controllers\Staff;

use App\Models\Staff;
use App\Repository\HR\AdvanceRepository;
use App\Services\CoreStaffService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GroupAccount;
use App\Services\DailyStockService;
use App\Services\PayrollService;
use Illuminate\Support\Facades\DB;

class AdvanceController extends Controller
{

    public function __construct(
        protected AdvanceRepository $hr,
        protected CoreStaffService $core,
    ) {}
    public function index()
    {
    

        $advances = Staff::with(['advance'])->paginate(10);

 
        $this->hr->Sum($advances, 'advance');
        // ------------------------------------------------------------------------------------------------
        $staffs =  DB::table('staff')
            ->select(
                'staff.name',
                'staff.id',
            )
            ->get();


            // dd($advances);
        // -------------------------------------------------------------------------------------------------

        return response()->json([

            'staffs' => $staffs,
            'list' => $advances,

            'debit' => GroupAccount::join('groups', 'groups.id', 'group_accounts.group_id')
                ->where('groups.code', 'advance')
                ->select('group_accounts.account_id')
                ->get(),


        ]);

      
    }


    public function report(Request $request)
    {
        // 40036484981

        $advances = Staff::with(['advance' => function ($query) use ($request) {
            $query->select('advances.*')
                ->where('advances.staff_id', '=', $request->staff)
                ->whereBetween('advances.date', array($request->post('from_date'), $request->post('into_date')));
        }])
            // 
            // ->whereBetween('date', array($request->post('from_date'), $request->post('into_date')))
            ->select('*')
            ->paginate(10);
        // dd($advances);
        $this->hr->Sum($advances, 'advance');

        // dd($advances);
        return response()->json(['list' => $advances]);
    }
    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['advance'])->paginate(10);

        return response()->json(['list' => $staffs]);
    }



    public function store(Request $request, DailyStockService $daily, PayrollService  $payroll)
    {

        $this->core->setData($request->all());

        // dd($request->all());
        try {

            DB::beginTransaction();

            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);
                $this->hr->handle();
                $payroll->refresh_payroll_for_hr();
            }
       
            // $daily->daily()->debit()->credit();
            $daily->daily()->exicute('debit')->exicute('credit');
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            Cache::forget('staff_advance');
            return response([
                'message' => "Advance created successfully",
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

    public function destroy($id)
    {

        // DB::table('payrolls')->where('staff_id', '=', $id)->delete();

        // $store = staff::find($id);

        // $store->delete();

        // Cache::forget('staff');



        return response()->json('successfully deleted');
    }
}
