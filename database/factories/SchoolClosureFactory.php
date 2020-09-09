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
        'affected_students' => $faker->numberBetween(15, 600),
        'user_id' => $faker->numberBetween(1, App\User::count()),
        'notes' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
    ];
});
