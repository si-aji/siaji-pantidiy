<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSaDonation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sa_donation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('panti_id')->unsigned();
            $table->string('donation_title')->nullable();
            $table->longText('donation_description');
            $table->date('donation_start');
            $table->date('donation_end')->nullable();
            $table->boolean('donation_hasdeadline')->default(false);
            $table->float('donation_needed', 20, 2);
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
        Schema::dropIfExists('sa_donation');
    }
}
