<?php

namespace App\Imports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Staff([
            
  
            'name'    => $row['name'],
            'phone' => $row['phone'],
            'email'     => $row['email'],
            'salary'    => $row['salary'],
            'register'    => $row['register'],
            'personal_card'    => $row['personal_card'],
            'date'    => $row['date'],
            'staff_status'    => $row['staff_status'],
            'social_status' => $row['social_status'],
            'barth_date' => $row['barth_date'],
            'qualification__id' => $row['qualification__id'],
            'gender' => $row['gender'],
            'branch_id' => $row['branch_id'],
            'department_id' => $row['department_id'],
            'job_id' => $row['job_id'],
            'staff_type_id' => $row['staff_type_id'],
            'religion_id' => $row['religion_id'],
            'nationality_id' => $row['nationality_id'],




     


        ]);
    }
}
