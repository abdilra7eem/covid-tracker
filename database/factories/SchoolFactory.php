<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\School;
use Faker\Generator as Faker;

$factory->define(School::class, function (Faker $faker) {
    return [
        'user_id' => $faker->unique()->numberBetween(1, App\User::count()),
        'total_male_students' => $faker->randomNumber(3),
        'total_female_students' => $faker->randomNumber(3),
        'total_male_staff' => $faker->randomNumber(2),
        'total_female_staff' => $faker->randomNumber(2),
        'youngest_class' => $faker->numberBetween($min = 1, $max = 12),
        'oldest_class' => $faker->numberBetween($min = 1, $max = 12),
        'number_of_classrooms' => $faker->randomNumber(2),
        'rented' => $faker->boolean(),
        'second_shift' => $faker->boolean(),
        'building_year' => $faker->numberBetween(150, 240),
        'head_of_school' => $faker->unique()->name(),
    ];
});
