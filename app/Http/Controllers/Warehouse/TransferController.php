<?php

namespace App\Http\Controllers\Warehouse;

use App\Repository\Unit\UnitTransferRepository;
use App\Repository\StoreInventury\StoreTransferRepository;
use App\Repository\StockInventury\StockTransferRepository;
use App\Repository\CheckData\CheckTransferRepository;
use App\Traits\Transfer\StoreProductTrait;
use App\Repository\Stock\TransferRepository;
use App\Traits\Details\DetailsTrait;
use App\Traits\OperationDataTrait;
use App\Traits\GeneralTrait;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\TransferDetail;
use App\Services\CoreService;
use App\Http\Controllers\Controller;
use App\Repository\Qty\QtyStockRepository;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{

    use StoreProductTrait,
        DetailsTrait,
        OperationDataTrait,
        GeneralTrait;


    public $qty;
    public $details;
    public $store_products;


    public function  __construct(
        Request $request,
        QtyStockRepository $qty,
        public CoreService $core
    ) {

        $this->qty = $qty;
        $this->qty->request = $request;
        $this->core->setData($request->all());
    }



    public function index()
    {
        $transfers = Transfer::all();

        return response()->json($transfers);
    }


    public function create($date)
    {
        $transfer = new Transfer();
        $transfer->date =  $date;

        $transfer->save();
        return $transfer->id;
    }

    public function get_product(Request $request)
    {


        // --------------------------------------------------------------------------
        // $this->qty->set_compare_array(['quantity']);
        // $this->qty->details = ($request->id) ? $this->get_one($request, $this->qty) : $this->get_all($this->qty);
        // $this->qty->handle_qty();

        // return response()->json([
        //     'products' => $this->qty->details,
        //     'customers' => $this->customers(),

        // ]);


        // --------------------------------------------------------------------------



        $this->qty->set_compare_array(['quantity']);
        $this->init();
        $this->operation_data($request);
        $this->qty->handle_qty();

        return response()->json(['products' => $this->qty->details]);
    }
    public function operation_data($request)
    {

        $this->start();
        $this->variant();
        $this->unit();
    }


    public function get_transfer_for_recive(Request $request)
    {

        $transfer_details = TransferDetail::where('transfer_details.transfer_id', $request->id)
            ->jointransfer()
            ->select(
                'products.*',
                'transfer_details.*',
                'units.name as unit',
                'products.text as product',
                'statuses.name as status',
                'stores.text as store',
                'store_products.desc',
            )
            ->get();
        $this->units($transfer_details);


        return response()->json(['transfer_details' => $transfer_details]);
    }
    // public function get_store_product_with_store($request)
    // {



    //     $details =  StoreProduct::where('store_products.quantity', '!=', 0)
    //         ->where('store_products.store_id', $request['id'])
    //         ->joinall()
    //         ->select(
    //             'products.*',
    //             'products.text as product',
    //             'stores.text as store',
    //             'stores.account_id as store_account_id',
    //             'statuses.name as status',
    //             'store_products.quantity as availabe_qty',
    //             'store_products.*',
    //             'store_products.cost as price',
    //             'store_products.id as store_product_id'

    //         )
    //         ->get();


    //     foreach ($details as $value) {

    //         $value->unit_id = 0;
    //     }
    //     return $details;
    // }

    // public function get_store_product_with_product($request)
    // {




    //     $this->details =   StoreProduct::where('store_products.quantity', '!=', 0)
    //         ->where('store_products.product_id', $request['id'])
    //         ->joinall()
    //         ->select(
    //             'store_products.quantity',
    //             'store_products.*',
    //             'products.id',
    //             'products.text as product',
    //             'statuses.name as status',
    //             'stores.text as store'
    //         )
    //         ->get();

    //     foreach ($this->details as $value) {


    //         $value->unit_id = 0;
    //     }
    //     return $this->details;
    // }




    public function data_for_transfer()
    {

        $products = Product::all();
        return response()->json(['products' => $products]);
    }





    public function store(

        StoreTransferRepository $store,
        StockTransferRepository $stock,
        TransferRepository $warehouse,
        UnitTransferRepository $unit,
        CheckTransferRepository $check,
    ) {




        try {

            // dd($this->core->data);

            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $warehouse->add(); // this handle data in transfer table


            foreach ($this->core->data['count'] as $value) {
                // for ($value = 0; $value < $this->core->data['count']; $value++) {



                $this->core->setValue($value);  //this set index of data

                $unit->handle_unit(); // this make decode for unit and convert qty into miqro

                $store->store(); // this handle data in store table

                $warehouse->init_details(); // this make initial for details table

                $stock->stock(); // this handle data in stock table



            }

            // dd(TransferDetail::all());


            // dd('sdsdsd');

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "transfer created successfully",
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




    // public function show()
    // {


    //     // dd($this->qty->request);
    //     $this->qty->set_compare_array(['quantity']);
    //     $this->operation_data();
    //     $this->qty->handle_qty();
    //     return response()->json([
    //         'products' => $this->qty->details,
    //     ]);
    // }




    public function show()
    {



        $transfer_details = DB::table('transfer_details')
            ->join('store_products', 'transfer_details.store_product_id', '=', 'store_products.id')
            // ->join('statuses', 'transfer_details.status_id', '=', 'statuses.id')
            // ->join('stores', 'transfer_details.store_id', '=', 'stores.id')
            // ->join('units', 'transfer_details.unit_id', '=', 'units.id')
            ->select(
                'store_products.*',
                // 'units.name as unit',
                'transfer_details.*',
                // 'statuses.*',
                // 'statuses.name as status',
                // 'stores.*'
            )
            ->get();

        // $transfer_details = DB::table('transfer_details')
        //     ->join('products', 'transfer_details.product_id', '=', 'products.id')
        //     ->join('statuses', 'transfer_details.status_id', '=', 'statuses.id')
        //     ->join('stores', 'transfer_details.store_id', '=', 'stores.id')
        //     ->join('units', 'transfer_details.unit_id', '=', 'units.id')
        //     ->select(
        //         'products.*',
        //         'units.name as unit',
        //         'transfer_details.*',
        //         'statuses.*',
        //         'statuses.name as status',
        //         'stores.*'
        //     )
        //     ->get();

        foreach ($transfer_details as $value) {

            $value->qty_transfer = 0;
            $value->unit_selected = [];
        }
        $this->units($transfer_details);
        return response()->json(['transfer_details' => $transfer_details]);
    }

    public function details_transfer()
    {


        $this->qty->set_compare_array(['qty']);
        $this->init();
        $this->get_details();
        $this->variant();
        $this->qty->handle_qty();


        return response()->json(['transfer_details' => $this->qty->details]);
    }

    public function  get_details()
    {




        $this->qty->details = TransferDetail::where('transfer_details.transfer_id', $this->qty->request->id)
            ->jointransfer()
            ->select(
                'products.*',
                'products.id as product_id',
                'transfer_details.*',
                'products.text as product',
                'statuses.name as status',
                'store_products.desc',
            )
            ->get();

        foreach ($this->qty->details as $value) {

            $value->qty_return_now = 0;
            $value->unit_selected = [];
        }
    }
}
