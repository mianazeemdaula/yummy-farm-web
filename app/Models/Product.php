<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [];
    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function meat()
    {
        return $this->hasOne(MeatProducts::class);
    }
}
