<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SchoolClosure;
use Faker\Generator as Faker;

$factory->define(SchoolClosure::class, function (Faker $faker) {
    return [
        'closure_date' => $faker->date,
        'reopening_date' => $faker->date,
        'user_id' => $faker->unique()->numberBetween(1, App\User::count()),
    ];
});
