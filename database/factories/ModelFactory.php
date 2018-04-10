<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $name;
    static $password;
    static $role_id;
    static $email;
    static $organization_id;
    static $major;
    static $availability;
    static $university;
    static $state;
    static $city;

    return [
        'role_id' => $role_id,
        'name' => $name ?: $faker->name,
        'email' => $email ?: $faker->safeEmail,
        'password' => $password ? bcrypt($password) : bcrypt('secret'),
        'subtitle' => $faker->sentence(),
        'sex' => rand(0, 1) == 1 ? true : false,
        'location' => $faker->address,
        'type' => null,
        'age' => rand(19, 29),
        'graduated' => rand(0, 1) == 1 ? true : false,
        'foi' => $faker->sentence(),
        'active' => true,
        'organization_id' => $organization_id,
        'student_type' => null,
        'dob' => Carbon::create(rand(1988, 1998), rand(1, 12), rand(1, 29))->format('Y-m-d'),
        'cellphone' => $faker->phoneNumber,
        'university' => $university ?: 'ITESM SLP',
        'major' => $major ?: 'ITIC',
        'availability' => $availability ?: 'Tiempo completo',
        'state' => $state ?: 'San Luis Potosí',
        'city' => $city ?: 'San Luis potosí',
    ];
});


$factory->define(App\Offer::class, function (Faker\Generator $faker) {
    static $organization_id;

    return [
        'organization_id' => $organization_id ?: 1,
        'name' => $faker->sentence(),
        'desc' => $faker->paragraph(),
        'salary' => '$15 / hr',
        'location' => $faker->address,
        'show_location' => true,
        'lat' => $faker->latitude(),
        'lng' => $faker->longitude(),
        'remote' => false,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    ];
});

$factory->define(App\ChatRoom::class, function (Faker\Generator $faker) {
    static $user_id;
    static $application_id;

    return [
        'user_id' => $user_id,
        'application_id' => $application_id,
    ];
});

$factory->define(App\Message::class, function (Faker\Generator $faker) {
    static $sender_id;
    static $chatroom_id;

    return [
        'sender_id' => $sender_id,
        'chat_room_id' => $chatroom_id ?: null,
        'message' => $faker->sentence()
    ];
});
