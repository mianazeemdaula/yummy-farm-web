<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
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
