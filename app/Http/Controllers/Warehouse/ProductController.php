<?php

namespace App\Http\Controllers\Warehouse;

use App\Services\Product\ProductService;
use App\Services\ProductService as ProService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Exports\ProductExport;
use App\Exports\ProductUnitExport;
use App\Imports\ProductUnitImport;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{



    public $request;
    public function __construct(Request $request)
    {

        $this->request = $request;
    }

    public function init_data($product_service)
    {

        $product_service->request = $this->request->all();
        $product_service->count = json_decode($this->request['count']);
        $product_service->data = json_decode($this->request['product_attr']);
    }

    public function index(Request $request) {}

    protected function random($length = 14)
    {
        $pool = '123456789';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length - 2);
    }



    public function search(Request $request)
    {


        $products = Product::where('products.name', 'LIKE', '%' . $request->post('word_search') . '%')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('group_categories', 'group_categories.id', '=', 'categories.group_id')
            ->select('products.*', 'categories.name as category_name', 'group_categories.name as group_name')
            ->paginate(10);
        return response()->json($products);
    }

    public function tree_product()
    {


        // $products = Cache::rememberForever('tree_product_products', function () {

        // return Product::where('parent_id', null)->with('children')->get();
        $products = Product::where('parent_id', null)->with('children')->get();
        // });

        // $last_nodes = Cache::rememberForever('tree_product_last_nodes', function () {

        // return Product::where('parent_id', null)->select('products.*')->max('id');
        $last_nodes = Product::where('parent_id', null)->select('products.*')->max('id');
        // });

        return response()->json([
            'trees' => $products,
            'last_nodes' => $last_nodes
        ]);
    }



    public function import(Request $request)
    {

        Excel::import(new ProductImport, storage_path('product.xlsx'));
        Excel::import(new ProductUnitImport, storage_path('product_unit.xlsx'));

        return response()->json([
            'status' =>
            'The file has been excel/csv imported'
        ]);
    }


    public function export()
    {

        Excel::download(new ProductExport, 'product.xlsx');
        Excel::download(new ProductUnitExport, 'product_unit.xlsx');


        return response()->json([
            'status' =>
            'The file has been excel/csv exporteded'
        ]);
    }




    public function store2(ProService $product_service)
    {




        // dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     'text' => 'required',
        //     'hash_rate' => 'required',
        //     'purchase_price' => 'required',
        // ]);

        // if ($validator->fails()) {


        //     return response([
        //         'message' => $validator->errors(),
        //         'status' => 'failed'
        //     ], 401);
        // }




        $this->init_data($product_service);
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            // --------------------------------------------------------------------------------------
            $product_service->save_product();
            // --------------------------------------------------------------------------------------
            $product_service->get_attribute_option();


            foreach ($product_service->count as $value) {

                // --------------------------------this save variant details of every product---------------
                $product_service->save_product_family_attribute($this->request->file('image'), $value);

                // -----------------------------------this save attributes of every product------------------
                $product_service->save_family_attribute_option($value);
            }



            // dd(Product::all());
            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB


            return response([
                'message' => "product created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"


            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }


        // return response()->json($request->file('image'));
    }

    public function store(ProductService $product)
    {




        // dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     'text' => 'required',
        //     'hash_rate' => 'required',
        //     'purchase_price' => 'required',
        // ]);

        // if ($validator->fails()) {


        //     return response([
        //         'message' => $validator->errors(),
        //         'status' => 'failed'
        //     ], 401);
        // }




        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction



            $product
                ->check()
                ->product()
                ->unit();


            Cache::forget('tree_product_products');
            Cache::forget('tree_product_last_nodes');
            Cache::forget('stock');



            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB



            return response([
                'message' => "product created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {
            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }


        // return response()->json($request->file('image'));
    }


    public function product_details_node($id)
    {


        $details = DB::table('products')
            ->where('products.id', '=', $id)
            ->select('products.*')
            ->get();


        $childs = Product::where('parent_id', $id)->select('products.*')->max('id');


        return response()->json(['childs' => $childs, 'details' => $details]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Product::find($id);
        return response()->json(['data' => $data]);
    }

    public function product_edit_node(Request $request, $id)
    {

        $data = Product::find($id);
        return response()->json(['data' => $data]);
    }

    public function product_update_node(Request $request, $id)
    {

        $data = Product::find($id);
        return response()->json(['data' => $data]);
    }

    public function product_rename_node(Request $request, $id)
    {

        $data = Product::find($id);
        $data->text = $request->post('text');
        $data->save();

        return response()->json($data);
    }


    // public function update(Request $request)
    // {

    //     // return response()->json($request);
    //     if ($request->post('image') != 0) {

    //         $file = $request->file('image');
    //         $upload_path = public_path('assets/upload');
    //         $file_name = $file->getClientOriginalName();
    //         $generated_new_name = time() . '.' . $file->getClientOriginalExtension();
    //         $file->move($upload_path, $file_name);
    //         // $request->merge(['image' => $file_name]);

    //     } else {

    //         $image = Product::find($request->id);


    //         $request->merge(['image' => $image->image]);
    //     }

    //     // return response()->json($image);
    //     // -----------------------------------------
    //     $product = Product::find($request->id);
    //     $product->update($request->post());
    //     return response()->json($request->file('image'));

    //     // ------------------------------------------

    // }


    public function destroy($id)
    {

        // $rr = Product::first()->getTable();
        // $rr = app(Product::class)->getTable();
        // Is there a way to list all relationships of a model?
        $article = new Product;
        dd($article->relationships());
        $product = Product::find($id);
        $product_unit = DB::table('product_units')
            ->where('product_id', '=', $id)
            ->delete();
        $product->delete();

        return response()->json('successfully deleted');
    }
}
