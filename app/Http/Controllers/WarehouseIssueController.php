<?php

namespace App\Http\Controllers;

use Auth;
use App\WarehouseStaff;
use App\WarehouseIssue;
use App\WarehouseIssueItem;
use App\Invoice;
use App\IMEI;
use App\WarehouseStock;
use App\Item;
use DB;

use Illuminate\Http\Request;

class WarehouseIssueController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index()
  {
    return view('warehouseissue');
  }

  public function warehouseIssueRequest()
  {
    $staffId=Auth::user()->staff_id;
    $warehouseStaff=WarehouseStaff::where( 'staff_id',$staffId )->first();
    $issueRequest=WarehouseIssue::where([['warehouse_id','=',$warehouseStaff->warehouse_id],['is_issued','=',False]])->get();
    return $issueRequest;
    //return $warehouse;
  }

  public function getProducts($id)
  {
    $invoice_id=$id;
    $invoice=Invoice::where('id',$invoice_id)->with('invoiceProduct.productColor.product')->first();
    // $invoiceProduct=$invoice['invoice_product'];
    // foreach ($invoiceProduct as $p) {

    // }
    return $invoice;
  }

  public function createIssue(Request $request)
  {
    $invoice_id=$request->input('invoice_id');
    $imei=$request->input('imei');
    $warehouseIssue_id=$request->input('warehouseIssue_id');
    $userId=Auth::user()->id;
    DB::beginTransaction();
    foreach($imei as $i) {

      try{
      $imeiRecord=IMEI::where('imei1',$i)->first();
      $itemId=$imeiRecord['item_id'];
      $item=Item::where('id',$itemId)->first();
      $productColorId=$item['product_color_id'];

      if(WarehouseIssueItem::where('item_id',$itemId)->exists()){
        DB::rollback();
        $return=array('replay'=>2,'data'=>"Item Alrady issued");
        return $return;
      }else{
        WarehouseIssueItem::create(['warehouse_issue_id'=>$warehouseIssue_id,'item_id'=>$itemId,'created_by'=>$userId]);
        WarehouseIssue::where('id',$warehouseIssue_id)->update(['is_issued'=>True]);
        $warehouseIssue=WarehouseIssue::where('id',$warehouseIssue_id)->first();
        $warehouseStock=WarehouseStock::where([['product_color_id','=',$productColorId],['warehouse_id','=',$warehouseIssue['warehouse_id']]])->first();
        $qty=$warehouseStock['product_qty']-1;
        WarehouseStock::where([['product_color_id','=',$productColorId],['warehouse_id','=',$warehouseIssue['warehouse_id']]])->update(['product_qty'=>$qty]);
      }
      }catch(\Exception $e){
        DB::rollback();
        $return=array('replay'=>1,'data'=>$e);
        return $return;
      }
    }
      DB::commit();
      $data=WarehouseIssue::where('id',$warehouseIssue_id)->with('warehouseIssueItem.item.productColor.product','warehouseIssueItem.item.imei')->first();
      $return=array('replay'=>0,'data'=>$data);
      return $return;
  }

  public function inverseIssue()
  {
    
  }

}
