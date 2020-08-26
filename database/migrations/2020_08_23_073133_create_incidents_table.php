<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            // Main data records. COVID related incidents.
            $table->id();
            $table->timestamps();
            $table->integer('student_id')->unsigned(); // Government isssued ID / birth cert. number.
            $table->string('student_name');
            $table->tinyinteger('grade'); // for students: 1 - 12, teacher: 13, manager: 14
            $table->foreignId('user_id'); // foreign key from the users table
            $table->date('suspected_at'); // dateTime can be used instead
            $table->date('confirmed_at');
            $table->date('closed_at');
            $table->tinyInteger('close_type'); // 0: not covid, 1: recovered, 2: died
            $table->boolean('deleted');
            $table->string('student_phone_primary');
            $table->string('student_phone_secondary');
            $table->text('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
}
