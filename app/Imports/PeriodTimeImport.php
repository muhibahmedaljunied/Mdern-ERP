<?php

namespace App\Imports;

use App\models\Product;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class PeriodTimeImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            
   
            'work_system_type_id'    => $row['work_system_type_id'],
            'from_time' => $row['from_time'],
            'into_time'     => $row['into_time'],
            'duration'    => $row['duration'],





        ]);
    }
}
