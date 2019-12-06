<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSaLkecamatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sa_lkecamatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kabupaten_id')->unsigned();
            $table->string('kecamatan_name');
            $table->timestamps();

            $table->foreign('kabupaten_id')->references('id')->on('sa_lkabupaten')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sa_lkecamatan');
    }
}
