<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Retailer;
use App\RetailerOrder;
use App\RetailerOrderProduct;
use Response;



class FinanceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            return 201;
        }
        else{
            RetailerOrder::where('id',$id)->update(['is_account_clearance'=>1, 'clearance_remarks'=>$remarks, 'updated_by'=>$user]);
            return 201;
        }


    }
}