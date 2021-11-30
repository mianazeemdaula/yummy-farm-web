<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function meat()
    {
        return $this->hasOne(MeatProducts::class);
    }


    // Mutators

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = round($value, 2);
    }

    public function setVatAttribute($value)
    {
        $this->attributes['vat'] = round($value, 2);
    }

    public function setDeliveryChargesAttribute($value)
    {
        $this->attributes['delivery_charges'] = round($value, 2);
    }
}
