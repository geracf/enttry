<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Administrator', 'edit_organization' => true, 'delete_organization' => true, 'create_offers' => true, 'read_offers' => true, 'read_applications' => true, 'update_offers' => true, 'delete_offers' => true, 'apply_offers' => false, 'favorite_offers' => false, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Recruiter', 'edit_organization' => false, 'delete_organization' => false, 'create_offers' => true, 'read_offers' => true, 'read_applications' => true, 'update_offers' => true, 'delete_offers' => true, 'apply_offers' => false, 'favorite_offers' => false, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Student', 'edit_organization' => false, 'delete_organization' => false, 'create_offers' => false, 'read_offers' => true, 'read_applications' => false, 'update_offers' => false, 'delete_offers' => false, 'apply_offers' => true, 'favorite_offers' => true, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ]);
    }
}
