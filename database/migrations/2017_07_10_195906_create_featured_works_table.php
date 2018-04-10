<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturedWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_works', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('feature_name')->nullable();
            $table->string('feature_url')->nullable();
            $table->longText('technologies_used');
            $table->longText('desc');
            $table->string('release_date'); // format mm-YYYY
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
        Schema::dropIfExists('featured_works');
    }
}
