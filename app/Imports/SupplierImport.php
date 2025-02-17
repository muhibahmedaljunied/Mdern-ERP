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
            
            'name'    => $row[0],
            'code'     => $row[1],
            'company'    => $row[2],
            'email'    => $row[3],
            'phone'    => $row[4],
            'address'    => $row[5],
            'status' => $row[6],
            'group_id' => $row[7],
     


        ]);
    }
}
