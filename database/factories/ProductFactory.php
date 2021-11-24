<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    $price = $this->faker->randomFloat(2, 5, 25);
    return [
        'name' => $this->faker->words(2, true),
        // 'product_category_id' => $this->faker->numberBetween(1, 5),
        'seller_id' =>  $this->faker->numberBetween(3, 4),
        'species' => $this->faker->sentence(),
        'body_part' => $this->faker->sentence(),
        'bio' => $this->faker->boolean(),
        'price' => $price,
        'vat' => $price - ($price / 1.21),
        'stock' => $this->faker->numberBetween(1, 10),
        'age' => $this->faker->numberBetween(1, 5),
        'weight' => $this->faker->randomFloat(1, 1, 5),
        'life_style' => $this->faker->words(3, true),
        'description' => $this->faker->realText(),
        'extra_info' => $this->faker->realText(),
        'delivery_date' => $this->faker->dateTime(),
        'delivery_type' => $this->faker->randomElement(['take_away', 'delivery']),
    ];
});
