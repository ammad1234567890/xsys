<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockStatusHistory extends Model
{
    protected $fillable=['id','item_id','warehouse_id','old_status', 'new_status','remarks', 'created_by'];

    public function item()
    {
      return $this->belongsTo('App\Item', 'item_id');
    }

    public function warehouse()
    {
      return $this->belongsTo('App\Warehouse', 'warehouse_id');
    }

    public function imei(){
        return $this->belongsTo('App\IMEI', 'item_id');
    }

    protected $table='stock_status_history';
}
