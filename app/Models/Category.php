<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [];

    public function supercategory()
    {
        return $this->hasOne(ProductCategory::class,'super_category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
