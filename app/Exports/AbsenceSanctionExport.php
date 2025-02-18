<?php

namespace App\Exports;
<<<<<<< HEAD

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
=======
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\models\Product;
use Carbon\Carbon;



class AbsenceSanctionExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    public function map($registration) : array {

        return [

        
            $registration->id,

            $registration->parent_id,

            $registration->text,

            $registration->rank,

            // $registration->purchase_price,

            $registration->status,

            $registration->rate,

            $registration->product_minimum,

            $registration->image,


            Carbon::parse($registration->created_at)->toFormattedDateString(),

            Carbon::parse($registration->updated_at)->toFormattedDateString()

        ] ;
 

    }

 

    public function headings() : array {
>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25


        return [

<<<<<<< HEAD
            'absence_type_id',

            'sanction_discount_id',

            'discount',

            'iteration',

            'sanction',



        ];
    }
=======
            'id',
 
            'parent_id',
 
            'text',
 
            'rank',
 
            'purchase_price',

            'status',

            'rate',

            'product_minimum',

            'image',


            'created_at',
 
            'updated_at'
 
 
         ] ;

        

    }

>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25
}
