<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = ['name','user_id','full_name','email_address','phone_no','address'];
}
