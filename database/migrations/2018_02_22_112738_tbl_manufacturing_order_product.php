<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblManufacturingOrderProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_manufacturing_order_product', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_color_id')->index();
            $table->unsignedInteger('manufacture_order_id')->index();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('unit_cost');


            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->index()->nullable();

            $table->foreign('product_color_id')->references('id')->on('tbl_product_color')->onDelete('cascade');
            $table->foreign('manufacture_order_id')->references('id')->on('tbl_manufacturing_order')->onDelete('cascade');
            
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
        Schema::dropIfExists('tbl_manufacturing_order_product');
    }
}
