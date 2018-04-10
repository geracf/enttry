<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->boolean('edit_organization')->default(false);
            $table->boolean('delete_organization')->default(false);

            // Offer permissions
            $table->boolean('create_offers')->default(false);
            $table->boolean('read_offers')->default(false);
            $table->boolean('update_offers')->default(false);
            $table->boolean('delete_offers')->default(false);
            $table->boolean('apply_offers')->default(false);
            $table->boolean('favorite_offers')->default(false);
            $table->boolean('read_applications')->default(false);

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
        Schema::dropIfExists('roles');
    }
}
