<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'id','account_id','name','email','phone','address','status'
    ];

    public function daily()
    {
        return $this->morphMany(GroupAccountDailyDetail::class, 'dailyable');
    }

    public function customer()
    {
        return $this->hasMany(Sale::class);
    }


    
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    

}
