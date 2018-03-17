<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeClubToNullableInAthlete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('athletes', function (Blueprint $table) {

          DB::statement('ALTER TABLE `athletes` MODIFY `club_id` INTEGER UNSIGNED NULL;');

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
