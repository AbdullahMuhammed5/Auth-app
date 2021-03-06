<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\News;
use Faker\Generator as Faker;

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

$factory->define(News::class, function (Faker $faker) {
    return [
        'main_title' => $faker->title,
        'secondary_title' => $faker->title,
        'type' => $faker->name,
        'content' => $faker->sentence,
        'published' => rand(0, 1),
        'author_id' => 1
    ];
});
