<?php

use Faker\Generator as Faker;

$factory->define(App\Competition::class, function (Faker $faker) {
  $date_finish = $faker->date();
  $date_start = $faker->date($max=$date_finish);
    return [
      'competition_series_id' => function () {
          return factory('App\CompetitionSeries')->create()->id;
      },
      'name' => $faker->unique()->words($nb = 3, $asText = true),
      'date_start' => $date_start,
      'date_finish' => $date_finish,
      'country' => $faker->country,
      'city' => $faker->city,
      'venue' => $faker->streetAddress,
    ];
});
