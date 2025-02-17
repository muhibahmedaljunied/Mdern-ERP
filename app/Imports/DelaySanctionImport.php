<?php

namespace App\Imports;

use App\models\Product;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class DelaySanctionImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([

            'delay_type_id'    => $row[' 	delay_type_id'],
            'part_id ' => $row['part_id '],
            'rank' => $row['rank'],
            'discount' => $row['discount'],
            'iteration' => $row['iteration'],
            'sanction' => $row['sanction'],






        ]);
    }
}
