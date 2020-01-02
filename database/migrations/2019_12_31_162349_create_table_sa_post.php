<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSaPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sa_post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('author_id')->unsigned();
            $table->bigInteger('editor_id')->unsigned()->nullable();
            $table->string('post_title')->unique();
            $table->string('post_slug')->unique();
            $table->string('post_thumbnail')->nullable();
            $table->longText('post_content');
            $table->boolean('post_shareable')->default(false);
            $table->boolean('post_commentable')->default(false);
            $table->enum('post_status', ['published', 'draft'])->default('draft');
            $table->dateTime('post_published')->nullable();
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('sa_category')
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
        Schema::dropIfExists('sa_post');
    }
}
