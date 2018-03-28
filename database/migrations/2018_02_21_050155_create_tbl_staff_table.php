<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phoneNumber');
            $table->string('email')->unique();
            $table->string('CNIC',15)->unique();
            $table->string('address');
            $table->unsignedInteger('city_id')->index();
            $table->unsignedInteger('region_id')->index();
            $table->unsignedInteger('department_id')->index();
            $table->unsignedInteger('staff_type_id')->index();
            $table->unsignedInteger('designation_id')->index();
            $table->unsignedInteger('created_by')->index();
            $table->unsignedInteger('updated_by')->index()->nullable();
            $table->unsignedTinyInteger('is_deleted')->default(0);//0 = active | 1=deleted
            $table->foreign('city_id')->references('id')->on('tbl_city')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('tbl_region')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('tbl_department')->onDelete('cascade');
            $table->foreign('staff_type_id')->references('id')->on('tbl_staff_type')->onDelete('cascade');
            $table->foreign('designation_id')->references('id')->on('tbl_designation')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_staff');
    }
}
