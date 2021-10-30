<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['rating', 'comment'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
