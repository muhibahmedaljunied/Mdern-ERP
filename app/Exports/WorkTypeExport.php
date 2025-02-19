<?php

namespace App\Exports;
use App\Models\PeriodTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class WorkTypeExport implements FromCollection,WithMapping, WithHeadings
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

    
            $registration->name,

        ] ;
 

    }

 

    public function headings() : array {


        return [
 
            'name',
 

         ] ;

        

    }

}
