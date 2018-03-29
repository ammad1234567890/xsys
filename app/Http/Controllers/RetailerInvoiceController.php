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
use App\WarehouseIssueItem;
use App\Ledger;
use App\InvoiceProduct;

class RetailerInvoiceController extends Controller {

    public function index() {
        return view('retailerInvoiceList');
    }

    public function get_invoice() {
        return $invoice_list = RetailerInvoice::with(
                        'payment_type'
                        , 'RetailerOrder'
                        , 'warehouse_issue'
                )->orderBy('id', 'desc')->get();
    }

    public function invoiceCreate($order_id) {

        return view('retailerInvoice', compact('order_id'));
    }

    public function create() {
        
    }

    public function store(Request $request) {
        $product[] = null;
        try {
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
            RetailerInvoice::where(['id' => $invoice_id])->update(['invoice_no' => $request->order_id_pattern . $this->make_number($invoice_id)]);
            for ($i = 0; $i < count($request->amount); $i++) {
                if ($request->productamount[$i] != 0) {
                    $product[$i]['invoice_id'] = $invoice_id;
                    $product[$i]['product_color_id'] = $request->colorid[$i];
                    $product[$i]['product_qty'] = $request->quantity[$i];
                    $product[$i]['product_price'] = $request->unitcost[$i];
                    $product[$i]['total_amount'] = $request->productamount[$i];
                    $product[$i]['created_by'] = Auth::user()->id;
                    if ($request->qty_db[$i] <= $request->quantity[$i]) {
                        RetailerOrderProduct::where(['id' => $request->product_id[$i]])->update(['is_delivered' => 1, 'remaining_qty' => 0]);
                        $count_status = RetailerOrderProduct::where(['id' => $request->product_id[$i], 'is_delivered' => 0])->count();
                        if ($count_status == 0) {
                            RetailerOrder::where(['id' => $request->order_id])->update(['is_delivered' => 1]);
                        }
                    } else {
                        RetailerOrderProduct::where(['id' => $request->product_id[$i]])->update(['remaining_qty' => $request->qty_db[$i] - $request->quantity[$i]]);
                    }
                }
            }
            RetailerInvoice_Products::insert($product);

            WarehouseIssue::create([
                'invoice_id' => $invoice_id,
                'warehouse_id' => $warehouse_id->warehouse_id,
                'created_by' => Auth::user()->id
            ]);
            Ledger::create(['invoice_id' => $invoice_id, 'TransDate' => date('Y-m-d H:i:s'),
                'description' => "invoice (" . $request->order_id_pattern . $this->make_number($invoice_id) . ")", 'Credit' => $request->total_amount,
                'retailer_id' => $request->retailer_id]);
            DB::commit();
            return 201;
        } catch (Exception $ex) {
             DB::rollBack();
             return ['message'=>'fail create invoice','Exception'=>$ex];
        }
    }

    public function make_number($order_id) {
        $order_zeros = "";
        if ($order_id <= 9) {
            $order_zeros = "00000";
        } elseif ($order_id <= 99) {
            $order_zeros = "0000";
        } elseif ($order_id <= 1000) {
            $order_zeros = "000";
        } elseif ($order_id <= 10000) {
            $order_zeros = "00";
        } elseif ($order_id <= 100000) {
            $order_zeros = "0";
        }
        return $order_zeros . $order_id;
    }

    public function invoice_details($id) {
        return $records = RetailerInvoice::with([
                    'RetailerOrder.retailer_outlet',
                    'warehouse_issue' => function($q) {
                        $q->where('is_issued', 1);
                    },
                    'warehouse_issue.warehouseIssueItem.item.productColor.product',
                    'warehouse_issue.warehouseIssueItem.item.imei'
                ])->where(['id' => $id])->first();
    }

    public function print_invoice() {
        return view('retailerInvoicePrint');
    }

    public function generate_invoice($id) {
        return $records = RetailerInvoice::with([
                    'invoice_Products.productColor.product'
                    , 'RetailerOrder.retailer_outlet'
                ])->where(['id' => $id])->first();
    }

    public function get_invoice_by_retailer(Request $request) {
        $outlet_id = $request->input('selected_invoice_retailer_outlet_id');
        //$records= RetailerOutlet::with('retailer_order','retailer_order.invoices')->where('id',$outlet_id)->get();
        $records = RetailerInvoice::with('RetailerOrder.retailer', 'RetailerOrder.retailer_outlet')->whereHas('RetailerOrder.retailer_outlet', function($q) use ($outlet_id) {

                    $q->where('id', $outlet_id);
                })->get();


        return Response::json($records);
    }

}
