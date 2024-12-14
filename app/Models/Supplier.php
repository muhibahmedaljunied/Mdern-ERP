<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'id','account_id','name', 'last_name','email','phone','address','status'
    ];


  
    public function daily()
    {
        return $this->morphMany(GroupAccountDailyDetail::class, 'dailyable');
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }


}
