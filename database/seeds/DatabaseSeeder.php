<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UniversitiesTableSeeder::class);
        $this->call(MajorsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(OffersTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(ChatsTableSeeder::class);
    }
}
