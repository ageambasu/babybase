<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Baby;
use Faker\Generator as Faker;

$factory->define(Baby::class, function (Faker $faker) {
    return [
        //Personal information
        'name' => $faker->name,
        'application_date' => '2019-01-01',
        'dob' => '2016-01-01',
        'sex' => 'male',
        'monolingual' => 'No',
        'other_languages' => $faker->languageCode,
        'parent_firstname' => $faker->firstNameMale,
        'parent_lastname' => $faker->lastName,
        'phone' =>  $faker->randomNumber(9),
        'email' => $faker->unique()->safeEmail,
        'street' => $faker->streetName,
        'house_number' =>  $faker->buildingNumber,
        'postcode' =>  $faker->postcode,
        'city' =>  $faker->city,
        'recruitment_source' =>  'Newsletter',
        
        //Appointment information
        'preferred_appointment_days' =>  $faker->dayOfWeek($max = 'now'),
        'appointment_date' => '2019-01-01',
        'appointment_time' => '13:15',
        'appointment_number' => $faker->randomNumber(1),
        'appointment_status' => 'New',

        //Study information
        'study_type' => 'Basic',
        'study_name' => 'Foreign language test',
        'study_age_range' => $faker->randomNumber(1),
        'prevous_studies_completed' => 'Mother tongue test',
        'notes' => 'No phone calls requested',
    ];
});
