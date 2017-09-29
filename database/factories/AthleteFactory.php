<?php

use Faker\Generator as Faker;

$factory->define(App\Athlete::class, function (Faker $faker) {
    return [
      'club_id' => function () {
          return factory('App\Club')->create()->id;
      },
      'first_name' => $faker->firstName,
      'last_name'  => $faker->lastName,
      'dob' => $faker->date,
      'gender' => $faker->randomElement(['male', 'female']),
    ];
});
