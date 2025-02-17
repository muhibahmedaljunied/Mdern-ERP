<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\StoreProduct;
use Maatwebsite\Excel\Concerns\Exportable;

class OpeningInventuryExport implements WithMapping, WithHeadings, FromCollection
{

    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */


    public function collection()
    {

        return StoreProduct::with('stock', 'opening')->get();
    }

    public function map($opening): array
    {




        return [
            // ---------------store_product-----------------------
            $opening->product_id,
            $opening->store_id,
            $opening->status_id,
            $opening->desc,
            $opening->qr_code,
            $opening->quantity,
            $opening->cost,
            $opening->total,
            // --------------------opening_inventury------------------
            $opening->opening[0]->unit_id,
            $opening->opening[0]->total,
            $opening->opening[0]->date,
            // -------------------stock-------------------
            $opening->stock[0]->stockable_id,



        ];
    }






    public function headings(): array
    {
        return [

            // ---------------store_product-----------------------
            "product_id",
            "store_id",
            "status_id",
            "desc",
            "qr_code",
            "quantity",
            "cost",
            "total",
            // --------------------opening_inventury------------------
            "unit_id",
            "total_opening",
            "date",
            // -------------------stock-------------------
            "stockable_id",





        ];
    }
}
