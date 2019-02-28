<?php

namespace App\Http\Controllers;

use Auth;
use App\WarehouseStaff;
use App\WarehouseIssue;
use App\WarehouseIssueItem;
use App\Warehouse;
use App\Invoice;
use App\IMEI;
use App\WarehouseStock;
use App\Item;
use App\InvoiceReverseItems;
use App\MainWarehouseReceiveItem;
use App\WarehouseIssueNot;
use App\WarehouseIssueNotItem;
use App\User;
use App\Notifications\transfer_request;
use DB;

use Illuminate\Http\Request;
use Illuminate\View\View;

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

  public function issue_note_create(){
    return View('issue_note_form');
  }

  public function display_issue_note(){
      return View('display_issue_note');
  }

  public function get_all_issue_notes(){
      return WarehouseIssueNot::with('warehouse_to', 'warehouse_from', 'approved_by','transfer_products', 'transfer_products.product', 'transfer_products.product_color')->get();

  }

    public function get_all_non_approved_issue_notes_of_warehouse($warehouse_id){
        return WarehouseIssueNot::with('warehouse_to', 'warehouse_from', 'approved_by','transfer_products', 'transfer_products.product', 'transfer_products.product_color')->where('warehouse_from', $warehouse_id)->orWhere('warehouse_to',$warehouse_id)->get();

    }

  public function non_approved_issue_page(){
      return View('IssueNoteApproval');
  }

  public function approve_issue_note(Request $request){
      $id= $request->input('id');
      $userId=Auth::user()->id;
      WarehouseIssueNot::where('id', $id)->update(['is_approved'=>1, 'approved_by'=>$userId]);
      return 201;
  }

  public function get_all_request_by_warehouse($warehouse_id){
    return WarehouseIssueNot::with('warehouse_to', 'warehouse_from', 'approved_by','transfer_products', 'transfer_products.product', 'transfer_products.product_color')->where('warehouse_from', $warehouse_id)->where('is_approved', 1)->where('stock_transfer',0)->get();
  }

  public function create_issue_note(Request $request){
      $warehouse_from=$request->input("from");
      $warehouse_to=$request->input("to");
      $products= $request->input('product_list');
      $issue_not_products=array();

      $return_message="";
      $out_of_stock_detected=0;

      foreach($products as $product) {
          $pro_id=$product['productColorId'];
          $issue_notes = DB::Select("Select sum(note_items.quantity) as sum_quantity from warehouse_issue_note note
          inner join warehouse_issue_note_items note_items on note_items.issue_note_id=note.id
          where note.warehouse_from='$warehouse_from' AND note.stock_transfer=0 AND note_items.product_color_id='$pro_id'");


          $final_qty= ((int)$issue_notes[0]->sum_quantity)+((int)$product['transferQty']);
          if($final_qty>$product['productQuantity']){
              $out_of_stock_detected=0;
              $out_of_stock_qty=(int)$final_qty-(int)$product['productQuantity'];
              $return_message.= $product['productName'].' '.$product['productColorName']." is Out of Stock Quantity: ".$out_of_stock_qty."\n";
          }
      }
    if($out_of_stock_detected==1){
        echo $return_message;
    }
    else{
        $warehouse_issue_note=WarehouseIssueNot::create(['warehouse_to'=>$warehouse_to, 'warehouse_from'=>$warehouse_from,'is_approved'=>0]);
      $issue_not_id=$warehouse_issue_note->id;
      $win_no='WIN'.$issue_not_id;
      WarehouseIssueNot::where('id',$issue_not_id)->update(['win_no'=>$win_no]);
      foreach($products as $product) {
          if($product['isTrue']==1){
              WarehouseIssueNotItem::create([
                  'issue_note_id'=>$issue_not_id,
                  'product_id'=>$product['productId'],
                  'product_color_id'=>$product['productColorId'],
                  'quantity'=>$product['transferQty'],
                  'price'=>$product['productPrice'],
              ]);
          }
      }

      $from_warehouse_details=Warehouse::with('manager')->where('id', $warehouse_from)->first();

      $from_warehouse_name= $from_warehouse_details->name;
       $post_data=array(
           'title'=>"Stock Transfer Request",
           'description'=> $from_warehouse_name." sent you the request to transfer the Stock",
       );

       /*return $from_warehouse_details->manager;
      foreach($from_warehouse_details->manager as $manager){
          //return $manager[''];
         // User::find()->notify(new transfer_request($post_data));
          //User::find(8)->notify(new transfer_request($post_data));
      }*/
      
      



       

    

        return 201;
    }






  }
  public function warehouseIssueRequest()
  {
    $staffId=Auth::user()->staff_id;
    $warehouseStaff=WarehouseStaff::where( 'staff_id',$staffId )->first();
   // $issueRequest=WarehouseIssue::where([['warehouse_id','=',$warehouseStaff->warehouse_id],['is_issued','=',False]])->get();
   // return $issueRequest;
      return DB::table('tbl_warehouse_issue')
                        ->select('tbl_warehouse_issue.id', 'tbl_warehouse_issue.created_by'
                                , 'tbl_warehouse_issue.created_at', 'tbl_warehouse_issue.invoice_id'
                                , 'tbl_warehouse_issue.invoice_no', 'tbl_warehouse_issue.is_issued'
                                , 'tbl_warehouse_issue.updated_at', 'tbl_warehouse_issue.warehouse_id')
                        ->join('tbl_invoice', 'tbl_invoice.id', '=', 'tbl_warehouse_issue.invoice_id')
                        ->where([['warehouse_id', '=', $warehouseStaff->warehouse_id], ['is_issued', '=', False]])
                        ->whereNotIn('is_invoice', [2, 3])
                        ->get();
  }

  public function getProducts($id)
  {
    $invoice_id=$id;
    $invoice=Invoice::where('id',$invoice_id)->with('order','order.retailer_outlet','invoiceProduct.productColor.product')->first();
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
      $imeiRecord=IMEI::where('imei1',$i['imei'])->first();
      $itemId=$imeiRecord['item_id'];
      $item=Item::where('id',$itemId)->first();
      $productColorId=$item['product_color_id'];

      if(WarehouseIssueItem::where('item_id',$itemId)->exists()){
        DB::rollback();
        $return=array('replay'=>2,'data'=>"Item Already issued");
        return $return;
      }else{
        WarehouseIssueItem::create(['warehouse_issue_id'=>$warehouseIssue_id,'item_id'=>$itemId,'created_by'=>$userId]);
        //return $warehouseIssue_id;
        $warehouseIssue=WarehouseIssue::where('id',$warehouseIssue_id)->first();
        //echo $warehouseIssue['is_issued'];
       // if($warehouseIssue['is_issued']){
       //   DB::rollback();
        //  $return=array('replay'=>2,'data'=>"Items are Already issued against this invoice");
       //   return $return;
       // }
        WarehouseIssue::where('id',$warehouseIssue_id)->update(['is_issued'=>1]);
        $warehouseStock=WarehouseStock::where([['product_color_id','=',$productColorId],['warehouse_id','=',$warehouseIssue['warehouse_id']]])->first();
        $qty=$warehouseStock['product_qty']-1;
        WarehouseStock::where([['product_color_id','=',$productColorId],['warehouse_id','=',$warehouseIssue['warehouse_id']]])->update(['product_qty'=>$qty]);

        $invoice_data=DB::select("Select r_order.outlet_id as outlet_id from tbl_invoice invoice inner join tbl_retailer_order r_order on invoice.order_id=r_order.id where invoice.id=$invoice_id");

        MainWarehouseReceiveItem::where('item_id',$itemId)->update(['is_sold'=>1, 'sold_to_outlet_id'=>$invoice_data[0]->outlet_id]);
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
//          $items=WarehouseIssueItem::where('warehouse_issue_id',$warehouseIssue['id'])->get();    
//          foreach ($items as $item) {
//              $data=item::where('id',$item['item_id'])->with('productColor')->first();
//              // return $warehouseIssue['warehouse_id'];
//              $stock=WarehouseStock::where([['warehouse_id','=',$warehouseIssue['warehouse_id']],['product_color_id','=',$data->productColor->id]])->first();
//            
//              $qty=$stock['product_qty'];
//              $newQty=1+(int)$stock['product_qty'];
//              WarehouseStock::where('id',$stock['id'])->update(['product_qty'=>$newQty]);
//              $issuedItems=WarehouseIssueItem::where('id',$item['id'])->first();
//              InvoiceReverseItems::create(['warehouse_issue_id'=>$issuedItems['warehouse_issue_id'],'item_id'=>$issuedItems['item_id'],'created_by'=>$userId]);
//              WarehouseIssueItem::where('id',$item['id'])->delete();
//          }
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
