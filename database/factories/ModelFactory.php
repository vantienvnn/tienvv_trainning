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
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

// word
$factory->define(App\Word::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->name,
        'category_id' => 1
    ];
});
// word answer
$factory->define(App\WordAnswer::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->name,
        'word_id' => 1,
        'correct' => 0
    ];
});

// lesson
$factory->define(App\Lesson::class, function () {
    return [
        'category_id' => 1,
        'user_id' => 1,
        'result' => 0
    ];
});
