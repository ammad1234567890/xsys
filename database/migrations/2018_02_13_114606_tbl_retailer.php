<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblRetailer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_retailer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('cnic')->unique()->nullable();
            $table->string('phone_no');
            $table->string('image');
            $table->unsignedTinyInteger('is_deleted')->default(0);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_retailer');
    }
}
