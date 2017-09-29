<?php

use Faker\Generator as Faker;

$factory->define(App\CompetitionSeries::class, function (Faker $faker) {
    return [
      'name' => $faker->unique()->words($nb = 3, $asText = true),
    ];
});
