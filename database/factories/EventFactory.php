<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [



      'name' => $faker->randomElement(['100m', '200m', '300m', '400m',
            '600m',
            '800m',
            '1000m',
            '1500m'	,
            'Mile',
            '2000m',
            '3000m'	,
            '2 Miles',
            '5000m',
            '10,000m',
            '110mH',
            '400mH'	,
            '2000mSC',
            '3000mSC'	,
            'HJ',
            'PV',
            'LJ',
            'TJ',
            'SP',
            'DT',
            'HT',
            'JT',
            '10 km',
            '15 km',
            '10 Miles',
            '20 km',
            'HM',
            'Marathon',
            'Decathlon',
            '4x100m',
            '4x400m']),
      'type' => $faker->randomElement(['track', 'field']),
      'season' => $faker->randomElement(['indoor', 'outdoor']),
      'gender' => $faker->randomElement(['male', 'female']),
    ];
});
