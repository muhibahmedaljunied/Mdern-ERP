<?php

namespace App\Http\Controllers\Warehouse;

use Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Cache;
use App\Models\Stock;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use App\Traits\Unit\UnitsTrait;
use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Status;
use App\Models\Supply;
use App\Repository\Qty\QtyStockRepository;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{

    use UnitsTrait;


    public function index(QtyStockRepository $qty)
    {


        $qty->set_compare_array(['quantity']);
        $qty->details = Cache::rememberForever('stock', function () {

            return StoreProduct::where('store_products.quantity', '!=', 0)
                ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
                ->join('stores', 'store_products.store_id', '=', 'stores.id')
                ->join('products', 'store_products.product_id', '=', 'products.id')
                ->select(
                    'store_products.quantity',
                    'store_products.*',
                    'products.id',
                    'products.text as product',
                    'statuses.name as status',
                    'stores.text as store',

                )
                ->paginate(100);
        });


        $qty->handle_qty();





        return response()->json(['stocks' => $qty->details]);
    }



    public function search(Request $request)
    {


        $stocks = StoreProduct::where('products.text', 'LIKE', '%' . $request->post('word_search') . '%')
            ->where('store_products.quantity', '!=', 0)
            ->joinall()
            ->select(
                'store_products.quantity',
                'store_products.*',
                'products.id',
                'products.text as product',
                'statuses.name as status',
                'stores.text as store'
            )
            ->paginate(10);


        return response()->json($stocks);
    }




    public function store(Request $request)
    {


        $size = new Stock([

            'quantity' => $request->post('quantity'),
            'price' => $request->post('price'),
            'unit_id' => $request->post('unit_id'),
            'product_id' => $request->post('product_id'),
            'store_id' => $request->post('store_id'),
        ]);

        $size->save();

        return response()->json('successfully added');
    }

    public function movement_repo()
    {
        return response()->json(['statuses' => Status::all()]);
    }


    public function show_repo_movement(Request $request)
    {

        // dd($request->all());

        // DB::enableQueryLog();

        $repo_movement = Stock::with(
            [
                'stockable' => function (MorphTo $morphTo) {
                    // $morphTo->constrain([
                    //     Purchase::class => function ($query) {
                    //         $query->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id');
                    //         $query->select('purchases.*', 'purchases.id as purchase_id', 'suppliers.name as supplier_name');
                    //     }
                    // ]);

                    $morphTo->constrain([
                        Sale::class => function ($query) {
                            $query->join('customers', 'customers.id', '=', 'sales.customer_id');
                            $query->select('sales.*', 'sales.id as sale_id', 'customers.name as customer_name');
                        }
                    ]);
                },

                'store_product' => function ($query) use ($request) {
                    $query->join('stores', 'stores.id', 'store_products.store_id');
                    $query->join('products', 'products.id', 'store_products.product_id');
                    $query->join('statuses', 'statuses.id', 'store_products.status_id');
                    $query->where([
                        'store_products.store_id' => $request->store_id,
                        'store_products.product_id' => $request->product_id,
                        'store_products.status_id' => $request->status_id[0],
                        'store_products.desc' => $request->desc,
                    ]);

                    $query->select('store_products.*', 'stores.text as store', 'products.text as product', 'statuses.name');
                }
            ]
        )
            ->where('stockable_type', 'App\\Models\\Sale')
            // ->select('store_products.*', 'stores.text as store', 'products.text as product')
            ->paginate();

        // $repo_movement = Stock::with(
        //     [
        //         'stockable' => function (MorphTo $morphTo) {
        //             $morphTo->constrain([
        //                 Purchase::class => function ($query) {
        //                     $query->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id');
        //                     $query->select('purchases.*', 'purchases.id as purchase_id', 'suppliers.name as supplier_name');
        //                 },
        //                 // Sale::class => function ($query) {
        //                 //     $query->join('customers', 'customers.id', '=', 'sales.customer_id');
        //                 //     $query->select('sales.*', 'sales.id as sale_id', 'customers.name as customer_name');
        //                 // }


        //             ]);
        //         },

        //         'store_product' => function ($query) {

        //             // $query->join('store_products', 'store_products.id', 'stocks.store_product_id');
        //             $query->join('stores', 'stores.id', 'store_products.store_id');
        //             $query->join('products', 'products.id', 'store_products.product_id');

        //             $query->select('store_products.*', 'stores.text as store', 'products.text as product');
        //         }
        //     ]
        // )
        //     ->where('stocks.stockable_type', 'App\\Models\\Purchase')
        //     // if ($request->date) {

        //     //     $period = $period->whereHas('attendance', function ($query) use ($request) {

        //     //         $query->where('attendances.attendance_date', '=', $request->date);
        //     //     });
        //     // }


        //     // ->join('store_products','store_products.id','stocks.store_product_id')

        //     // ->where('stockable_type', 'App\\Models\\Purchase')
        //     ->select('stocks.stock_type')
        //     ->paginate();



        // dd(DB::getQueryLog());

        return response()->json(['repo_movement' => $repo_movement]);
    }

    public function stock_repo()
    {

        return response()->json(['statuses' => Status::all()]);
    }

    public function show_repo_stock(Request $request)
    {

        // dd($request->all());

        // DB::enableQueryLog();

        $repo_stock = DB::table('store_products')
            ->join('stores', 'stores.id', 'store_products.store_id')
            ->join('products', 'products.id', 'store_products.product_id')
            ->join('statuses', 'statuses.id', 'store_products.status_id')
            // ->where([
            //     'store_products.store_id' => $request->store_id,
            //     'store_products.product_id' => $request->product_id,
            //     'store_products.status_id' => $request->status_id[0],
            //     'store_products.desc' => $request->desc,
            // ])

            ->select('store_products.*', 'stores.text as store', 'products.text as product', 'statuses.name')
            ->paginate();




        // dd(DB::getQueryLog());

        return response()->json(['repo_stock' => $repo_stock]);
    }
}
