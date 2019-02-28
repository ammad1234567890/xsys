<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseStockTypeDetails extends Model
{

	public function warehouse_stock()
	{
		return $this->belongsTo('App\WarehouseStock');
	}

    protected $table='vw_stock_details_by_warehouse';
}
