<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Supplier;




class SupplierExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Supplier::all();
    }

    public function map($row) : array {

        return [

<<<<<<< HEAD
    
=======
        




>>>>>>> e6f25e3908fccf613f415c22430d25ca28bcaa25
            $row->name,

            $row->code,

            $row->company,

            $row->email,

            $row->phone,

            $row->address,

            $row->status,

            $row->group_id,



            // Carbon::parse($row->created_at)->toFormattedDateString(),

            // Carbon::parse($row->updated_at)->toFormattedDateString()

        ] ;
 

    }

 

    public function headings() : array {


        return [

            'name',
            'code',
            'company',
            'email',
            'phone',
            'address',
            'status',
            'group_id',
 
 
         ] ;

        

    }

}
