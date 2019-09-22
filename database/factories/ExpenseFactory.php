<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expense;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'name' => $faker->text,
        'value' => $faker->numberBetween(0, 1000),
//        'balance_id' => 3,
//        'balance_id' => factory(\App\Balance::class)->create()->id,
        'balance_id' => function() {
            return factory(App\Balance::class)->create()->id;
        },
    ];
    // dd('this is data', $data);
    // return $data;
});
