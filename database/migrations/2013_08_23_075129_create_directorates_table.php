<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directorates', function (Blueprint $table) {
            // Directorate information; used as reference for
            // authentication, authorization and validation
            $table->id();
            $table->timestamps();
            $table->string('name')->unique();
            $table->string('name_ar')->unique();
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('head_of_directorate');
            $table->tinyInteger('school_count')->unsigned();
            $table->mediumInteger('last_editor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directorates');
    }
}
