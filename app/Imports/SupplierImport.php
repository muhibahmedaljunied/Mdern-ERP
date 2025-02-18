<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SupplierImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Supplier([
            
<<<<<<< HEAD
            'name'    => $row['name'],
            'code'     => $row['code'],
            'company'    => $row['company'],
            'email'    => $row['email'],
            'phone'    => $row['phone'],
            'address'    => $row['address'],
            'status' => $row['status'],
            'group_id' => $row['group_id'],
=======
            'name'    => $row[0],
            'code'     => $row[1],
            'company'    => $row[2],
            'email'    => $row[3],
            'phone'    => $row[4],
            'address'    => $row[5],
            'status' => $row[6],
            'group_id' => $row[7],
>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25
     


        ]);
    }
}
