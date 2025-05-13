<?php


namespace App\Repository\StoreInventury;

use App\Models\FamilyAttributeOption;
use App\Models\ProductPrice;
use App\Models\StoreProduct;
use App\RepositoryInterface\StoreRepositoryInterface;
use App\Services\CoreService;

class StoreSaleReturnRepository extends StoreRepository implements StoreRepositoryInterface
{
    public $family_attribute_option;
    public $product_price;
    public $operation;

    public function __construct(CoreService $core)
    {
        $this->core = $core;
        $this->operation = 'increment';
    }
    public function store()
    {


        $this->get_store_product_when_return_to_another_store();
        $this->check_founded_store();
        $this->family_attribute_option();
        $this->product_price();

    }


    public function check_founded_store()
    {

        if ($this->core->id_store_product == 0) {

            $this->init_store_product_table();

        } else {

            $this->refresh_store_product();
        }
    }


    public function refresh_store_product()
    {


        $this->refresh_qty_store_product_table();
        $this->refresh_total_store_product_table();
        $this->get_store_product_first();
        $this->refresh_cost_store_product_table();
    }


    public function init_store_product_table()
    {


        $this->core->data_store_product = new StoreProduct();
        $this->core->data_store_product->product_id = $this->core->data['old'][$this->core->value]['product_id'];
        $this->core->data_store_product->qr_code = $this->core->data['old'][$this->core->value]['qr_code'];
        $this->core->data_store_product->store_id = $this->core->data['store'][$this->core->value];
        $this->core->data_store_product->status_id = $this->core->data['old'][$this->core->value]['status_id'];
        $this->core->data_store_product->desc = $this->core->data['old'][$this->core->value]['desc'];
        $this->core->data_store_product->quantity = $this->core->micro_unit_qty;
        $this->core->data_store_product->cost = $this->core->data['total'][$this->core->value] / $this->core->micro_unit_qty;
        $this->core->data_store_product->total = $this->core->data['total'][$this->core->value];
        $this->core->data_store_product->save();
        $this->core->id_store_product =  $this->core->data_store_product->id;
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
