<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->insert([
            ['name' => 'Google', 'address' => '1600 Amphitheatre Parkway', 'website' => 'http://google.com', 'email' => 'jobs@google.com', 'twitter' => '', 'facebook' => '', 'linkedin' => '', 'remaining_offers' => 3, 'remaining_days' => 45, 'remaining_discover' => 30, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            // ['name' => 'Apple', 'address' => 'Infinite Loop. Cupertino, CA 95014', 'website' => 'http://apple.com', 'email' => 'jobs@apple.com', 'twitter' => '', 'facebook' => '', 'linkedin' => '', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ]);
    }
}
