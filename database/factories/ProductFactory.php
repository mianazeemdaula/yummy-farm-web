<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => $this->faker->words(2, true),
        // 'product_category_id' => $this->faker->numberBetween(1, 5),
        'seller_id' =>  $this->faker->numberBetween(3, 4),
        'species' => $this->faker->sentance(3),
        'body_part' => $this->faker->sentance(1),
        'bio' => $this->faker->boolean(),
        'price' => $this->faker->randomFloat(2),
        'vat' => $this->faker->randomFloat(2),
        'stock' => $this->faker->numberBetween(1, 10),
        'age' => $this->faker->numberBetween(1, 5),
        'weight' => $this->faker->randomFloat(2),
        'life_style' => $this->faker->sentance(1),
        'description' => $this->faker->realText(),
        'extra_info' => $this->faker->realText(),
        'delivery_date' => $this->faker->dateTime(),
    ];
});
