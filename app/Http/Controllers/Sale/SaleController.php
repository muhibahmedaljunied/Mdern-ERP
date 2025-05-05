<?php

namespace App\Http\Controllers\Sale;

use App\Services\StockService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Traits\Invoice\InvoiceTrait;
use App\Http\Controllers\Controller;
use App\Models\HrAccount;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\StoreProduct;
use App\Traits\Unit\UnitsTrait;
use App\Traits\OperationDataTrait;
use App\Models\Sale;
use App\Repository\Qty\QtyStockRepository;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SaleController extends Controller
{
    use UnitsTrait,
        GeneralTrait,
        OperationDataTrait,
        InvoiceTrait;

    public $qty;
    public $details;
    public $store_products;
    public function  __construct(Request $request, QtyStockRepository $qty)
    {

        $this->qty = $qty;
        $this->qty->request = $request;
    }
    public function details()
    {

        $this->qty->set_compare_array(['qty']);
        $this->init()->get_details();
        // $this->get_details();
        $this->variant();
        $this->qty->handle_qty();
        return response()->json([
            'details' => $this->qty->details,

        ]);
    }



    public function index()
    {


        // dd($this->qty->request);
        $this->qty->set_compare_array(['quantity']);
<<<<<<< HEAD
        $this->operation_data();
=======
<<<<<<< HEAD
        $this->operation_data();
=======
        ($request->id) ? $this->operation_data() : $this->get_all($this->qty);
>>>>>>> b8ad28e449a5c1b1f26a009ee09ac1e352d35de9
>>>>>>> fa067d02058eb412e603d2152bd282007de27a22
        $this->qty->handle_qty();
        return response()->json([
            'products' => $this->qty->details,
            'customers' => $this->customers(),


        ]);
    }
    // Admin123456
    // Long Distance Cooled Sensor PTZ Thermal Camera  CTC690110-LFZ

    public function operation_data()
    {



        $this->start();
        $this->variant();
        $this->unit();
    }




    public function customers()
    {

        return DB::table('customers')

            ->select(
                'customers.*',


            )
            ->get();
    }

    public function treasuries()
    {

        return DB::table('treasuries')
            ->select(
                'treasuries.id',
                'treasuries.name',

            )
            ->get();
    }
    public function get_all()
    {



        $details =  StoreProduct::where('store_products.quantity', '!=', '0')
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

        StockService $stock,

    ) {


        //// ($stock->core->data);

        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            $stock->handle();

            //// (Sa'finall'

            Cache::forget('stock');
            // dd(12);
            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB



            return response([
                'message' => "sale created successfully",
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



    public function sale_daily(Request $request)
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

    public function get_sale_account_setting()
    {



        $accounts = HrAccount::with(
            [
                'account' => function ($query) {
                    $query->select('*', 'text as first_name');
                },
                'account_second' => function ($query) {
                    $query->select('*', 'text as second_name');
                }
            ]
        )->select('hr_accounts.*', 'hr_accounts.name as account_name')
            ->get();

        // dd($accounts);
        $count_account = HrAccount::all()->count();

        return response()->json(['accounts' => $accounts, 'count_account' => $count_account]);
    }


    public function show()
    {


        $sales = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                Sale::class => function ($query) {

                    $query->join('customers', 'customers.id', '=', 'sales.customer_id');
                    $query->select('sales.*', 'sales.id as sale_id', 'customers.name as customer_name');
                },
            ]);
        }])
            ->where('paymentable_type', 'App\\Models\\Sale')
            ->paginate(5);


        return response()->json(['sales' => $sales]);
    }




    function invoice_sale()
    {

        $this->qty->set_compare_array(['qty']);
        $this->init()->get_details();
        $this->get_details();
        $this->qty->handle_qty();
        return response()->json([
            'sale_details' => $this->qty->details,
            'sales' => $this->get_sale(),
            'users' => Auth::user()
        ]);
    }

    function get_sale()
    {

        return Sale::where('sales.id', $this->qty->request->id)
            ->join('customers', 'customers.id', '=', 'sales.customer_id')
            ->select('sales.*', 'sales.id as sale_id', 'customers.*')
            ->get();
    }
}
