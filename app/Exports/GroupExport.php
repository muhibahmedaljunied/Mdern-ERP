<?php

namespace App\Exports;
use App\Models\Group;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class GroupExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Group::all();
    }

    public function map($registration) : array {

        return [

    
            $registration->name,

            $registration->group_type_id,

            $registration->code,

            $registration->status,
      

            


            // Carbon::parse($registration->created_at)->toFormattedDateString(),

            // Carbon::parse($registration->updated_at)->toFormattedDateString()

        ] ;
 

    }

 

    public function headings() : array {


        return [

            'name',
 
            'group_type_id',
 
            'code',
 
            'status',
 
    
 
 
         ] ;

        

    }

}
