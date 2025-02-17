<?php

namespace App\Imports;

use App\models\Product;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class ExtraSanctionImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([

            'extra_type_id'    => $row['extra_type_id'],
            'part_id' => $row['part_id'],
            'sanction_discount_id'     => $row['sanction_discount_id'],
            'iteration'    => $row['iteration'],
            'sanction'    => $row['sanction'],






        ]);
    }
}
