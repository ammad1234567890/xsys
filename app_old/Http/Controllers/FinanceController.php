<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Retailer;
use App\RetailerOrder;
use App\RetailerOrderProduct;
use App\Notifications\send_alert;
use Response;
use App\User;



class FinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function non_approved_order(){
        return View("FinanceOrderApproval");
    }


    //route     /finance/approve_order
    public function approve_retailer_order(Request $request){
        $id=$request->input('id');
        $credit_limit=$request->input('credit_limit');
        $total_amount=$request->input('total_cost');
        $remarks=$request->input('remarks');
        $id=$request->input('id');
        $user=Auth::user()->id;
        if($total_amount>$credit_limit){
            RetailerOrder::where('id',$id)->update(['is_account_clearance'=>1, 'clearance_remarks'=>$remarks,'is_forcefully_approve'=>1 ,'updated_by'=>$user]);
            
        }
        else{
            RetailerOrder::where('id',$id)->update(['is_account_clearance'=>1, 'clearance_remarks'=>$remarks, 'updated_by'=>$user]);
            
        }

        $order_data=RetailerOrder::where('id',$id)->first();
        $finance_user= User::with('staffRecord.warehouseStaff')->where('id', Auth::user()->id)->first();

        //return print_r($finance_user['staffRecord']['warehouseStaff']);
       /* $post_data=array(
           'title'=>"Order Approved ".$order_data['order_no'],
           'description'=> "Order has been Approved By Finance Officer ".$finance_user['name'],
        );*/
       // User::find(8)->notify(new send_alert($post_data));

        return 201;

    }
}