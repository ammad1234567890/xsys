<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblRolePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('tbl_role_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->index();
            $table->integer('permission_id')->unsigned()->index();
            $table->unsignedTinyInteger('is_deleted')->default(0); //0 = active | 1=deleted
            $table->foreign('role_id')->references('id')->on('tbl_role')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('tbl_permission')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_role_permission');
    }
}
