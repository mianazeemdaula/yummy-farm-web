<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {
    return [
        'seller_id' => 3,
        'customer_id' => 4,
        'number' => '21003'.$this->faker->randomNumber(4,true),
        'delivery_address' => $this->faker->streetAddress(),
        'extra_note' => $this->faker->sentence(2),
    ];
});
