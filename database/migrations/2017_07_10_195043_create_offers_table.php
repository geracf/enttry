<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id');
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->longText('desc')->nullable();
            $table->string('salary')->nullable();
            $table->string('location')->nullable();
            $table->boolean('show_location')->defaut(false);
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->boolean('remote')->nullable();
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
        Schema::dropIfExists('offers');
    }
}
