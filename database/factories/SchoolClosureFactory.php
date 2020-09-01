<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SchoolClosure;
use Faker\Generator as Faker;

$factory->define(SchoolClosure::class, function (Faker $faker) {
    return [
        'closure_date' => $faker->date,
        'reopening_date' => $faker->randomElement(null, $faker->date),
        'grade' => $faker->numberBetween(1,14),
        'grade_section' => $faker->numberBetween(1,14),        
        'user_id' => $faker->unique()->numberBetween(1, App\User::count()),
    ];
});
