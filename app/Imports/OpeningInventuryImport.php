<?php

namespace App\Imports;

use App\models\Product;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class OpeningInventuryImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            
            'id'  => $row['id'],
            'parent_id'    => $row['parent_id'],
            'text' => $row['text'],
            'rank'     => $row['rank'],
            'product_minimum'    => $row['product_minimum'],
            'image'    => $row['image'],





        ]);
    }
}
