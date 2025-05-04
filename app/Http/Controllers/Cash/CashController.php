<?php

namespace App\Http\Controllers\Cash;

use App\Repository\CheckData\CheckCashReturnRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Traits\Invoice\InvoiceTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\StoreProduct;
use App\Traits\Unit\UnitsTrait;
use App\Traits\OperationDataTrait;
use App\Models\Cash;
use App\Models\Payment;
use App\Models\Supply;
use App\Repository\Qty\QtyStockRepository;
use App\Services\StockService;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CashController extends Controller
{
    use InvoiceTrait,
        UnitsTrait,
        OperationDataTrait,
        GeneralTrait;


    public $qty;
    public $request;

    public function  __construct(Request $request, QtyStockRepository $qty)
    {
        $this->qty = $qty;
        $this->qty->request = $request;
    }

    public function details()
    {


        $this->qty->set_compare_array(['qty']);
        $this->init();
        $this->get_details();
        $this->variant();
        $this->qty->handle_qty();

        return response()->json([
            'details' => $this->qty->details,

        ]);
    }

    public function index(Request $request)
    {


        $this->qty->set_compare_array(['quantity']);
        // ($request->id) ? $this->operation_data($request) : $this->get_all($request);
        $this->operation_data();
        $this->qty->handle_qty();

        return response()->json([
            'products' => $this->qty->details,
            'customers' => $this->customers(),


        ]);
    }

    public function operation_data()
    {


        $this->product_detail();
        $this->variant();
        $this->unit();
    }

    public function customers()
    {

        $customers = DB::table('customers')
            ->select(
                'customers.*',
            )
            ->get();

        return $customers;
    }

    public function treasuries()
    {

        return DB::table('treasuries')
            ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
            ->select(
                'treasuries.id',
                'treasuries.name',
                'treasuries.account_id'
            )
            ->get();
    }
    public function get_all()
    {

        return  StoreProduct::where('store_products.quantity', '!=', '0')
            ->joinall()
            ->select(
                'products.*',
                'products.text as product',
                'stores.text as store',
                'stores.account_id as store_account_id',
                'statuses.name as status',
                'store_products.quantity as availabe_qty',
                'store_products.*',
                'store_products.cost as price',
                'store_products.id as store_product_id'
            )
            ->paginate(100);
        // $units = $this->qtys($products);

    }
    public function get_one($request)
    {

        $retVal = ($request->type == 'product') ? 'store_products.product_id' : 'store_products.store_id';
        $details =  StoreProduct::where($retVal, $request->id)
            ->where('store_products.quantity', '!=', '0')
            ->joinall()
            ->select(
                'products.*',
                'products.text as product',
                'stores.text as store',
                'stores.account_id as store_account_id',
                'statuses.name as status',
                'store_products.quantity as availabe_qty',
                'store_products.*',
                'store_products.cost as price',
                'store_products.id as store_product_id'
            )
            ->paginate(100);

        foreach ($details as $value) {


            $value->unit_id = 0;
        }

        return $details;
    }


    public function payment(
        StockService $stock


    ) {


        // dd($this->qty->request);
        // dd($stock->core->data);
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            $stock->handle();
            // dd(CashDetail::all());

            Cache::forget('stock');

            // dd(1);

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "cash created successfully",
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



    public function cash_daily(Request $request)
    {



        $cashes = DB::table('cashes')->where('cashes.id', $request->id)
            ->join('customers', 'customers.id', '=', 'cashes.customer_id')
            ->join('dailies', 'dailies.id', '=', 'cashes.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                // 'cashes.*',
                'cashes.id as cash_id',
                'customers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($cashes);
        return response()->json(['daily_details' => $cashes]);
    }

    public function show()
    {


        $cashes = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                Cash::class => function ($query) {
                    // $query->join('customers', 'customers.id', '=', 'cashes.customer_id');
                    $query->join('dailies', 'dailies.id', '=', 'cashes.daily_id');
                    $query->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id');
                    $query->join('accounts', 'accounts.id', '=', 'daily_details.account_id');
                    $query->where('daily_details.debit', '!=', 0);
                    $query->select(
                        'cashes.*',
                        'cashes.id as cash_id',
                        'accounts.text',
                        'accounts.id as account_id',
                    );
                },
            ]);
        }])
            ->where('paymentable_type', 'App\\Models\\Cash')
            ->paginate(5);


        return response()->json(['cashes' => $cashes]);
    }

    public function cash_list()
    {




        $cashes = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                Cash::class => function ($query) {
                    // $query->join('cash_details', 'cash_details.cash_id', '=', 'cashes.id');
                    $query->select(
                        'cashes.*',
                        'cashes.id as cash_id',
                        // 'cash_details.*',

                    );
                },
            ]);
        }])
            ->where('paymentable_type', 'App\\Models\\Cash')
            ->paginate(5);






        return response()->json(['cashes' => $cashes]);
    }




    function invoice_cash()
    {

        $this->qty->set_compare_array(['qty']);
        $this->init();
        $this->get_details();
        $this->variant();
        $this->qty->handle_qty();

        return response()->json([
            'cash_details' => $this->qty->details,
            'cashes' => $this->get_cash(),
            'users' => Auth::user()
        ]);
    }


    public function get_cash()
    {


        return Cash::where('cashes.id', $this->qty->request->id)
            ->join('customers', 'customers.id', '=', 'cashes.customer_id')
            ->select('cashes.*', 'cashes.id as cash_id', 'customers.*')
            ->get();
    }
}
