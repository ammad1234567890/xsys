<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Item;
use App\IMEI;
use App\WarehouseStaff;
use App\Warehouse;
use App\Receive;
use App\MainWarehouseReceive;
use App\MainWarehouseReceiveProduct;
use App\MainWarehouseReceiveItem;
use App\WarehouseStock;
use Illuminate\Http\Request;

class MainWarehouseReceiveController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

   public function index()
   {
     return view('mainWarehouseReceive');
   }

   public function currentWarehouse()
   {
     $staffId=Auth::user()->staff_id;
     $warehouseStaff=WarehouseStaff::where('staff_id',$staffId)->first();
     $warehouse=Warehouse::where('id',$warehouseStaff['warehouse_id'])->first();
     return $warehouse;
     //return $staffId;
   }

   public function receive($search)
   {
      $searchReceive=Receive::where('id','Like',(int)$search)->where('is_deleted',0)->get();
      return $searchReceive;
   }
   public function store(Request $request)
   {
      $warehouse_id=$request->input('warehouse_id');
      $receive=$request->input('receive');
      $userId=Auth::user()->id;
      try{
        $mainWarehouseReceive=MainWarehouseReceive::create(['warehouse_id'=>$warehouse_id,'receive_id'=>$receive['id'],'created_by'=>$userId]);
      }
      catch(\Exception $e){
        $return=array('replay'=>1,'data'=>$e);
        return $return;
      }
      //$mainWarehouseReceive=MainWarehouseReceive::where('id',$mainWarehouseReceive['id'])->with('receive.receiveProducts.ProductColor.product')->with('warehouse')->first();
      $return=array('replay'=>0,'data'=>$mainWarehouseReceive);
      return $return;
   }

   public function lastWarehouseReceive()
   {
     $currentWarehouse=$this->currentWarehouse();
     $lastReceive=MainWarehouseReceive::where('warehouse_id',$currentWarehouse['id'])->orderBy('id', 'desc')->first();
     if($lastReceive===null){
        $return=array('replay'=>1);
        return $return;
     }else{
       $return=array('replay'=>0,'data'=>$lastReceive);
       return $return;
     }
   }

   public function createReceiveItems(Request $request)
   {
     $productColor=$request->input('productColor');
     $main_receive=$request->input('main_receive');
     $imei=$request->input('imei');
     $quantity=$request->input('quantity');
     $warehouse_id=$request->input('warehouse_id');
     $userId=Auth::user()->id;

     try{
       DB::beginTransaction();
          //get receiveID
        $receive=MainWarehouseReceive::where('id',$main_receive['id'])->first();
        $receiveId=$receive['receive_id'];
          //entry in main receive product
        // $return=array('replay'=>1,'data'=>$receiveId);
        // return $return;
        $MainWarehouseReceiveProduct=MainWarehouseReceiveProduct::create(['main_receive_id'=>$main_receive['id'],'product_color_id'=>$productColor['id'],'product_qty'=>$quantity,'created_by'=>$userId]);
        foreach ($imei as $i) {
          //Item Creation
          if(IMEI::where('imei1',$i)->exists()){
                if(IMEI::where([['imei1','=',$i],['item_id','=',NULL]])->exists()){
                  $item=Item::create(['product_color_id'=>$productColor['id'],'receive_id'=>$receiveId,'created_by'=>$userId]);
                  //IMEI
                  $imei=IMEI::where('imei1',$i)->update(['item_id'=>$item->id]);
                  //Main warehouse receive item
                  $mainWarehouseReceiveItem=MainWarehouseReceiveItem::create(['item_id'=>$item->id,'warehouse_id'=>$warehouse_id]);
                }else{
                  $return=array('replay'=>2,'data'=>$i." IMEI is alocated to another Item");
                  DB::rollBack();
                  return $return;
                }
          }else{
            $return=array('replay'=>2,'data'=>$i." IMEI is not found in Database");
            DB::rollBack();
            return $return;
          }

        }
        WarehouseStock::create(['warehouse_id'=>$warehouse_id,'product_color_id'=>$productColor['id'],'product_qty'=>$quantity]);
     }catch(\Exception $e){
       $return=array('replay'=>1,'data'=>$e);
       return $return;
      }
      DB::commit();
      $return=array('replay'=>0);
      return $return;
   }
}
