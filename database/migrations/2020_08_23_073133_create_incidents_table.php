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
            $table->integer('person_id')->unsigned(); // Government isssued ID / birth cert. number.
            $table->string('person_name');
            $table->tinyinteger('grade'); // for students: 1 - 12, teacher: 13, manager: 14, directorate: 15
            $table->foreignId('user_id'); // foreign key from the users table
            $table->date('suspected_at')->nullable(); // dateTime can be used instead
            $table->tinyinteger('suspect_type')->nullable();
            // 0: undefined, 1: personal / parent, 2: private doctor, 3: gov.
            $table->date('confirmed_at')->nullable();
            $table->date('closed_at')->nullable();
            $table->tinyInteger('close_type')->nullable(); // 0: not covid, 1: recovered, 2: died
            $table->boolean('deleted')->default(false)->nullable();
            $table->string('person_phone_primary');
            $table->string('person_phone_secondary')->nullable();
            $table->text('notes')->nullable(); // if grade is 13, 14 or 15, input is recommended; suspect type notes here;
            // $table->string('files'); // array of file records, connected to files
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
