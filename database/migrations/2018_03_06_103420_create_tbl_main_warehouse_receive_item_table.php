<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMainWarehouseReceiveItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_main_warehouse_receive_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id')->index();
            $table->unsignedInteger('warehouse_id')->index();
            $table->foreign('item_id')->references('id')->on('tbl_item')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('tbl_warehouse')->onDelete('cascade');
            $table->unsignedTinyInteger('is_deleted')->default(0);//0 = active | 1=deleted
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
        Schema::dropIfExists('tbl_main_warehouse_receive_item');
    }
}
