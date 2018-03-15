<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainWarehouseReceiveProduct extends Model
{
    protected $fillable=['main_receive_id','product_color_id','product_qty','created_by','updated_by','is_deleted'];

    public function mainWarehouseReceive()
    {
        return $this->belongsTo('App\MainWarehouseReceive','main_receive_id');
    }

    public function productColor()
    {
        return $this->belongsTo('App\ProductColor','product_color_id');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    protected $table='tbl_main_warehouse_receive_product';
}
