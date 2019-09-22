<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Balance;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Balance::class, function (Faker $faker) {
    return [
        'date_open' => Carbon::now(),
        'value_previous_close' => $faker->numberBetween(0, 1000),
        'value_open' => $faker->numberBetween(0, 1000),
        'observation' => $faker->text,
        'close' => 0,
        'card' => 0,
        'cashier_id' => function() {
            return factory(\App\Cashier::class)->create()->id;
        },
    ];
});
