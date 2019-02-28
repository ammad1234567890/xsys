<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=['product_color_id','receive_id','is_deleted','created_by','updated_by'];

    protected $table="tbl_item";

    public function imei()
    {
      return $this->hasMany('App\IMEI');
    }

    public function receive(){
      return $this->belongsTo('App\Receive','receive_id');
    }

    public function productColor()
    {
     return $this->belongsTo('App\ProductColor','product_color_id');
    }

    public function mainWarehouseReceiveItem()
    {
      return $this->hasMany('App\mainWarehouseReceiveItem');
    }

    public function warehouseIssueItem(){
      return $this->hasOne('App\warehouseIssueItem');
    }

    public function warehouseStockItem()
    {
      return $this->hasMany('App\warehouseStockItem');
    }

    public function receiveBy()
    {
      return $this->belongsTo('App\Receive');
    }
}
