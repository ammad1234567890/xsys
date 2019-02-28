<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\WarehouseStock;
use App\WarehouseTransfer;
use App\WarehouseStaff;
use App\Warehouse;
use App\MainWarehouseReceiveItem;
use App\WarehouseIssueNot;
use App\WarehouseIssueNotItem;
use App\WarehouseIssueNoteImei;
use Auth;
use DB;

class WarehouseTransferController extends Controller
{

	 public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
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
        $items= $request->input('items');
        $winID=$request->input('winID');
        // return $details;

        $items_sperate=[];
        $create_issue_items=[];

        $userId=Auth::user()->id;
        try{
            DB::beginTransaction();
            foreach ($details as $detail) {
                if($detail['isTrue']==True){
                    $mainWarehouseId=$detail['warehouseId'];
                    $productColorId=$detail['productColorId'];
                    $previousProductQuantity=$detail['productQuantity'];
                    $product_price=$detail['productPrice'];
                    if(WarehouseStock::where('warehouse_id',$subWarehouse)->where('product_color_id',$productColorId)->exists()){
                        $warehouseStock=WarehouseStock::where('warehouse_id',$subWarehouse)->where('product_color_id',$productColorId)->first();
                        $newQuantity=(int)$warehouseStock['product_qty']+(int)$detail['transferQty'];
                       // $warehouseStock=WarehouseStock::where('warehouse_id',$subWarehouse)->where('product_color_id',$productColorId)->update(['product_qty'=>$newQuantity]);
                    }else{
                       // WarehouseStock::create(['warehouse_id'=>$subWarehouse,'product_color_id'=>$productColorId,'product_qty'=>$detail['transferQty']]);
                        $newQuantity=$detail['transferQty'];
                    }
                    $mainStock=WarehouseStock::where('warehouse_id',$mainWarehouseId)->where('product_color_id',$productColorId)->first();
                    $remainingQuantity=(int)$mainStock['product_qty']-(int)$detail['transferQty'];
                    WarehouseStock::where('warehouse_id',$mainWarehouseId)->where('product_color_id',$productColorId)->update(['product_qty'=>$remainingQuantity]);
                    WarehouseTransfer::create([
                        'resource_id'=>$winID,
                        'product_unit_price'=>$product_price,
                        'previous_warehouse_id'=>$mainWarehouseId,
                        'product_color_id'=>$productColorId,
                        'old_product_qty'=>$previousProductQuantity,
                        'remaining_qty'=>$remainingQuantity,
                        'transfer_qty'=>$detail['transferQty'],
                        'new_warehouse_id'=>$subWarehouse,
                        'new_transfer_qty'=>$newQuantity,
                        'created_by'=>$userId]);
                }
            }
        }catch(\Exception $e){
            DB::rollback();
            $return=array('replay'=>1,'data'=>$e);
            return $return;
        }
        DB::commit();

        foreach($items as $item){
            //$item['item_id'];
            //MainWarehouseReceiveItem::where('item_id', $item['item_id'])->update(['current_stock_status'=>4]);
            array_push($items_sperate, $item['item_id']);
            $create_issue_items[]=['item_id'=> $item['item_id'], 'issue_note_id'=>$winID, 'imei'=>$item['imei']];

        }

        //return $items_sperate;
        //return $create_issue_items;
        MainWarehouseReceiveItem::whereIn('item_id', $items_sperate)->update(['current_stock_status'=>4]);
        WarehouseIssueNoteImei::insert($create_issue_items);



        WarehouseIssueNot::where('id', $winID)->update(['stock_transfer'=>1]);

        $replay=array('replay'=>0);
        return $replay;
    }

    public function transfer_requests_page(){
        return View('transfer_requests');
    }

    public function get_issue_note_details($issue_note_id){
        return WarehouseIssueNot::with('warehouse_to',
            'warehouse_from',
            'approved_by',
            'transfer_products',
            'transfer_products.product',
            'transfer_products.product_color')
            ->where('id', $issue_note_id)->get();
    }
	
	public function get_transfer_receiving(){
        $userId=Auth::user()->staff_id;
        $warehouse_details=warehouseStaff::with('warehouse')->where('staff_id',$userId)->get();
        $warehouse_id= $warehouse_details[0]['warehouse']['id'];

        return WarehouseIssueNot::Select('id', 'win_no')->where('warehouse_to', $warehouse_id)->where('stock_transfer', 1)->where('received_date', null)->get();

    }
	
	public function receive_stock_to_warehouse(Request $request){
        $win_id= $request->input('win_no');
        $win_products=WarehouseIssueNotItem::where('issue_note_id', $win_id)->get();

        $userId=Auth::user()->staff_id;
        $warehouse_details=warehouseStaff::with('warehouse')->where('staff_id',$userId)->get();
        $warehouse_id= $warehouse_details[0]['warehouse']['id'];

        $items_array=[];

        foreach($win_products as $products){

            if(WarehouseStock::where('warehouse_id',$warehouse_id)->where('product_color_id',$products['product_color_id'])->exists()){
                $warehouseStock=WarehouseStock::where('warehouse_id',$warehouse_id)->where('product_color_id',$products['product_color_id'])->first();
                $newQuantity=(int)$warehouseStock['product_qty']+(int)$products['quantity'];
                $warehouseStock=WarehouseStock::where('warehouse_id',$warehouse_id)->where('product_color_id',$products['product_color_id'])->update(['product_qty'=>$newQuantity]);
            }else{
                 WarehouseStock::create(['warehouse_id'=>$warehouse_id,'product_color_id'=>$products['product_color_id'],'product_qty'=>$products['quantity']]);
                $newQuantity=$products['quantity'];
            }

        }

        $imei_details=WarehouseIssueNoteImei::Select('item_id')->where('issue_note_id', $win_id)->get();


        foreach($imei_details as $items){
            array_push($items_array, $items['item_id']);
        }
        MainWarehouseReceiveItem::whereIn('item_id', $items_array)->update(['current_stock_status'=>1, 'warehouse_id'=>$warehouse_id]);
        WarehouseIssueNot::where('id', $win_id)->update(['received_date'=>date('Y-m-d H:i:s')]);


        return 201;

    }
	
	public function transfer_imei_print($win_id){
         $items= WarehouseIssueNot::with(

            'items',
            'items.item',
            'items.item.productColor.product',
            'items.item.imei'
            )
            ->where('id', $win_id);

        return $items->where(function($query) {
            $query->orWhereHas('items.item.productColor', function ( $q ) {
                $q->orderBy('id', 'DESC');
            });
        })->get();






         //DB::select("Select note_imei.item_id from warehouse_issue_note issue_note inner join warehouse_issue_note_imei note_imei on note_imei.issue_note_id=issue_note.id inner join  where issue_note.id=$win_id ");
    }

    
}
