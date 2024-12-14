<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{


    protected $fillable = ['staff_id','vacation_type_id', 'start_date', 'end_date','days'];
    public function scopeWhereLeave($query, $data,$value)

    {
        return $query->where([
            'staff_id' => $data['staff'][$value],
            'vacation_type_id' => $data['vaction_type'][$value],
            'start_date' => $data['start_date'][$value],
            'end_date' => $data['end_date'][$value],

        ]);
    }





    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function vacation_type()
    {
        return $this->belongsTo(VacationType::class);
    }
}
