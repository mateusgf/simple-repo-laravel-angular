<?php

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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Application::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->company
    ];
});


$factory->define(App\ApplicationVersion::class, function (Faker\Generator $faker) {
    return [
        'title' => 'v' . $faker->numberBetween(1, 20)
    ];
});


$factory->define(App\File::class, function (Faker\Generator $faker) {


    return [
        'title' => 'file-' . $faker->numberBetween(1, 20),
        'filename' => 'file-' . $faker->numberBetween(1, 20) . '.zip',
    ];
});

