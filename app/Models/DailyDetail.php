<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyDetail extends Model
{
    protected $fillable = ['daily_id','account_id','account_name','description','debit','credit'];


    public function group_account_daily_detail()
    {
        return $this->hasMany(GroupAccountDailyDetail::class);
    }

}
