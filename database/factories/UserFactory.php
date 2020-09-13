<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

// $fakerAr = Faker\Factory::create('ar_EG');

$factory->define(User::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'gov_id' => $faker->unique()->randomNumber(9),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'phone_primary' => $faker->phoneNumber,
        'phone_secondary' => $faker->phoneNumber,
        // 'image' => $faker->image('public/storage/images', 400, 300, null, false),
        'account_type' => $faker->randomElement([1, 2, 3]),
        'active' => $faker->boolean($chanceOfGettingTrue = 90),
        'directorate_id' => $faker->numberBetween(1, App\Directorate::count()),
        'last_editor' => $faker->numberBetween(1, App\User::count()),
        'last_editor_ip' => $faker->ipv4(),
    ];
});
