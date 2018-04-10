<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('organization_name')->nullable();
            $table->string('organization_website')->nullable();
            $table->string('title');
            $table->longText('technologies_used');
            $table->longText('responsibilities');
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
        Schema::dropIfExists('work_experiences');
    }
}
