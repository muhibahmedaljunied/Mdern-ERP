<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\models\Store;
use App\Models\Supplier;
use Carbon\Carbon;



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

        


            $row->id,

            $row->name,

            $row->code,

            $row->company,

            $row->email,

            $row->phone,

            $row->address,

            $row->status,

            $row->group_id,



            Carbon::parse($row->created_at)->toFormattedDateString(),

            Carbon::parse($row->updated_at)->toFormattedDateString()

        ] ;
 

    }

 

    public function headings() : array {


        return [
            'id' ,
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
