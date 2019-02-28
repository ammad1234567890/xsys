<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainWarehouseReceiveItem extends Model
{
    protected $fillable=['item_id','warehouse_id','current_stock_status','is_deleted','is_sold','sold_to_outlet_id','item_is_activate', 'activated_date'];

    public function item()
    {
      return $this->belongsTo('App\Item');
    }

    public function warehouse()
    {
      return $this->belongsTo('App\Warehouse');
    }

    public function outlet(){
        return $this->belongsTo('App\RetailerOutlet', 'sold_to_outlet_id');
    }

   

    protected $table='tbl_main_warehouse_receive_item';
}
