<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainWarehouseReceiveItem extends Model
{
    protected $fillable=['item_id','warehouse_id','is_deleted'];

    public function item()
    {
      return $this->belongsTo('App\Item');
    }

    public function warehouse()
    {
      return $this->belongsTo('App\Warehouse');
    }

    protected $table='tbl_main_warehouse_receive_item';
}
