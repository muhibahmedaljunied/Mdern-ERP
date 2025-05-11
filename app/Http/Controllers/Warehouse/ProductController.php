<?php

namespace App\Http\Controllers\Warehouse;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Exports\ProductExport;
use App\Exports\ProductUnitExport;
use App\Imports\ProductUnitImport;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Repository\Qty\QtyStockRepository;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\OperationDataTrait;

class ProductController extends Controller
{

    use OperationDataTrait;
    public $qty;
    public $products;
    public $store_products;
    public $request;
    public $product_service;
    public $data_store_product;
    public $key;
    public $filter;

    public function __construct(
        Request $request,
        ProductService $product_service,
        QtyStockRepository $qty,
        FilterService $filter
    ) {

        $this->qty = $qty;
        $this->filter = $filter;
        $this->request = $request;
        $this->product_service = $product_service;
        $this->filter->product_id =  $this->request->id;
    }



    public function init_data()
    {

        $this->product_service->request = $this->request->all();
        $this->product_service->count = $this->request['count'];
        $this->product_service->data = json_decode($this->request['product_attr']);
    }



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



    public function import()
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

    public function show_product()
    {

<<<<<<< HEAD
        $this->start();
        $this->variant();

        return response()->json(['product' => $this->qty->details]);
    


    }


=======
        $this->operation_data();

        return response()->json(['product' => $this->qty->details]);
    }

    public function operation_data()
    {

        ($this->request->id) ? $this->category_filter() : $this->get_product();
        $this->variant();

    }


    public function category_filter()
    {




        $this->qty->details = $this->filter->queryfilter();

    }


    public function get_product()
    {

        $this->qty->details = DB::table('products')
            ->join('store_products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->select(
                'products.*',
                'products.text as product',
                'statuses.name as status',
                'store_products.quantity as availabe_qty',
                'store_products.*',
                'store_products.cost as price',
                'store_products.id as store_product_id'

            )

            ->get();
    }
>>>>>>> a0453f59696fe492f2f043f4027ec1b69f3e1beb

    // public function get_product()
    // {

<<<<<<< HEAD
    //     $this->qty->details = DB::table('products')
    //         ->join('store_products', 'store_products.product_id', '=', 'products.id')
    //         ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
    //         ->select(
    //             'products.*',
    //             'products.text as product',
    //             'statuses.name as status',
    //             'store_products.quantity as availabe_qty',
    //             'store_products.*',
    //             'store_products.cost as price',
    //             'store_products.id as store_product_id'

    //         )

    //         ->get();
    // }


=======
>>>>>>> a0453f59696fe492f2f043f4027ec1b69f3e1beb
    public function pricing()
    {

        $products = DB::table('products')
            ->where('products.id', $this->request->id)
            ->join('store_products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->join('product_units', 'product_units.product_id', '=', 'products.id')
            ->join('units', 'product_units.unit_id', '=', 'units.id')

            ->select(
                'products.*',
                'units.name as unit_name',
                'store_products.id as store_product_id',
                'product_units.id as product_unit_id',
                'store_products.desc',
                'statuses.name',

            )
            ->get();

        foreach ($products as $value) {

            $value->kk = collect(DB::table('family_attribute_options')
                ->where('family_attribute_options.store_product_id', $value->store_product_id)
                ->join('attribute_options', 'attribute_options.id', '=', 'family_attribute_options.attribute_option_id')
                ->join('attributes', 'attributes.id', '=', 'attribute_options.attribute_id')
                ->get())->toArray();

            $product_prices = ProductPrice::where([
                'store_product_id' => $value->store_product_id,
                'product_unit_id' => $value->product_unit_id,

            ])
                ->get();

            foreach ($product_prices as $value2) {

                if ($value2) {

                    $value->cost = $value2->cost;
                    $value->supply_price = $value2->supply_price;
                    $value->small_price = $value2->small_price;
                    $value->big_price = $value2->big_price;
                    $value->private_price = $value2->private_price;
                } else {

                    $value->cost = 0;
                    $value->supply_price = 0;
                    $value->small_price = 0;
                    $value->big_price = 0;
                    $value->private_price = 0;
                }
            }
        }



        return response()->json([
            'products' => $products
        ]);
    }




    public function store()
    {





        // dd($this->request->all());
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

            $this->init_data();
            $this->product();

            if ($this->request['status'] == 'false') {

                $this->product_variant();
            }

            // dd(ProductUnit::all());

            Cache::forget('tree_product_products');
            Cache::forget('tree_product_last_nodes');
            Cache::forget('stock');
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
    public function store_price()
    {





        // dd($this->request->all());
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



            foreach ($this->request['data'] as $key => $value) {

                $this->key = $key;

                $this->get_product_price();
                // ----------------------------------------------------------------------
                if ($this->data_store_product[0] != null) {


                    $this->refresh_product_price();
                } else {


                    $this->init_product_price();
                }






                // ---------------------------------------------

            }

            // dd(ProductPrice::all());

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


    public function get_product_price()
    {

        // dd($this->request['data'][$key]);

        $this->data_store_product = collect(ProductPrice::where([
            'product_unit_id' => $this->request['data'][$this->key]['product_unit_id'],
            'store_product_id' => $this->request['data'][$this->key]['store_product_id'],
        ])->get())->toArray();
    }

    public function refresh_product_price()
    {


        DB::table('product_prices')->where([
            'product_unit_id' => $this->request['data'][$this->key]['product_unit_id'],
            'store_product_id' => $this->request['data'][$this->key]['store_product_id']
        ])
            ->update([
                'cost' => $this->request['data'][$this->key]['cost'],
                'supply_price' => $this->request['data'][$this->key]['supply_price'],
                'small_price' => $this->request['data'][$this->key]['small_price'],
                'big_price' => $this->request['data'][$this->key]['big_price'],
                'private_price' => $this->request['data'][$this->key]['private_price']

            ]);
    }


    public function init_product_price()
    {


        $product = new ProductPrice();
        $product->product_unit_id = $this->request['data'][$this->key]['product_unit_id'];
        $product->store_product_id = $this->request['data'][$this->key]['store_product_id'];
        $product->cost = $this->request['data'][$this->key]['cost'];
        $product->supply_price = $this->request['data'][$this->key]['supply_price'];
        $product->small_price = $this->request['data'][$this->key]['small_price'];
        $product->big_price = $this->request['data'][$this->key]['big_price'];
        $product->private_price = $this->request['data'][$this->key]['private_price'];
        $product->save();
    }
    public function product_variant()
    {

        $this->product_service->get_attribute_option();
        // foreach ($this->product_service->count as $value) {

        for ($value = 0; $value < $this->product_service->count; $value++) {

            // --------------------------------this save variant details of every product---------------
            // $this->product_service->set_image($this->request->file('image'), $value);

            $this->product_service->save_product_family_attribute($this->request->file('image'), $value);
            // -----------------------------------this save attributes of every product------------------
            $this->product_service->save_family_attribute_option($value);
        }
    }

    public function product()
    {

        $this->product_service
            // ->set_image($this->request->file('image'))
            ->product()
            ->unit();
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
