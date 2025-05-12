<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Support\Facades\Cache;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use App\Traits\OperationDataTrait;
use Illuminate\Http\Request;
use App\Models\PurchaseReturn;
use App\Repository\Qty\QtyStockRepository;
use App\Services\FilterService;
use App\Services\StockService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{

    use GeneralTrait, OperationDataTrait;

    public $qty;
    public $filter;
    public function  __construct(
        QtyStockRepository $qty,
        FilterService $filter
    ) {
        $this->qty = $qty;
        $this->filter = $filter;

    }


    public function details()
    {

        $this->qty->set_compare_array([
            'qty',
            'quantity',
            'qty_remain'
        ]);
        $this->init();
        $this->get_details();
        $this->variant();
        $this->unit();
        $this->qty->handle_qty();
        return response()->json([
            'details' => $this->qty->details,
            'purchase' => $this->get_purchase(),

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


    public function get_purchase()
    {

        return DB::table('purchases')
            ->where('purchases.id', $this->qty->request->id)
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select(
                'suppliers.id',
                'suppliers.name',
                'purchases.grand_total',


            )
            ->get();
    }


    public function suppliers()
    {

        return DB::table('suppliers')
            ->join('accounts', 'accounts.id', '=', 'suppliers.account_id')
            ->select(
                'suppliers.id',
                'suppliers.name',
                'suppliers.account_id',

            )
            ->get();
    }

    public function treasuries()
    {

        $treasuries = DB::table('treasuries')
            ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
            ->select(
                'treasuries.id',
                'treasuries.name',
                'treasuries.account_id',

            )
            ->get();

        return $treasuries;
    }


    public function return_invoice()
    {


        $this->qty->set_compare_array(['qty']);
        $this->init();
        $this->get_return_details();
        $this->variant();
        $this->qty->handle_qty();
        return response()->json([
            'purchase_returns' => $this->get_purshace_return(),
            'purchase_return_details' => $this->qty->details,
            'users' => Auth::user()
        ]);
    }

    public function get_purshace_return()
    {


        return PurchaseReturn::where('purchase_returns.id', $this->qty->request->id)
            ->join('purchases', 'purchases.id', '=', 'purchase_returns.purchase_id')
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select(
                'purchases.*',
                'purchases.id as purchase_id',
                'suppliers.*',
                'purchase_returns.*',
                'purchase_returns.id as return_id'
            )
            ->get();
    }

    public function show(Request $request)
    {



        $returns = PurchaseReturn::with(['payments'])->where('purchase_returns.purchase_id', $request->id)->paginate(5);


        return response()->json(['returns' => $returns]);
    }


    public function return_purchase_list()
    {

        $returns = PurchaseReturn::with(['payments'])->paginate(15);

        return response()->json([
            'returns' => $returns,
            //  'suppliers' => $this->suppliers()
        ]);
    }



    public function create(
        StockService $stock,
    )   // this create return for supply,cashing,sale,purchase
    {


        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            $stock->handle();


            // dd(StoreProduct::all());
            Cache::forget('stock');

            // dd(1);

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "PurchaseReturn created successfully",
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

    public function return_purchase_daily(Request $request)
    {



        $purchase_returns = DB::table('purchase_returns')
            ->where('purchase_returns.id', $request->id)
            ->join('dailies', 'dailies.id', '=', 'purchase_returns.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                'purchase_returns.id as purchase_return_id',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();


        return response()->json(['daily_details' => $purchase_returns]);
    }
}



    // public function index()
    // {



    //     $this->qty->set_compare_array(['qty', 'available_qty', 'qty_remain']);
    //     $this->details();
    //     return response()->json([
    //         'purchase_details' => $this->qty->details,
    //         'suppliers' => $this->suppliers(),
    //         'treasuries' => $this->treasuries()
    //     ]);
    // }
