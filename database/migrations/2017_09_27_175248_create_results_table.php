<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('position');
            $table->string('mark');
            $table->date('date');
            $table->integer('score');
            $table->string('race');
            $table->time('age');

            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events');

            $table->integer('athlete_id')->unsigned();
            $table->foreign('athlete_id')->references('id')->on('athletes');


            $table->integer('competition_id')->unsigned();
            $table->foreign('competition_id')->references('id')->on('competitions');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}