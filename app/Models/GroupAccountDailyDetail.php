<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAccountDailyDetail extends Model
{
    // protected $fillable = ['id','name','group_type_id','account_id'];

    public function dailyable()
    {
        return $this->morphTo();
    }


    public function daily_detail()
    {
        return $this->belongsTo(DailyDetail::class);
    }

}
