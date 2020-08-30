<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolClosuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_closures', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('closure_date');
            $table->date('reopening_date')->nullable();
            $table->tinyInteger('grade'); // 1-12: grade, 13: teachers, 14: school
            // grade closure depends on school, teachers and grade
            // teachers presence depends on school
            
            $table->tinyInteger('grade_section')->nullable();
            $table->foreignId('user_id'); // foreign key from the users table
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
        Schema::dropIfExists('school_closures');
    }
}
