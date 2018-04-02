<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\WarehouseStock;

class WarehouseTransferController extends Controller
{
    public function index(){
    	return view('WarehouseTransfer');
    }

    public function warehouseProductDetails($id){
    	$warehouseData=WarehouseStock::where('warehouse_id',$id)->with('productColor.product')->get();
    	return $warehouseData;
    }
}
