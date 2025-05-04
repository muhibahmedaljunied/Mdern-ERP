<?php

namespace App\Traits;

use App\Models\ProductUnit;
use Illuminate\Support\Facades\DB;

trait OperationDataTrait
{

    public function product_detail()
    {



        $this->qty->details = DB::table('products');

        if ($this->qty->request->id) {

            $this->qty->details =  $this->qty->details->where('products.id', $this->qty->request->id);
        }


        $this->qty->details = $this->qty->details->join('store_products', 'store_products.product_id', '=', 'products.id')
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

        // dd($this->qty->details);
    }


    public function product_detail_by_store()
    {



        $this->qty->details = DB::table('products')
            ->where('stores.id', $this->qty->request->id)
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

        // dd($this->qty->details);
    }

    public function variant()
    {


        foreach ($this->qty->details as $value) {

            $value->kk = collect(DB::table('family_attribute_options')
                ->where('family_attribute_options.store_product_id', $value->store_product_id)
                ->join('attribute_options', 'attribute_options.id', '=', 'family_attribute_options.attribute_option_id')
                ->join('attributes', 'attributes.id', '=', 'attribute_options.attribute_id')
                ->get())
                ->toArray();
        }
    }

    public function unit()
    {


        foreach ($this->qty->details as $value) {

            $value->unit = ProductUnit::where([
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
