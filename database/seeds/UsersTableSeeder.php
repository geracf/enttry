<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class)->create(['email' => 'admin@jobshere.com', 'name' => 'Jobshere admin', 'role_id' => 0, 'organization_id' => null]);

        factory(App\User::class)->create(['email' => 'admin@google.com', 'name' => 'Google admin', 'role_id' => 1, 'organization_id' => 1]);
        factory(App\User::class)->create(['email' => 'recruiter@google.com', 'name' => 'Google recluitment', 'role_id' => 2, 'organization_id' => 1]);

        factory(App\User::class)->create([
            'role_id' => '3',
            'major' => 'Ingeniería Industrial',
            'availability' => 'Prácticante',
            'university' => 'POLITÉCNICA',
            'state' => 'CDMX',
            'city' => 'Naucaupan',
        ]);

        factory(App\User::class)->create([
            'role_id' => '3',
            'major' => 'Mecatrónica',
            'availability' => 'Tiempo completo',
            'university' => 'UASLP',
        ]);

        factory(App\User::class)->create([
            'role_id' => '3',
            'major' => 'Turismo',
            'availability' => 'Medio tiempo',
            'university' => 'UNID',
            'state' => 'Aguascalientes',
            'city' => 'Aguascalientes',
        ]);

        factory(App\User::class)->create([
            'role_id' => '3',
            'major' => 'Ingeniero textil',
            'availability' => 'Prácticante',
            'university' => 'POLITÉCNICA',
            'state' => 'Jalisco',
            'city' => 'Guadalajara',
        ]);

        factory(App\User::class)->create([
            'role_id' => '3',
            'major' => 'Administración de empresas',
            'availability' => 'Prácticante',
            'university' => 'POLITÉCNICA',
            'state' => 'CDMX',
            'city' => 'Naucaupan',
        ]);

        factory(App\User::class)->create([
            'role_id' => '3',
        ]);
    }
}
