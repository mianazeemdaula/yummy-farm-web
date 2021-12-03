<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\Product::class, function (Faker $faker) {
    $price = $this->faker->randomFloat(2, 5, 25);
    $type =  $this->faker->boolean();
    $individual =  $this->faker->boolean();
    return [
        'name' => $this->faker->city(),
        'individual' => $individual,
        'seller_id' =>  $this->faker->numberBetween(3, 4),
        'species' => $this->faker->jobTitle(),
        'body_part' => $this->faker->citySuffix(),
        'bio' => $this->faker->boolean(),
        'price' => $price,
        // 'delivery_charges' => $type ? 0 : 5.25,
        'vat' => $price - ($price / 1.21),
        'stock' => $this->faker->numberBetween(1, 10),
        'age' => $this->faker->numberBetween(1, 5),
        'weight' => $this->faker->randomFloat(1, 1, 5),
        'life_style' => $this->faker->words(3, true),
        'description' => $individual ? null : $this->faker->realText(),
        'extra_info' => $this->faker->realText(),
        'available_from' => Carbon::now()->addDays(2)->toDateString(),
        'available_to' => $type ? Carbon::now()->addDays(5)->toDateString() : null,
        // 'delivery_type' => $type ? 'take_away' : 'delivery',
    ];
});
