<?php

namespace App\Imports;

use App\models\Product;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class GroupImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            
            'name'  => $row['name'],
            'group_type_id'    => $row['group_type_id'],
            'code' => $row['code'],
            'status'     => $row['status'],
      





        ]);
    }
}
