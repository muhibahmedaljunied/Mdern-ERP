<?php

namespace App\Http\Controllers\Staff;

use App\Services\DailyService;
use App\Http\Controllers\Controller;
use App\Services\CoreStaffService;
use App\Repository\HR\AllowanceRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Services\DailyStockService;
use App\Services\PayrollService;
use Illuminate\Support\Facades\DB;

class AllowanceController extends Controller
{

    public function __construct(
        protected AllowanceRepository $hr,
        protected CoreStaffService $core,
        public DailyStockService $daily,

    ) {}

    public function index()
    {



        $allowance_types =  DB::table('allowance_types')
            ->join('groups', 'groups.id', '=', 'allowance_types.group_id')
            ->join('group_accounts', 'groups.id', '=', 'group_accounts.group_id')
            ->select(
                'group_accounts.*',
                'allowance_types.*',
            )
            ->get();



        return response()->json([
            'allowance_types' => $allowance_types,
            'staffs' => $this->get_staff(),
            'list' => $this->get_staff_allowance()
        ]);
    }


    public function get_staff()
    {

        $staffs =  DB::table('staff')
            ->select(
                'staff.name',
                'staff.id',
            )
            ->get();


        return $staffs;
    }
    public function get_staff_allowance()
    {


        $staff_allowances = Cache::rememberForever('staff_allowances', function () {
            return staff::with([

                'allowance' => function ($query) {
                    $query->select('*');
                },

                'allowance.allowance_type' => function ($query) {
                    $query->select('*');
                },

            ])
                ->paginate(10);
        });

        return $staff_allowances;
    }
    public function store(Request $request, DailyService $daily, PayrollService  $payroll)
    {
        $this->core->setData($request->all());

        // dd($this->core->data);
        try {

            DB::beginTransaction();

            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);
                $this->hr->handle();
                $payroll->refresh_payroll_for_hr();

                Cache::forget('staff_allowances');
            }

            $this->daily->daily()->exicute('debit')->exicute('credit');

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            Cache::forget('staff_allowance');
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
