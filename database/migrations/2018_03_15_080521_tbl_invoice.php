<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->index();
            $table->unsignedInteger('discount_type_id')->index();
            $table->unsignedInteger('invoice_type_id')->index();
            $table->decimal('discount_percent', 13, 2);
            $table->decimal('discount_amount', 13, 2);
            $table->longText('description');
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->index()->nullable();
            $table->foreign('order_id')->references('id')->on('tbl_retailer_order')->onDelete('cascade');
            $table->foreign('discount_type_id')->references('id')->on('tbl_discount_type')->onDelete('cascade');
            $table->foreign('invoice_type_id')->references('id')->on('tbl_invoice_type')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_invoice');
    }
}
