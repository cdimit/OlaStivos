<?php

use Illuminate\Database\Seeder;
use App\Record;
use App\Age;
use App\Club;
use App\Role;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Create User Roles
      $this->call(RoleTableSeeder::class);
      // Create Standard Competition Series
      $this->call(CompetitionSeriesTableSeeder::class);

      Record::forceCreate(['name' => 'National Record', 'acronym' => 'NR']);
      Record::forceCreate(['name' => 'National U23 Record', 'acronym' => 'NUR']);
      Record::forceCreate(['name' => 'National U20 Record', 'acronym' => 'NJR']);
      Record::forceCreate(['name' => 'National U18 Record', 'acronym' => 'NYR']);
      Record::forceCreate(['name' => 'Competition Record', 'acronym' => 'CR']);
      Record::forceCreate(['name' => 'Area Record', 'acronym' => 'AR']);
      Record::forceCreate(['name' => 'Personal Best', 'acronym' => 'PB']);
      Record::forceCreate(['name' => 'Season Best', 'acronym' => 'SB']);

      Age::forceCreate(['name' => 'Άνδρες/Γυναίκες', 'category' => 'senior', 'min' => '0', 'max' => '99']);
      Age::forceCreate(['name' => 'Κάτω των 23', 'category' => 'u23', 'min' => '20', 'max' => '22']);
      Age::forceCreate(['name' => 'Έφηφοι/Νεανίδες', 'category' => 'u20', 'min' => '0', 'max' => '19']);
      Age::forceCreate(['name' => 'Παίδες/Κορασίδες', 'category' => 'u18', 'min' => '0', 'max' => '17']);
      Age::forceCreate(['name' => 'u16', 'category' => 'u16', 'min' => '0', 'max' => '15']);

      Club::forceCreate(['name' => 'Γυμναστικός Σύλλογος Τα Παγκύπρια', 'acronym' => 'ΓΣΠ', 'city' => 'Λευκωσία', 'since' => '1894']);
      Club::forceCreate(['name' => 'Γυμναστικός Σύλλογος τα Ολύμπια', 'acronym' => 'ΓΣΟ', 'city' => 'Λεμεσός', 'since' => '1892']);
      Club::forceCreate(['name' => 'Γυμναστικός Σύλλογος Ευαγόρας', 'acronym' => 'ΓΣΕ', 'city' => 'Αμμόχωστος', 'since' => '1903']);
      Club::forceCreate(['name' => 'Γυμναστικού Συλλόγου Ζήνων', 'acronym' => 'ΓΣΖ', 'city' => 'Λάρνακα', 'since' => '1896']);
      Club::forceCreate(['name' => 'Γυμναστικός Σύλλογος Κόροιβος', 'acronym' => 'ΓΣΚ', 'city' => 'Πάφος', 'since' => '1898']);
      Club::forceCreate(['name' => 'Γυμναστικός Συλλογος Πράξανδρος', 'acronym' => 'ΓΣΠΡ', 'city' => 'Κερύνεια', 'since' => '1919']);


    }
}
