<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainWarehouseReceive extends Model
{
    protected $fillable=['warehouse_id','receive_id','created_by','updated_by','is_deleted'];

    public function warehouse()
    {
      return $this->belongsTo('App\Warehouse','warehouse_id');
    }
    public function receive()
    {
      return $this->belongsTo('App\Receive','receive_id');
    }

    public function mainWarehouseReceiveProduct()
    {
      return $this->hasMany('App\MainWarehouseReceiveProduct','main_receive_id');
    }

    public function user()
    {
      return $this->belongsTo('App/User');
    }

    protected $table='tbl_main_warehouse_receive';
}
