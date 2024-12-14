<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['id','name','group_type_id','code','status','created_at','updated_at'];

    
   
    public function group_account()
    {
        return $this->hasMany(GroupAccount::class);
    }

      
    public function group_type()
    {
        return $this->belongsTo(GroupType::class);
    }


    public function supplier()
    {
        return $this->hasMany(Supplier::class);
    }


    public function sale()
    {
        return $this->hasMany(Customer::class);
    }


   

    


}
