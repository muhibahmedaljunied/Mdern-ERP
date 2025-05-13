<?php

namespace App\Repository\StoreInventury;

use App\Models\FamilyAttributeOption;
use App\Models\ProductPrice;
use App\Traits\Transfer\StoreProductTrait;
use App\Services\CoreService;

class StoreTransferRepository extends StoreRepository
{

    use StoreProductTrait;
    public $store = '';
    public $family_attribute_option;
    public $product_price;
    public function __construct(CoreService $core)
    {
        $this->core = $core;
    }

    public function store()
    {

        // $this->refresh_store_product_transfer(['decrement', 'increment']);
        // --------------------------------------

        $this->handle_from_store();

        $this->handle_into_store();
    }


    public function handle_from_store()
    {

        // dd($this->core->data['old'][$this->core->value]);

        $this->operation = 'decrement';
        $this->store = $this->core->data['old'][$this->core->value]['store_id'];

        $this->get_store_product_first();

        $this->refresh_store_product();
    }
    public function handle_into_store()
    {

        $this->operation = 'increment';
        $this->store = $this->core->data['intostore_id'];
        $this->get_store_product_table();
        $this->check_founded_store();
        $this->family_attribute_option();
        $this->product_price();
    }


    public function refresh_store_product()
    {


        $this->refresh_qty_store_product_table();

        // $this->refresh_total_store_product_table();

        // $this->get_store_product_table();

        // $this->refresh_cost_store_product_table();
    }

    public function check_founded_store()
    {


        if ($this->core->id_store_product == 0) {


            $this->init_store_product_table();
            
        } else {


            $this->refresh_store_product();
        }
    }

    public function family_attribute_option()
    {


        if ($this->core->id_store_product != 0) {


            $this->get_family_attribute_option();
            $this->init_family_attribute_option();
        }
    }

    public function product_price()
    {

        if ($this->core->id_store_product != 0) {


            $this->get_product_price();
            $this->init_product_price();
        }
    }


    public function init_product_price()
    {


        foreach ($this->product_price as $value) {





            $attribute_option = new ProductPrice();
            $attribute_option->cost = $value['cost'];
            $attribute_option->product_unit_id = $value['product_unit_id'];
            $attribute_option->store_product_id = $this->core->id_store_product;
            $attribute_option->supply_price = $value['supply_price'];
            $attribute_option->small_price = $value['small_price'];
            $attribute_option->big_price = $value['big_price'];
            $attribute_option->private_price = $value['private_price'];
            $attribute_option->save();
        }
    }

    public function get_product_price()
    {


        $this->product_price = collect(
            ProductPrice::where([
                'product_prices.store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id'],

            ])
                ->select(
                    'product_prices.*',
                )
                ->get()
        )->toArray();
    }
    public function get_family_attribute_option()
    {


        $this->family_attribute_option = collect(
            FamilyAttributeOption::where([
                'family_attribute_options.store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id'],

            ])
                ->select(
                    'family_attribute_options.*',
                )
                ->get()
        )->toArray();
    }
    public function init_family_attribute_option()
    {


        foreach ($this->family_attribute_option as $value) {


            $attribute_option = new FamilyAttributeOption();
            $attribute_option->attribute_family_mapping_id = $value['attribute_family_mapping_id'];
            $attribute_option->store_product_id = $this->core->id_store_product;
            $attribute_option->attribute_option_id = $value['attribute_option_id'];
            $attribute_option->save();
        }
    }
}
