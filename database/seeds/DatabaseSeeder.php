<?php

use Illuminate\Database\Seeder;
use App\Record;
use App\Age;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Record::forceCreate(['name' => 'National Record', 'acronym' => 'NR']);
      Record::forceCreate(['name' => 'National U23 Record', 'acronym' => 'NUR']);
      Record::forceCreate(['name' => 'National U20 Record', 'acronym' => 'NJR']);
      Record::forceCreate(['name' => 'National U18 Record', 'acronym' => 'NYR']);
      Record::forceCreate(['name' => 'Competition Record', 'acronym' => 'CR']);
      Record::forceCreate(['name' => 'Area Record', 'acronym' => 'AR']);
      Record::forceCreate(['name' => 'Personal Best', 'acronym' => 'PB']);
      Record::forceCreate(['name' => 'Season Best', 'acronym' => 'SB']);

      //Age::forceCreate(['name' => '', 'min' => '', 'max' => '']);
      Age::forceCreate(['name' => 'u23', 'min' => '20', 'max' => '22']);
      Age::forceCreate(['name' => 'u20', 'min' => '0', 'max' => '19']);
      Age::forceCreate(['name' => 'u18', 'min' => '0', 'max' => '17']);
      Age::forceCreate(['name' => 'u16', 'min' => '0', 'max' => '15']);

    }
}
