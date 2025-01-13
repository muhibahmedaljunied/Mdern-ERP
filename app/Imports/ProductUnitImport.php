<?php

namespace App\Imports;
use App\Models\ProductUnit;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductUnitImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProductUnit([
            
            'id'  => $row['id'],
            'product_id'    => $row['product_id'],
            'unit_id' => $row['unit_id'],
            'purchase_price'     => $row['purchase_price'],
            'rate'    => $row['rate'],


        ]);
    }
}
