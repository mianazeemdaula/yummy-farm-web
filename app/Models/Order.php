<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $appends = [
        'total_qty', 'total_charges', 'total_price'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class,'customer_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getTotalQtyAttribute()
    {
        return $this->details()->sum('qty');
    }

    public function getTotalPriceAttribute()
    {
        return round($this->details()->sum(\DB::raw('qty * price')),2);
    }

    public function getTotalChargesAttribute()
    {
        return round($this->details()->sum('delivery_charges'),2);
    }
}
