<?php

namespace App\Imports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;

class StaffImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Staff([
            
            'id'     => $row[0],
            'name'    => $row[1],
            'phone' => $row[2],
            'email'     => $row[3],
            'salary'    => $row[4],
            'personal_card'    => $row[5],
            'date'    => $row[6],
            'staff_status'    => $row[7],
            'social_status' => $row[8],
            'barth_date' => $row[9],
            'qualification__id' => $row[10],
            'branch_id' => $row[11],
            'department_id' => $row[12],
            'job_id' => $row[13],
            'staff_type_id' => $row[14],
            'religion_id' => $row[15],
            'nationality_id' => $row[16],




     


        ]);
    }
}
