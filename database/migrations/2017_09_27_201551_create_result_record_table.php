<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_record', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('record_id')->unsigned();
            $table->integer('result_id')->unsigned();

            $table->foreign('record_id')->references('id')->on('records');
            $table->foreign('result_id')->references('id')->on('results');
            
            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events');
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
        Schema::dropIfExists('result_record');

    }
}
