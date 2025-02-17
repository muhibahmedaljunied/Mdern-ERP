<?php

namespace App\Exports;

use App\Models\LeaveSanction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeaveSanctionExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LeaveSanction::all();
    }

    public function map($registration) : array {

        return [


            $registration->leave_type_id,

            $registration->part_id,

            $registration->sanction_discount_id,

            $registration->discount,

            $registration->iteration,

            $registration->sanction,

        

        ] ;
 

    }

 

    public function headings() : array {


        return [

 
            'leave_type_id',
 
            'part_id',
 
            'sanction_discount_id',
 
            'discount',

            'iteration',

            'sanction',

     

     
 
 
         ] ;

        

    }

}
