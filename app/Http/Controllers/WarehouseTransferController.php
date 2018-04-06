<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\WarehouseStock;
use App\WarehouseTransfer;
use App\WarehouseStaff;
use App\Warehouse;
use Auth;
use DB;

class WarehouseTransferController extends Controller
{

	 public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	return view('WarehouseTransfer');
    }

    public function warehouseProductDetails($id){
    	$warehouseData=WarehouseStock::where('warehouse_id',$id)->with('productColor.product')->get();
    	return $warehouseData;
    }

    public function allStock()
    {
    	$staffId=Auth::user()->staff_id;
     	$warehouseStaff=WarehouseStaff::where('staff_id',$staffId)->first();
     	$warehouse=Warehouse::where('id',$warehouseStaff['warehouse_id'])->first();
    	$warehouseStock=WarehouseStock::with('warehouse','productColor.product')->where('warehouse_id',$warehouse['id'])->get();
    	return $warehouseStock;
    }

    public function transferReq(Request $request)
    {
    	$subWarehouse=$request->input('subWarehouse');
    	$details=$request->input('details');    
    	// return $details;

    	$userId=Auth::user()->id;	
    	 try{
    		DB::beginTransaction();
    	foreach ($details as $detail) {
    		if($detail['isTrue']==True){    			
    			$mainWarehouseId=$detail['warehouseId'];
    			$productColorId=$detail['productColorId'];
    			$previousProductQuantity=$detail['productQuantity'];
    			if(WarehouseStock::where('warehouse_id',$subWarehouse)->where('product_color_id',$productColorId)->exists()){
    				$warehouseStock=WarehouseStock::where('warehouse_id',$subWarehouse)->where('product_color_id',$productColorId)->first();
    				$newQuantity=(int)$warehouseStock['product_qty']+(int)$detail['transferQty'];
    				$warehouseStock=WarehouseStock::where('warehouse_id',$subWarehouse)->where('product_color_id',$productColorId)->update(['product_qty'=>$newQuantity]);
    			}else{
    				WarehouseStock::create(['warehouse_id'=>$subWarehouse,'product_color_id'=>$productColorId,'product_qty'=>$detail['transferQty']]);
    				$newQuantity=$detail['transferQty'];
    			}
    			$mainStock=WarehouseStock::where('warehouse_id',$mainWarehouseId)->where('product_color_id',$productColorId)->first();
    			$remainingQuantity=(int)$mainStock['product_qty']-(int)$detail['transferQty'];
    			WarehouseStock::where('warehouse_id',$mainWarehouseId)->where('product_color_id',$productColorId)->update(['product_qty'=>$remainingQuantity]);
    			WarehouseTransfer::create(['previous_warehouse_id'=>$mainWarehouseId,'product_color_id'=>$productColorId,'old_product_qty'=>$previousProductQuantity,'remaining_qty'=>$remainingQuantity,'transfer_qty'=>$detail['transferQty'],'new_warehouse_id'=>$subWarehouse,'new_transfer_qty'=>$newQuantity,'created_by'=>$userId]);
    		}
    		}
    	}catch(\Exception $e){
    		DB::rollback();
    		$return=array('replay'=>1,'data'=>$e);
    		return $return;
    	}
    	DB::commit();
    	$replay=array('replay'=>0);
    	return $replay;
    }

    
}
