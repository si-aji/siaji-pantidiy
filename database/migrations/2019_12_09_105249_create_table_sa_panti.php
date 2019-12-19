<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSaPanti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sa_panti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('provinsi_id')->unsigned()->nullable();
            $table->bigInteger('kabupaten_id')->unsigned()->nullable();
            $table->bigInteger('kecamatan_id')->unsigned()->nullable();
            $table->string('panti_name');
            $table->string('panti_slug')->unique();
            $table->text('panti_alamat')->nullable();
            $table->text('panti_description')->nullable();
            $table->timestamps();

            $table->foreign('provinsi_id')
                ->references('id')
                ->on('sa_lprovinsi')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('kabupaten_id')
                ->references('id')
                ->on('sa_lkabupaten')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('kecamatan_id')
                ->references('id')
                ->on('sa_lkecamatan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sa_panti');
    }
}
