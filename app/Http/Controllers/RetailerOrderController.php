<?php

namespace App\Http\Controllers;

use App\WarehouseStaff;
use App\WarehouseStock;
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
use App\RetailerInvoice;
use App\RetailerCollection;
use App\Ledger;
use App\RetailerCollectionDS;
use DateTime;
use Response;
use App\CreditNotes;
use App\CreditNoteTypes;



class RetailerOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
    
    public function get_all_orders_warehouse_datatable_two($warehouse_id, Request $request){
        if ( $request->input('client') ) {
            return RetailerOrder::with(
            ['order_products'=> function($q){ $q->where('is_deleted',0);},
            'order_products.ProductColor',
            'sales_officer',
            'sales_officer.warehouseStaff.warehouse',
            'order_products.ProductColor.product.productCategory',
            'retailer',
            'retailer_outlet',
            'retailer_outlet.city',
            'user','updated_user']
            )->where('is_deleted',0)->where('warehouse_id', $warehouse_id)->get();
        }
        $columns = ['created_at', 'order_no', 'outlet_id', 'total_cost', 'is_account_clearance'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = RetailerOrder::with(
            ['order_products'=> function($q){ $q->where('is_deleted',0);},
            'order_products.ProductColor',
            'sales_officer',
            'sales_officer.warehouseStaff.warehouse',
            'order_products.ProductColor.product.productCategory',
            'retailer',
            'retailer_outlet',
            'retailer_outlet.city',
            'user','updated_user']
            )->where('is_deleted', 0)->where('warehouse_id', $warehouse_id)->orderBy($columns[$column], $dir);
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('order_no', 'like', '%' . $searchValue . '%')
                ->orWhere('created_at', 'like', '%' . $searchValue . '%')
                 ->orWhereHas('retailer_outlet', function ( $q ) use ($searchValue){
                    $q->Where('name' , 'like', '%' . $searchValue . '%');
                });
            });
        }
        $projects = $query->paginate($length);
        return ['data' => $projects, 'draw' => $request->input('draw')];
    }
	
	
	public function get_all_orders_warehouse_datatable($warehouse_id, Request $request){
        if ( $request->input('client') ) {
            return RetailerOrder::with(
            ['order_products'=> function($q){ $q->where('is_deleted',0);},
            'order_products.ProductColor',
            'sales_officer',
            'sales_officer.warehouseStaff.warehouse',
            'order_products.ProductColor.product.productCategory',
            'retailer',
            'retailer_outlet',
            'retailer_outlet.city',
            'user','updated_user']
            )->where('is_deleted',0)->where('warehouse_id', $warehouse_id)->get();
        }
        $columns = ['created_at', 'order_no', 'outlet_id', 'total_cost', 'is_account_clearance'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');


        $selected_state=$request->input('selected_state');
        $selected_city=$request->input('selected_city');
        $selected_filter_type= $request->input('selected_filter_type');
        $selected_sales_officer= $request->input('selected_sales_officer');
        $selected_outlet= $request->input('selected_outlet');
        $selected_product= $request->input('selected_product');
        $selected_product_color= $request->input('selected_product_color');


        $excel_export=$request->input("excel_export");
        $excel_type=$request->input("excel_type");
        $file_name=$request->input("file_name");

        $query = RetailerOrder::with(
            ['order_products'=> function($q){ $q->where('is_deleted',0);},
                'order_products.ProductColor',
                'sales_officer',
                'sales_officer.warehouseStaff.warehouse',
                'order_products.ProductColor.product.productCategory',
                'retailer',
                'retailer_outlet',
                'retailer_outlet.city',
                'user','updated_user']
        )->where('is_deleted', 0)->where('warehouse_id', $warehouse_id)->orderBy($columns[$column], $dir);

        if($selected_state!=""){
            $query->where(function($query) use ($selected_state) {
                $query->orWhereHas('retailer_outlet.city', function ( $q ) use ($selected_state) {
                    $q->Where('state_id', $selected_state);
                });
            });
        }
        if($selected_city!=""){
            $query->where(function($query) use ($selected_city) {
                $query->orWhereHas('retailer_outlet', function ( $q ) use ($selected_city) {
                    $q->Where('city_id', $selected_city);
                });
            });
        }
        if($selected_filter_type==1){
            if($selected_sales_officer!=""){
                $query->where("sales_officer_id", $selected_sales_officer);
            }
        }
        else if($selected_filter_type==2){
            if($selected_outlet!=""){
                $query->where("outlet_id", $selected_outlet);
            }
        }
        else if($selected_filter_type==3){
            if($selected_product!="" && $selected_product_color!=""){
                $query->where(function($query) use ($selected_product_color) {
                    $query->orWhereHas('order_products.ProductColor', function ( $q ) use ($selected_product_color) {
                        $q->Where('id', $selected_product_color);
                    });
                });
            }
            else if($selected_product_color=="" && $selected_product!=""){
                $query->where(function($query) use ($selected_product) {
                    $query->orWhereHas('order_products.ProductColor.product', function ( $q ) use ($selected_product) {
                        $q->Where('id', $selected_product);
                    });
                });
            }
        }




        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('order_no', 'like', '%' . $searchValue . '%')
                ->orWhere('created_at', 'like', '%' . $searchValue . '%')
                 ->orWhereHas('retailer_outlet', function ( $q ) use ($searchValue){
                    $q->Where('name' , 'like', '%' . $searchValue . '%');
                });
            });
        }
        $projects = $query->paginate($length);


        if($excel_export==1){
            if($excel_type==1){
                $total_rows=$query->count();
                $projects = $query->paginate($total_rows);
            }

            $data= $query->get();

            $data_final=array();



            for($i=0; $i<count($data); $i++){
               
                $product_text="";
                for($j=0; $j<count($data[$i]["order_products"]); $j++){
                    $data_color= $this->object_to_array($data[$i]["order_products"][$j]);
                    $product_text.=$data_color["product_color"]["product"]["name"]." ".$data_color["product_color"]["color"]." ".$data[$i]["order_products"][$j]["product_qty"]."\n";
                    
                }

                $data_final[]=[
                    "Order No"=>$data[$i]["order_no"],
                    "SalesOfficer"=>$data[$i]["sales_officer"]["name"],
                    "Dealer Code"=>$data[$i]["retailer"]["retailer_no"],
                    "Outlet Name"=> $data[$i]["retailer_outlet"]["name"],
                    "City"=>$data[$i]["retailer_outlet"]["city"]["name"],
                    "Address"=> $data[$i]["retailer_outlet"]["address"],
                    "Product Details"=>$product_text,
                    "Order Created Date"=>date("d/M/y", strtotime($data[$i]["created_at"])),
                ];
	

            }
			if($file_name==""){
                $file_name="OrderRecords";
            }
            $this->export_excel($file_name,$data_final);
        }

        return ['data' => $projects, 'draw' => $request->input('draw')];
    }

    public function export_excel($name, $data){
        return \Excel::create($name, function($excel) use ($name, $data) {


            $excel->sheet($name, function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });

        })->download("xlsx");

    }
	public function object_to_array($data) {
        return collect($data)->map(function($x) {
            return (array) $x;
        })->toArray();
    }

    //Registered a route with the name of /retailer_order/get_orders
    public function get_all_orders(){
        $records=RetailerOrder::with(
            ['order_products'=> function($q){ $q->where('is_deleted',0);},
            'order_products.ProductColor',
            'sales_officer',
            'sales_officer.warehouseStaff.warehouse',
            'order_products.ProductColor.product.productCategory',
            'retailer',
            'retailer_outlet',
            'retailer_outlet.city',
            'user','updated_user']
        )->where('is_deleted',0)->get();
        return Response::json($records);

    }

    //Registered a route with the name of /retailer_order/get_orders_with_warehouse_stock
    public function get_all_orders_with_warehouse_stock(Request $request){
        $product_color_id= $request->input('product_color_id');
        $warehouse_id= $request->input('warehouse_id');

        $records= WarehouseStock::where([['product_color_id','=',$product_color_id],['warehouse_id','=', $warehouse_id]])->get();

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
            $qty=$product['m_quantity'];
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

    public function get_all_order($id) {
//        $user_staff_id = Auth::user()->staff_id;
//        $staff_id = $warehousestaff = Warehouse_staff::where('staff_id', $user_staff_id)->first();
      
        $RetailerOrder = new RetailerOrder();
        $records['payment_type'] = $RetailerOrder->payment_type();
        $records['discount_type'] = $RetailerOrder->discount_type();
        $records['get_all_order'] = RetailerOrder::with([
                        'order_products'=>function($q){ $q->where('is_delivered',0);}, 
                'order_products.ProductColor',
                'order_products.ProductColor.product', 
                'order_products.ProductColor.product.productCategory', 
                'retailer', 'retailer_outlet', 'user',
                'retailer_outlet.city',
                  'retailer_outlet.region']
                )->where(['id' => $id])->first();
        if ($records['get_all_order']->is_approved == 0) {
            return $records;
        } else {
            return "not approve";
        }
    }
    
    public function get_all_orders_warehouse($warehouse_id){
        $records=RetailerOrder::with(
            ['order_products'=> function($q){ $q->where('is_deleted',0);},
            'order_products.ProductColor',
            'sales_officer',
            'sales_officer.warehouseStaff.warehouse',
            'order_products.ProductColor.product.productCategory',
            'retailer',
            'retailer_outlet',
            'retailer_outlet.city',
            'user','updated_user']
        )->where('is_deleted',0)->where('warehouse_id', $warehouse_id)->get();
        return Response::json($records);
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

    //Registered a route with the name of /retailer_order/payment_reversal
    public function order_payment_reversal($ds_id){
        return View('PaymentReverse');
    }

    public function order_payment_slips(){
        return View('PaymentSlips');
    }

   

    public function get_ds_details($ds_id){
        $ds=RetailerCollectionDS::with('bank', 'currency', 'payment_type', 'retailer_outlet', 'retailer')->where('id', $ds_id)->get();

        $cheques_data=RetailerCollection::where('collection_ds_id', $ds_id)->groupBy('cheque_number')->get();

        foreach($cheques_data as $cheque){
            $cheque_no=$cheque['cheque_number'];
            $invoices_data=RetailerCollection::with('invoice')->where('cheque_number', $cheque_no)->get();
            $total_amount=0;
            $reverse_found=0;
            foreach($invoices_data as $invoices){
                if($invoices['is_reversible']==1){
                    $reverse_found=1;
                }
            }
            $data_arr=null;

            if($reverse_found==0){
                foreach($invoices_data as $invoices) {
                    $data_arr[] = [
                        'collection_id' => $invoices['id'],
                        'invoice_id' => $invoices['invoice_id'],
                        'amount' => $invoices['amount'],
                        'invoice_no' => $invoices['invoice']['invoice_no']
                    ];
                    $total_amount += $invoices['amount'];
                }
            }
            $final_arr[]=array(
                'selected_for_reverse'=>false,
                'cheque_no'=>$cheque_no,
                'invoice_data'=>$data_arr,
                'total_cheque_amount'=>$total_amount
            );
            $data_arr=null;
        }

        $return=array('data'=>['DS'=>$ds, 'cheques'=>$final_arr]);
        return $return;

    }

    public function check_bounce(Request $request){
        $cheques=$request->input('cheques');
        $user=Auth::user()->id;
        $seconds_increament=1;
        foreach($cheques as $cheque){
            if($cheque['selected_for_reverse']==1){
                $cheque_no=$cheque['cheque_no'];
                foreach($cheque['invoice_data'] as $invoice_d){
                    $collection_id=$invoice_d['collection_id'];
                    $old_collection_details=RetailerCollection::where('id',$collection_id)->get();
                    if(isset($old_collection_details[0]['invoice_id'])){
                        $invoice=Invoice::where('id', $old_collection_details[0]['invoice_id'])->get();
                        $total_invoice_amount=$invoice[0]['total_amount'];
                        $actual_paid_amount=$invoice[0]['paid'];

                        $invoice_no=$invoice[0]['invoice_no'];

                        $final_amount=0;


                        $create_bounce_collection_array=array(
                            'bank_id'=>$old_collection_details[0]['bank_id'],
                            'collection_ds_id'=>$old_collection_details[0]['collection_ds_id'],
                            'currency_id'=>$old_collection_details[0]['currency_id'],
                            'payment_type_id'=>$old_collection_details[0]['payment_type_id'],
                            'retailer_id'=>$old_collection_details[0]['retailer_id'],
                            'retailer_outlet_id'=>$old_collection_details[0]['retailer_outlet_id'],
                            'invoice_id'=>$old_collection_details[0]['invoice_id'],
                            'amount'=>$old_collection_details[0]['amount'],
                            'cheque_number'=>$old_collection_details[0]['cheque_number'],
                            'deposit_slip_number'=>$old_collection_details[0]['deposit_slip_number'],
                            'is_reversible'=>1,
                            'remarks'=>"Check Bounced",
                            'created_by'=>$user
                        );
                        $startTime = date("Y-m-d H:i:s");
                        $cenvertedTime = date('Y-m-d H:i:s',strtotime($seconds_increament.' seconds',strtotime($startTime)));

                        $create_bounce_ledger_array=array(
                            'invoice_id'=>$old_collection_details[0]['invoice_id'],
                            'collection_id'=>$collection_id,
                            'retailer_id'=>$old_collection_details[0]['retailer_outlet_id'],
                            'TransDate'=>$stamp = $cenvertedTime,
                            'description'=>' Collection (DS#'.$old_collection_details[0]['deposit_slip_number'].' Invoice#'.$invoice_no.', Cheque#'.$old_collection_details[0]['cheque_number'].' Bounced)',
                            'Credit'=>$old_collection_details[0]['amount'],
                        );
                    
                        $final_amount=$actual_paid_amount-$old_collection_details[0]['amount'];

                        if($actual_paid_amount==0){
                            $old_collection_details[0]['amount'];
                            Invoice::where('id', $old_collection_details[0]['invoice_id'])->update(['paid'=>0, 'is_pay'=>0]);
                        }
                        else{
                            if($final_amount==$total_invoice_amount){
                                Invoice::where('id', $old_collection_details[0]['invoice_id'])->update(['paid'=>0, 'is_pay'=>0]);
                            }
                            else{
                                Invoice::where('id', $old_collection_details[0]['invoice_id'])->update(['paid'=>$final_amount, 'is_pay'=>2]);
                            }
                        }
                    }
                    else{
                        $create_bounce_collection_array=array(
                            'bank_id'=>$old_collection_details[0]['bank_id'],
                            'collection_ds_id'=>$old_collection_details[0]['collection_ds_id'],
                            'currency_id'=>$old_collection_details[0]['currency_id'],
                            'payment_type_id'=>$old_collection_details[0]['payment_type_id'],
                            'retailer_id'=>$old_collection_details[0]['retailer_id'],
                            'retailer_outlet_id'=>$old_collection_details[0]['retailer_outlet_id'],
                            'invoice_id'=>null,
                            'amount'=>$old_collection_details[0]['amount'],
                            'cheque_number'=>$old_collection_details[0]['cheque_number'],
                            'deposit_slip_number'=>$old_collection_details[0]['deposit_slip_number'],
                            'is_reversible'=>1,
                            'remarks'=>"Advance Payment, Check Bounced",
                            'created_by'=>$user
                        );

                        $startTime = date("Y-m-d H:i:s");
                        $cenvertedTime = date('Y-m-d H:i:s',strtotime($seconds_increament.' seconds',strtotime($startTime)));

                        $create_bounce_ledger_array=array(
                            'invoice_id'=>null,
                            'collection_id'=>$collection_id,
                            'retailer_id'=>$old_collection_details[0]['retailer_outlet_id'],
                            'TransDate'=>$stamp = $cenvertedTime,
                            'description'=>' Collection (DS#'.$old_collection_details[0]['deposit_slip_number'].', Cheque#'.$old_collection_details[0]['cheque_number'].' Advance Payment Bounced)',
                            'Credit'=>$old_collection_details[0]['amount'],
                        );

                        $outlet_data=RetailerOutlet::where('id', $old_collection_details[0]['retailer_outlet_id'])->get(['advance_amount'])->first();

            $final_advance_amount= $outlet_data['advance_amount']-$old_collection_details[0]['amount'];
            RetailerOutlet::where('id', $old_collection_details[0]['retailer_outlet_id'])->update(['advance_amount'=>$final_advance_amount]);
                    }
                    
                    

                    RetailerCollection::create($create_bounce_collection_array);

                    Ledger::create($create_bounce_ledger_array);

                    $seconds_increament+=8;
                }
            }

        }

        return 201;

    }

    //Registered a route with the name of /retailer/get_invoices
    public function get_all_invoices(){
        $records= RetailerInvoice::with('RetailerOrder.retailer','RetailerOrder.retailer_outlet')->get();
        return Response::json($records);
    }
    //Registered a route with the name of /retailer/order/add_payment
    public function add_order_payment(Request $request){
        $bank_id= $request->input('bank_id');
        $payment_id= $request->input('payment_id');
        $currency_id=$request->input('currency_id');
        $selected_invoice_retailer_outlet_id= $request->input('retailer_outlet_id');
        $sales_officer_id= $request->input('sales_officer_id');
        $amount_in_rs= $request->input('amount_in_rs');
        $deposit_slip_no= $request->input('deposit_slip_no');
        $user=Auth::user()->id;
        $remarks= $request->input('remarks');

        $advance_cheque_no=$request->input('advance_cheque_no');
        $advance_amount= $request->input('advance_amount');

        $invoices= $request->input('invoices');

        $selected_retailer_query= RetailerOutlet::where('id', $selected_invoice_retailer_outlet_id)->get();
        $retailer_id=$selected_retailer_query[0]['retailer_id'];

        $recent_created=RetailerCollectionDS::create([
            'deposit_slip_number'=>$deposit_slip_no,
            'total_amount'=>$amount_in_rs,
            'bank_id'=>$bank_id,
            'currenct_id'=>$currency_id,
            'payment_type_id'=>$payment_id,
            'retailer_id'=>$retailer_id,
            'retailer_outlet_id'=>$selected_invoice_retailer_outlet_id,
        ]);

        $ds_id=$recent_created->id;

        $seconds_increament=1;
        foreach($invoices as $invoice){

            if($invoice['given_amount']!=0){
                $OrderCollection=RetailerCollection::create(['bank_id'=>$bank_id,
                    'currency_id'=>$currency_id,
                    'collection_ds_id'=>$ds_id,
                    'payment_type_id'=>$payment_id,
                    'retailer_id'=>$retailer_id,
                    'retailer_outlet_id'=>$selected_invoice_retailer_outlet_id,
                    'invoice_id'=>$invoice['invoice_id'],
                    'cheque_number'=>$invoice['cheque_no'],
                    'amount'=>$invoice['given_amount'],
                    'deposit_slip_number'=>$deposit_slip_no,
                    'remarks'=>$remarks,
                    'created_by'=>$user
                ]);
                $payment_type_format='';
                if($payment_id==3){
                    $payment_type_format='Cheque#'.$invoice['cheque_no'];
                }
                else if($payment_id==1){
                    $payment_type_format='Cash';
                }
                $collection_id=$OrderCollection->id;

                $startTime = date("Y-m-d H:i:s");
                $cenvertedTime = date('Y-m-d H:i:s',strtotime($seconds_increament.' seconds',strtotime($startTime)));
                Ledger::create([
                    'retailer_id'=>$selected_invoice_retailer_outlet_id,
                    'collection_id'=>$collection_id,
                    'invoice_id'=>$invoice['invoice_id'],
                    'TransDate'=>$cenvertedTime,
                    'description'=>' Collection (DS#'.$deposit_slip_no.' '.$invoice['invoice_no'].' '.$payment_type_format.')',
                    'Collection'=>$invoice['given_amount'],
                    'Credit'=>null
                ]);
                $amount_in_r=$invoice['given_amount'];
                $invoice_id=$invoice['invoice_id'];
                $db=DB::select("SELECT * FROM `tbl_invoice` where id=$invoice_id");
                if($db[0]->is_pay==2){
                    $final_amt=($db[0]->paid-$amount_in_r);

                    $t_amt=($db[0]->total_amount)-($db[0]->paid+$amount_in_r);
                    $final_rup=($db[0]->paid)+($amount_in_r);
                    if($t_amt==0){
                        Invoice::where('id', $invoice_id)->update(['is_pay'=>1, 'paid'=>0]);
                    }
                    else{
                        Invoice::where('id', $invoice_id)->update(['paid'=>$final_rup]);
                    }
                }
                else{
                    $final_amt=($db[0]->total_amount-$amount_in_r);
                    if($final_amt==0) {
                        Invoice::where('id', $invoice_id)->update(['is_pay'=>1]);
                    }
                    else{
                        Invoice::where('id', $invoice_id)->update(['is_pay'=>2,'paid'=>$amount_in_r]);
                    }
                }
            }
            $seconds_increament+=8;

        }

        if($advance_amount!=0){
            $advance_payment_type_format='';
            if($payment_id==3){
                $advance_payment_type_format='Cheque#'.$advance_cheque_no;
            }
            else if($payment_id==1){
                $advance_payment_type_format='Cash';
            }
            $OrderCollection=RetailerCollection::create([
                'bank_id'=>$bank_id,
                'currency_id'=>$currency_id,
                'collection_ds_id'=>$ds_id,
                'payment_type_id'=>$payment_id,
                'retailer_id'=>$retailer_id,
                'retailer_outlet_id'=>$selected_invoice_retailer_outlet_id,
                'invoice_id'=>null,
                'cheque_number'=>$advance_cheque_no,
                'amount'=>$advance_amount,
                'deposit_slip_number'=>$deposit_slip_no,
                'remarks'=>$remarks,
                'created_by'=>$user
            ]);
            $collection_id=$OrderCollection->id;
            Ledger::create([
            'retailer_id'=>$selected_invoice_retailer_outlet_id,
            'collection_id'=>$collection_id,
            'invoice_id'=>null,
            'TransDate'=>date("Y-m-d H:i:s"),
            'description'=>' Collection (DS#'.$deposit_slip_no.' '.$advance_payment_type_format.') Advance Payment',
            'Collection'=>$advance_amount,
            'Credit'=>null
            ]);

            $outlet_data=RetailerOutlet::where('id', $selected_invoice_retailer_outlet_id)->get(['advance_amount'])->first();

            $final_advance_amount= $outlet_data['advance_amount']+$advance_amount;
            RetailerOutlet::where('id', $selected_invoice_retailer_outlet_id)->update(['advance_amount'=>$final_advance_amount]);
        }

        
        

        return 201;

    }
    //Registered a route with the name of /retailer/order/add_advance_payment
    public function add_advance_payment(Request $request){


        $currency_id=$request->input('currency_id');
        $selected_invoice_retailer_outlet_id= $request->input('retailer_outlet_id');
        $sales_officer_id= $request->input('sales_officer_id');
        $amount_in_rs= $request->input('amount_in_rs');

        $user=Auth::user()->id;
        $remarks= "Deduction from Advance Amount ".$request->input('remarks');

        $invoices= $request->input('invoices');

        $selected_retailer_query= RetailerOutlet::where('id', $selected_invoice_retailer_outlet_id)->get();
        $retailer_id=$selected_retailer_query[0]['retailer_id'];

        $ds_id=NULL;
        $payment_id=1;
        $deposit_slip_no=NULL;
        $bank_id=NULL;





        $seconds_increament=1;
        foreach($invoices as $invoice){

            if($invoice['given_amount']!=0){
                $OrderCollection=RetailerCollection::create(['bank_id'=>$bank_id,
                    'currency_id'=>$currency_id,
                    'collection_ds_id'=>$ds_id,
                    'payment_type_id'=>$payment_id,
                    'retailer_id'=>$retailer_id,
                    'retailer_outlet_id'=>$selected_invoice_retailer_outlet_id,
                    'invoice_id'=>$invoice['invoice_id'],
                    'cheque_number'=>$invoice['cheque_no'],
                    'amount'=>$invoice['given_amount'],
                    'deposit_slip_number'=>$deposit_slip_no,
                    'remarks'=>$remarks,
                    'created_by'=>$user
                ]);
                $payment_type_format='';
                if($payment_id==3){
                    $payment_type_format='Cheque#'.$invoice['cheque_no'];
                }
                else if($payment_id==1){
                    $payment_type_format='Cash';
                }
                $collection_id=$OrderCollection->id;

                $startTime = date("Y-m-d H:i:s");
                $cenvertedTime = date('Y-m-d H:i:s',strtotime($seconds_increament.' seconds',strtotime($startTime)));
                Ledger::create([
                    'retailer_id'=>$selected_invoice_retailer_outlet_id,
                    'collection_id'=>$collection_id,
                    'invoice_id'=>$invoice['invoice_id'],
                    'TransDate'=>$cenvertedTime,
                    'description'=>' Collection (Deduction from Advance '.$invoice['invoice_no'].')',
                    'Collection'=>$invoice['given_amount'],
                    'Credit'=>null
                ]);
                $amount_in_r=$invoice['given_amount'];
                $invoice_id=$invoice['invoice_id'];
                $db=DB::select("SELECT * FROM `tbl_invoice` where id=$invoice_id");
                if($db[0]->is_pay==2){
                    $final_amt=($db[0]->paid-$amount_in_r);

                    $t_amt=($db[0]->total_amount)-($db[0]->paid+$amount_in_r);
                    $final_rup=($db[0]->paid)+($amount_in_r);
                    if($t_amt==0){
                        Invoice::where('id', $invoice_id)->update(['is_pay'=>1, 'paid'=>0]);
                    }
                    else{
                        Invoice::where('id', $invoice_id)->update(['paid'=>$final_rup]);
                    }
                }
                else{
                    $final_amt=($db[0]->total_amount-$amount_in_r);
                    if($final_amt==0) {
                        Invoice::where('id', $invoice_id)->update(['is_pay'=>1]);
                    }
                    else{
                        Invoice::where('id', $invoice_id)->update(['is_pay'=>2,'paid'=>$amount_in_r]);
                    }
                }
            }
            $seconds_increament+=8;

        }


        $outlet_data=RetailerOutlet::where('id', $selected_invoice_retailer_outlet_id)->get(['advance_amount'])->first();

        $final_advance_amount= $outlet_data['advance_amount']-$amount_in_rs;
        RetailerOutlet::where('id', $selected_invoice_retailer_outlet_id)->update(['advance_amount'=>$final_advance_amount]);



        return 201;
    }
    
    public function create_credit_note(Request $request){
        //CreditNotes
        $cn_no= $request->input('cn_no');
        $cn_no_type= $request->input('cn_type');
        $selected_invoice_retailer_outlet_id= $request->input('retailer_outlet_id');
        $sales_officer_id= $request->input('sales_officer_id');
        $amount_in_rs= $request->input('amount_in_rs');
        $user=Auth::user()->id;
        $remarks= $request->input('remarks');


        $selected_retailer_query= RetailerOutlet::where('id', $selected_invoice_retailer_outlet_id)->get();
        $retailer_id=$selected_retailer_query[0]['retailer_id'];

        $ds_id=NULL;
        $payment_id=1;
        $deposit_slip_no=NULL;
        $bank_id=NULL;

            $credit_note=CreditNotes::create([
                'cr_type_id'=>$cn_no_type,
                'cr_no'=>$cn_no,
                'retailer_id'=>$retailer_id,
                'outlet_id'=>$selected_invoice_retailer_outlet_id,
                'amount'=>$amount_in_rs,
                'remarks'=>$remarks,
                'created_by'=>$user
            ]);

             $recent_cr_id=$credit_note->id;


        $OrderCollection=RetailerCollection::create(['bank_id'=>$bank_id,
            'currency_id'=>1,
            'collection_ds_id'=>$ds_id,
            'credit_note_id'=>$recent_cr_id,
            'payment_type_id'=>$payment_id,
            'retailer_id'=>$retailer_id,
            'retailer_outlet_id'=>$selected_invoice_retailer_outlet_id,
            'invoice_id'=>NULL,
            'cheque_number'=>NULL,
            'amount'=>$amount_in_rs,
            'deposit_slip_number'=>NULL,
            'remarks'=>$remarks,
            'created_by'=>$user
        ]);
        $collection_id=$OrderCollection->id;

        $cenvertedTime=date('Y-m-d h:i:s');
        Ledger::create([
            'retailer_id'=>$selected_invoice_retailer_outlet_id,
            'collection_id'=>$collection_id,
            'invoice_id'=>NULL,
            'TransDate'=>$cenvertedTime,
            'description'=>' Collection (Credit Note '.$cn_no.')'.'('.$remarks.')',
            'Collection'=>$amount_in_rs,
            'Credit'=>null
        ]);



        return 201;





    }

    public function get_cr_types(){
        return CreditNoteTypes::get();
    }

    //Registered a route /retailer/order/get_all_collection
    public function get_all_order_payment(){
        $records= RetailerCollection::with('bank','currency','payment_type','retailer_outlet','retailer','invoice')->get();
        return Response::json($records);
    }

    public function check_order_can_edit(Request $request){
        $order_id= $request->input('order_id');
        $date=date('Y-m-d');
        $records=RetailerCollection::where('id', $order_id)->get();
        $now = new DateTime($records[0]['created_at']);
        $order_date = $now->format('Y-m-d');

        if($order_date==$date){
            return 201;
        }
        else{
            echo "Cannot Edit the Record";
        }


    }



    //               /retailer/get_orders_by_outlet/{id}
    public function get_order_by_id($outlet_id){
        $records=RetailerOrder::with(
            ['order_products'=> function($q){ $q->where('is_deleted',0);},
                'order_products.ProductColor',
                'sales_officer',
                'order_products.ProductColor.product',
                'order_products.ProductColor.product.productCategory',
                'retailer',
                'retailer_outlet',
                'retailer_outlet.city',
                'user','updated_user']
        )->where('is_deleted',0)->where('outlet_id', $outlet_id)->get();

        return Response::json($records);
    }

    public function get_all_collections(Request $request){
        $collection_id= $request->input('collection_id');
        return RetailerCollection::
        with('bank', 'currency', 'payment_type', 'invoice')
            ->where('id', $collection_id)->get();
    }

    public function get_orders_of_sales_officers_by_outlet_id($outlet_id){
        return RetailerOrder::with('sales_officer')->where('outlet_id', $outlet_id)->get();

    }


    public function get_all_outstanding_invoices($outlet_id, $sales_officer_id){
        return DB::select("Select * from tbl_invoice invoice inner join tbl_retailer_order r_order on r_order.id=invoice.order_id where r_order.outlet_id=$outlet_id AND r_order.sales_officer_id=$sales_officer_id AND invoice.is_pay!=1");
    }
    
    public function deposit_slip_details($ds_id){
        return RetailerCollectionDS::with(['get_ds_collections', 'retailer_outlet', 'get_ds_collections.invoice'])->where('id', $ds_id)->get();
    }
	
	
	public function get_all_ds(Request $request){
        if ($request->input('client')) {
            return RetailerCollectionDS::with('bank', 'currency', 'payment_type', 'retailer_outlet', 'retailer')->orderBy('id', 'desc')->get();
        }
        $columns = ['id', 'deposit_slip_number', 'address', 'cnic', 'email', 'phoneNumber'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = RetailerCollectionDS::with('bank', 'currency', 'payment_type', 'retailer_outlet', 'retailer')->orderBy($columns[$column], $dir);
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('deposit_slip_number', 'like', '%' . $searchValue . '%')
                    ->orWhere('total_amount', 'like', '%' . $searchValue . '%')
                    ->orWhereHas('payment_type', function ( $q ) use ($searchValue) {
                            $q->Where('type', 'like', '%' . $searchValue . '%');
                    })->orWhereHas('bank', function ( $q ) use ($searchValue) {
                            $q->Where('bank_name', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('retailer_outlet', function ( $q ) use ($searchValue) {
                            $q->Where('name', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('retailer', function ( $q ) use ($searchValue) {
                            $q->Where('retailer_no', 'like', '%' . $searchValue . '%');
                    });
                    
            });
        }
        $projects = $query->paginate($length);
        $total_amount=RetailerCollection::where("is_reversible", 0)->whereNotNull('collection_ds_id')->sum("amount");
        return ['data' => $projects, 'draw' => $request->input('draw'), 'total_deposit_slip'=>$total_amount];



    }
    public function get_all_advance_payment(Request $request){
        
        if ($request->input('client')) {
            return RetailerCollection::with('invoice','currency', 'payment_type', 'retailer_outlet', 'retailer')->where('collection_ds_id',null)->where('credit_note_id', null)->get();
        }

        $columns = ['id', 'deposit_slip_number', 'retailer_id', 'retailer_outlet_id'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = RetailerCollection::with('invoice','currency', 'payment_type', 'retailer_outlet', 'retailer')->where('collection_ds_id',null)->where('credit_note_id', null)->orderBy($columns[$column], $dir);
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('deposit_slip_number', 'like', '%' . $searchValue . '%')
                    ->orWhereHas('retailer_outlet', function ( $q ) use ($searchValue) {
                            $q->Where('name', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('invoice', function ( $q ) use ($searchValue) {
                            $q->Where('invoice_no', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('retailer', function ( $q ) use ($searchValue) {
                            $q->Where('retailer_no', 'like', '%' . $searchValue . '%');
                    });  
            });
        }
        $projects = $query->paginate($length);


        $total_amount=RetailerCollection::where('collection_ds_id',null)->where('credit_note_id', null)->sum("amount");
        return ['data' => $projects, 'draw' => $request->input('draw'), 'total_amount'=>$total_amount];
    }

    public function get_all_credit_notes(Request $request){
        if ($request->input('client')) {
            return CreditNotes::with('retailer', 'retailer_outlet', 'Cr_type')->get();
        }

        $columns = ['id', 'deposit_slip_number', 'retailer_id', 'retailer_outlet_id'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = CreditNotes::with('retailer', 'retailer_outlet', 'Cr_type')->orderBy($columns[$column], $dir);
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->orWhereHas('retailer_outlet', function ( $q ) use ($searchValue) {
                            $q->Where('name', 'like', '%' . $searchValue . '%');
                    })
                    
                    ->orWhereHas('retailer', function ( $q ) use ($searchValue) {
                            $q->Where('retailer_no', 'like', '%' . $searchValue . '%');
                    });  
            });
        }
        $projects = $query->paginate($length);


        $total_amount=CreditNotes::sum("amount");
        return ['data' => $projects, 'draw' => $request->input('draw'), 'total_amount'=>$total_amount];
    }

    public function transaction_closed_ds(Request $request){
        $ds_id= $request->input('ds_id');

        RetailerCollectionDS::where('id', $ds_id)->update(['transaction_closed'=>1]);
        return 201;
    }


}

?>