<?php

use Faker\Generator as Faker;

$factory->define(App\Club::class, function (Faker $faker) {
    return [
      'name' => $faker->name,
      'acronym' => $faker->unique()->word,
      'city' => $faker->city,
      'since' => $faker->year($max = 'now'),

    ];
});
