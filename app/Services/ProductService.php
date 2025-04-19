<?php

namespace App\Services;

use App\Models\Product;
use App\Models\FamilyAttributeOption;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use App\Models\ProductUnit;
use App\Models\Unit;


class ProductService
{

    public $file_name = '';
    public $generated_new_name = '';
    public $id;
    public $kk = 0;
    public $arr_p = array();
    public $count;
    public $data;
    public $request;
    public $product;
    public $arrayName;
    public $product_attribute;



    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get_attribute_option()
    {


        $this->arrayName = array();
        foreach ($this->count as $value) {

            foreach ($this->data[$value - 1] as $key => $value2) {


                $arrayName['fam'][$value - 1][$key]  = $value2[0];
                $arrayName['att'][$value - 1][$key]  = [$value2[1]];
            }
        }

        $this->arrayName = $arrayName;
    }



    public function save_product_family_attribute()
    {

        $product_attribute = new StoreProduct();
        $product_attribute->product_id = $this->product->id;
        // $product_attribute->image = $this->generated_new_name;
        $product_attribute->status_id = $this->request['status_product'];
        $product_attribute->desc = $this->request['desc'];
        $product_attribute->save();
        $this->product_attribute = $product_attribute;
    }


    public function save_family_attribute_option($value)
    {


        foreach ($this->arrayName['att'][$value - 1] as $value2) {


            $attribute_option = new FamilyAttributeOption();
            $attribute_option->attribute_family_mapping_id = $this->arrayName['fam'][$value - 1][$value - 1];
            $attribute_option->store_product_id = $this->product_attribute->id;
            $attribute_option->attribute_option_id = $value2[0];
            $attribute_option->save();
        }
    }

    public function set_image($image, $value = 1)
    {



        if ($this->request->file('image') != 0) {


            if ($this->request['product_type'] == 1) {

                $file = $image;
            }

            if ($this->request['product_type'] == 2) {
                $file = $image[$value - 1];
            }

            $upload_path = public_path('assets/upload');
            $this->generated_new_name = time() . rand() . '.' . $file->getClientOriginalExtension();
            $file->move($upload_path, $this->generated_new_name);
        }

        return $this;
    }

    public function productCodeExists($number)
    {
        return product::whereProductCode($number)->exists();
    }

    public function product()
    {

        $product = new Product();
        $product->text = $this->request['text'];
        if ($this->request['parent'] != 0) {
            $product->parent_id = $this->request['parent'];
        }
        $product->rank = $this->request['rank'];
        $product->product_minimum = $this->request['product_minimum'];
    
        // $product->image = $this->file_name;
        $product->save();
        $this->product = $product;
      
        $this->id = $product->id;

        // dd(Product::all());
        return $this;
    }
    public function unit()
    {


        // purchase_price_for_retail_unit
        // hash_rate
        // retail_unit




        if ($this->request['status'] == 'false') {


            if ($this->request['unit']) {

                $product_unit = new ProductUnit();
                $product_unit->unit_id = $this->request['unit'];
                $product_unit->rate = 1;
                $product_unit->product_id = $this->id;
                // $product_unit->purchase_price = $this->request['purchase_price');
                // $product_unit->unit_type = 1;

                $product_unit->save();


                foreach ($this->request['count'] as $value) {




                    if (
                        $this->request['retail_unit'][$value] !==  'null' ||
                        // $this->request['purchase_price_for_retail_unit')[$value] ||
                        $this->request['hash_rate'][$value] !==  'null'
                    ) {



                        $product_unit = new ProductUnit();

                        $product_unit->unit_id = $this->request['retail_unit'][$value];
                        // $product_unit->rate = $this->request['hash_rate');
                        $product_unit->product_id = $this->id;
                        // $product_unit->purchase_price = $this->request['purchase_price_for_retail_unit')[$value];
                        $product_unit->rate = $this->request['hash_rate'][$value];
                        // $product_unit->unit_type = 0;

                        $product_unit->save();
                    }

                    // return response()->json($value);
                }
            } else {

                $unit = collect(Unit::where('name', 'default')->get('id'))->toArray();

                $product_unit = new ProductUnit();

                $product_unit->unit_id = $unit[0]['id'];
                // $product_unit->rate = $this->request['hash_rate');
                $product_unit->product_id = $this->id;
                // $product_unit->purchase_price = 0;
                $product_unit->rate = 1;
                // $product_unit->unit_type = 0;

                $product_unit->save();
            }
        }
    }
}
