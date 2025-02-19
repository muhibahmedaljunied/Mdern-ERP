<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodTime extends Model
{
    protected $fillable = ['id', 'period_id', 'from_time', 'into_time', 'duration'];



    public function attendance_detail()
    {
        return $this->hasMany(AttendanceDetail::class);
    }
    public function work_system_type()
    {
        return $this->belongsToMany(WorkSystemType::class,'work_systems');
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class,'work_systems');
    }
}
