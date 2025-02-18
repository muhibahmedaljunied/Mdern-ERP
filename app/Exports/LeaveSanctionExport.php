<?php

namespace App\Exports;
<<<<<<< HEAD

use App\Models\LeaveSanction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
=======
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\models\Product;
use Carbon\Carbon;


>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25

class LeaveSanctionExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
<<<<<<< HEAD
        return LeaveSanction::all();
=======
        return Product::all();
>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25
    }

    public function map($registration) : array {

        return [

<<<<<<< HEAD

            $registration->leave_type_id,

            $registration->part_id,

            $registration->sanction_discount_id,

            $registration->discount,

            $registration->iteration,

            $registration->sanction,

        
=======
        
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
>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25

        ] ;
 

    }

 

    public function headings() : array {


        return [

<<<<<<< HEAD
 
            'leave_type_id',
 
            'part_id',
 
            'sanction_discount_id',
 
            'discount',

            'iteration',

            'sanction',

     

     
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
>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25
 
 
         ] ;

        

    }

}
