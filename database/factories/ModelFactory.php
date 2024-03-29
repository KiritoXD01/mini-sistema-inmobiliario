<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'firstname'         => $faker->firstName,
        'lastname'          => $faker->lastName,
        'email'             => $faker->unique()->safeEmail,
        'phonenumber'       => $faker->phoneNumber,
        'email_verified_at' => now(),
        'password'          => bcrypt('password'), // password
        'remember_token'    => Str::random(10),
        'code'              => Str::random(8),
        'created_by'        => 0
    ];
});
