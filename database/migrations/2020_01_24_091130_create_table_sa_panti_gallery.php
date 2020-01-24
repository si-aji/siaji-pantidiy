<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSaPantiGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sa_panti_gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('panti_id')->unsigned();
            $table->string('gallery_filename');
            $table->string('gallery_fullname');
            $table->string('gallery_filesize');
            $table->boolean('is_thumb')->default(false);
            $table->timestamps();

            $table->foreign('panti_id')
                ->references('id')
                ->on('sa_panti')
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
        Schema::dropIfExists('sa_panti_gallery');
    }
}
