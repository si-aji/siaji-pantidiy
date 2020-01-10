<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSaPostKeyword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sa_post_keyword', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->unsigned();
            $table->bigInteger('keyword_id')->unsigned();
            $table->timestamps();

            $table->foreign('post_id')
                ->references('id')
                ->on('sa_post')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('keyword_id')
                ->references('id')
                ->on('sa_keyword')
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
        Schema::dropIfExists('sa_post_keyword');
    }
}
