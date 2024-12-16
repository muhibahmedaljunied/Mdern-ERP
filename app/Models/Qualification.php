<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

}
