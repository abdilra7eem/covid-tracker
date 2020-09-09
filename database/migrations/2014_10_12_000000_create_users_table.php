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
            $table->integer('gov_id')->unsigned()->unique();
            $table->string('email')->unique(); // required, unique
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); //required
            $table->rememberToken()->nullable(); //optional
            $table->string('phone_primary'); // required, unique?
            $table->string('phone_secondary')->nullable(); //not required
            $table->string('image')->nullable();
            // optional. supervisor photo or school logo
            // controller & view implementation postponed
            $table->tinyInteger('account_type')->default(3)->unsigned();
            // 1:admin, 2:supervisor, 3:school
            $table->boolean('active')->default(true)->nullable(); // false: locked account; true: active account;
            
            $table->timestamps();
            $table->foreignId('directorate_id');
            $table->foreign('directorate_id')->references('id')->on('directorates');
            $table->foreignId('last_editor');
            $table->foreign('last_editor')->references('id')->on('users');
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
