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
        'kind' => $this->faker->sentence(3),
        'bio' => $this->faker->boolean(),
        'price_incl_vat' => $this->faker->randomFloat(2),
        'price_excl_vat' => $this->faker->randomFloat(2),
        'delivery_charges' => $this->faker->randomFloat(2),
        'weight' => $this->faker->randomFloat(2),
        'delivery_date' => $this->faker->dateTime(),
        // 'package' => $this->faker->boolean(),
        'detail' => $this->faker->realText(),
    ];
});
