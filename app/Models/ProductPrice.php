<?php

namespace App\Models;

use App\RelationshipsTrait;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use RelationshipsTrait;

    protected $fillable = [
        'id',
        'product_unit_id',
        'store_product_id',
        'cost',
        'supply_price',
        'small_price',
        'big_price',
        'private_price',
        'created_at',
        'updated_at'
    ];



    // public function units()
    // {

    //     return $this->belongsToMany(Unit::class, 'product_units', 'product_id', 'unit_id');
    // }
}
