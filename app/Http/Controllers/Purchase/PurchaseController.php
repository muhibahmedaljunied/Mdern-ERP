<?php

namespace App\Http\Controllers\Purchase;

use App\Services\StockService;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Models\Payment;
use Illuminate\Support\Facades\Cache;
use App\Models\StoreProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\HrAccount;
use App\Models\ProductPrice;
use App\Models\ProductUnit;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\status;
use App\Models\Temporale;
use App\Models\Purchase;
use App\Models\Unit;
use App\Repository\Qty\QtyStockRepository;

class PurchaseController extends Controller
{
    use InvoiceTrait,
        GeneralTrait;

    public $qty;
    public $products;
    public $store_products;
    public function __construct(Request $request, QtyStockRepository $qty)
    {

        $this->qty = $qty;
        $this->qty->request = $request;
    }
    public function details()
    {
        $this->qty->set_compare_array(['qty']);
        $this->init();
        $this->get_details();
        $this->qty->handle_qty();
        return response()->json(['details' => $this->qty->details]);
    }


    public function index()
    {



        $this->product();
        $this->product_detail();
        $this->variant();
        $this->unit();
        // $this->price();





        // dd($this->store_products);


        return response()->json([
            'products' => $this->products,
            'store_products' => $this->store_products,
            'suppliers' => $this->suppliers(),
            'statuses' => Status::all(),
            'stores' => $this->get_store()

        ]);
    }

    public function product()
    {


        $this->products = DB::table('products')
            ->select('products.*',)
            ->get();
    }
    public function product_detail()
    {


        $this->store_products = DB::table('products')
            ->join('store_products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->select(
                'products.*',
                'store_products.id as store_product_id',
                'store_products.desc',
                'statuses.name',
                'statuses.id as status_id'
            )
            ->get();
    }

    public function variant()
    {


        foreach ($this->store_products as $value) {

            $value->kk = collect(DB::table('family_attribute_options')
                ->where('family_attribute_options.store_product_id', $value->store_product_id)
                ->join('attribute_options', 'attribute_options.id', '=', 'family_attribute_options.attribute_option_id')
                ->join('attributes', 'attributes.id', '=', 'attribute_options.attribute_id')
                ->get())
                ->toArray();
        }
    }

    public function unit()
    {


        foreach ($this->store_products as $value) {


            $value->unit = ProductUnit::where([
                // 'product_prices.product_unit_id' => $value->product_unit_id,
                'product_prices.store_product_id' => $value->store_product_id
            ])
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->join('product_prices', 'product_prices.product_unit_id', '=', 'product_units.id')
                ->select(
                    'units.*',
                    'product_units.*',
                    'product_units.id as product_unit_id',
                    'product_prices.*',
                )

                ->get();
        }
    }

    // public function price()
    // {


    //     foreach ($this->store_products as $value) {

    //         // foreach ($value->unit as $value2) {

    //         $value->price = ProductPrice::where([
    //             // 'product_prices.product_unit_id' => $value->product_unit_id,
    //             'product_prices.store_product_id' => $value->store_product_id
    //         ])
    //             ->join('product_units', 'product_units.id', '=', 'product_prices.product_unit_id')
    //             ->join('units', 'units.id', '=', 'product_units.unit_id')

    //             ->select(
    //                 'product_prices.*',
    //                 'product_units.*',
    //                 'units.*'

    //             )

    //             ->get();

    //         // }

    //     }
    // }







    public function get_store()
    {


        return  DB::table('stores')
            ->select(
                'stores.account_id as store_account_id',
                'stores.text as store_name',
                'stores.id as store_id'

            )
            ->get();
    }
    public function suppliers()
    {

        $suppliers =  DB::table('suppliers')
            ->select(
                'suppliers.*',

            )
            ->get();

        return $suppliers;
    }

    public function treasuries()
    {

        $treasuries = DB::table('treasuries')
            ->select(
                'treasuries.id',
                'treasuries.name',


            )
            ->get();

        return $treasuries;
    }

    public function payment(

        StockService $stock,
    ) {



        dd($stock->core->data);
        // $result  = $this->daily->check_account();

        // if ($result == 0) {

        //     return response([
        //         'message' => $this->daily->message,
        //         'status' => 'failed'
        //     ], 400);
        // }




        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $stock->handle();

            Cache::forget('stock');

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB


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
    }
    public function purchase_daily(Request $request)
    {



        $purchases = DB::table('purchases')
            ->where('purchases.id', $request->id)
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->join('dailies', 'dailies.id', '=', 'purchases.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                // 'purchases.*',
                'purchases.id as purchase_id',
                'suppliers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($purchases);
        return response()->json(['daily_details' => $purchases]);
    }


    public function show()
    {


        $purchases = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                Purchase::class => function ($query) {
                    $query->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id');
                    $query->select('purchases.*', 'purchases.id as purchase_id', 'suppliers.name as supplier_name');
                },
            ]);
        }])
            ->where('paymentable_type', 'App\\Models\\Purchase')
            ->paginate(5);


        return response()->json(['purchases' => $purchases]);
    }

    public function get_purchase_account_setting()
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
    public function search(Request $request)
    {

        $products = StoreProduct::where('products.name', 'LIKE', '%' . $request->post('word_search') . '%')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('group_categories', 'group_categories.id', '=', 'categories.group_id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'stores.text as store',
                'group_categories.name as group_name'
            )
            ->paginate(10);

        return response()->json(['products' => $products]);
    }

    public function invoice_purchase()
    {


        $this->qty->set_compare_array(['qty']);
        $this->init();
        $this->get_details();
        $this->qty->handle_qty();

        return response()->json([
            'purchase_details' => $this->qty->details,
            'purchases' => $this->get_purchase(),
            'users' => Auth::user()
        ]);
    }

    public function get_purchase()
    {




        return Purchase::where('purchases.id', $this->qty->request->id)
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select(
                'purchases.*',
                'purchases.id as purchase_id',
                'purchases.*'
            )
            ->get();
    }

    public function destroy(Request $request)
    {
        if ($request->id) {
            Temporale::where('type_process', 'purchase')->where('temporales.product_id', $request->id)->delete();
        } else {
            Temporale::where('type_process', 'purchase')->delete();
        }


        return response()->json('successfully deleted');
    }
}
