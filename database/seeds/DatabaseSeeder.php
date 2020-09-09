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
        $this->call(DirectorateTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(SchoolTableSeeder::class);
        $this->call(SchoolClosureTableSeeder::class);
        $this->call(IncidentTableSeeder::class);

        // factory(App\Directorate::class, 10)->create();
        // factory(App\User::class, 100)->create();
        // factory(App\School::class, 85)->create();
        // factory(App\SchoolClosure::class, 200)->create();
    }
}
