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

    public function transferReq(Request $request)
    {
    	$subWarehouse=$request->input('subWarehouse');
    	$details=$request->input('details');    	
    	foreach ($details as $detail) {
    		if($detail['isTrue']==True){    			
    			$warehouseId=$detail['warehouseId'];
    			$productColorId=$detail['productColorId'];
    			// if(WarehouseStock::where('warehouse_id',$subWarehouse['id']))
    		}

    	}
    	return $data;
    }

    
}
