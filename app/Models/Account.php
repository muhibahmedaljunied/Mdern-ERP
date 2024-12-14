<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    protected $fillable = ['id', 'text', 'account_name_en', 'parent_id', 'rank', 'account_type', 'currency', 'type_branch', 'status_account', 'created_at', 'updated_at'];

    public function children()
    {


        return $this->hasMany('App\Models\Account', 'parent_id', 'id')->with('children');
    }

    public function acc()
    {
        return $this->hasMany(GroupAccount::class,'account_id');
    }
    public function acc_second()
    {
        return $this->hasMany(GroupAccount::class,'account_second_id');
    }

    public function group_account_detail()
    {
        return $this->hasMany(GroupAccountDetail::class);
    }

  

}
