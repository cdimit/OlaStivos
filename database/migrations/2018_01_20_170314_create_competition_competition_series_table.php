<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionCompetitionSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_competition_series', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('competition_id')->unsigned();
            $table->integer('competition_series_id')->unsigned();

            $table->foreign('competition_id')->references('id')->on('competitions');
            $table->foreign('competition_series_id')->references('id')->on('competition_series');
        });
  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    
        Schema::dropIfExists('competition_competition_series');
        
    }
}
