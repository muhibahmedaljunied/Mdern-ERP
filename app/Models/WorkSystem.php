<?php

namespace App\Models;

use App\Enums\Days;
use Illuminate\Database\Eloquent\Model;

class WorkSystem extends Model
{
    protected $fillable = ['id','period_time_id','work_system_type_id','days'];


    protected $casts = [
        'days' => 'array'
    ];

    
    public function staff()
    {
        return $this->belongsToMany(Staff::class);
    }

    public function work_system_type()
    {
        
        return $this->hasMany(WorkSystemType::class);
    }

    public function period_time()
    {
        
        return $this->hasMany(PeriodTime::class);
    }



    // protected $casts = [
    //     'days' => Days::class,
    // ];

}
