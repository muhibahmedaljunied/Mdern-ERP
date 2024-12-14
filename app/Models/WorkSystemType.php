<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSystemType extends Model
{
    protected $fillable = ['id', 'name'];


 


    public function staff()
    {
        return $this->belongsToMany(Staff::class,'work_systems');
    }

    public function period_time()
    {
        return $this->belongsToMany(PeriodTime::class,'work_systems');
    }

   
}
