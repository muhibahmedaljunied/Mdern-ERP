<?php

namespace App\Services\Product;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Unit;

class ProductService
{

    public $file_name = '';
    public $request;
    public $id;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function check()
    {

        if ($this->request->file('image') != 0) {


            $file = $this->request->file('image');
            $upload_path = public_path('assets/upload');
            $this->file_name = $file->getClientOriginalName();
            $generated_new_name = time() . '.' . $file->getClientOriginalExtension();
            $file->move($upload_path, $this->file_name);
        }

        return $this;
    }

    public function productCodeExists($number)
    {
        return product::whereProductCode($number)->exists();
    }

    public function product()
    {




        // Product::create($request->all());


        $product = new Product();
        $product->text = $this->request->post('text');
        if ($this->request->post('parent') != 0) {
            $product->parent_id = $this->request->post('parent');
        }
        $product->id = $this->request->post('product_id');
        $product->rank = $this->request->post('rank');
        $product->product_minimum = $this->request->post('product_minimum');
        // $product->status = $this->request->post('status');
        // $product->rate = $this->request->post('hash_rate');
        // $product->product_code = $request['product_code'];
        $product->image = $this->file_name;
        $product->save();
        // dd(1);
        $this->id = $product->id;
        return $this;
    }
    public function unit()
    {


        // purchase_price_for_retail_unit
        // hash_rate
        // retail_unit



        if ($this->request->post('status') =='false') {


            if ($this->request->post('unit')) {

                $product_unit = new ProductUnit();
                $product_unit->unit_id = $this->request->post('unit');
                $product_unit->rate = 1;
                $product_unit->product_id = $this->id;
                $product_unit->purchase_price = $this->request->post('purchase_price');
                // $product_unit->unit_type = 1;

                $product_unit->save();


                foreach ($this->request['count'] as $value) {




                    if (
                        $this->request->post('retail_unit')[$value] !==  'null' ||
                        // $this->request->post('purchase_price_for_retail_unit')[$value] ||
                        $this->request->post('hash_rate')[$value] !==  'null'
                    ) {



                        $product_unit = new ProductUnit();

                        $product_unit->unit_id = $this->request->post('retail_unit')[$value];
                        // $product_unit->rate = $this->request->post('hash_rate');
                        $product_unit->product_id = $this->id;
                        $product_unit->purchase_price = $this->request->post('purchase_price_for_retail_unit')[$value];
                        $product_unit->rate = $this->request->post('hash_rate')[$value];
                        // $product_unit->unit_type = 0;

                        $product_unit->save();
                    }

                    // return response()->json($value);
                }
            } else {

                $unit = collect(Unit::where('name', 'default')->get('id'))->toArray();

                $product_unit = new ProductUnit();

                $product_unit->unit_id = $unit[0]['id'];
                // $product_unit->rate = $this->request->post('hash_rate');
                $product_unit->product_id = $this->id;
                $product_unit->purchase_price = 0;
                $product_unit->rate = 1;
                // $product_unit->unit_type = 0;

                $product_unit->save();
            }
        }


    }
}
