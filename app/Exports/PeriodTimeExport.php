<?php

namespace App\Exports;
use App\Models\PeriodTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class PeriodTimeExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        
        return PeriodTime::all();
    }
    

    public function map($registration) : array {

        return [

        

            $registration->work_system_type_id,

            $registration->from_time,

            $registration->into_time,

            $registration->duration,



        ] ;
 

    }

 

    public function headings() : array {


        return [


 
            'work_system_type_id',
 
            'from_time',
 
            'into_time',
 
            'duration',
 
  

 
         ] ;

        

    }

}
