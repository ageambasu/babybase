<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Baby;
use Faker\Generator as Faker;

$factory->define(Baby::class, function (Faker $faker) {
    return [
        //Personal information
        'name' => $faker->name,
        'application_date' => date($format = 'Y-m-d'),
        'dob' => date($format = 'Y-m-d'),
        'sex' => ['female', 'male', 'other'][rand(0,2)],
        'monolingual' => ['yes', 'no'][rand(0,1)],
        'other_languages' => $faker->languageCode,
        'parent_firstname' => $faker->firstNameMale,
        'parent_lastname' => $faker->lastName,
        'phone' =>  $faker->randomNumber(9),
        'email' => $faker->unique()->safeEmail,
        'street' => $faker->streetName,
        'house_number' =>  $faker->buildingNumber,
        'postcode' =>  $faker->postcode,
        'city' =>  $faker->city,
        'recruitment_source' =>  ['mail', 'email', 'website', 'flyer consultatiebureau', 'friend', 'facebook', 'instagram', 'flyer daycare', 'flyer elsewhere'][rand(0,8)],
        
        //Appointment information
        'preferred_appointment_days' =>  $faker->dayOfWeek($max = 'now'),
        'appointment_date' => date($format = 'Y-m-d'),
        'appointment_time' => '13:15',
        'appointment_number' => $faker->randomNumber(1),
        'appointment_status' => ['open', 'closed'][rand(0,1)],
    ];
});
