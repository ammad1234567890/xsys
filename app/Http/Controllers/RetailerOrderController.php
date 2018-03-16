<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Retailer;
use App\City;
use App\Region;
use App\RetailerOutlet;
use App\Order;
use App\OrderProducts;
use App\Receive;
use App\ReceiveProducts;
use App\ReceiveLog;
use App\ReceiveStatus;
use App\Product;
use App\ProductColor;
use App\ProductImage;
use App\OrderPayment;
use App\OrderStatus;
use App\RetailerOrder;
use App\RetailerOrderProduct;
use App\Invoice;
use App\RetailerCollection;
use App\Ledger;
use Response;



class RetailerOrderController extends Controller
{

    //Registered a route with the name of /retailer_order/non_clear_orders
    public function get_all_non_clear_orders(){
        $records=RetailerOrder::with(
            ['order_products'=> function($q){ $q->where('is_deleted',0);},
            'order_products.ProductColor',
            'order_products.ProductColor.product',
            'order_products.ProductColor.product.productCategory',
            'retailer',
            'retailer_outlet',
            'user']
        )->where('is_account_clearance',0)->where('is_deleted',0)->get();

        return Response::json($records);
    }

    //Registered a route with the name of /retailer_order/get_orders
    public function get_all_orders(){
        $records=RetailerOrder::with(
            ['order_products'=> function($q){ $q->where('is_deleted',0);},
            'order_products.ProductColor',
            'order_products.ProductColor.product',
            'order_products.ProductColor.product.productCategory',
            'retailer',
            'retailer_outlet',
            'user','updated_user']
        )->where('is_deleted',0)->get();

        return Response::json($records);
    }

    //Registered a route with the name of /retailer_order/orders
    public function orders(){
        return View("retailer_orders");
    }

    //Registered a route with the name of /retailer_order/edit_products
    public function edit_order_products(Request $request){
        $products=$request->input('order_products');
        $delete_products=$request->input('remove_product_ids');
        $order_id= $request->input('orderno');
        $total_price=0;
        $user=Auth::user()->id;
        foreach($delete_products as $product){
            $id=$product['id'];
            RetailerOrderProduct::where('id',$id)->update(['is_deleted'=>1, 'updated_by'=>$user]);
        }
        foreach($products as $product){
            $qty=$product['product_qty'];
            $unit_price=$product['unit_price'];
            $id=$product['id'];
            $price= $qty*$unit_price;
            RetailerOrderProduct::where('id', $id)->update(['product_qty'=>$qty, 'total_price'=>$price, 'updated_by'=>$user]);
            $total_price+=$qty*$unit_price;
        }
        try {
            DB::beginTransaction();
            RetailerOrder::where('id', $order_id)->update(['total_cost' => $total_price, 'remaining_payment' => $total_price, 'updated_by' => $user]);
            DB::commit();
            return 201;
        }
        catch (\Exception $e){
            DB::rollBack();
            return $e;
        }
    }

    //Registered a route with the name of /retailer_order/delete
    public function delete_order(Request $request){
        $order_id= $request->input('id');
        try{
            RetailerOrder::where('id', $order_id)->update(['is_deleted'=>1]);
            return 201;
        }
        catch(\Exception $e){
            return $e;
        }
    }

    //Registered a route with the name of /retailer_order/payment
    public function order_payment(){
        return View('retailer_collection');
    }

    //Registered a route with the name of /retailer/get_invoices
    public function get_all_invoices(){
        $records= Invoice::with('order','order.retailer','order.retailer_outlet')->get();
        return Response::json($records);
    }
    //Registered a route with the name of /retailer/order/add_payment
    public function add_order_payment(Request $request){
        $bank_id= $request->input('bank_id');
        $invoice_id= $request->input('invoice_id');
        $payment_id= $request->input('payment_id');
        $selected_invoice_retailer_id= $request->input('selected_invoice_retailer_id');
        $currency_id=$request->input('currency_id');
        $selected_invoice_retailer_outlet_id= $request->input('selected_invoice_retailer_outlet_id');
        $cheque_no= $request->input('cheque_no');
        $amount_in_rs= $request->input('amount_in_rs');
        $deposit_slip_no= $request->input('deposit_slip_no');
       $user=Auth::user()->id;
        $remarks= $request->input('remarks');

        $OrderCollection=RetailerCollection::create(['bank_id'=>$bank_id,
            'currency_id'=>$currency_id,
            'payment_type_id'=>$payment_id,
            'retailer_id'=>$selected_invoice_retailer_id,
            'retailer_outlet_id'=>$selected_invoice_retailer_outlet_id,
            'invoice_id'=>$invoice_id,
            'cheque_number'=>$cheque_no,
            'amount'=>$amount_in_rs,
            'deposit_slip_number'=>$deposit_slip_no,
            'remarks'=>$remarks,
            'created_by'=>$user
        ]);

        $collection_id=$OrderCollection->id;

        Ledger::create([
            'invoice_id'=>$invoice_id,
            'retailer_id'=>$selected_invoice_retailer_id,
            'collection_id'=>$collection_id,
            'TransDate'=>date('Y-m-d'),
            'description'=>'Something',
            'Collection'=>$amount_in_rs,
            'Credit'=>$amount_in_rs
        ]);

    }
}

?>