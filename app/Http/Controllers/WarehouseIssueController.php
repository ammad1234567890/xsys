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
use App\InvoiceReverseItems;
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
        
        $warehouseIssue=WarehouseIssue::where('id',$warehouseIssue_id)->first();
        if($warehouseIssue['is_issued']==1){
          DB::rollback();
          $return=array('replay'=>2,'data'=>"Items are Alrady issued against this invoice");
          return $return;
        }
        WarehouseIssue::where('id',$warehouseIssue_id)->update(['is_issued'=>1]);
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

  public function inverseIssue($invoiceId)
  {
    try{
          DB::beginTransaction();
          $warehouseIssue=WarehouseIssue::where('invoice_id',$invoiceId)->first(['id','is_issued','warehouse_id']);
          $userId=Auth::user()->id;
          if($warehouseIssue['is_issued']!=1){
            if($warehouseIssue['is_issued']==2){
                $return=array('replay'=>1,'data'=>"Items are Alrady Reversed");
                return $return;  
            }
            $return=array('replay'=>1,'data'=>"Items Are not issued against this invoice");
            return $return;
          }
          $items=WarehouseIssueItem::where('warehouse_issue_id',$warehouseIssue['id'])->get();    
          foreach ($items as $item) {
              $data=item::where('id',$item['item_id'])->with('productColor')->first();
              // return $warehouseIssue['warehouse_id'];
              $stock=WarehouseStock::where([['warehouse_id','=',$warehouseIssue['warehouse_id']],['product_color_id','=',$data->productColor->id]])->first();
            
              $qty=$stock['product_qty'];
              $newQty=1+(int)$stock['product_qty'];
              WarehouseStock::where('id',$stock['id'])->update(['product_qty'=>$newQty]);
              $issuedItems=WarehouseIssueItem::where('id',$item['id'])->first();
              InvoiceReverseItems::create(['warehouse_issue_id'=>$issuedItems['warehouse_issue_id'],'item_id'=>$issuedItems['item_id'],'created_by'=>$userId]);
              WarehouseIssueItem::where('id',$item['id'])->delete();
          }
           $warehouseIssue=WarehouseIssue::where('invoice_id',$invoiceId)->update(['is_issued'=>2]);
      }catch(\Exception $e){
           DB::rollback();
           $return=array('replay'=>2,'data'=>$e);
            return $return;
      }
           DB::commit();
      $return=array('replay'=>0);
      return $return;

  }

}
