<?php

namespace App\Imports;

use App\Models\AbsenceSanction;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class AbsenceSanctionImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new AbsenceSanction([

            'absence_type_id'=> $row['absence_type_id'],
            'sanction_discount_id' => $row['sanction_discount_id'],
            'discount'     => $row['discount'],
            'iteration'    => $row['iteration'],
            'sanction'    => $row['sanction'],





        ]);
    }
}
