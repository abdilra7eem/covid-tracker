<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            // School specific information. Other information is in the 'users' table
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id');

            $table->smallInteger('total_male_students');
            $table->smallInteger('total_female_students');
            // Total number of students is calculated
            
            $table->smallInteger('total_male_staff');
            $table->smallInteger('total_female_staff');
            // Total number of staff is calculated
            
            $table->tinyInteger('youngest_class');
            $table->tinyInteger('oldest_class');
            // School age group; also used for input validation

            $table->tinyInteger('number_of_classrooms'); // عدد الشعب الصفية

            $table->boolean('rented'); // true: مستأجر
            $table->boolean('second_shift'); // true: مسائي

            $table->tinyInteger('building_year')->unsigned(); // number of years after 1780;
            // used to calculate the building (year of construction) and (how old);

            $table->string('head_of_school'); // name of the head of staff (manager)

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
