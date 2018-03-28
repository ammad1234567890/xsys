<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblWarehouseIssueItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_warehouse_issue_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('warehouse_issue_id')->index();
            $table->unsignedInteger('item_id')->index();
            $table->unsignedInteger('created_by')->index();
            $table->foreign('warehouse_issue_id')->references('id')->on('tbl_warehouse_issue')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('tbl_item')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_warehouse_issue_items');
    }
}
