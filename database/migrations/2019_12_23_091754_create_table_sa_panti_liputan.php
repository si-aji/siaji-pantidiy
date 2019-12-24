<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSaPantiLiputan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sa_panti_liputan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('panti_id')->unsigned();
            $table->bigInteger('author_id')->unsigned();
            $table->bigInteger('editor_id')->unsigned()->nullable();
            $table->dateTime('liputan_date');
            $table->string('liputan_thumbnail')->nullable();
            $table->longText('liputan_content');
            $table->timestamps();

            $table->foreign('panti_id')
                ->references('id')
                ->on('sa_panti')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('editor_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('sa_panti_liputan');
    }
}
