<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAthletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('athletes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob');
            $table->string('gender');// male, female
            $table->string('picture')->default('/img/athlete.png');
            $table->boolean('status')->default(0);

            $table->integer('club_id')->unsigned();

            $table->foreign('club_id')->references('id')->on('clubs');

            $table->unique(['first_name','last_name', 'dob', 'gender']);

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
        Schema::dropIfExists('athletes');
    }
}
