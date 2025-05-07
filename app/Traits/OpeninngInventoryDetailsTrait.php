<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;
trait OpeninngInventoryDetailsTrait
{



    public function add_into_opening_inventory_details_table()
    {




        $opening_inventury = DB::table('opening_inventuries')
            ->where(['id' => $this->core->data_store_product[0]['id']])
            ->update([
                'qty' => $this->core->micro_unit_qty,
                'cost' => $this->core->data['cost'][$this->core->value]
            ]);

            dd($opening_inventury);



        // $opening_inventury = OpeningInventury::create(
        //     [
        //         'cost' => $this->core->data['cost'][$this->core->value],
        //         // 'supplier_name' => $this->core->data['supplier_name'],
        //         'store_product_id' => $this->core->id_store_product,
        //         'unit_id' => $this->core->unit_array[0],
        //         'qty' => $this->core->micro_unit_qty,


        //     ]
        // );




        $this->core->stockable = $opening_inventury;
    }
}
