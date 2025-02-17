<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;



class CustomerExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::all();
    }

    public function map($row) : array {

        return [

        


            // $row->id,

            $row->name,

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
            // 'id' ,
            'name',
            'email',
            'phone',
            'address',
            'status',
            'group_id',
 
 
         ] ;

        

    }

}
