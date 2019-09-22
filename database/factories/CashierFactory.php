<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cashier;
use Faker\Generator as Faker;

$factory->define(Cashier::class, function (Faker $faker) {
    return [
        'name' => $faker->text,
    ];
});
