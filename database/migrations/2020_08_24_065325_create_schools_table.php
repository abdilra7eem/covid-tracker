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
            $table->foreignId('user_id')->unique();

            $table->smallInteger('total_male_students')->unsigned();
            $table->smallInteger('total_female_students')->unsigned();
            // Total number of students is calculated
            
            $table->smallInteger('total_male_staff')->unsigned();
            $table->smallInteger('total_female_staff')->unsigned();
            // Total number of staff is calculated
            
            $table->tinyInteger('youngest_class')->unsigned();
            $table->tinyInteger('oldest_class')->unsigned();
            // School age group; also used for input validation

            $table->tinyInteger('number_of_classrooms')->unsigned(); // عدد الشعب الصفية

            $table->boolean('rented')->default(false); // true: مستأجر
            $table->boolean('second_shift')->default(false); // true: مسائي

            $table->tinyInteger('building_year')->default(0)->unsigned(); // number of years after 1780;
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
