<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\ProductUnit;
use Carbon\Carbon;



class ProductUnitExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductUnit::all();
    }

    public function map($registration) : array {

        return [

        
            $registration->id,

            $registration->product_id,

            $registration->unit_id,

            $registration->purchase_price,

            $registration->rate,

            Carbon::parse($registration->created_at)->toFormattedDateString(),

            Carbon::parse($registration->updated_at)->toFormattedDateString()

        ] ;
 

    }

 

    public function headings() : array {


        return [

            'id',
 
            'product_id',
 
            'unit_id',
 
            'purchase_price',

            'rate',

            'created_at',
 
            'updated_at'
 
 
         ] ;

        

    }

}
