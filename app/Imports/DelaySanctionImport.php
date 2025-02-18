<?php

namespace App\Imports;
<<<<<<< HEAD
use App\Models\DelaySanction;
=======

use App\models\Product;
>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25
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
<<<<<<< HEAD
        return new DelaySanction([

            'delay_type_id'    => $row['delay_type_id'],
            'part_id' => $row['part_id'],
            'sanction_discount_id' => $row['sanction_discount_id'],
=======
        return new Product([

            'delay_type_id'    => $row[' 	delay_type_id'],
            'part_id ' => $row['part_id '],
            'rank' => $row['rank'],
>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25
            'discount' => $row['discount'],
            'iteration' => $row['iteration'],
            'sanction' => $row['sanction'],






        ]);
    }
}
