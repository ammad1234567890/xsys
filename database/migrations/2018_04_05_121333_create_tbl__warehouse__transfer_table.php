<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblWarehouseTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl__warehouse__transfer', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('previous_warehouse_id')->index();
            $table->unsignedInteger('product_color_id')->index();
            $table->integer('old_product_qty');
            $table->integer('remaining_qty');
            $table->integer('transfer_qty');
            $table->unsignedInteger('new_warehouse_id')->index();
            $table->unsignedInteger('new_transfer_qty');
            $table->unsignedInteger('created_by')->index();
            $table->foreign('previous_warehouse_id')->references('id')->on('tbl_warehouse')->onDelete('cascade');
            $table->foreign('product_color_id')->references('id')->on('tbl_product_color')->onDelete('cascade');
            $table->foreign('new_warehouse_id')->references('id')->on('tbl_warehouse')->onDelete('cascade');
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
        Schema::dropIfExists('tbl__warehouse__transfer');
    }
}
