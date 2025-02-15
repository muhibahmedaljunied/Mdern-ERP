<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningInventury extends Model
{



    protected $fillable = [
        'store_product_id','unit_id','cost','qty','total','date','status_id'
    ];

    public function stock()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }
}
