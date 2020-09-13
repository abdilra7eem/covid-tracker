<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Incident;
use Faker\Generator as Faker;

$factory->define(Incident::class, function (Faker $faker) {
    return [
        'person_id' => $faker->randomNumber(9),
        'person_name' => $faker->name,
        'male' => $faker->boolean(),
        'grade' => $faker->numberBetween(1, 14),
        'grade_section' => $faker->numberBetween(1, 14),
        'user_id' => $faker->numberBetween(1, App\User::count()),
        'suspected_at' => $faker->randomElement([$faker->date, null]),
        'suspect_type' => $faker->numberBetween(1,3),
        'confirmed_at' => $faker->randomElement([$faker->date, null]),
        'closed_at' => $faker->randomElement([$faker->date, null]),
        'close_type' => $faker->randomElement([1, 2, 3]),
        'deleted' => $faker->boolean($chanceOfGettingTrue = 5),
        'person_phone_primary' => $faker->phoneNumber,
        'person_phone_secondary' => $faker->phoneNumber,
        'notes' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'last_editor' => $faker->numberBetween(1, App\User::count()),
        'last_editor_ip' => $faker->ipv4(),
    ];
});
