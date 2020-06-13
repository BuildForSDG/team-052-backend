<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Report;
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

$factory->define(Report::class, function (Faker $faker) {
    return [
        'title' => "$faker->streetName Accident",
        'note'  =>  $faker->realText(100),
        'location' => $faker->streetAddress(),
        'visual_image' => $faker->imageUrl(300, 300, 'city'),
    ];
});

$factory->state(Report::class, 'pending', [
    'status'    =>  'pending'
]);

$factory->state(Report::class, 'enroute', [
    'status'    =>  'enroute'
]);

$factory->state(Report::class, 'onsite', [
    'status'    =>  'onsite'
]);

$factory->state(Report::class, 'acknowledged', [
    'status'    =>  'acknowledged'
]);
