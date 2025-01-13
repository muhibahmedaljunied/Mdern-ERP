<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;

class SupplierImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Supplier([
            
            'id'     => $row[0],
            'name'    => $row[1],
            'code'     => $row[2],
            'company'    => $row[3],
            'email'    => $row[4],
            'phone'    => $row[5],
            'address'    => $row[6],
            'status' => $row[7],
            'group_id' => $row[8],
     


        ]);
    }
}
