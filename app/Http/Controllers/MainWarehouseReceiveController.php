<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Item;
use App\IMEI;
use App\WarehouseStaff;
use App\Warehouse;
use App\Receive;
use App\ReceiveProducts;
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
        DB::beginTransaction();
        $mainWarehouseReceive=MainWarehouseReceive::create(['warehouse_id'=>$warehouse_id,'receive_id'=>$receive['id'],'created_by'=>$userId]);
        Receive::where('id',$receive['id'])->update(['receive_status_id'=>2]);
      }
      catch(\Exception $e){
        DB::rollBack();
        $return=array('replay'=>1,'data'=>$e);
        return $return;
      }
      //$mainWarehouseReceive=MainWarehouseReceive::where('id',$mainWarehouseReceive['id'])->with('receive.receiveProducts.ProductColor.product')->with('warehouse')->first();
      DB::commit();
      $return=array('replay'=>0,'data'=>$mainWarehouseReceive);
      return $return;
   }

   public function getReceive($id){
      $mainWarehouseReceive=MainWarehouseReceive::where('receive_id',$id)->first();
      return $mainWarehouseReceive;
   }

   public function getRemainingQuantity($receiveId,$productColorId){
      $mainWarehouseReceive=MainWarehouseReceive::where('id',$receiveId)->first();
      $mainWarehouseReceiveProduct=MainWarehouseReceiveProduct::where('product_color_id',$productColorId)->where('main_receive_id',$receiveId)->first();
      $receive=ReceiveProducts::where('receive_id',$mainWarehouseReceive['receive_id'])->where('product_color_id',$productColorId)->first();
      $a=(int)$mainWarehouseReceiveProduct['product_qty'];
      $b=(int)$receive['product_qty'];
      $remainingQuantity=$b-$a;
      return $remainingQuantity;
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
     $alocatedIMEI=array();
     $notInDB=array();
      try{
      DB::beginTransaction();
          //get receiveID
        $receive=MainWarehouseReceive::where('id',$main_receive['id'])->first();
        $receiveId=$receive['receive_id'];
          //entry in main receive product
        // $return=array('replay'=>1,'data'=>$receiveId);
        // return $return;      
        if(MainWarehouseReceiveProduct::where([['main_receive_id','=',$main_receive['id']],['product_color_id','=',$productColor['id']]])->exists()){          
         $MainWarehouseReceiveProduct=MainWarehouseReceiveProduct::where('main_receive_id',$main_receive['id'])->where('product_color_id',$productColor['id'])->first();
           $qty=$quantity+(int)$MainWarehouseReceiveProduct['product_qty'];
           $MainWarehouseReceiveProduct=MainWarehouseReceiveProduct::where('main_receive_id',$main_receive['id'])->where('product_color_id',$productColor['id'])->update(['product_qty'=>$qty]); 
        }else{
          $MainWarehouseReceiveProduct=MainWarehouseReceiveProduct::create(['main_receive_id'=>$main_receive['id'],'product_color_id'=>$productColor['id'],'product_qty'=>$quantity,'created_by'=>$userId]);
        }
        
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
                  array_push($alocatedIMEI,$i);
                  $quantity=$quantity-1;
                  $return=array('replay'=>2,'data'=>$i." IMEI is alocated to another Item");
                  DB::rollBack();
                  return $return;
                }
          }else{
            array_push($notInDB,$i);
            $quantity=$quantity-1;
            // $return=array('replay'=>2,'data'=>$i." IMEI is not found in Database");
            // DB::rollBack();
            // return $return;
          }
        }
        //WarehouseStock
        if(WarehouseStock::where([['warehouse_id',$warehouse_id],['product_color_id',$productColor['id']]])->exists()){
            $warehouseStock=WarehouseStock::where([['warehouse_id',$warehouse_id],['product_color_id',$productColor['id']]])->first();
            $warehouseStockQuantity=$warehouseStock['product_qty'];
            $NewQuantity=$quantity+(int)$warehouseStockQuantity;
            //return $productColor['id'];
            WarehouseStock::where([['warehouse_id','=',$warehouse_id],['product_color_id','=',$productColor['id']]])->update(['product_qty'=>$NewQuantity]);
            //WarehouseStock::where('id',$warehouseStock['id'])->update(['product_qty'=>$NewQuantity]);
        }else{
            WarehouseStock::create(['warehouse_id'=>$warehouse_id,'product_color_id'=>$productColor['id'],'product_qty'=>$quantity]);
        }
        
        //WarehouseStock::create(['warehouse_id'=>$warehouse_id,'product_color_id'=>$productColor['id'],'product_qty'=>$quantity]);
     }catch(\Exception $e){
       $return=array('replay'=>1,'data'=>$e);
       DB::rollBack();
       return $return;
      }
      DB::commit();
      $return=array('replay'=>0,'alocated'=>$alocatedIMEI,'notInDB'=>$notInDB);
      return $return;
   }
}
