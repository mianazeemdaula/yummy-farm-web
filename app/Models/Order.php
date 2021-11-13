<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

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
}
