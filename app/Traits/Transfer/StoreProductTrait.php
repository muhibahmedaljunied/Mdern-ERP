<?php

namespace App\Traits\Transfer;
use App\Models\StoreProduct;
trait StoreProductTrait
{


    public function init_store_product_table() // this intial store that transfer into it if it empty
    {


        // if ($this->init_status == false) {
        // dd($this->core->data['old'][$this->core->value]);
        $this->core->data_store_product =  new StoreProduct();
        $this->core->data_store_product->product_id = $this->core->data['old'][$this->core->value]['product_id'];
        $this->core->data_store_product->qr_code = $this->core->data['old'][$this->core->value]['qr_code'];
        $this->core->data_store_product->store_id = $this->core->data['intostore_id'];
        $this->core->data_store_product->status_id = $this->core->data['old'][$this->core->value]['status_id'];
        $this->core->data_store_product->desc = $this->core->data['old'][$this->core->value]['desc'];
        $this->core->data_store_product->quantity = $this->core->micro_unit_qty;
        $this->core->data_store_product->cost = $this->core->data['old'][$this->core->value]['cost'];
        $this->core->data_store_product->total = $this->core->data['old'][$this->core->value]['cost'] * $this->core->micro_unit_qty;
        $this->core->data_store_product->save();
        $this->core->data_store_product = collect($this->core->data_store_product)->toArray();
        $this->core->id_store_product = $this->core->data_store_product['id'];
        // }
    }


    public function get_store_product_table()  // this check and return store that transfer from it
    {


        $this->core->data_store_product = collect(
            StoreProduct::where([
                'store_products.qr_code' => $this->core->data['old'][$this->core->value]['qr_code'],
                'store_products.store_id' => $this->store,

            ])
                ->select(
                    'store_products.*',
                )
                ->get()
        )->toArray();

        // dd($this->core->data_store_product);
        $this->core->id_store_product = ($this->core->data_store_product == null) ? 0 : $this->core->data_store_product[0]['id'];
    }
}
