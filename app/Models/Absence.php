<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = ['staff_id','absence_type_id','date'];


    public function staff()

    {

        return $this->belongsTo(Staff::class);
    }

    

}
