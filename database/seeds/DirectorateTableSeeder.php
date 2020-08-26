<?php

use Illuminate\Database\Seeder;

class DirectorateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Directorate::class, 2)->create();
    }
}
