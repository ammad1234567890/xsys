<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_warehouse', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('warehouse_type_id');
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('region_id');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('address');
            $table->unsignedInteger('warehouse_manager')->index()->nullable();
            $table->unsignedInteger('warehouse_accountant')->index()->nullable();
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->index()->nullable();
            $table->unsignedTinyInteger('is_deleted')->default(0);//0 = active | 1=deleted
            $table->foreign('warehouse_type_id')->references('id')->on('tbl_warehouse_type')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('tbl_city')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('tbl_region')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_warehouse');
    }
}
