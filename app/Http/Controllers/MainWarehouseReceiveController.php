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
use App\DeActiveSets;
use Illuminate\Support\Facades\Input;
use Excel;
use Session;
use App\Product;
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
      $mainWarehouseReceive=MainWarehouseReceive::with('mainWarehouseReceiveProduct','mainWarehouseReceiveProduct.productColor','mainWarehouseReceiveProduct.productColor.product')->where('receive_id',$id)->first();
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

   public function receive_consignment_items(Request $request){
      $items=$request->input('my_items');
      $userId=Auth::user()->id;
      $alocatedIMEI=array();
      $notInDB=array();

      $perfect_imeis=array();
      $imei_data=array();

      //print_r($items);
      foreach($items as $item){
        //echo $item['productColorName'];
        //echo $item['main_receive'];
        $quantity=$item['quantity'];
        $product_color_id=$item['productColor'];
        $warehouse_id= $item['warehouse_id'];
        $main_warehouse_receive_id=$item['main_receive'];
        $receive=MainWarehouseReceive::where('id',$item['main_receive'])->first();
        $receiveId=$receive['receive_id'];
        if(MainWarehouseReceiveProduct::where([['main_receive_id','=',$item['main_receive']],['product_color_id','=',$item['productColor']]])->exists()){          
         $MainWarehouseReceiveProduct=MainWarehouseReceiveProduct::where('main_receive_id',$item['main_receive'])->where('product_color_id',$item['productColor'])->first();
           $qty=$item['quantity']+(int)$MainWarehouseReceiveProduct['product_qty'];
           $MainWarehouseReceiveProduct=MainWarehouseReceiveProduct::where('main_receive_id',$item['main_receive'])->where('product_color_id',$item['productColor'])->update(['product_qty'=>$qty]); 
        }else{
          $MainWarehouseReceiveProduct=MainWarehouseReceiveProduct::create(['main_receive_id'=>$item['main_receive'],'product_color_id'=>$item['productColor'],'product_qty'=>$item['quantity'],'created_by'=>$userId]);
        }

        foreach ($item['imei'] as $imei) {
          //Item Creation
          if(IMEI::where('imei1',$imei)->exists()){
                if(IMEI::where([['imei1','=',$imei],['item_id','=',NULL]])->exists()){
                    $item=Item::create(['product_color_id'=>$product_color_id,'receive_id'=>$receiveId,'created_by'=>$userId]);

                    //IMEI
                    $imei=IMEI::where('imei1',$imei)->update(['item_id'=>$item->id]);
                    //Main warehouse receive item

                    //$imei_data[]=array('item_id'=>$item->id);

                    //$perfect_imeis[]=array('item_id'=>$item->id, 'warehouse_id'=>$warehouse_id);
                    $mainWarehouseReceiveItem=MainWarehouseReceiveItem::create(['item_id'=>$item->id,'warehouse_id'=>$warehouse_id]);
                }else{
                  array_push($alocatedIMEI,$imei);
                  $quantity=$quantity-1;
                  $return=array('replay'=>2,'data'=>$imei." IMEI is allocated to another Item", 'imei'=>$imei);
                  DB::rollBack();
                  return $return;
                }
          }else{
            array_push($notInDB,$imei);
            $quantity=$quantity-1;
            $return=array('replay'=>2,'data'=>$imei." IMEI is not found in Database", 'imei'=>$imei);
            DB::rollBack();
            return $return;
          }
        }
        //return $perfect_imeis;
          //MainWarehouseReceiveItem::insert($perfect_imeis);

        if(WarehouseStock::where([['warehouse_id',$warehouse_id],['product_color_id',$product_color_id]])->exists()){
            $warehouseStock=WarehouseStock::where([['warehouse_id',$warehouse_id],['product_color_id',$product_color_id]])->first();
            $warehouseStockQuantity=$warehouseStock['product_qty'];
            $NewQuantity=$quantity+(int)$warehouseStockQuantity;
            //return $productColor['id'];
            WarehouseStock::where([['warehouse_id','=',$warehouse_id],['product_color_id','=',$product_color_id]])->update(['product_qty'=>$NewQuantity]);
            //WarehouseStock::where('id',$warehouseStock['id'])->update(['product_qty'=>$NewQuantity]);
        }else{
            WarehouseStock::create(['warehouse_id'=>$warehouse_id,'product_color_id'=>$product_color_id,'product_qty'=>$quantity]);
        }

        MainWarehouseReceive::where('id',$main_warehouse_receive_id)->update(['is_received'=>1]);
      }



      return 201;
   }


   public function get_main_warehouse_receive_by_id($id){
      return MainWarehouseReceive::with('receive.ReceiveProducts','receive.ReceiveProducts.ProductColor','receive.ReceiveProducts.ProductColor.product','receive','receive.order','Warehouse','mainWarehouseReceiveProduct')->where('id', $id)->get();
   }


   public function consignment_receive_products_page($main_receive_id){
      return View('ConsignmentItemEntry');
   }


   public function product_uploading_with_imies_view(){
       $products=Product::where('is_deleted',0)->get();
       return view('upload_item',array('products'=>$products));
   }

   public function upload_items_in_excel(Request $request){
        $userId=Auth::user()->id;

        $productId=$request->input('product');
        $receive_id=111;


        if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();

            if(!empty($data) && $data->count()){
                MainWarehouseReceive::create(['created_by'=>$userId, 'receive_id'=>$receive_id]);
                //Receive::where('id', $receive_id)->update(['receive_status_id'=>2]);

                $is_uploaded=0;
                $count=0;
                foreach ($data as $key => $value) {
                    if(IMEI::where('imei1','=',$value->imei1)->exists() || IMEI::where('imei2','=',$value->imei2)->exists()){
                        $is_uploaded=1;

                        //echo $value->imei1.'<br/>';
                        //$count++;
                       // break;
                        //return back();

                    }
                }
                //return $count;
                //Session::flash('import_error_message', $is_uploaded);
                if($is_uploaded==0){
                    foreach ($data as $key => $value) {
                        if($value->color!=null){
                            $insert=[];
                            //Items Entry
                            $item=['product_color_id'=>$value->color, 'receive_id'=>$receive_id, 'created_by'=>$userId];

                            $latest_item=Item::create($item);
                            $latest_item_id=$latest_item->id;

                            $warehouse_receive_items=['warehouse_id'=>3,'item_id'=>$latest_item_id];
                            MainWarehouseReceiveItem::create($warehouse_receive_items);

                            //Imei Entry
                            $insert[] = ['item_id'=>$latest_item_id ,'imei1' => $value->imei1,'imei2'=>$value->imei2,'product_id'=>$productId,'created_by'=>$userId];
                            DB::table('tbl_imei')->insert($insert);
                        }
                        else{
                            return "New Items has been Uploaded Successfully";
                        }
                    }
                   /* if(!empty($insert)){
                        // DB::table('tbl_imei')->insert($insert);
                        //  Session::flash('import_success_message', 'Imeis has been successfully imported!');
                        //dd('Insert Record successfully.');
                    } */
                }
                else{
                    Session::flash('import_error_message', "Duplicate Imeis Found");
                }
            }

        return back();
    }
  }



   public function receive_stock_view(){
       return view('ReceiveStock');
   }

   public function submit_consignment_imeis(Request $request){
        $items= $request->input('imeis');
        $warehouse_id= $request->input('warehouse_id');

        $perfect_imeis=array();
        $warehouse_id_array=array();
        $error_imeis=array();

        $is_error_found=0;
	   
	   $already_item_array=array();
        foreach($items as $item){
            $imei_no= $item['imei'];
            if(IMEI::where('imei1', $imei_no)->orWhere('imei2', $imei_no)->exists()){
                $imei_more_details=IMEI::where('imei1', '=', $imei_no)->orWhere('imei2','=', $imei_no)->first();
                $item_id= $imei_more_details['item_id'];
				
				if($already_item_array!=null){
					foreach($already_item_array as $item_arr){
						if($item_id==$item_arr){
							$is_error_found=1;
							$error_imeis[]=['is_error'=>1, 'imei'=>$imei_no, 'error_text'=> 'Item Scanned Already'];
						}
						else{
							if(MainWarehouseReceiveItem::where('warehouse_id', null)->where('item_id', $item_id)->exists()){
								//$perfect_imeim_s[]=['item_id'=> $item_id];
								array_push($already_item_array, $item_id);
								array_push($perfect_imeis, $item_id);
								//array_push($warehouse_id_array, $warehouse_id);
							   // $warehouse_id_array[]=['warehouse_id'=>$warehouse_id];
							}
							else{
								$is_error_found=1;
								$error_imeis[]=['is_error'=>1, 'imei'=>$imei_no, 'error_text'=> 'Item Already Received'];
							}
						}
					}
				}
				else{
					if(MainWarehouseReceiveItem::where('warehouse_id', null)->where('item_id', $item_id)->exists()){
								//$perfect_imeim_s[]=['item_id'=> $item_id];
								array_push($already_item_array, $item_id);
								array_push($perfect_imeis, $item_id);
								//array_push($warehouse_id_array, $warehouse_id);
							   // $warehouse_id_array[]=['warehouse_id'=>$warehouse_id];
							}
							else{
								$is_error_found=1;
								$error_imeis[]=['is_error'=>1, 'imei'=>$imei_no, 'error_text'=> 'Item Already Received'];
							}
				}
				
                
            }
            else {
                $is_error_found=1;
                $error_imeis[]=['is_error'=>1, 'imei'=>$imei_no, 'error_text'=> 'Item Not Exist'];
            }
        }

        if($is_error_found==1){
            return ['error_found'=>1, 'details'=>$error_imeis];
        }
        else{
           // return $perfect_imeis;
            //MainWarehouseReceiveItem::whereIn('item_id', $perfect_imeis)->update(['warehouse_id'=>$warehouse_id]);

            $item_data=Item::whereIn('id', $perfect_imeis)->get();


            $stock_array=array();

            $product_color_id= $item_data[0]['product_color_id'];
            $stock_count=0;


            $loop_count=0;

            foreach($item_data as $item){
                $loop_count++;

                if($item['product_color_id']==$product_color_id){
                    $stock_count=$stock_count+1;

                    if($loop_count==count($item_data)){
                        $stock_array[]=['warehouse_id'=> $warehouse_id,'product_color_id'=>$product_color_id, 'product_qty'=>$stock_count];
                        $product_color_id=$item['product_color_id'];
                        $stock_count=0;
                    }
                }
                else{
                    $stock_array[]=['warehouse_id'=> $warehouse_id,'product_color_id'=>$product_color_id, 'product_qty'=>$stock_count];
                    $product_color_id=$item['product_color_id'];
                    $stock_count=1;
                }
            }

            foreach($stock_array as $stock_d){
                if(WarehouseStock::where([['warehouse_id',$stock_d['warehouse_id']],['product_color_id',$stock_d['product_color_id']]])->exists()){
                    $warehouseStock=WarehouseStock::where([['warehouse_id',$stock_d['warehouse_id']],['product_color_id',$stock_d['product_color_id']]])->first();
                    $warehouseStockQuantity=$warehouseStock['product_qty'];
                    $NewQuantity=$stock_d['product_qty']+(int)$warehouseStockQuantity;
                    //return $productColor['id'];
                    WarehouseStock::where([['warehouse_id','=',$warehouse_id],['product_color_id','=',$stock_d['product_color_id']]])->update(['product_qty'=>$NewQuantity]);
                    //WarehouseStock::where('id',$warehouseStock['id'])->update(['product_qty'=>$NewQuantity]);
                }else{
                    WarehouseStock::create(['warehouse_id'=>$warehouse_id,'product_color_id'=>$stock_d['product_color_id'],'product_qty'=>$stock_d['product_qty']]);
                }
            }
            MainWarehouseReceiveItem::whereIn('item_id', $perfect_imeis)->update(['warehouse_id'=>$warehouse_id]);

            //WarehouseStock::create($stock_array);


          //  return $stock_array;
          //  return $item_data;
            return ['error_found'=>0];
        }
   }
	
	public function deactivate_imei(Request $request){
       $imei_no=$request->input("imei");
       $userId=Auth::user()->id;
       if(IMEI::where('imei1', $imei_no)->orWhere('imei2', $imei_no)->exists()){
           $imei_details=IMEI::where('imei1', '=', $imei_no)->orWhere('imei2','=', $imei_no)->first();
           $item_id=$imei_details['item_id'];
           if(MainWarehouseReceiveItem::where("item_id", $item_id)->where('item_is_activate', 1)->exists()){
               $main_receive_item=MainWarehouseReceiveItem::where("item_id", $item_id)->where('item_is_activate', 1)->first();
               $activated_date=$main_receive_item['activated_date'];

               DeActiveSets::create(['item_id'=>$item_id, 'activate_on'=>$activated_date,'created_by'=>$userId]);
               MainWarehouseReceiveItem::where("item_id", $item_id)->update(["item_is_activate"=>0, "activated_date"=>null]);


               Session::flash('deactivate_success_message', 'Successfully Deactivated');

           }
           else{
               Session::flash('deactivate_error_message', "Already De-Activated");
           }


       }
       else{
           Session::flash('deactivate_error_message', "Invalid IMEI Number");
       }

       return back();

   }
}
