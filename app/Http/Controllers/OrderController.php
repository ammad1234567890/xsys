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
use Response;



class OrderController extends Controller
{


	//Registered a route with the name of /order/create
	public function create_order(){
		return view('order');
	}

    //Registered a route with the name of /order/create
    public function receive_order(){
        return view('receive');
    }

    //Registered a route with the name of /order/payment
    public function order_payment(){
        return view('order_payment');
    }

    //Registered a route with the name of /order/create
    public function add_new_order(Request $request){

        //INPUTS
        $estimation_date= $request->input('estimation_date');
        $order_products_arr= $request->input('products');
        $userId=Auth::user()->id;
        //Add Order
            try {
                DB::beginTransaction();
                $insert_order=Order::create(
                    ['eta'=>$estimation_date, 
                    'total_cost'=>0, 
                    'remaining_payment'=>0, 
                    'created_by'=>$userId]
                );
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                return $e;
            }
        
        $order_id= $insert_order->id;


        //Add Products
        $total_cost=0;
        foreach($order_products_arr as $order_products){
           // if($order_products['product_color_id']!=null && $order_products['quantity']!=null){
                $products=array(
                    'product_color_id'=> $order_products['product_color_id'],
                    'manufacture_order_id'=>$order_id,
                    'quantity'=>$order_products['quantity'],
                    'remaining_qty'=>$order_products['quantity'],
                    'unit_cost'=>$order_products['cost_per_set'],
                    'created_by'=>$userId
                );
                try {
                    DB::beginTransaction();
                    OrderProducts::create($products);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    return $e;
                }
                $total_cost+=($order_products['quantity'])*($order_products['cost_per_set']);
            //}
        }
        

        //Update Order Total Cost & Remaining Payment Value
        try {
            DB::beginTransaction();
            Order::where('id', $order_id)->update(['total_cost'=>$total_cost, 'remaining_payment'=>$total_cost]);
            DB::commit();
            return 201;
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
        
    }

    //Registered a route with the name of /order/get_orders
    public function get_orders(){
        $records=Order::where('transaction_closed',0)->get();
        return Response::json($records);
    }




    //Registered a route with the name of /order/get_products
    public function get_products_by_order(Request $request){
        $id= $request->input('order_id');
        $records= OrderProducts::with('ProductColor.product')->where('manufacture_order_id', $id)->where('remaining_qty','!=',0)->get();
        return Response::json($records);

        //print_r($records);
    }

    //Registered a route with the name of /order/received
    public function order_received(Request $request){
        $order_id= $request->input('order_id');
        $qa_check=$request->input('qa_check');
        $collected_person_id= $request->input('collected_id');
        $qa_description= $request->input('qa_description');
        $recieve_status=$request->input('recieve_status_id');
        $order_products=$request->input('order_products');
        $user=Auth::user()->id;

        try{
            DB::beginTransaction();
            $recieved_insert=Receive::create(['manufacturing_order_id'=>$order_id,
                'collected_by'=>$collected_person_id,
                'is_qa_pass'=>$qa_check,
                'qa_description'=>$qa_description,
                'receive_status_id'=>$recieve_status,
                'created_by'=>$user]);
            $receive_id= $recieved_insert->id;
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            return $e;
        }

        try {
            DB::beginTransaction();
            $received_log = ReceiveLog::create(['recieve_id' => $receive_id, 'recieve_status_id' => $recieve_status, 'created_by' => $user]);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            return $e;
        }

        foreach($order_products as $products){
            $product=array(
                'receive_id'=>$receive_id,
                'product_color_id'=>$products['id'],
                'product_qty'=>$products['quantity'],
                'created_by'=>$user
            );
            try{
                ReceiveProducts::create($product);
                $data=OrderProducts::Select('remaining_qty')->where('manufacture_order_id',$order_id)->where('product_color_id',$products['id'])->get();
                $remaining_qty=$data[0]['remaining_qty'];
                $final_qty=$data[0]['remaining_qty']-$products['quantity'];
                OrderProducts::where('manufacture_order_id',$order_id)->where('product_color_id',$products['id'])->update(['remaining_qty'=>$final_qty]);
            }
            catch(\Exception $e){
                DB::rollBack();
                return $e;
            }
        }

        return 201;
    }

    //Registered a route with the name of /order/add_payment
    public function add_payment(Request $request){
        $order_id=$request->input('order_id');
        $amount=$request->input('amount');
        $method_id=$request->input('method_id');
        $currency_id=$request->input('currency_id');
        $exchange_rate= $request->input('exchange_rate');

        $final_amount=($amount*$exchange_rate);
        $userId=Auth::user()->id;
        OrderPayment::create(['manufacture_order_id'=>$order_id,
            'payment_amount'=>$amount,
            'total_amount'=>$final_amount,
            'payment_type_id'=> $method_id,
            'currency_id'=>$currency_id,
            'exchange_rate'=>$exchange_rate,
            'created_by'=>    $userId
        ]);

        $records=Order::Select('remaining_payment')->get();
        $remaining_total_payment=$records[0]['remaining_payment'];
        $remaining_payment=$remaining_total_payment-$final_amount;

        if($remaining_payment==0){
            Order::where('id', $order_id)->update(['transaction_closed'=>1]);
        }
        Order::where('id', $order_id)->update(['remaining_payment'=>$remaining_payment]);

        return 201;


    }

    ///Registered a route with the name of order/get_orders_by_id
    public function get_orders_by_id(Request $request){
        $id=$request->input('order_id');
        $records=Order::where('id', $id)->get();
        return Response::json($records);
    }

}

