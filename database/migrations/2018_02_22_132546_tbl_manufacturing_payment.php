<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblManufacturingPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_manufacturing_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('manufacture_order_id')->index();
            $table->unsignedInteger('payment_amount');
            $table->unsignedInteger('payment_type_id')->index();
            $table->unsignedInteger('currency_id')->index();
            $table->unsignedInteger('exchange_rate');

            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->index()->nullable();

            $table->foreign('manufacture_order_id')->references('id')->on('tbl_manufacturing_order')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('tbl_payment_type')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('tbl_currency')->onDelete('cascade');
            
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
        Schema::dropIfExists('tbl_manufacturing_payment');
    }
}
