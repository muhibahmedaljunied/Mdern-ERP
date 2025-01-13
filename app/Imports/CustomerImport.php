<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomerImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
            
            'id'     => $row[0],
            'name'    => $row[1],
            'email'    => $row[2],
            'phone'    => $row[3],
            'address'    => $row[4],
            'status' => $row[5],
            'group_id' => $row[6],
     


        ]);
    }
}
