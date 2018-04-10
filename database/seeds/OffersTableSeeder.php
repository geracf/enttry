<?php

use Illuminate\Database\Seeder;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Offer::class, 3)->create(['organization_id' => 1]);

        // factory(App\Offer::class, 3)->create(['organization_id' => 2]);
    }
}
