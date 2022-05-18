<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('banner');
            $table->string('link');
            $table->unsignedBigInteger('ad_space_id');
            $table->unsignedBigInteger('country_id');
            $table->integer('views')->default(0);
            $table->integer('clicks')->default(0);
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('ad_space_id')->references('id')->on('ad_spaces')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
