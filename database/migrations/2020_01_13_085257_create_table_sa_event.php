<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSaEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sa_event', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_title');
            $table->string('event_slug');
            $table->string('event_thumbnail')->nullable();
            $table->longText('event_description');
            $table->dateTime('event_start');
            $table->dateTime('event_end');
            $table->string('event_place')->nullable();
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
        Schema::dropIfExists('sa_event');
    }
}
