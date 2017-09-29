<?php

use Illuminate\Database\Seeder;
use App\Record;

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
    }
}
