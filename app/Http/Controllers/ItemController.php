<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Item;
use App\IMEI;
class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      return view('item');
    }

    public function allItems()
    {
      $getItem=Item::where('is_deleted',0)->with('imei')->with('productColor')->with('receiveBy')->get();
    }

    public function itemDetails($imei){
      $imei=IMEI::where('imei1',$imei)->with('item.receive.Order','item.receive.mainWarehouseReceive','item.productColor.product')->get();
      return $imei;
    }

    public function store(Request $request)
    {
      $productColorId=$request->input('product_color_id');
      $receiveId=$request->input('receive_id');
      $user=Auth::user();
      $imei1=$request->input('imei1');
      $imei2=$request->input('imei2');
      try{
        DB::beginTransaction();
          $createdItem=Item::create(['product_color_id'=>$productColor,'receive_id'=>$receiveId,'created_by'=>$user->id]);
          IMEI::where('imei',$imei1)->update(['item_id'=>$createdItem->id]);
          IMEI::where('imei',$imei2)->update(['item_id'=>$createdItem->id]);
      }catch(\Exception $e){
        DB::rollBack();
        $return=array('replay'=>1,'data'=>$e);
        return $return;
      }
      $getItem=Item::where('id',$id)->where('is_deleted',0)->with('imei')->with('productColor')->with('receiveBy')->first();
      $return=array('replay'=>0,'data'=>$getItem);
      return $return;
    }

    public function update(Request $request)
    {

    }

    public function destroy($id)
    {
      try{
        DB::beginTransaction();
        IMEI::where('item_id',$id)->update(['item_id'=>NULL]);
        Item::where('item_id',$id)->update(['is_deleted'=>1]);
      }
      catch(\Exception $e){
        $return=array('replay'=>1,'data'=>$e);
        return $return;
      }

    }

    public function detail(){
      return view('itemDetail');
    }

}
