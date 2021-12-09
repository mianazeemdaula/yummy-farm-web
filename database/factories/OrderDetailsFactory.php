<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\OrderDetail::class, function (Faker $faker) {
    $method = $this->faker->randomElement(['take_away', 'delivery']);
    return [
        'order_id' => $this->faker->numberBetween(1, 10),
        'product_id' => $this->faker->numberBetween(1, 50),
        'delivery_type' => $method,
        'delivery_date' => $this->faker->date(),
        'delivery_charges' => $method == 'delivery' ? $this->faker->randomFloat(2, 5, 25) : 0,
        'qty' => $this->faker->numberBetween(1, 5),
        'price' => $this->faker->randomFloat(2, 5, 25),
    ];
});
