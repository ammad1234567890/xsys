<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblRegion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_region',function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('city_id')->index();
            $table->string('name');
            $table->foreign('city_id')->references('id')->on('tbl_city')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_region');
    }
}
