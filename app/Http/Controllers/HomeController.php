<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Retailer;
//use App\RetailerOrder;
//use App\RetailerOrderProduct;
use App\Invoice;
use App\User;
use App\Staff;
use Response;

class HomeController extends Controller
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
    public function index()
    {
        $retailerRecords=Retailer::where('is_deleted',0)->get();
        $staffRecords= Staff::all();
        $userRecords= User::all();
        $invoiceAmount= DB::table('tbl_invoice')->sum('total_amount');//->where('user_id' '=' $id);
        $collectionAmount= DB::table('tbl_retailer_collection')->sum('amount');//->where('user_id' '=' $id);
        $itemTotalStock= DB::table('tbl_warehouse_stock')->sum('product_qty');
        $warehouseTotal= DB::table('tbl_warehouse')->count('name');
        $balance =
        $data['staff']  = $staffRecords;
        $data['retailer']= $retailerRecords;
        $data['user']= $userRecords;
        $data['invoiceAmount']= $invoiceAmount;
        $data['collectionAmount']= $collectionAmount;
        $data['itemTotalStock']= $itemTotalStock;
        $data['warehouseTotal']= $warehouseTotal;
        return view('home')->with($data);
    }

    public function test()
    {
        $userId=Auth::user()->id;
        //$user=User::where('id',$userId)->with('staff')->first();
        
        return $user;
    }

    public function demo()
    {
        return view('demo');
    }
}
