<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class,'customer_id');
    }
}
