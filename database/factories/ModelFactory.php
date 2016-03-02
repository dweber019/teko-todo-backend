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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'birthday' => \Carbon\Carbon::createFromTimestamp($faker->dateTimeThisCentury->getTimestamp()),
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Tasklist::class, function (Faker\Generator $faker) {
    return [
      'name' => $faker->sentence,
      'color' => $faker->hexColor,
    ];
});

$factory->define(App\Models\Task::class, function (Faker\Generator $faker) {
    return [
      'name' => $faker->sentence,
      'description' => $faker->text,
      'dueDate' => \Carbon\Carbon::createFromTimestamp($faker->dateTimeBetween('now', '+1 years')->getTimestamp()),
      'favorite' => $faker->boolean()
    ];
});