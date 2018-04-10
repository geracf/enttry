<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('school_name')->nullable();
            $table->string('school_website')->nullable();
            $table->string('degree');
            $table->longText('technologies_used');
            $table->longText('achivements');
            $table->string('start_date'); // format mm-YYYY
            $table->string('end_date')->nullable(); // format mm-YYYY
            $table->boolean('current')->default(false);
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
        Schema::dropIfExists('education');
    }
}
