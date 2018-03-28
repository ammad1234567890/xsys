<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RetailerOrderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_retailer_order_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('retailer_order_id')->index();
            $table->unsignedInteger('product_color_id')->index();
            $table->unsignedInteger('product_qty');
            $table->unsignedInteger('unit_price');
            $table->unsignedInteger('remaining_qty');
            $table->unsignedTinyInteger('is_delivered')->default(0);
            $table->unsignedTinyInteger('is_deleted')->default(0);
            $table->decimal('total_price', 13, 2);
            $table->integer('created_by')->unsigned()->index();
            $table->integer('updated_by')->unsigned()->index();

            $table->foreign('retailer_order_id')->references('id')->on('tbl_retailer_order')->onDelete('cascade');
            $table->foreign('product_color_id')->references('id')->on('tbl_product_color')->onDelete('cascade');
            
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
        Schema::dropIfExists('tbl_order_products');
    }
}
