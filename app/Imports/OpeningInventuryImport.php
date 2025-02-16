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
        //QUERY UNTUK MENGAMBIL SELURUH DATA USER
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


        $store_product = $this->store_product->where('id', $row['store_product_id'])->first();
        $stock = $this->stock->where(

            [
                'stockable_type' => 'App\Models\OpeningInventury',
                'stockable_id' => $row['id']
            ]

        )->first();

        return new OpeningInventury([

            "id" => $row['id'],
            "store_product_id" => $row['store_product_id'],
            "unit_id" => $row['unit_id'],
            "desc" => $row['desc'],
            "qty" => $row['qty'],
            "cost" => $row['cost'],
            "total" => $row['total'],
            "expiry_date" => $row['expiry_date'],
            "date" => $row['date'],
            "created_at" => $row['created_at'],
            "updated_at" => $row['updated_at'],


        
        ]);
    }
}
