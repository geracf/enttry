<?php

use Illuminate\Database\Seeder;

class UniversitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('universities')->insert([
            ['name' => 'ITESM SLP', 'address' => 'Eugenio Garza Sada #123'],
            ['name' => 'IPN SLP', 'address' => 'Anillo Periférico Km 35']
        ]);
    }
}
