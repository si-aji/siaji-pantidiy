<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSaPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sa_page', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('page_title');
            $table->string('page_slug')->unique();
            $table->string('page_thumbnail')->nullable();
            $table->longText('page_content');
            $table->boolean('page_shareable')->default(false);
            $table->enum('page_status', ['published', 'draft'])->default('draft');
            $table->dateTime('page_published')->nullable();
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
        Schema::dropIfExists('sa_page');
    }
}
