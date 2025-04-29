<?php

namespace App\Http\Controllers\Sale;

use App\Services\StockService;
use Illuminate\Support\Facades\Cache;
use App\Traits\Return\ReturnTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SaleReturn;
use App\Traits\OperationDataTrait;
use App\Repository\Qty\QtyStockRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleReturnController extends Controller
{

    use GeneralTrait,
        OperationDataTrait,
        ReturnTrait;

    public $qty;
    public function  __construct(Request $request, QtyStockRepository $qty)
    {
        $this->qty = $qty;
        $this->qty->request = $request;
    }


    public function details()
    {


        // dd($this->qty->request->all());

        $this->qty->set_compare_array([
            'qty',
            'quantity',
            'qty_remain'
        ]);
        $this->init();
        $this->get_details();
        $this->variant();
        $this->qty->handle_qty();
        return response()->json([
            'details' => $this->qty->details,
            'sale' => $this->get_sale(),
        ]);
    }


    public function return_detail()
    {



        $this->qty->set_compare_array(['qty']);
        $this->init();
        $this->get_return_details();
        $this->variant();
        $this->qty->handle_qty();
        return response()->json([
            'return_details' => $this->qty->details
        ]);
    }

    public function get_sale()
    {


        return DB::table('sales')
            ->where('sales.id', $this->qty->request->id)
            ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->select(
                'customers.id',
                'customers.name',
                'sales.grand_total',


            )
            ->get();
    }

    public function index(Request $request, $id)
    {

        $this->qty->set_compare_array(['qty', 'quantity', 'qty_remain']);
        $this->init();
        $this->details();
        return response()->json([
            'sale_details' => $this->qty->details,
            'customers' => $this->customers(),
            'treasuries' => $this->treasuries()
        ]);
    }

    public function customers()
    {

        return DB::table('customers')
            ->join('accounts', 'accounts.id', '=', 'customers.account_id')
            ->select(
                'customers.id',
                'customers.name',
                'customers.account_id',


            )
            ->get();
    }

    public function treasuries()
    {

        return DB::table('treasuries')
            ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
            ->select(
                'treasuries.id',
                'treasuries.name',
                'treasuries.account_id',

            )
            ->get();
    }

    public function return_sale_daily(Request $request)
    {



        $sale_returns = DB::table('sale_returns')->where('sale_returns.id', $request->id)
            ->join('dailies', 'dailies.id', '=', 'sale_returns.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                'sale_returns.id as sale_return_id',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',
            )
            ->get();

        // dd($sales);
        return response()->json(['daily_details' => $sale_returns]);
    }



    public function show(Request $request)
    {



        $returns = SaleReturn::with(['payments'])->where('sale_returns.sale_id', $request->id)->paginate(5);


        return response()->json(['returns' => $returns]);
    }

    public function return_sale_list()
    {



        $returns = SaleReturn::with(['payments'])->paginate(5);


        return response()->json(['returns' => $returns]);
    }




    public function return_invoice()
    {


        $this->qty->set_compare_array([
            'qty'
        ]);
        $this->init();
        $this->get_return_details();
        $this->variant();
        $this->qty->handle_qty();
        return response()->json([
            'sale_returns' => $this->get_sale_return(),
            'sale_return_details' => $this->qty->details,
            'users' => Auth::user()
        ]);
    }



    public function get_sale_return()
    {


        return SaleReturn::where('sale_returns.id', $this->qty->request->id)
            ->join('sales', 'sales.id', '=', 'sale_returns.sale_id')
            ->join('users', 'users.id', '=', 'sales.customer_id')
            ->select(
                'sales.*',
                'sales.id as sale_id',
                'users.*',
                'sale_returns.*',
                'sale_returns.id as return_id'
            )
            ->get();
    }



    public function create(
        StockService $stock,
    )   // this create return for supply,cashing,sale,purchase
    {


        // dd($this->qty->request->all());
        // foreach ($this->qty->request['count'] as $value) {

        //     $result = $check->check_return($this->qty->request['old'][$value]);

        //     // dd($result);
        //     if ($result['status'] == 0) {
        //         return response(['message' => $result['text'], 'status' => $result['status']]);
        //     }
        // }

        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction




            $stock->handle();

            // dd(StoreProduct::all());
            Cache::forget('stock');




            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "SaleReturn created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {
            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }

        // return response()->json(['message' => $responce]);

    }

    public function sale_return_aily(Request $request)
    {



        $sales = DB::table('sales')->where('sales.id', $request->id)
            ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->join('dailies', 'dailies.id', '=', 'sales.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                // 'sales.*',
                'sales.id as sale_id',
                'customers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($sales);
        return response()->json(['daily_details' => $sales]);
    }
}
