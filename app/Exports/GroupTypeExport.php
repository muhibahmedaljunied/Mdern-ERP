<?php

namespace App\Exports;
use App\Models\GroupType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class GroupTypeExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return GroupType::all();
    }

    public function map($registration) : array {

        return [

    
            $registration->name,

            $registration->code,

            $registration->status,


          
        ] ;
 

    }

 

    public function headings() : array {


        return [

 
            'name',
 
            'code',
 
            'status',
 
           
 
 
         ] ;

        

    }

}
