<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblRetailerCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_retailer_collection', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_id')->index();
            $table->unsignedInteger('currency_id')->index();
            $table->unsignedInteger('payment_type_id')->index();
            $table->unsignedInteger('retailer_id')->index();
            $table->unsignedInteger('retailer_outlet_id')->index();
            $table->unsignedInteger('invoice_id')->index();
            $table->decimal('outstanding_amount', 13, 2);
            $table->string('cheque_number');
            $table->string('deposit_slip_number');
            $table->longText('remarks');
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->index();
            $table->foreign('bank_id')->references('id')->on('tbl_bank')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('tbl_currency')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('tbl_payment_type')->onDelete('cascade');
            $table->foreign('retailer_id')->references('id')->on('tbl_retailer')->onDelete('cascade');
            $table->foreign('retailer_outlet_id')->references('id')->on('tbl_retailer_outlet')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('tbl_invoice')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('user')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_retailer_collection');
    }
}
