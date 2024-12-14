<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAccountDetail extends Model
{
    protected $fillable = ['id','account_id','group_account_id','created_at', 'updated_at'];


 
    
      
    public function group_account()
    {
        return $this->belongsTo(GroupAccount::class);
    }


    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    
    


}
