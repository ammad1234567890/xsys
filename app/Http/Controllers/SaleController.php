<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\SaleReturn;
use Illuminate\Http\Request;
use App\InvoiceProductsReturn;
use App\WarehouseIssueItem;
use App\Http\Controllers\ReportsController;
use App\RetailerInvoice;
use App\Ledger;
use App\WarehouseStock;
use App\MainWarehouseReceiveItem;
use App\IMEI;

class SaleController extends Controller {

    function __construct() {
        $this->SaleReturn = new SaleReturn();
        $this->report = new ReportsController();
    }

    function sale_return_verification(Request $request) {
        $imei_list = array_flatten(IMEI::whereIn('tbl_imei.imei1', $request->imei_list)
                        ->orwhereIn('tbl_imei.imei2', $request->imei_list)
                        ->select('imei1')->get()
                        ->toArray());
        $data = $this->SaleReturn->sale_validation($imei_list);
        if (sizeof($data)) {
            return ['status' => true, 'data' => $data];
        } else {
            return ['status' => false];
        }
    }

    function sale_find() {
        return view('saleFind');
    }

    function sale_return(Request $request) {
        try {
            DB::beginTransaction();
            $data_sort = [];
            $data_invoice = [];
            $item = [];
            $item_insert = [];
            $total = 0;
            $pro_decs = "";
            for ($i = 0; $i < sizeof($request->products['data']); $i++) {
                $data_sort[$i]['imei1'] = $request->products['data'][$i]['imei1'];
                $data_sort[$i]['invoice_no'] = $request->products['data'][$i]['invoice_no'];
                $data_sort[$i]['invoice_id'] = $request->products['data'][$i]['invoice_id'];
                $data_sort[$i]['tbl_invoice_product'] = $request->products['data'][$i]['item_invoice_products_id'];
                $data_sort[$i]['product_color_id'] = $request->products['data'][$i]['product_color_id'];
                $data_sort[$i]['unit_price'] = $request->products['data'][$i]['product_unit_price_discount'];
                $data_sort[$i]['sale_officer_id'] = $request->products['data'][$i]['staff_id'];
                $data_sort[$i]['item_id'] = $request->products['data'][$i]['item_id'];
                $data_sort[$i]['outlet_id'] = $request->products['data'][$i]['outlet_id'];
                $data_sort[$i]['created_by'] = Auth::user()->id;
                $pro_decs .= "(" . $request->products['data'][$i]['imei1'] . " " . $request->products['data'][$i]['product_name'] . " " . $request->products['data'][$i]['color'] . " " . $request->products['data'][$i]['product_unit_price'] . ")";
                array_push($item, $request->products['data'][$i]['item_id']);
                array_push($item_insert, ['item_id' => $request->products['data'][$i]['item_id']
                    , 'invoice_id' => $request->products['data'][$i]['invoice_id']
                    , 'warehouse_id' => $request->products['data'][$i]['warehouse_id']
                ]);
                $data_invoice[$i]['invoice_id'] = $request->products['data'][$i]['invoice_id'];
                $data_invoice[$i]['unit_price'] = $request->products['data'][$i]['product_unit_price_discount'];
                $data_invoice[$i]['outlet_id'] = $request->products['data'][$i]['outlet_id'];
                $data_invoice[$i]['product_color_id'] = $request->products['data'][$i]['product_color_id'];
                $data_invoice[$i]['warehouse_id'] = $request->products['data'][$i]['warehouse_id'];
//                MainWarehouseReceiveItem::whereIn(['item_id' => $request->products['data'][$i]['item_id']])
//                        ->update(['is_sold' => 0, 'sold_to_outlet_id' => null]);
            }
            MainWarehouseReceiveItem::whereIn('item_id',$item)
                    ->update(['is_sold' => 0, 'sold_to_outlet_id' => null]);
            DB::table('tbl_warehouse_issue_return')->insert($item_insert);
            DB::table('tbl_warehouse_issue_items')->whereIn('item_id', $item)->delete();
            InvoiceProductsReturn::insert($data_sort);
            $insert_invoice_id = DB::table('tbl_invoice')->insertGetId(['order_id' => $request->products['data'][0]['order_id']
                , 'total_amount' => 0, 'final_amount' => 0, 'is_invoice' => 4, 'is_pay' => 4
                , 'created_by' => Auth::user()->id, 'created_at' => now(), 'updated_at' => now()]);
            DB::table('tbl_invoice_products')->insert(['invoice_id' => $insert_invoice_id, 'discount' => 0, 'product_color_id' => 0, 'product_qty' => 0, 'product_price' => 0, 'total_amount' => 0, 'created_by' => Auth::user()->id]);
            $data_invoice = $this->report->multisort($data_invoice, 'invoice_id');
            $data_color = $this->report->multisort($data_invoice, 'product_color_id');
            $subtotal = 0;
            $qty = 0;
            $invoice_id = null;
            $subcount = 0;
            $invoice = [];
            $index = 0;
            $outlet_id = null;
            $count_y = sizeof($data_invoice) - 1;
            $stock = [];
            $product_color_id = null;
            $cont_color = 0;
            for ($y = 0; $y < sizeof($data_invoice); $y++) {
                if ($subcount == 0) {
                    $invoice_id = $data_invoice[$y]['invoice_id'];
                    $subcount++;
                }
                if ($invoice_id == $data_invoice[$y]['invoice_id']) {
                    $subtotal += $data_invoice[$y]['unit_price'];
                    if ($count_y == $y) {
                        $invoice[$index] = ['invoice_id' => $invoice_id, 'total' => $subtotal, 'outlet_id' => $data_invoice[$y]['outlet_id']];
                    }
                } else {
                    $y--;
                    $invoice[$index++] = ['invoice_id' => $invoice_id, 'total' => $subtotal, 'outlet_id' => $data_invoice[$y]['outlet_id']];
                    $subtotal = 0;
                    $subcount = 0;
                    $qty = 0;
                }
            }
            for ($z = 0; $z < sizeof($invoice); $z++) {
                $total += $invoice[$z]['total'];
                $outlet_id = $invoice[$z]['outlet_id'];
                $query = $this->SaleReturn->invoice($invoice[$z]);
                $cal_total = $query->total_amount - $invoice[$z]['total'];
                if ($query->is_pay == 0) {
                    if ($query->paid >= $cal_total) {
                        RetailerInvoice::where('id', $invoice[$z]['invoice_id'])
                                ->update(['total_amount' => $cal_total, 'paid' => 0, 'is_pay' => 1, 'updated_by' => Auth::user()->id]);
                    } else {
                        RetailerInvoice::where('id', $invoice[$z]['invoice_id'])
                                ->update(['total_amount' => $cal_total, 'updated_by' => Auth::user()->id]);
                    }
                }
                if ($query->is_pay == 1) {
                    RetailerInvoice::where('id', $invoice[$z]['invoice_id'])
                            ->update(['total_amount' => $cal_total, 'updated_by' => Auth::user()->id]);
                }
                if ($query->is_pay == 2) {
                    RetailerInvoice::where('id', $invoice[$z]['invoice_id'])
                            ->update(['total_amount' => $cal_total, 'updated_by' => Auth::user()->id]);
                    if ($query->paid >= $cal_total) {
                        RetailerInvoice::where('id', $invoice[$z]['invoice_id'])
                                ->update(['paid' => 0, 'is_pay' => 1, 'updated_by' => Auth::user()->id]);
                    }
                }
            }
            DB::table('tbl_ledger')->insert(
                    ['collection' => $total, 'description' => "sale return " . $pro_decs,
                        'retailer_id' => $outlet_id,
                        'TransDate' => now(), 'created_at' => now(), 'updated_at' => now()]);

            for ($j = 0; $j < sizeof($data_color); $j++) {
                if ($cont_color == 0) {
                    $product_color_id = $data_color[$j]['product_color_id'];
                    $cont_color++;
                }
                if ($data_color[$j]['product_color_id'] == $product_color_id) {
                    $qty++;
                    $stock[$data_color[$j]['product_color_id']] = $qty;
                } else {
                    $j--;
                    $stock[$data_color[$j]['product_color_id']] = $qty;
                    $qty = 0;
                    $cont_color = 0;
					$product_color_id = '';
                }
            }
            foreach ($stock as $key => $value) {
                $add_qty = $value;
                $current = WarehouseStock::where(['product_color_id' => $key
                            , 'warehouse_id' => $data_color[0]['warehouse_id']])->select('product_qty')->first();
                $add_qty += $current['product_qty'];
                WarehouseStock::where(['product_color_id' => $key
                            , 'warehouse_id' => $data_color[0]['warehouse_id']])
                        ->update(['product_qty' => $add_qty]);
            }
            DB::commit();
            return ['status' => true];
        } catch (Exception $ex) {
            DB::rollBack();
        }
    }

}
