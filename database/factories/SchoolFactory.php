<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\School;
use Faker\Generator as Faker;

$factory->define(School::class, function (Faker $faker) {
    return [
        'user_id' => $faker->unique()->numberBetween(1, App\User::count()),
        'school_number' => $faker->unique()->randomNumber(9),
        'total_male_students' => $faker->randomNumber(3),
        'total_female_students' => $faker->randomNumber(3),
        'total_male_staff' => $faker->randomNumber(2),
        'total_female_staff' => $faker->randomNumber(2),
        'youngest_class' => $faker->numberBetween($min = 1, $max = 12),
        'oldest_class' => $faker->numberBetween($min = 1, $max = 12),
        'number_of_classrooms' => $faker->randomNumber(2),
    ];
});
