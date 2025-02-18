<?php

namespace App\Imports;

<<<<<<< HEAD
use App\Models\AbsenceSanction;
=======
use App\models\Product;
>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25
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
<<<<<<< HEAD
        return new AbsenceSanction([

            'absence_type_id'=> $row['absence_type_id'],
            'sanction_discount_id' => $row['sanction_discount_id'],
            'discount'     => $row['discount'],
=======
        return new Product([

            'absence_type_id '    => $row['absence_type_id '],
            'sanction_discount_id ' => $row['sanction_discount_id '],
            'discount '     => $row['discount '],
>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25
            'iteration'    => $row['iteration'],
            'sanction'    => $row['sanction'],





        ]);
    }
}
