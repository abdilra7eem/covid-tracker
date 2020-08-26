<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        factory(App\Directorate::class, 2)->create();
        factory(App\User::class, 10)->create();
        factory(App\School::class, 10)->create();
        factory(App\SchoolClosure::class, 10)->create();
    }
}
