<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treasury extends Model
{
    protected $fillable = ['id','name','group_id'];

    
    public function daily()
    {
        return $this->morphMany(GroupAccountDailyDetail::class, 'dailyable');
    }

}
