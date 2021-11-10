<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function meat()
    {
        return $this->hasOne(MeatProducts::class);
    }
}
