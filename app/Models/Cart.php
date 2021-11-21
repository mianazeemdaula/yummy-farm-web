<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }

    public function details()
    {
        return $this->hasMany(CartDetail::class);
    }

}
