<?php

namespace App\Exports;

use App\Models\AdministrativeStructure;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdministrativeStructureExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AdministrativeStructure::all();
    }

    public function map($registration) : array {



        return [

            $registration->text,

            $registration->parent_id,

            $registration->rank,

            $registration->type_branch,

            $registration->status,


        ] ;

 

 

    }

 

    public function headings() : array {


      

        return [

           'text',

           'parent_id',

           'rank',

           'type_branch',

           'status',



        ] ;

    }
}
