<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblRecieveStatusLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_receive_status_log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recieve_id')->index();
            $table->unsignedInteger('recieve_status_id')->index();

            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->index()->nullable();
            $table->foreign('recieve_id')->references('id')->on('tbl_receive')->onDelete('cascade');
            $table->foreign('recieve_status_id')->references('id')->on('tbl_recieve_status')->onDelete('cascade');
            
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
        Schema::dropIfExists('tbl_receive_status_log');
    }
}
