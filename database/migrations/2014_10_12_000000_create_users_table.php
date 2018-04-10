<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('university_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            $table->string('subtitle')->nullable();
            $table->boolean('sex')->nullable();
            $table->string('location')->nullable();
            $table->string('type')->nullable();
            $table->string('major_id')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('graduated')->nullable();
            $table->string('foi')->nullable();

            $table->string('facebook')->unique()->nullable();
            $table->string('twitter')->unique()->nullable();
            $table->string('linkedin')->unique()->nullable();
            $table->string('spotify')->unique()->nullable();
            $table->string('instagram')->unique()->nullable();

            $table->string('activation_id')->nullable();
            $table->boolean('active')->default(false);
            $table->rememberToken();
            $table->timestamps();
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
