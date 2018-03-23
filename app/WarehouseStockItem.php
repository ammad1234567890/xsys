<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseStockItem extends Model
{

	public function item()
	{
		return $this->belongsTo('App\Item','item_id');
	}

	public function warehouse()
	{
		return $this->belongsTo('App\Warehouse','warehouse_id');
	}

    protected $table='vw_warehouse_stock_items';
}
