<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseTransfer extends Model
{

	protected $fillable=['resource_id','product_unit_price','previous_warehouse_id','product_color_id','old_product_qty','remaining_qty','transfer_qty','new_warehouse_id','new_transfer_qty','created_by'];
    protected $table='tbl__warehouse__transfer';
}
