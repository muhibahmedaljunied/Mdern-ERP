<?php

namespace App\Imports;
<<<<<<< HEAD
use App\Models\ExtraSanction;
=======

use App\models\Product;
>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25
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
<<<<<<< HEAD
        return new ExtraSanction([
=======
        return new Product([
>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25

            'extra_type_id'    => $row['extra_type_id'],
            'part_id' => $row['part_id'],
            'sanction_discount_id'     => $row['sanction_discount_id'],
            'iteration'    => $row['iteration'],
            'sanction'    => $row['sanction'],






        ]);
    }
}
