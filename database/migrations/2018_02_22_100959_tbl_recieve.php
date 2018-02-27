<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblRecieve extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::disableForeignKeyConstraints();
        Schema::create('tbl_receive', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('manufacturing_order_id')->index();
            $table->unsignedInteger('collected_by')->index();
            $table->unsignedTinyInteger('is_qa_pass')->default(0);
            $table->string('qa_description');
            $table->unsignedInteger('receive_status_id')->index();

            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->index()->nullable();

            $table->foreign('manufacturing_order_id')->references('id')->on('tbl_manufacturing_order')->onDelete('cascade');
            $table->foreign('collected_by')->references('id')->on('tbl_staff')->onDelete('cascade');
            $table->foreign('receive_status_id')->references('id')->on('tbl_receive_status')->onDelete('cascade');
            
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
        Schema::dropIfExists('tbl_receive');
    }
}
