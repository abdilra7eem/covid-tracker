<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Directorate;
use Faker\Generator as Faker;

$factory->define(Directorate::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
        // 'email' => $faker->unique()->safeEmail,
        'name_ar' => $faker->name,
        'phone_number' => $faker->phoneNumber,
    ];
});
