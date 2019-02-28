<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable=['name','warehouse_type_id','name','city_id','region_id','latitude','longitude','address','warehouse_manager','warehouse_accountant','created_by','updated_by'];

    public function warehouseType()
    {
      return $this->belongsTo('App\WarehouseType','warehouse_type_id');
    }

    public function city()
    {
     return $this->belongsTo('App\City');
    }

    public function region()
    {
      return $this->belongsTo('App\Region');
    }

    public function manager()
    {
      return $this->belongsTo('App\Staff','warehouse_manager');
    }

    public function accountant()
    {
      return $this->belongsTo('App\Staff','warehouse_accountant');
    }

    public function user()
    {
      return $this->belongsTo('App\User','created_by');
    }

    public function warehouseStock()
    {
      return $this->hasMany('App\WarehouseStock');
    }

    public function mainWarehouseReceive()
    {
      return $this->hasMany('App\MainWarehouseReceive');
    }

    public function warehouseStaff()
    {
      return $this->hasMany('App\WarehouseStaff');
    }

    public function mainWarehouseReceiveItem()
    {
      return $this->hasMany('App\MainWarehouseReceiveItem');
    }

    public function warehouseStockItem()
    {
      return $this->hasMany('App\warehouseStockItem');
    }
    protected $table='tbl_warehouse';
}
