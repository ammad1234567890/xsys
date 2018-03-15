<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMainWarehouseReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_main_warehouse_receive', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('warehouse_id')->index();
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('receive_id')->index();
            $table->unsignedInteger('updated_by')->index()->nullable();
            $table->unsignedTinyInteger('is_deleted')->default(0);//0 = active | 1=deleted
            $table->foreign('warehouse_id')->references('id')->on('tbl_warehouse')->onDelete('cascade');
            $table->foreign('receive_id')->references('id')->on('tbl_receive')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_main_warehouse_receive');
    }
}
