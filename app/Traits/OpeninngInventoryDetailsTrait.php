<?php

namespace App\Traits;

use App\Models\OpeningInventury;

trait OpeninngInventoryDetailsTrait
{



    public function add_into_opening_inventory_details_table()
    {


        // $Details = new OpeningInventury();
        // $Details->cost = $this->core->data['price'][$this->core->value];
        // // $Details->total = $this->core->data['total'][$this->core->value];
        // $Details->store_product_id = $this->core->id_store_product;
        // $Details->unit_id = $this->core->unit_array[0];
        // $Details->qty = $this->core->micro_unit_qty;
        // // $Details->qty = $this->core->data['qty'][$this->core->value];

        // $Details->save();
        // dd($Details->id);

        $opening_inventury = OpeningInventury::create(
            [
                'cost' => $this->core->data['price'][$this->core->value],
                // 'supplier_name' => $this->core->data['supplier_name'],
                'store_product_id' => $this->core->id_store_product,
                'unit_id' => $this->core->unit_array[0],
                'qty' => $this->core->micro_unit_qty,


            ]
        );




        $this->core->stockable = $opening_inventury;
    }
}
