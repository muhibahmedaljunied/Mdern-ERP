<?php

namespace App\Imports;

use App\Models\OpeningInventury;
use App\Models\Stock;
use App\Models\StoreProduct;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class OpeningInventuryImport implements ToModel, WithHeadingRow
{




    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        // foreach ($row as $rows) {

        $store_product = StoreProduct::create([

            "product_id" => $row['product_id'],
            "store_id" => $row['store_id'],
            "status_id" => $row['status_id'],
            "desc" => $row['desc'],
            "cost" => $row['cost'],
            "qr_code" => $row['qr_code'],
            "quantity" => $row['quantity'],
            "cost" => $row['cost'],
            "total" => $row['total'],

        ]);
        $opening_inventury  = OpeningInventury::create([

            "store_product_id" => $store_product->id ?? NULL,
            "unit_id" => $row['unit_id'],
            "qty" => $row['quantity'],
            "total" => 0,
            "date" => $row['date'],


        ]);
        Stock::create([

            "store_product_id" => $store_product->id ?? NULL,
            "unit_id" => $row['unit_id'],
            "stockable_type" => 'App\Models\OpeningInventury',
            "stockable_id" => $opening_inventury->id,
            "quantity" => $row['quantity'],
            "date" => $row['date'],


        ]);
        // }



        return $opening_inventury;
    }
}
