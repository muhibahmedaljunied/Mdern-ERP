<?php

namespace App\Http\Controllers\Warehouse;
use App\Traits\OperationDataTrait;
use App\Models\Stock;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use App\Traits\Unit\UnitsTrait;
use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Repository\Qty\QtyStockRepository;
use App\Services\FilterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{

    use UnitsTrait, OperationDataTrait;

    public $qty;
    public $request;
    public $filter;
    public $pds;
    public function __construct(

        Request $request,
        QtyStockRepository $qty,
        FilterService $filter,


    ) {

        $this->qty = $qty;
        $this->filter = $filter;
        $this->request = $request;

    }

    public function index()
    {

        $this->qty->set_compare_array(['quantity']);
        // $qty->details = Cache::rememberForever('stock', function () {
        $this->start();
        // });
        $this->variant();
        $this->qty->handle_qty();
        // dd( $this->qty->details);
        return response()->json([

            'stocks' => $this->qty->details

        ]);
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
        return response()->json([
            'statuses' => Status::all(),
            'users' => Auth::user()
        ]);
    }


    public function show_repo_movement(Request $request)
    {

        // dd($request->all());

        // DB::enableQueryLog();


        $count = 0;
        $select = [];
        $repo_movement = DB::table('stocks')
            ->join('store_products', 'store_products.id', 'stocks.store_product_id');

        $select[0] =  'store_products.*';
        if ($request->desc) {

            $repo_movement = $repo_movement
                ->where('store_products.desc', $request->desc);
        }

        $repo_movement = $repo_movement
            ->whereBetween('date', $request->from_date, $request->to_date);
        if ($request->store_id > 0) {

            $repo_movement = $repo_movement->join('stores', 'stores.id', 'store_products.store_id')
                ->where('store_products.store_id', $request->store_id);

            $select[1] =  'stores.*';
            $select[2] =  'stores.text as store';
            $count += 2;
        }

        if ($request->product_id > 0) {


            $repo_movement = $repo_movement->join('products', 'products.id', 'store_products.product_id')
                ->where('store_products.product_id', $request->product_id);
            $count += 1;
            $select[$count] =  'products.text as product';
        }

        if ($request->status_id > 0) {


            $repo_movement = $repo_movement->join('statuses', 'statuses.id', 'store_products.status_id')
                ->where('store_products.status_id', $request->status_id[0]);
            $count += 1;
            $select[$count] =  'statuses.name';
        }

        // for ($i=1; $i < 10; $i++) {

        //     if ($request->type_operation[0] == 2) {

        //         $repo_movement = $repo_movement->join('cashes', 'cashes.id', 'stockable_id')->where('stockable_type', 'App\Models\Cash');
        //         $select[5] =  'cashes.*';
        //     }


        // }
        if ($request->type_operation[0] == 2) {

            $repo_movement = $repo_movement->join('cashes', 'cashes.id', 'stockable_id')
                ->where('stockable_type', 'App\Models\Cash');
            $count += 1;
            $select[$count] =  'cashes.*';
        }
        if ($request->type_operation[0] == 3) {

            $repo_movement = $repo_movement->join('supplies', 'supplies.id', 'stockable_id')
                ->where('stockable_type', 'App\Models\Supply');
            $count += 1;
            $select[$count] =  'supplies.*';
        }
        if ($request->type_operation[0] == 4) {

            $repo_movement = $repo_movement->join('cash_returns', 'cash_returns.id', 'stockable_id')
                ->where('stockable_type', 'App\Models\CashReturn');
            $count += 1;
            $select[$count] =  'cash_returns.*';
        }
        if ($request->type_operation[0] == 5) {

            $repo_movement = $repo_movement->join('supply_returns', 'supply_returns.id', 'stockable_id')
                ->where('stockable_type', 'App\Models\SupplyReturn');
            $count += 1;
            $select[$count] =  'supply_returns.*';
        }

        if ($request->type_operation[0] == 6) {

            $repo_movement = $repo_movement->join('sales', 'sales.id', 'stockable_id')
                ->where('stockable_type', 'App\Models\Sale');
            $count += 1;
            $select[$count] =  'supplies.*';
        }

        if ($request->type_operation[0] == 7) {

            $repo_movement = $repo_movement->join('purchases', 'purchases.id', 'stockable_id')
                ->where('stockable_type', 'App\Models\Purchase');
            $count += 1;
            $select[$count] =  'supplies.*';
        }

        $count += 1;
        $select[$count] =  'stocks.*';
        $repo_movement = $repo_movement->select(
            $select


        )->paginate();


        // dd($select);
        // dd($repo_movement);
        // --------------------------------------------------------------------------------------------------------------------------------------------------


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

        return response()->json([
            'repo_movement' => $repo_movement

        ]);
    }

    public function stock_repo()
    {

        return response()->json([
            'statuses' => Status::all(),
            'users' => Auth::user()
        ]);
    }

    public function show_repo_stock(Request $request)
    {


        // dd($request->all());

        // DB::enableQueryLog();




        $select = [];


        $repo_stock = DB::table('store_products');
        $select[0] =  'store_products.*';
        if ($request->store_id > 0) {

            $repo_stock = $repo_stock->join('stores', 'stores.id', 'store_products.store_id')
                ->where('store_products.store_id', $request->store_id);

            $select[1] =  'stores.*';
            $select[2] =  'stores.text as store';
        }
        // ---------------------------------------------------------------------------------------------
        if ($request->product_id > 0) {


            $repo_stock = $repo_stock->join('products', 'products.id', 'store_products.product_id')
                ->where('store_products.product_id', $request->product_id);

            $select[3] =  'products.text as product';
        }
        // ---------------------------------------------------------------------------------------------

        if ($request->status_id > 0) {


            $repo_stock = $repo_stock->join('statuses', 'statuses.id', 'store_products.status_id')
                ->where('store_products.status_id', $request->status_id[0]);

            $select[4] =  'statuses.name';
        }
        // ---------------------------------------------------------------------------------------------

        if ($request->desc != null) {

            $repo_stock = $repo_stock->Where([

                'store_products.desc' => $request->desc,
            ]);
        }



        $repo_stock = $repo_stock->select($select)
            ->paginate();

        // dd(DB::getQueryLog());
        return response()->json([
            'repo_stock' => $repo_stock

        ]);
    }
}
