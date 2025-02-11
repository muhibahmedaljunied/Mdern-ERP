<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningInventury extends Model
{

    protected $fillable = [];



    public function stock()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }
}
