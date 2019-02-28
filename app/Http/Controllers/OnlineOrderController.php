<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OnlineOrder;
use App\OnlineOrderProduct;
use DB;

class OnlineOrderController extends Controller {

    public function orders() {
        $data = OnlineOrder::where(['is_deleted' => 1])->orderBy('id', 'desc')->get();
        return ['status' => true, 'data' => $data];
    }

    public function order_list() {
        return view("online_order_list");
    }

    public function order_details($id) {
        $data = DB::table('tbl_customer_orders')
                ->join('tbl_customer_order_products', 'tbl_customer_order_products.order_id', '=', 'tbl_customer_orders.id')
                ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_customer_order_products.product_color_id')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_customer_order_products.product_id')
                ->where(['tbl_customer_orders.id' => $id])
                ->select('tbl_customer_orders.order_no', 'tbl_customer_orders.fullname', 'tbl_customer_orders.status'
                        , 'tbl_customer_orders.phone', 'tbl_customer_orders.email', 'tbl_customer_orders.address'
                     ,'tbl_customer_orders.id'
                        , 'tbl_customer_orders.created_at', 'tbl_customer_order_products.qty'
                        , 'tbl_customer_order_products.price', 'tbl_product_color.color', 'tbl_product.name')
                ->get();
        return ['status' => true, 'data' => $data];
    }
    
    public function status_update(Request $request){
        OnlineOrder::where(['id' => $request->order_id])->update(['status' => $request->status_id]);
        return ['status'=>true];
    }

}
