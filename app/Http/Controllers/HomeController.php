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
use App\MainWarehouseReceiveItem;
use App\WarehouseStock;
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
        //$invoiceAmount= DB::table('tbl_invoice')->sum('total_amount');//->where('user_id' '=' $id);
        $invoiceFAmount= DB::table('tbl_invoice')->whereNotIn('is_invoice', [2,3])->sum('final_amount');
		$sale_return_amount=DB::table('tbl_invoice_products_return')->sum('unit_price');
		$invoiceAmount=round($invoiceFAmount-$sale_return_amount);
		//$invoiceAmount="74,363,331";
        $collectionAmount= DB::table('tbl_retailer_collection')->where("is_reversible", 0)->sum('amount');//->where('user_id' '=' $id);
        $itemTotalStock= DB::table('tbl_warehouse_stock')->sum('product_qty');
        $warehouseTotal= DB::table('tbl_warehouse')->count('name');


        $warehouseTotalWorth= $this->get_total_warehouse_worth();


        $balance =
        $data['staff']  = $staffRecords;
        $data['retailer']= $retailerRecords;
        $data['user']= $userRecords;
        $data['invoiceAmount']= $invoiceAmount;
        $data['collectionAmount']= $collectionAmount;
        $data['itemTotalStock']= $itemTotalStock;
        $data['warehouseTotal']= $warehouseTotal;
        $data['warehouseTotalWorth']=$warehouseTotalWorth;
        return view('home')->with($data);
    }

    public function get_total_warehouse_worth(){
       $data=  DB::table('tbl_warehouse_stock as warehouse_stock')
            ->join('tbl_product_color','tbl_product_color.id','=','warehouse_stock.product_color_id')->select(DB::raw('sum(tbl_product_color.price*warehouse_stock.product_qty) AS total_worth'))->get();
        return $data[0]->total_worth;
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
