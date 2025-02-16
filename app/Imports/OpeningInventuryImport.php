<?php

namespace App\Imports;

use App\Models\OpeningInventury;
use App\Models\Stock;
use App\Models\StoreProduct;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class OpeningInventuryImport implements ToModel, WithHeadingRow
{

    protected $store_product;
    protected $stock;

    public function __construct()
    {

        $this->store_product = StoreProduct::select()->get();
        $this->stock = Stock::select()->get();
    }


    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {


        // $store_product = $this->store_product->where('id', $row['store_product_id'])->first();
        // $stock = $this->stock->where(

        //     [
        //         'stockable_type' => 'App\Models\OpeningInventury',
        //         'stockable_id' => $row['id']
        //     ]

        // )->first();


        // --------------------------------------------------------------------
        foreach ($row as $rows) {
            $memberId = StoreProduct::create([
                'full_name'     => $rows['full_name'],
                'father_name'   => $rows['father_name'],
                'mother_name'   => $rows['mother_name'],
                'cell_number'   => $rows['cell_number'],
            ]);
            $applicationId  = OpeningInventury::create([
                'member_id'             => $memberId->member_id,
                'licence_category_name' => $rows['licence_category_name'],
            ]);
            Stock::create([
                'member_id'         => $memberId->member_id,
                'application_id'    => $applicationId->application_id,
                'application_type'  => $rows['application_type'],
            ]);

            
        }
        // -----------------------------------store_product-----------------------
        $opening_inventury =  new StoreProduct([


            "store_product_id" => $row['store_product_id'],
            "unit_id" => $row['unit_id'],
            "desc" => $row['desc'],
            "qty" => $row['qty'],
            "cost" => $row['cost'],
            "total" => $row['total'],
            "expiry_date" => $row['expiry_date'],
            "date" => $row['date'],



        ]);

        // --------------------------------opening_inventury--------------------------

        $opening_inventury->opening()->create([

            "store_product_id" => $store_product->store_product_id ?? NULL,
            "unit_id" => $row['unit_id'],
            "qty" => $row['qty'],
            "total" => $row['total'],
            "expiry_date" => $row['expiry_date'],
            "date" => $row['date'],

        ]);
        // --------------------------------------stock--------------------
        $opening_inventury->stock()->create([

            "id" => $row['id'],
            "store_product_id" => $store_product->store_product_id ?? NULL,
            "unit_id" => $row['unit_id'],
            "qty" => $row['qty'],
            "cost" => $row['cost'],
            "total" => $row['total'],
            "expiry_date" => $row['expiry_date'],
            "date" => $row['date'],
        ]);




        return $opening_inventury;
    }
}
