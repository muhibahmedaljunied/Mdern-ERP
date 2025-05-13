<?php

namespace App\Traits;

use App\Models\ProductPrice;
use Illuminate\Support\Facades\DB;

trait ProductPriceTrait
{


    public function get_product_price()
    {


        // dd($this->request['data'][$this->key]['product_unit_id'],$this->request['data'][$this->key]['store_product_id']);
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



        // dd($this->request['data'][$this->key]);
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




}
