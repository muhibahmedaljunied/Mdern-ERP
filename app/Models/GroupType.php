<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupType extends Model
{
    protected $fillable = ['id','name'];

    public function Group()
    {
        return $this->hasMany(Group::class);
    }

}
