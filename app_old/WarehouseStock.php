<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseStock extends Model
{
    protected $fillable=['warehouse_id','product_color_id','product_qty'];

    public function warehouse()
    {
      return $this->belongsTo('App\Warehouse');
    }

    public function productColor()
    {
      return $this->belongsTo('App\productColor','product_color_id');
    }

    public function warehouse_stock_details(){
        return $this->hasMany('App\WarehouseStockTypeDetails','warehouse_stock_id');
    }

    protected $table='tbl_warehouse_stock';
}
