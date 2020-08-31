<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Incident;
use Faker\Generator as Faker;

$factory->define(Incident::class, function (Faker $faker) {
    return [
        'person_id' => $faker->randomNumber(9),
        'person_name' => $faker->name,
        'grade' => $faker->numberBetween(1, 12),
        'user_id' => $faker->unique()->numberBetween(1, App\User::count()),
        'suspected_at' => $faker->date,
        'suspect_type' => $faker->numberBetween(1,3),
        'confirmed_at' => $faker->date,
        'closed_at' => $faker->date,
        'close_type' => $faker->randomElement([0, 1, 2]),
        'deleted' => $faker->boolean($chanceOfGettingTrue = 5),
        'person_phone_primary' => $faker->phoneNumber,
        'person_phone_secondary' => $faker->phoneNumber,
        'notes' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
    ];
});
