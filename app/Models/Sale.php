<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    protected $fillable = [
        'customer_id', 'grand_total','status',' discount '
    ];


    
    public function sale_returns()
    {
        return $this->hasMany(SaleReturn::class);
    }

    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function receivable_notes()
    {
        return $this->hasMany(ReceivableNote::class);
    }

    // public function payment_sales()
    // {
    //     return $this->hasMany(PaymentSale::class);
    // }

    public function stock()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }
    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }
    
  



}
