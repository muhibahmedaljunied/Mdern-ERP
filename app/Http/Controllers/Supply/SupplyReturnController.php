<?php

namespace App\Http\Controllers\Supply;

use Illuminate\Support\Facades\Cache;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupplyReturn;
use App\Repository\Qty\QtyStockRepository;
use App\Services\FilterService;
use App\Services\StockService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplyReturnController extends Controller
{

    use GeneralTrait;
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
            'qty_remain',
            'quantity',
            // 'avilable_qty',
            // 'qty_return'
        ]);
        $this->init();
        $this->get_details();
        $this->variant();
        $this->unit();
        $this->qty->handle_qty();
        return response()->json([
            'details' => $this->qty->details,

        ]);
    }



    public function suppliers()
    {

        return DB::table('suppliers')
            ->select(
                'suppliers.*',


            )
            ->get();
    }

    public function treasuries()
    {

        $treasuries = DB::table('treasuries')
            ->select(
                'treasuries.*',


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
            'supply_returns' => $this->get_supply_return(),
            'supply_return_details' => $this->qty->details,
            'users' => Auth::user()
        ]);
    }

    public function get_supply_return()
    {


        return SupplyReturn::where('supply_returns.id', $this->qty->request->id)
            ->join('supplies', 'supplies.id', '=', 'supply_returns.supply_id')
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->select(
                'supplies.*',
                'supplies.id as supply_id',
                'suppliers.*',
                'supply_returns.*',
                'supply_returns.id as return_id'
            )
            ->get();
    }


    public function return_detail(Request $request)
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


    public function show($id)
    {


        // $returns = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
        //     $morphTo->constrain([
        //         SupplyReturn::class => function ($query) {
        //             // $query->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id');
        //             $query->select('supplies.*', 'supplies.id as supply_id');
        //         },
        //     ]);
        // }])
        //     ->where('paymentable_type', 'App\\Models\\SupplyReturn')
        //     ->paginate(10);


        // return response()->json(['returns' => $returns]);

        // -----------------------------------------------------------------------------------------------
        $returns = DB::table('supply_returns')->where('supply_returns.supply_id', $id)
            ->join('supplies', 'supplies.id', '=', 'supply_returns.supply_id')
            ->select(
                'supply_returns.*',
                'supply_returns.date as return_date',
                'supply_returns.quantity as qty_return',
                'supply_returns.id as return_id',
                'supplies.*'
            )
            ->paginate(10);



        return response()->json(['returns' => $returns]);
    }
    public function create(

        StockService $stock
    )   // this create return for supply,cashing,sale,supply
    {



        // dd($this->qty->request);

        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $stock->handle();
            // dd(SupplyReturnDetail::all());
            Cache::forget('stock');

            // dd(DailyDetail::all());

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "supplyReturn created successfully",
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

    public function return_supply_daily(Request $request)
    {



        $supplies = DB::table('supplies')
            ->where('supplies.id', $request->id)
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->join('dailies', 'dailies.id', '=', 'supplies.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                'supplies.id as supply_id',
                'suppliers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($supplies);
        return response()->json(['daily_details' => $supplies]);
    }
}



    // public function index()
    // {



    //     $details = $this->details();

    //     return response()->json([
    //         'supply_details' => $details,
    //         'suppliers' => $this->suppliers(),
    //         'treasuries' => $this->treasuries()
    //     ]);
    // }
