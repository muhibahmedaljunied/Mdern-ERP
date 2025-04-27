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

        for ($value = 0; $value < $this->count; $value++) {

            foreach ($this->data[$value] as $key => $value2) {


                $arrayName['fam'][$value][$key]  = $value2[0];
                $arrayName['att'][$value][$key]  = [$value2[1]];
            }
        }

        $this->arrayName = $arrayName;
    }



    public function save_product_family_attribute()
    {

        $product_attribute = new StoreProduct();
        $product_attribute->product_id = $this->product->id;
        $product_attribute->status_id = $this->request['status_product'];
        $product_attribute->desc = $this->request['desc'];
        $product_attribute->save();
        $this->product_attribute = $product_attribute;
    }


    public function save_family_attribute_option($value)
    {


        foreach ($this->arrayName['att'][$value] as $value2) {


            $attribute_option = new FamilyAttributeOption();
            $attribute_option->attribute_family_mapping_id = $this->arrayName['fam'][$value][$value];
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
                $file = $image[$value];
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
        // dd($this->product->id);

        $this->id = $this->product->id;

        return $this;
    }
    public function unit()
    {

        if ($this->request['status'] == 'false') {


            if ($this->request['unit']) {

                $product_unit = new ProductUnit();
                $product_unit->unit_id = $this->request['unit'];
                $product_unit->rate = 1;
                $product_unit->product_id = $this->id;

                $product_unit->save();

                // dd($this->request);
                for ($value = 0; $value < $this->request['count_unit']; $value++) {


                    $product_unit = new ProductUnit();
                    $product_unit->unit_id = $this->request['retail_unit'][$value];
                    $product_unit->product_id = $this->id;
                    $product_unit->rate = $this->request['hash_rate'][$value];
                    $product_unit->save();

                    // return response()->json($value);
                }
            } else {

                $unit = collect(Unit::where('name', 'default')->get('id'))->toArray();

                $product_unit = new ProductUnit();

                $product_unit->unit_id = $unit[0]['id'];
                $product_unit->product_id = $this->id;
                $product_unit->rate = 1;
                $product_unit->save();
            }
        }
    }
}
