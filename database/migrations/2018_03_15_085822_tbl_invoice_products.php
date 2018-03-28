<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblInvoiceProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_invoice_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id')->index();
            $table->unsignedInteger('product_color_id')->index();
            $table->unsignedInteger('product_qty');
            $table->decimal('product_price', 13, 2);
            $table->unsignedInteger('discount_type_id')->index()->nullable();
            $table->decimal('total_amount', 13, 2);
            $table->unsignedInteger('extra')->nullable();
            $table->unsignedTinyInteger('is_deleted')->default(0);//0 = active | 1=deleted
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->index()->nullable();
            
            $table->foreign('invoice_id')->references('id')->on('tbl_invoice')->onDelete('cascade');
            $table->foreign('product_color_id')->references('id')->on('tbl_product_color')->onDelete('cascade');
            $table->foreign('discount_type_id')->references('id')->on('tbl_discount_type')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_invoice_products');
    }
}
