<?php

namespace App\Http\Controllers;

use Auth;
use App\WarehouseStaff;
use App\WarehouseIssue;
use App\WarehouseIssueItem;
use App\Invoice;
use App\IMEI;

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
    $warehouse=WarehouseStaff::where( 'staff_id',$staffId )->first();
    $issueRequest=WarehouseIssue::where([['warehouse_id','=',$warehouse->id],['is_issued','=',False]])->get();
    return $issueRequest;
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
    foreach($imei as $i) {
      $imeiRecord=IMEI::where('imei1',$i)->first();
      $itemId=$imeiRecord['item_id'];
      try{ 
      DB::beginTransaction(); 
      if(WarehouseIssueItem::where('item_id',$itemId)->exists()){
        return 2;
      }else{
        WarehouseIssueItem::create(['warehouse_issue_id'=>$warehouseIssue_id,'item_id'=>$itemId,'created_by'=>$userId]);
        WarehouseIssue::where('id',$warehouseIssue_id)->update(['is_issued'=>True]);
      }    
      }catch(\Exception $e){
        DB::rollback();
        return 1;
      }
    }
      DB::commit();
      return 0;
  }

  // public function insertItems(Request $request)
  // {
  //   $warehouseIssue=$request->input('warehouseIssue');
  //   $items=$request->input('items');
  //   $userId=Auth::User->id();
  //   foreach ($items as $item) {
  //     try{
  //     //$invoiceProduct=
  //     $warehouseIssue=WarehouseIssueItem::create('warehouse_issue_id'=>$warehouseIssue['id'],'item_id'=>$item['id'],'created_by'=>$userId);
  //     WarehouseStock
  //     }

  //   }
  //}

}
