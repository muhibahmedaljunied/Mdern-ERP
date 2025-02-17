<?php

namespace App\Imports;
use App\Models\LeaveSanction;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class LeaveSanctionImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new LeaveSanction([


            'leave_type_id'    => $row['leave_type_id'],
            'part_id' => $row['part_id'],
            'sanction_discount_id'     => $row['sanction_discount_id'],
            'discount'    => $row['discount'],
            'iteration'    => $row['iteration'],
            'sanction'    => $row['sanction'],






        ]);
    }
}
