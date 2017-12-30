<?php

use Illuminate\Database\Seeder;
use App\CompetitionSeries;

class CompetitionSeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompetitionSeries::forceCreate(['name' => 'Παγκύπριο Πρωτάθλημα Ανδρών/Γυναικών Ανοικτού Στίβου']);

    }
}
