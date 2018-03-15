<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RetailerOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_retailer_order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('retailer_id')->index();
            $table->unsignedInteger('sales_officer_id')->index();
            $table->unsignedInteger('outlet_id')->index();
            $table->date('order_date');
            $table->date('expected_delivery_date');
            $table->unsignedInteger('total_cost');
            $table->unsignedInteger('remaining_payment');
            $table->date('ageing_date');
            $table->unsignedTinyInteger('is_account_clearance')->default(0);
            $table->unsignedTinyInteger('is_approved')->default(0);
            $table->unsignedTinyInteger('is_deleted')->default(0);
            $table->unsignedInteger('retailer_order_status_id')->index();
            $table->unsignedInteger('warehouse_id')->index();
            $table->integer('created_by')->unsigned()->index();
            $table->integer('updated_by')->unsigned()->index();

            $table->foreign('retailer_id')->references('id')->on('tbl_retailer')->onDelete('cascade');
            $table->foreign('sales_officer_id')->references('id')->on('tbl_staff')->onDelete('cascade');
            $table->foreign('outlet_id')->references('id')->on('tbl_retailer_outlet')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('tbl_warehouse')->onDelete('cascade');
            $table->foreign('retailer_order_status_id')->references('id')->on('tbl_retailer_order_status')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_retailer_order');
    }
}
