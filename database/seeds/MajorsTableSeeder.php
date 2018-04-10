<?php

use Illuminate\Database\Seeder;

class MajorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('majors')->insert([
            ['university_id' => 1, 'name' => 'ITIC'],
            ['university_id' => 1, 'name' => 'INT'],
            ['university_id' => 1, 'name' => 'IDI'],
            ['university_id' => 1, 'name' => 'LAF'],
            ['university_id' => 1, 'name' => 'LAD'],

            ['university_id' => 2, 'name' => 'ITM'],
            ['university_id' => 2, 'name' => 'LDC'],
            ['university_id' => 2, 'name' => 'ARQ'],
            ['university_id' => 2, 'name' => 'IDS'],
            ['university_id' => 2, 'name' => 'IPQ'],
        ]);
    }
}
