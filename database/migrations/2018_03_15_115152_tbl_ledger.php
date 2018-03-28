<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_ledger', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('retailer_id')->index();
            $table->unsignedInteger('invoice_id')->index();
            $table->unsignedInteger('collection_id')->index();
            $table->dateTime('TransDate');
            $table->decimal('Collection', 13, 2);
            $table->decimal('Credit', 13, 2);
            $table->longText('description');

            $table->foreign('retailer_id')->references('id')->on('tbl_retailer_outlet')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('tbl_invoice')->onDelete('cascade');
            $table->foreign('collection_id')->references('id')->on('tbl_retailer_collection')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_ledger');
    }
}
