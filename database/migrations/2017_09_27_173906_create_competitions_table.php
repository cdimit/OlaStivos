<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('date_start');
            $table->date('date_finish');
            $table->string('country');
            $table->string('city');
            $table->string('picture')->default('competition.jpg');
            $table->string('venue');
            $table->boolean('status')->default(0);
            $table->integer('competition_series_id')->unsigned();
            $table->foreign('competition_series_id')->references('id')->on('competition_series');
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
        Schema::dropIfExists('competitions');
    }
}
