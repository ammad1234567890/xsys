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
use App\Http\Controllers\API\MessageController;

class outletController extends Controller {

    public function __construct() {
        //$this->middleware('auth:api');
        $this->outlet = new RetailerOutlet();
        $this->ledger = new Ledger();
    }

    public function dealer_dashboard(Request $request) {
        $retailer_id = $request->dealer_id;
        $data = $this->outlet->dealer_dashboard($retailer_id);
        return ['status' => 1, 'status_code' => 200, 'data' => $data];
    }

    public function get_dealer_ledger(Request $request) {
        $outlet_id = RetailerOutlet::where(['retailer_id' => $request->dealer_id])->select('id')->first();
        $data = $this->ledger->dealer_ledger($outlet_id->id);
        return ['status' => 1, 'status_code' => 200, 'data' => $data];
    }

}
