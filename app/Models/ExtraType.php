<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ExtraType extends Model
{
    protected $fillable = ['name','code'];

    public function extra()
    {
        return $this->hasMany(Extra::class);
    }

}
