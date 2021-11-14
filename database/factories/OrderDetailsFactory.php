<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\OrderDetail::class, function (Faker $faker) {
    return [
        'order_id' => $this->faker->numberBetween(1, 10),
        'product_id' => $this->faker->numberBetween(1, 50),
        // 'delivery_method' => $this->faker->randomElement(['take_away', 'delivery']),
        // 'delivery_time' => $this->faker->dateTime(),
        'qty' => $this->faker->numberBetween(1, 5),
    ];
});
