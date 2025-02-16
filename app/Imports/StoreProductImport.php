<?php

namespace App\Imports;
use App\Models\StoreProduct;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class StoreProductImport implements ToModel, WithHeadingRow
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new StoreProduct([

            'id',
            'product_id',
            'store_id',
            'status_id',
            'desc',
            'qr_code',
            'quantity',
            'cost',
            'total',
            'created_at',
            'updated_at',
          

            // 'id'  => $row['id'],
            // 'parent_id'    => $row['parent_id'],
            // 'text' => $row['text'],
            // 'rank'     => $row['rank'],
            // 'product_minimum'    => $row['product_minimum'],
            // 'image'    => $row['image'],





        ]);
    }
}
