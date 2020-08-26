<?php

use Illuminate\Database\Seeder;

class SchoolClosureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SchoolClosure::class, 10)->create();
    }
}
