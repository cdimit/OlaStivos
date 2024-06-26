<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYearToAthlete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('athletes', function (Blueprint $table) {

          $table->year('year')->after('dob');
          DB::statement('ALTER TABLE `athletes` MODIFY `dob` DATE NULL;');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('athletes', function($table) {
          $table->dropColumn('year');
      });
    }
}
