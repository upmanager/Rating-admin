<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ratingid');
            $table->string('res_key');
            $table->string('res_value');
            $table->string('type')->comment('0: question, 1: image');
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
        Schema::dropIfExists('rating_details');
    }
}
