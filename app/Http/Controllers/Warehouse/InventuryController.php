<?php

namespace App\Http\Controllers\Warehouse;

use App\Exports\OpeningInventuryExport;
use App\Traits\GeneralTrait;
use App\Http\Controllers\Controller;
use App\Imports\OpeningInventuryImport;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\Details\DetailsTrait;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Temporale;
use App\Models\Status;
use App\Repository\Qty\QtyStockRepository;
use App\Services\OpeningService;
use Illuminate\Support\Facades\DB;

class InventuryController extends Controller
{
    use InvoiceTrait, DetailsTrait, GeneralTrait;



    public $qty;
    public function __construct(Request $request, QtyStockRepository $qty)
    {

        $this->qty = $qty;
        $this->qty->request = $request;
    }

    public function index()
    {



        $statuses = Status::all();
        $this->details();

        return response()->json([

            'statuses' => $statuses,
            'details' => $this->qty->details
        ]);
    }


    public function details()
    {
        $this->qty->set_compare_array(['qty']);
        $this->init();
        $this->get_details();
        $this->qty->handle_qty();
        // return response()->json(['details' => $this->qty->details]);
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



        // dd($request->all());
        // -------------------------------------------------------------------------------------

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
