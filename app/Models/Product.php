<?php

namespace App\Models;

use App\RelationshipsTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use RelationshipsTrait;

    protected $fillable = ['id','parent_id','text','rank','purchase_price','status','rate','product_minimum','image','created_at','updated_at'];


    public function children(){


        return $this->hasMany('App\Models\Product', 'parent_id','id')->with('children');


    }
    public function store_product()
    {
        return $this->hasMany(StoreProduct::class);
    }

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }

    public function units()
    {

        return $this->belongsToMany(Unit::class,'product_units', 'product_id', 'unit_id');

    }


    // public function unit()
    // {
    //     return $this->belongsTo(Unit::class);
    // }

}
