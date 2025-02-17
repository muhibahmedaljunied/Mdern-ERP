<?php

namespace App\Exports;

use App\Models\ExtraSanction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;



class ExtraSanctionExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ExtraSanction::all();
    }

    public function map($registration) : array {

        return [


            $registration->extra_type_id,

            $registration->part_id,

            $registration->sanction_discount_id,

            $registration->iteration,

            $registration->sanction,


        ] ;
 

    }

 

    public function headings() : array {


        return [
 
            'extra_type_id',
 
            'part_id',
 
            'sanction_discount_id',
 
            'iteration',

            'sanction',


 
 
         ] ;

        

    }

}
