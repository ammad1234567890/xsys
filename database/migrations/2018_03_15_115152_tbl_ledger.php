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
            $table->decimal('collection_amount', 13, 2);
            $table->decimal('outstanding_amount', 13, 2);
            $table->longText('description');
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->index();

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
        Schema::dropIfExists('tbl_ledger');
    }
}
