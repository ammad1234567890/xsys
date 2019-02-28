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
use App\IMEI;
use App\StockStatusHistory;
use Auth;
use DB;

class ChangeStockTypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function change_stock_view(){
        return View('change_stock_type');

    }

   /* public function change_stock_type(Request $request){
        $imeis= $request->input('imeis');
        $change_from= $request->input('change_from');
        $change_to= $request->input('change_to');
        $warehouse_id= $request->input('warehouse_id');
        $remarks= $request->input('remarks');
        $userId=Auth::user()->id;
        $error_arr=[];

        $final_imeis=[];

        $is_any_not_exist=0;
        foreach($imeis as $i) {

                $imeiRecord = IMEI::where('imei1', $i['imei'])->first();
                if($imeiRecord!=null){
                    $itemId = $imeiRecord['item_id'];
                    if(MainWarehouseReceiveItem::where('warehouse_id', $warehouse_id)->where('current_stock_status', $change_from)->where('item_id', $itemId)->exists()){
                        array_push($final_imeis, $i['imei']);
                    }
                    else {
                        $is_any_not_exist = 1;
                        $error_arr[] = array(
                            'imei' => $i['imei'],
                            'error' => "406",
                            'error_text'=> "Imei is not available in your stock"
                        );
                    }
                }
                else{
                    $is_any_not_exist=1;
                    $error_arr[]=array(
                        'imei'=>$i['imei'],
                        'error'=>"404",
                        'error_text'=> "Invalid Imei"
                    );
                }
        }

        if($is_any_not_exist==0){
            foreach($imeis as $i) {
                $imeiRecord = IMEI::where('imei1', $i['imei'])->first();
                $itemId = $imeiRecord['item_id'];
                StockStatusHistory::create([
                    'item_id' => $itemId,
                    'warehouse_id' => $warehouse_id,
                    'old_status' => $change_from,
                    'new_status' => $change_to,
                    'created_by' => $userId,
                    'remarks' => $remarks
                ]);
                MainWarehouseReceiveItem::where('warehouse_id', $warehouse_id)->where('current_stock_status', $change_from)->where('item_id', $itemId)->update(['current_stock_status' => $change_to]);
            }
        }
        else{
            return $error_arr;
        }

        return 201;

    }*/
	public function change_stock_type(Request $request){
        $imeis= $request->input('imeis');
        $change_from= $request->input('change_from');
        $change_to= $request->input('change_to');
        $warehouse_id= $request->input('warehouse_id');
        $remarks= $request->input('remarks');
        $userId=Auth::user()->id;
        $error_arr=[];

        $final_imeis=[];

        $is_any_not_exist=0;

        $already_item_array=array();
        foreach($imeis as $i) {

                $imeiRecord = IMEI::where('imei1', $i['imei'])->orWhere('imei2', $i['imei'])->first();
                if($imeiRecord!=null){
                    $itemId = $imeiRecord['item_id'];
                    if($already_item_array!=null) {
                        foreach ($already_item_array as $item_arr) {
                            if ($itemId == $item_arr) {
                                $is_any_not_exist = 1;
                                $error_arr[] = ['error' => "406", 'imei' => $i['imei'], 'error_text' => 'Item Scanned Already'];
                            }
                            else{
                                if(MainWarehouseReceiveItem::where('warehouse_id', $warehouse_id)->where('current_stock_status', $change_from)->where('item_id', $itemId)->exists()){

                                    array_push($already_item_array, $itemId);
                                    array_push($final_imeis, $i['imei']);
                                }
                                else {
                                    $is_any_not_exist = 1;
                                    $error_arr[] = array(
                                        'imei' => $i['imei'],
                                        'error' => "406",
                                        'error_text'=> "Imei is not available in your stock"
                                    );
                                }
                            }
                        }
                    }
                    else{
                        if(MainWarehouseReceiveItem::where('warehouse_id', $warehouse_id)->where('current_stock_status', $change_from)->where('item_id', $itemId)->exists()){

                            array_push($already_item_array, $itemId);
                            array_push($final_imeis, $i['imei']);
                        }
                        else {
                            $is_any_not_exist = 1;
                            $error_arr[] = array(
                                'imei' => $i['imei'],
                                'error' => "406",
                                'error_text'=> "Imei is not available in your stock"
                            );
                        }
                    }

                }
                else{
                    $is_any_not_exist=1;
                    $error_arr[]=array(
                        'imei'=>$i['imei'],
                        'error'=>"404",
                        'error_text'=> "Invalid Imei"
                    );
                }
        }

        if($is_any_not_exist==0){
            foreach($final_imeis as $i) {
                $imeiRecord = IMEI::where('imei1', $i)->orWhere('imei2', $i)->first();
                $itemId = $imeiRecord['item_id'];
                StockStatusHistory::create([
                    'item_id' => $itemId,
                    'warehouse_id' => $warehouse_id,
                    'old_status' => $change_from,
                    'new_status' => $change_to,
                    'created_by' => $userId,
                    'remarks' => $remarks
                ]);
                MainWarehouseReceiveItem::where('warehouse_id', $warehouse_id)->where('current_stock_status', $change_from)->where('item_id', $itemId)->update(['current_stock_status' => $change_to]);
            }
        }
        else{
            return $error_arr;
        }

        return 201;

    }
}
