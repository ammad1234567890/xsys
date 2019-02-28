<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DealerAuth;
use App\Retailer;
use App\RetailerOutlet;
use App\MainWarehouseReceiveItem;
use App\Ledger;
use Validator;
use Auth;
use Hash;
use DB;


class ImeiActivationController extends Controller
{
    public $successStatus = 200;

		      public function __construct() {
        $this->retailerOutlet = new RetailerOutlet();
    }
	
    public function activate_imei(Request $request){
        $item_id= $request->input('item_id');
        $dealer_Response= $request->input('dealer_response');

        if($dealer_Response==1){
            MainWarehouseReceiveItem::where('item_id', $item_id)->update(['item_is_activate'=>1, 'activated_date'=> date('Y-m-d H:i:s')]);
            $response=array(
                'status'=>1,
                'status_code'=>200,
                'message'=>'Imei has been Activated',
                'data'=>[],
            );

            return response()->json($response);
        }
        else{
            $response=array(
                'status'=>1,
                'status_code'=>406,
                'message'=>'Cancel',
                'data'=>[],
            );

            return response()->json($response);
        }

    }
	    public function get_dealer_activations(Request $request) {
        return ['activations' => $this->retailerOutlet->dealer_activations($dealer_id = $request->dealer_id)];
    }
	    public function get_dealer_shelf(Request $request) {
        $count = 0;
        $product = null;
        $data = [];
        $index = 0;
        $product_index = -1;
        $query = $this->retailerOutlet->get_dealer_shelf($dealer_id = $request->dealer_id);

        for ($i = 0; $i < sizeof($query); $i++) {
            if ($count == 0) {
                $product = $query[$i]->model;
                $data[++$product_index]['model'] = $query[$i]->model;
                $count++;
            }
            if ($product == $query[$i]->model) {
                $data[$product_index]['items'][$index]['color'] = $query[$i]->color;
                $data[$product_index]['items'][$index]['imei1'] = $query[$i]->imei1;
                $data[$product_index]['items'][$index]['imei2'] = $query[$i]->imei2;
                $index++;
            } else {
                --$i;
                $count = 0;
                $index = 0;
            }
        }
        return ['shelf' => $data];
    }
	 
}
