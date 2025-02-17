<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromCollection;

class StaffExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Staff::all();
    }

    public function map($registration): array
    {

        return [

            $registration->name,
            $registration->phone,
            $registration->email,
            $registration->salary,
            $registration->personal_card,
            $registration->date,
            $registration->staff_status,
            $registration->social_status,
            $registration->barth_date,
            $registration->qualification_id,
            $registration->branch_id,
            $registration->department_id,
            $registration->job_id,
            $registration->staff_type_id,
            $registration->religion_id,
            $registration->nationality_id,



        ];
    }



    public function headings(): array
    {


        return [

            'name',

            'phone',

            'email',

            'salary',

            'personal_card',

            'date',

            'staff_status',

            'social_status',

            'barth_date',

            'qualification_id',

            'branch_id',

            'department_id',

            'job_id',

            'staff_type_id',

            'religion_id',

            'nationality_id',





        ];
    }
}
