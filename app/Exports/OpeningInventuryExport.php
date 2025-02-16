<?php

namespace App\Exports;

use App\Models\OpeningInventury;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\models\Product;
use App\Models\StoreProduct;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class OpeningInventuryExport implements WithMapping, WithHeadings, FromCollection
{

    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */


    public function collection()
    {


        // dd(StoreProduct::with('stock','opening')->get());
        return StoreProduct::with('stock', 'opening')->get();
    }

    public function map($opening): array
    {




        return [

            $opening->id,
            $opening->product_id,
            $opening->store_id,
            $opening->status_id,
            $opening->desc,
            $opening->qr_code,
            $opening->quantity,
            $opening->cost,
            $opening->total,
            $opening->created_at,
            $opening->updated_at,

            // --------------------------------------
            $opening->opening[0]->id,
            $opening->opening[0]->store_product_id,
            $opening->opening[0]->unit_id,
            $opening->opening[0]->desc,
            $opening->opening[0]->qty,
            $opening->opening[0]->cost,
            $opening->opening[0]->total,
            $opening->opening[0]->expiry_date,
            $opening->opening[0]->date,
            $opening->opening[0]->created_at,
            $opening->opening[0]->updated_at,
            // --------------------------------------
            $opening->stock[0]->id,
            $opening->stock[0]->store_product_id,
            $opening->stock[0]->unit_id,
            $opening->stock[0]->stockable_type,
            $opening->stock[0]->stockable_id,
            $opening->stock[0]->quantity,
            $opening->stock[0]->date,
            $opening->stock[0]->created_at,
            $opening->stock[0]->updated_at,


        ];
    }






    public function headings(): array
    {
        return [

            // ---------------store_product-----------------------
            "id",
            "product_id",
            "store_id",
            "status_id",
            "desc",
            "qr_code",
            "quantity",
            "cost",
            "total",
            "created_at",
            "updated_at",
            // --------------------opening_inventury------------------
            "id",
            "store_product_id",
            "unit_id",
            "desc",
            "qty",
            "cost",
            "total",
            "expiry_date",
            "date",
            "created_at",
            "updated_at",
            // -------------------stock-------------------
            "id",
            "store_product_id",
            "unit_id",
            "stockable_type",
            "stockable_id",
            "quantity",
            "date",
            "created_at",
            "updated_at",




        ];
    }
}
