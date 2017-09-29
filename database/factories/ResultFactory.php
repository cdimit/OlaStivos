<?php

use Faker\Generator as Faker;

$factory->define(App\Result::class, function (Faker $faker) {
    return [
        'event_id' => function () {
            return factory('App\Event')->create()->id;
        },
        'athlete_id' => function () {
            return factory('App\Athlete')->create()->id;
        },
        'competition_id' => function () {
            return factory('App\Competition')->create()->id;
        },
        'mark' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
        'position'  => $faker->numberBetween($min = 1, $max = 48),
        'date' => $faker->date,
        'score' => $faker->numberBetween($min = 0, $max = 2000),
        'race' => $faker->randomElement(['Heat', 'Semi-Final', 'Final']),
        'age' => $faker->unixTime($max = 'now'),
    ];
});
