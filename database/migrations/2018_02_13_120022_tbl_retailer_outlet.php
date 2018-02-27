<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblRetailerOutlet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_retailer_outlet',function(Blueprint $table){
            Schema::disableForeignKeyConstraints();
            $table->increments('id');
            $table->integer('retailer_id')->unsigned()->index();
            $table->integer('city_id')->unsigned()->index();
            $table->integer('region_id')->unsigned()->index();
            $table->string('name');
            $table->string('phone_no');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('business_person_name');
            $table->string('mobile_no');
            $table->string('address');
            $table->integer('security_deposit_amount');
            $table->string('security_deposit_image');
            $table->integer('credit_limit');
            $table->integer('credit_duration');
            $table->integer('credit_remaining');
            $table->integer('aging_amount')->default(0);
            $table->integer('created_by')->unsigned()->index();
            $table->integer('updated_by')->unsigned()->index();

            $table->unsignedTinyInteger('is_deleted')->default(0);

            $table->foreign('retailer_id')->references('id')->on('tbl_retailer')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('tbl_city')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('tbl_region')->onDelete('cascade');

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
        Schema::dropIfExists('tbl_retailer_outlet');
    }
}
