<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseType extends Model
{
    protected $fillable=['type'];

    protected $table="tbl_warehouse_type";
}
