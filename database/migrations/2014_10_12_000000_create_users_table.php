<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // Users table
            $table->id(); //autoincrement
            $table->string('name'); //required
            $table->string('email')->unique(); // required, unique
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); //required
            $table->rememberToken(); //optional
            $table->string('phone_primary'); // required, unique?
            $table->string('phone_secondary'); //not required
            $table->string('image'); //optional. supervisor photo or school logo
            $table->tinyInteger('account_type')->unsigned();
            // 0:root, 1:admin, 2:supervisor, 3:school
            
            $table->timestamps();
            $table->foreignId('directorate_id');
            $table->foreign('directorate_id')->references('id')->on('directorates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
