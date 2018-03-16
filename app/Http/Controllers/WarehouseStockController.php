<?php

namespace App\Http\Controllers;

use App\WarehouseStock;
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
}
