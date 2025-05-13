<?php

namespace App\Http\Controllers\Warehouse;
use App\Exports\OpeningInventuryExport;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use App\Imports\OpeningInventuryImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Temporale;
use App\Models\Status;
use App\Repository\Qty\QtyStockRepository;
use App\Services\FilterService;
use App\Services\OpeningService;
use Illuminate\Support\Facades\DB;
class InventuryController extends Controller
{
    use GeneralTrait;

    public $qty;
    public $products;
    public $store_products;
    public $request;
    public $filter;
    public function __construct(
        Request $request,
        QtyStockRepository $qty,
        FilterService $filter
    ) {

        $this->qty = $qty;
        $this->request = $request;
        $this->filter = $filter;




    }



    public function index()
    {


        $this->product();
        $this->operation_data();
        return response()->json([
            'products' => $this->products,
            'store_products' => $this->qty->details,
            'statuses' => Status::all(),

        ]);
    }
    public function operation_data()
    {

        $this->start();
        $this->variant();
        $this->unit();
    }
    public function product()
    {


        $this->products = DB::table('products')
            ->select('products.*',)
            ->get();
    }






    public function details()
    {

        $this->qty->set_compare_array(['qty']);
        $this->init();
        $this->get_details();
        $this->variant();
        $this->qty->handle_qty();
    }
    public function import()
    {

        Excel::import(new OpeningInventuryImport, storage_path('opening_inventury.xlsx'));

        return response()->json([
            'status' =>
            'The file has been excel/csv imported'
        ]);
    }


    public function export()
    {

        Excel::download(new OpeningInventuryExport, 'opening_inventury.xlsx');



        return response()->json([
            'status' =>
            'The file has been excel/csv exporteded'
        ]);
    }

    public function store(
        OpeningService $stock
    ) {






        // dd($this->qty->request);
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            $stock->handle();




            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => " created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {
            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
        // -------------------------------------------------------------------------------------

        return response()->json(['message' => 'success']);
    }





    public function destroy(Request $request)
    {
        if ($request->id) {
            Temporale::where('type_process', 'sale')->where('temporales.product_id', $request->id)->delete();
        } else {
            Temporale::where('type_process', 'sale')->delete();
        }


        return response()->json('successfully deleted');
    }
}
