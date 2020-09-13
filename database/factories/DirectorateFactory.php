<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Directorate;
use Faker\Generator as Faker;

$factory->define(Directorate::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->lastName,
        'email' => $faker->unique()->safeEmail,
        'name_ar' => $faker->unique()->lastName,
        'phone_number' => $faker->unique()->phoneNumber,
        'head_of_directorate' => $faker->unique()->name,
        'school_count' => $faker->numberBetween(50, 250),
        'last_editor' => $faker->numberBetween(1, App\User::count()),
        'last_editor_ip' => $faker->ipv4(),
    ];
});
