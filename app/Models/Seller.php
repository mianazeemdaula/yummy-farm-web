<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;


class Seller extends Model
{
    use SpatialTrait;

    protected $spatialFields = [
        'location',
    ];

    public function user()
    {
        return $this->morphOne('App\Models\User', 'userable');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
