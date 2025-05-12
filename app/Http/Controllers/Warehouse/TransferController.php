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
use App\Services\FilterService;
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
    public $filter;
    public $core;
    public $request;


    public function  __construct(
        Request $request,
        QtyStockRepository $qty,
        CoreService $core,
        FilterService $filter,

    ) {

        $this->qty = $qty;
        $this->request = $request;
        $this->filter = $filter;
        $this->core = $core;


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

    public function get_product()
    {



        $this->qty->set_compare_array(['quantity']);
        $this->init();
        $this->operation_data();
        $this->qty->handle_qty();

        return response()->json(['products' => $this->qty->details]);
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

            // foreach ($this->core->data['count'] as $value) {
            for ($value = 0; $value < $this->core->data['count']; $value++) {


                $this->core->setValue($value);  //this set index of data

                $unit->handle_unit(); // this make decode for unit and convert qty into miqro

                $store->store(); // this handle data in store table

                $warehouse->init_details(); // this make initial for details table

                $stock->stock(); // this handle data in stock table



            }

            // dd('finall');



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







    public function show()
    {



        $transfer_details = DB::table('transfer_details')
            ->join('store_products', 'transfer_details.store_product_id', '=', 'store_products.id')
            ->select(
                'store_products.*',
                'transfer_details.*',

            )
            ->get();

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


        return response()->json([
            'transfer_details' => $this->qty->details,

        ]);
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
