<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Study;
use Faker\Generator as Faker;

$factory->define(Study::class, function (Faker $faker) {
    return [
        'study_type' => ['linguistics', 'pedagogy', 'NIRS'][rand(0,2)],
        'study_name' => $faker->sentence,
        'study_age_range_start' => $faker->randomNumber(1),
        'study_age_range_end' => $faker->randomNumber(1),
        'notes' => $faker->sentence,
    ];
});
