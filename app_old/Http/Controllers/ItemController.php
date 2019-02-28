<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\StockStatusHistory;
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

 public function itemDetails($imei) {
        $imei = IMEI::where('imei1', $imei)->orWhere('imei2', $imei)->with('item.receive.Order', 'item.receive.mainWarehouseReceive.warehouse', 'item.mainWarehouseReceiveItem.warehouse', 'item.productColor.product', 'item.productColor.productImages', 'item.warehouseIssueItem')->first();
        if ($imei != null) {
            $outlet_details = DB::table('tbl_warehouse_issue_items')->where(['item_id' => $imei->id])
                    ->join('tbl_warehouse_issue', 'tbl_warehouse_issue.id', '=', 'tbl_warehouse_issue_items.warehouse_issue_id')
                    ->join('tbl_invoice', 'tbl_invoice.id', '=', 'tbl_warehouse_issue.invoice_id')
                    ->join('tbl_retailer_order', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                    ->join('tbl_retailer_outlet', 'tbl_retailer_outlet.id', '=', 'tbl_retailer_order.outlet_id')
                    ->join('tbl_city', 'tbl_city.id', '=', 'tbl_retailer_outlet.city_id')
                    ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id')
                    ->select('tbl_city.name as city_name', 'tbl_retailer_outlet.name as outlet_name', 'tbl_region.name as region_name')
                    ->first();
            if ($outlet_details != "") {
                $imei['outlet_details'] = $outlet_details;
            } else {
                $imei['outlet_details'] = "";
            }
            return $imei;
        } else {
            return 404;
        }
    }

    public function get_all_stock_type_history($item_id){
      return StockStatusHistory::where('item_id', $item_id)->with('warehouse')->get();
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
