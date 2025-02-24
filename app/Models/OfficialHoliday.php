<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficialHoliday extends Model
{
    
    protected $fillable = ['id','name','start_date','end_date','days','created_at', 'updated_at'];

  

}
