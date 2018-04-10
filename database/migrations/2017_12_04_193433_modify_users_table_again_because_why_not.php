<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTableAgainBecauseWhyNot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cellphone')->nullable();
            $table->string('university')->nullable();
            $table->string('major')->nullable();
            $table->string('availability')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->dropColumn('university_id', 'major_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cellphone', 'university', 'major', 'availability', 'state', 'city');
            $table->integer('university_id')->nullable();
            $table->integer('major_id')->nullable();
        });
    }
}
