<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblWarehouseIssueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_warehouse_issue', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id')->index()->unique();
            $table->unsignedInteger('warehouse_id')->index()->unique();
            $table->boolean('is_issued')->default(False);
            $table->unsignedInteger('created_by')->index();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('tbl_invoice')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('tbl_warehouse')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_warehouse_issue');
    }
}
