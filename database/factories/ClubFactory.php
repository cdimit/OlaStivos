<?php

use Faker\Generator as Faker;

$factory->define(App\Club::class, function (Faker $faker) {
    return [
      'name' => $faker->name,
      'acronym' => $faker->unique()->word,
      'city' => $faker->city,
      'dof' => $faker->year($max = 'now'),

    ];
});
