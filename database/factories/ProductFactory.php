<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $this->faker->name(),
        'product_category_id' => $this->faker->numberBetween(1, 5),
        'seller_id' => 3,
        'species' => $this->faker->sentence(3),
        'bio' => $this->faker->boolean(),
        'priceexclVAT' => $this->faker->randomFloat(2),
        'package' => $this->faker->boolean(),
        'detail' => $this->faker->realText(),
    ];
});
