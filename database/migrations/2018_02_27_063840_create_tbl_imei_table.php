<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblImeiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_imei', function (Blueprint $table) {
             $table->increments('id');
            $table->string('imei1')->unique()->index();
            $table->string('imei2')->unique()->index();
            $table->unsignedInteger('item_id')->index()->nullable();
            $table->unsignedInteger('created_by')->index();
            $table->foreign('item_id')->references('id')->on('tbl_item');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_imei');
    }
}
