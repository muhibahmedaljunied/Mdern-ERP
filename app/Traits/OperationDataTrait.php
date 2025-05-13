<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait OperationDataTrait
{


    public function operation_data()
    {

        $this->start();
        $this->check_duplicate();
        $this->variant();
        $this->unit();
    }


    public function start()
    {

        if ($this->qty->request->id) {

            $this->qty->details = $this->filter->queryfilter();
        } else {

            $this->qty->details = ($this->request->segment(1) == 'get_product_price') ? $this->product_for_price() : $this->product_detail();
        }


    }

    public function check_duplicate()
    {


        $this->qty->details = (
            $this->request->segment(2) == 'newpurchase' ||
            $this->request->segment(2) == 'newsupply' ||
            $this->request->segment(1) == 'show_product' ||
            $this->request->segment(1) == 'opening'
        ) ? collect($this->qty->details)->unique('qr_code') : $this->qty->details;
    }


    public function product_detail()
    {

        return (

            $this->request->segment(2) == 'newpurchase' ||
            $this->request->segment(2) == 'newsupply' ||
            $this->request->segment(1) == 'show_product' ||
            $this->request->segment(1) == 'opening'
        ) ? $this->product_detail_for_product() : $this->product_detail_for_another();
    }

    public function product_for_price()
    {


        return DB::table('products')
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
    }
    public function product_detail_for_product()
    {




        return DB::table('products')
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

    public function product_detail_for_another()
    {




        return DB::table('products')
            ->join('store_products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            ->select(
                'products.*',
                'products.text as product',
                'stores.text as store',
                'stores.account_id as store_account_id',
                'statuses.name as status',
                'store_products.quantity as availabe_qty',
                'store_products.*',
                'store_products.cost as price',
                'store_products.id as store_product_id'

            )
            ->get();
    }




    public function variant()
    {


        // dd($this->qty->details);
        foreach ($this->qty->details as $key => $value) {


            $value->kk = collect(
                DB::table('family_attribute_options')
                    ->where('family_attribute_options.store_product_id', $value->store_product_id)
                    ->join('attribute_options', 'attribute_options.id', '=', 'family_attribute_options.attribute_option_id')
                    ->join('attributes', 'attributes.id', '=', 'attribute_options.attribute_id')
                    ->get()
            )
                ->toArray();
        }
    }

    public function unit()
    {


        foreach ($this->qty->details as $value) {

            $value->unit = DB::table('product_units')->where([
                'product_prices.store_product_id' => $value->store_product_id
            ])
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->join('product_prices', 'product_prices.product_unit_id', '=', 'product_units.id')
                ->select(
                    'units.*',
                    'product_units.*',
                    'product_units.id as product_unit_id',
                    'product_prices.*',
                )

                ->get();
        }
    }
}
