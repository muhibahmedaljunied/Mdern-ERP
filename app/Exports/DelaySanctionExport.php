<?php

namespace App\Exports;

use App\Models\DelaySanction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;



class DelaySanctionExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DelaySanction::all();
    }

    public function map($registration) : array {

        return [




            $registration->delay_type_id,

            $registration->part_id,

            $registration->sanction_discount_id,

            $registration->discount,

            $registration->iteration,

            $registration->sanction,

          
        ] ;
 

    }

 

    public function headings() : array {


        return [

 
            'delay_type_id',
 
            'part_id',
 
            'sanction_discount_id',
 
            'discount',

            'iteration',

            'sanction',

 
 
         ] ;

        

    }

}
