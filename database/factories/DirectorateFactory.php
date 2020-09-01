<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Directorate;
use Faker\Generator as Faker;

$factory->define(Directorate::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->lastName,
        'email' => $faker->unique()->safeEmail,
        'name_ar' => $faker->unique()->name,
        'phone_number' => $faker->unique()->phoneNumber,
    ];
});
