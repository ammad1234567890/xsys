<?php

namespace App\Http\Controllers;

use App\WarehouseStock;
use App\WarehouseStockItem;
use Illuminate\Http\Request;

class WarehouseStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('warehouseStock');
    }

    public function allStock()
    {
    	$warehouseStock=WarehouseStock::with('warehouse','productColor.product')->get();
    	return $warehouseStock;
    }

    public function warehouseStockSearch($id)
    {
        $searchStock=WarehouseStock::where('warehouse_id',$id)->with('warehouse','productColor.product')->get();
        return $searchStock;
    }

    public function searchStockDetails($id)
    {
        //$searchStock=WarehouseStockItem::all();
        // $searchStock=WarehouseStockItem::where('warehouse_id',5)->get();
        $searchStock=WarehouseStockItem::where('warehouse_id',$id)->with('warehouse','item.productColor.product','item.imei')->get();
        return $searchStock;
        //return $id;
    }
}
