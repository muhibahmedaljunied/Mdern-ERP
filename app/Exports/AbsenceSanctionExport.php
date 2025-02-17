<?php

namespace App\Exports;

use App\Models\AbsenceSanction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;



class AbsenceSanctionExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return AbsenceSanction::all();
    }

    public function map($registration): array
    {

        return [

            $registration->absence_type_id,

            $registration->sanction_discount_id,

            $registration->discount,

            $registration->iteration,
            $registration->sanction,

        ];
    }



    public function headings(): array
    {


        return [

            'absence_type_id',

            'sanction_discount_id',

            'discount',

            'iteration',

            'sanction',



        ];
    }
}
