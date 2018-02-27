<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblManufacturingOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_manufacturing_order', function (Blueprint $table) {
            $table->increments('id');
            $table->date('eta');
            $table->unsignedInteger('total_cost');
            $table->unsignedInteger('remaining_payment');
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->index()->nullable();
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
        Schema::dropIfExists('tbl_manufacturing_order');
    }
}
