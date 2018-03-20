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
use Response;
use App\PaymentType;
use App\DiscountType;
use App\RetailerInvoice;
use App\RetailerInvoice_Products;
use App\WarehouseStaff;
use App\Staff;
use App\WarehouseIssue;
use App\Ledger;

class RetailerInvoiceController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {

        return view('retailerInvoiceList');
    }

    public function get_invoice() {
        return $invoice_list = RetailerInvoice::with(
                        'payment_type'
                )->get();
    }

    

    public function invoiceCreate($order_id) {

        return view('retailerInvoice', compact('order_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $product[] = null;

        DB::beginTransaction();
        $staff_id = Auth::user()->staff_id;
        $warehouse_id = $warehousestaff = WarehouseStaff::where('staff_id', $staff_id)->first();

        $invoice = RetailerInvoice::create([
                    'order_id' => $request->order_id,
                    'payment_type_id' => $request->payment_type_id,
                    'invoice_type_id' => $request->invoice_type_id,
                    'total_amount' => $request->total_amount,
                    'description' => $request->decs,
                    'created_by' => Auth::user()->id,
        ]);
        $invoice_id = $invoice->id;

        for ($i = 0; $i < count($request->amount); $i++) {
            $product[$i]['invoice_id'] = $invoice_id;
            $product[$i]['product_color_id'] = $request->colorid[$i];
            $product[$i]['product_qty'] = $request->quantity[$i];
            $product[$i]['product_price'] = $request->unitcost[$i];
            $product[$i]['discount_type_id'] = $request->discount_type_id[$i];
            $product[$i]['total_amount'] = $request->productamount[$i];
            $product[$i]['extra'] = $request->extra[$i];
            $product[$i]['created_by'] = Auth::user()->id;
        }
        RetailerInvoice_Products::insert($product);
        //DB::table('tbl_invoice_products')->insert($product);
        
        WarehouseIssue::create([
            'invoice_id' => $invoice_id,
            'warehouse_id' => $warehouse_id->warehouse_id,
            'created_by' => Auth::user()->id
        ]);
		   Ledger::create(['invoice_id' => $invoice_id, 'transDate' => date('Y-m-d'),
            'description' => $invoice_id . $request->decs, 'credit' => $request->total_amount,
            'retailer_id' => $request->retailer_id]);
  //      DB::table('tbl_ledger')->insert(['invoice_id'=>$invoice_id,'transDate'=>date('Y-m-d'),'description'=>$invoice_id.$request->decs,'credit'=>$request->total_amount,'retailer_id'=>$request->retailer_id]);
        DB::commit();

        return 201;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RetailerInvoice  $retailerInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(RetailerInvoice $retailerInvoice) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RetailerInvoice  $retailerInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(RetailerInvoice $retailerInvoice) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RetailerInvoice  $retailerInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RetailerInvoice $retailerInvoice) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RetailerInvoice  $retailerInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(RetailerInvoice $retailerInvoice) {
        //
    }

}
