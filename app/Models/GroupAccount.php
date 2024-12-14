<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAccount extends Model
{
    protected $fillable = ['id','account_id','group_id','account_second_id','created_at', 'updated_at'];


    public function groupable()
    {
        return $this->morphTo();
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function account_second()
    {
        return $this->belongsTo(Account::class);
    }

    public function group_account_detail()
    {
        return $this->hasMany(GroupAccountDetail::class);
    }


}
