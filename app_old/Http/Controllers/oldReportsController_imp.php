<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Excel;
use App\Retailer;
use App\City;
use App\State;
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
use App\InvoiceProductsReturn;
use App\WarehouseIssueReturn;

class ReportsController extends Controller {

    public function __construct() {
        
    }

    public function outstandingReport() {
        return view('reportOutstanding');
    }

    public function get_outstanding(Request $request) {
        $data = [];
        $aging_total_amount = 0;
        $aging_paid = 0;
        $aging = 0;
        $outstanding_paid = [];
        $retailer_outlet_id = null;
        $count = 0;
        $index = 0;
        $count_i = 0;
        $outstanding = 0;
        $paid = 0;
        $t_outstanding = 0;
        $t_paid = 0;
        $query = DB::table('tbl_retailer_outlet')
                ->select('tbl_retailer_outlet.name as outletname', 'tbl_retailer_outlet.credit_limit'
                        , 'tbl_retailer_outlet.credit_duration', 'tbl_retailer_outlet.address'
                        , 'tbl_retailer_outlet.id as tbl_retailer_outlet_id'
                        , 'tbl_retailer.retailer_no', 'tbl_city.name as cityname'
                        , 'tbl_region.name as region_name', 'tbl_invoice.invoice_no', 'tbl_invoice.id'
                        , 'tbl_invoice.total_amount', 'tbl_invoice.paid', 'tbl_invoice.order_id as invoice_order_id'
                        , 'tbl_invoice.created_at as invoice_created_date', 'tbl_staff.name as sales_officer_name'
                )
                ->join('tbl_retailer_order', 'tbl_retailer_outlet.id', '=', 'tbl_retailer_order.outlet_id')
                ->join('tbl_invoice', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                ->join('tbl_retailer', 'tbl_retailer_outlet.retailer_id', '=', 'tbl_retailer.id')
                ->join('tbl_city', 'tbl_retailer_outlet.city_id', '=', 'tbl_city.id')
                ->join('tbl_staff', 'tbl_staff.id', '=', 'tbl_retailer_order.sales_officer_id')
                ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id');
        if ($request->state != "all") {
            $query->where(['tbl_city.state_id' => $request->state]);
        }
        if ($request->city != "all" && $request->city != null) {
            $query->where(['tbl_retailer_outlet.city_id' => $request->city]);
        }
        if ($request->locality != "all" && $request->locality != null) {
            $query->where(['tbl_region.id' => $request->locality]);
        }
        if ($request->sales_officer != "all" && $request->sales_officer != "") {
            $query->where(['tbl_retailer_order.sales_officer_id' => $request->sales_officer]);
        }
        if ($request->customer != "") {
            $query->where(['tbl_retailer_outlet.id' => $request->customer]);
        }
        if ($request->fdate != "" && $request->tdate != "") {
            $from = date('Y-m-d H:i:s', strtotime($request->fdate . " 00:00:00"));
            $to = date('Y-m-d H:i:s', strtotime($request->tdate . " 23:59:59"));
            $query->whereRaw("tbl_invoice.created_at > '$from' and tbl_invoice.created_at < '$to'");
        }
        $query = $query->whereNotIn('tbl_invoice.is_pay', [1, 3])
                        ->whereNotIn('tbl_invoice.is_invoice', [2, 3])->orderBy('tbl_invoice.order_id')->get();
        if (sizeof($query)) {
            $query = $this->multisort($this->object_to_array($query), 'tbl_retailer_outlet_id');
            $count_i = sizeof($query) - 1;
            for ($i = 0; $i < sizeof($query); $i++) {
                if ($count == 0) {
                    $retailer_outlet_id = $query[$i]['tbl_retailer_outlet_id'];
                    $count++;
                }
                if ($query[$i]['tbl_retailer_outlet_id'] == $retailer_outlet_id) {
                    $outstanding += $query[$i]['total_amount'];
                    $paid += $query[$i]['paid'];
                    $t_outstanding += $query[$i]['total_amount'];
                    $t_paid += $query[$i]['paid'];
                    if (date('Y-m-d', strtotime(date('Y-m-d'))) >= date('Y-m-d', strtotime($query[$i]['invoice_created_date'] . " + " . $query[$i]['credit_duration'] . " days"))) {
                        $aging_total_amount += $query[$i]['total_amount'];
                        $aging_paid += $query[$i]['paid'];
                    }
                    if ($count_i == $i) {
                        $data[$index]['outlet'] = $query[$i];
                        $data[$index]['outstanding'] = $outstanding;
                        $data[$index]['paid'] = $paid;
                        $outstanding_paid['total_outstanding'] = $t_outstanding;
                        $outstanding_paid['total_paid'] = $t_paid;
                        $aging += $data[$index]['aging'] = $aging_total_amount - $aging_paid;
                    }
                } else {
                    --$i;
                    $aging += $data[$index]['aging'] = $aging_total_amount - $aging_paid;
                    $data[$index]['outstanding'] = $outstanding;
                    $data[$index]['paid'] = $paid;
                    $data[$index]['outlet'] = $query[$i];
                    $index++;
                    $count = 0;
                    $outstanding = 0;
                    $paid = 0;
                    $aging_total_amount = 0;
                    $aging_paid = 0;
                }
            }
            return ['status' => true, 'data' => $data, 'outstanding_paid' => $outstanding_paid, 'aging' => $aging];
        } else {
            return ['status' => false];
        }
    }

    public function get_outstanding_invoice_wise(Request $request) {
        $data = [];
        $aging_total_amount = 0;
        $aging_paid = 0;
        $aging = 0;
        $outstanding_paid = [];
        $retailer_outlet_id = null;
        $count = 0;
        $index = 0;
        $count_i = 0;
        $outstanding = 0;
        $paid = 0;
        $t_outstanding = 0;
        $t_paid = 0;
        $color = "";
        $query = DB::table('tbl_retailer_outlet')
                ->select('tbl_retailer_outlet.name as outletname', 'tbl_retailer_outlet.credit_limit'
                        , 'tbl_retailer_outlet.credit_duration', 'tbl_retailer_outlet.address'
                        , 'tbl_retailer_outlet.id as tbl_retailer_outlet_id'
                        , 'tbl_retailer.retailer_no', 'tbl_city.name as cityname'
                        , 'tbl_region.name as region_name', 'tbl_invoice.invoice_no', 'tbl_invoice.id'
                        , 'tbl_invoice.total_amount', 'tbl_invoice.paid', 'tbl_invoice.order_id as invoice_order_id'
                        , 'tbl_invoice.created_at as invoice_created_date', 'tbl_staff.name as sales_officer_name'
                )
                ->join('tbl_retailer_order', 'tbl_retailer_outlet.id', '=', 'tbl_retailer_order.outlet_id')
                ->join('tbl_invoice', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                ->join('tbl_retailer', 'tbl_retailer_outlet.retailer_id', '=', 'tbl_retailer.id')
                ->join('tbl_city', 'tbl_retailer_outlet.city_id', '=', 'tbl_city.id')
                ->join('tbl_staff', 'tbl_staff.id', '=', 'tbl_retailer_order.sales_officer_id')
                ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id');
        if ($request->state != "all") {
            $query->where(['tbl_city.state_id' => $request->state]);
        }
        if ($request->city != "all" && $request->city != null) {
            $query->where(['tbl_retailer_outlet.city_id' => $request->city]);
        }
        if ($request->locality != "all" && $request->locality != null) {
            $query->where(['tbl_region.id' => $request->locality]);
        }
        if ($request->sales_officer != "all" && $request->sales_officer != "") {
            $query->where(['tbl_retailer_order.sales_officer_id' => $request->sales_officer]);
        }
        if ($request->customer != "") {
            $query->where(['tbl_retailer_outlet.id' => $request->customer]);
        }
        if ($request->fdate != "" && $request->tdate != "") {
            $from = date('Y-m-d H:i:s', strtotime($request->fdate . " 00:00:00"));
            $to = date('Y-m-d H:i:s', strtotime($request->tdate . " 23:59:59"));
            $query->whereRaw("tbl_invoice.created_at > '$from' and tbl_invoice.created_at < '$to'");
        }
        $query = $query->whereNotIn('tbl_invoice.is_pay', [1, 3])
                        ->whereNotIn('tbl_invoice.is_invoice', [2, 3, 4])->orderBy('tbl_invoice.order_id')->get();
        if (sizeof($query)) {
            $query = $this->multisort($this->object_to_array($query), 'tbl_retailer_outlet_id');
            $count_i = sizeof($query) - 1;
            for ($i = 0; $i < sizeof($query); $i++) {
                if ($count == 0) {
                    $retailer_outlet_id = $query[$i]['tbl_retailer_outlet_id'];
                    $count++;
                }
                $color = "";
                if ($query[$i]['tbl_retailer_outlet_id'] == $retailer_outlet_id) {
                    $data[$index]['invoice'][$i] = $query[$i];
                    $outstanding += $query[$i]['total_amount'];
                    $paid += $query[$i]['paid'];
                    $t_outstanding += $query[$i]['total_amount'];
                    $t_paid += $query[$i]['paid'];
                    if (date('Y-m-d', strtotime(date('Y-m-d'))) >= date('Y-m-d', strtotime($query[$i]['invoice_created_date'] . " + " . $query[$i]['credit_duration'] . " days"))) {
                        $aging_total_amount += $query[$i]['total_amount'];
                        $aging_paid += $query[$i]['paid'];
                        $color = "red";
                    } else {
                        $color = "";
                    }
                    if ($count_i == $i) {
                        $data[$index]['outlet'] = $query[$i];
                        $data[$index]['outstanding'] = $outstanding;
                        $data[$index]['paid'] = $paid;
                        $outstanding_paid['total_outstanding']['total_outstanding'] = $t_outstanding;
                        $outstanding_paid['total_paid']['total_paid'] = $t_paid;
                        $aging += $data[$index]['aging'] = $aging_total_amount - $aging_paid;
                        $data[$index]['invoice'][$i]['color'] = $color;
                    }
                    $data[$index]['invoice'][$i]['color'] = $color;
                } else {
                    --$i;
                    $aging += $data[$index]['aging'] = $aging_total_amount - $aging_paid;
                    $data[$index]['outstanding'] = $outstanding;
                    $data[$index]['paid'] = $paid;
                    $data[$index]['outlet'] = $query[$i];
                    $index++;
                    $count = 0;
                    $outstanding = 0;
                    $paid = 0;
                    $aging_total_amount = 0;
                    $aging_paid = 0;
                    $color = "";
                }
            }
            return ['status' => true, 'data' => $data, 'outstanding_paid' => $outstanding_paid, 'aging' => $aging];
        } else {
            return ['status' => false];
        }
    }

    public function get_sales(Request $request) {
        if ($request->month == "") {
            return ['status' => false];
        }
        $data = [];
        $data_sort = [];
        $retailer_outlet_id = null;
        $count = 0;
        $index = 0;
        $count_i = 0;
        $date = null;
        $total = 0;
        $sale_return_total = 0;
        $sale_return_sub_total = 0;
        $sub_total = 0;
        $subcount = 0;
        $monthtotal = 0;
        $query = DB::table('tbl_retailer_outlet')
                ->select('tbl_retailer_outlet.name as outletname', 'tbl_retailer_outlet.credit_limit'
                        , 'tbl_retailer_outlet.credit_duration', 'tbl_retailer_outlet.address'
                        , 'tbl_retailer_outlet.id as retailer_outlet_id'
                        , 'tbl_retailer.retailer_no', 'tbl_city.name as cityname'
                        , 'tbl_region.name as region_name', 'tbl_invoice.invoice_no', 'tbl_invoice.id'
                        , 'tbl_invoice.total_amount', 'tbl_invoice.final_amount'
                        , 'tbl_invoice.paid', 'tbl_invoice.order_id as invoice_order_id'
                        , 'tbl_invoice.created_at as invoice_created_date', 'tbl_staff.name as sales_officer_name'
                )
                ->join('tbl_retailer_order', 'tbl_retailer_outlet.id', '=', 'tbl_retailer_order.outlet_id')
                ->join('tbl_invoice', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                ->join('tbl_retailer', 'tbl_retailer_outlet.retailer_id', '=', 'tbl_retailer.id')
                ->join('tbl_city', 'tbl_retailer_outlet.city_id', '=', 'tbl_city.id')
                ->join('tbl_staff', 'tbl_staff.id', '=', 'tbl_retailer_order.sales_officer_id')
                ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id');
        if ($request->state != "all") {
            $query->where(['tbl_city.state_id' => $request->state]);
        }
        if ($request->city != "all" && $request->city != null) {
            $query->where(['tbl_retailer_outlet.city_id' => $request->city]);
        }
        if ($request->locality != "all" && $request->locality != null) {
            $query->where(['tbl_region.id' => $request->locality]);
        }
        if ($request->sales_officer != "all" && $request->sales_officer != "") {
            $query->where(['tbl_retailer_order.sales_officer_id' => $request->sales_officer]);
        }
        if ($request->customer != "") {
            $query->where(['tbl_retailer_outlet.id' => $request->customer]);
        }
        if ($request->month != "") {
            $from = date('Y-m-d H:i:s', strtotime($request->month . "-1 00:00:00"));
            $to = date('Y-m-d H:i:s', strtotime($request->month . "-31 23:59:59"));
            $query->whereRaw("tbl_invoice.created_at > '$from' and tbl_invoice.created_at < '$to'");
        }
        $query = $query->whereNotIn('tbl_invoice.is_invoice', [2, 3])
                        ->orderBy('tbl_invoice.order_id')->get();
        if (sizeof($query)) {
            $query = $this->multisort($this->object_to_array($query), 'retailer_outlet_id');
            $count_i = sizeof($query) - 1;
            for ($i = 0; $i < sizeof($query); $i++) {
                if ($count == 0) {
                    $retailer_outlet_id = $query[$i]['retailer_outlet_id'];
                    $count++;
                }
                $temp_count = 0;
                $temp_date = null;
                $temp_amount = 0;
                if ($query[$i]['retailer_outlet_id'] == $retailer_outlet_id) {
                    $data_sort[$index]['invoice'][$i]['create_date'] = $query[$i]['invoice_created_date'];
                    $data_sort[$index]['invoice'][$i]['total_amount'] = $query[$i]['final_amount'];
                    $data_sort[$index]['invoice'][$i]['paid'] = $query[$i]['paid'];
                    $data_sort[$index]['invoice'][$i]['date'] = date('j', strtotime($query[$i]['invoice_created_date']));
                    if ($count_i == $i) {
                        $data[$index]['outlet'] = $query[$i];
                        $data[$index]['invoice'] = $this->multisort($this->object_to_array($data_sort[$index]['invoice']), 'create_date');
                        $sale_return = InvoiceProductsReturn::where(['outlet_id' => $data[$index]['outlet']['retailer_outlet_id']])
                                        ->whereRaw("created_at > '$from' and created_at < '$to'")
                                        ->orderBy('created_at')->get();
                        $sale_return_price = [];
                        for ($j = 1; $j <= 31; $j++) {
                            $sale_return_price[$j] = null;
                        }

                        for ($l = 0; $l < sizeof($sale_return); $l++) {
                            if ($temp_count == 0) {
                                $temp_date = $sale_return[$l]->created_at;
                                $temp_count++;
                            }
                            if ($sale_return[$l]->created_at == $temp_date) {
                                $temp_amount += $sale_return[$l]->unit_price;
                                $sale_return_total += $sale_return[$l]->unit_price;
                                $sale_return_sub_total += $sale_return[$l]->unit_price;
                                if ($l == sizeof($sale_return) - 1) {
                                    $sale_return_price[date('j', strtotime($temp_date))] += $temp_amount;
                                }
                            } else {
                                $l--;
                                $sale_return_price[date('j', strtotime($temp_date))] += $temp_amount;
                                $temp_count = 0;
                                $temp_amount = 0;
                            }
                        }
                        $data[$index]['sale_return'] = $sale_return_price;
                        for ($j = 1; $j <= 31; $j++) {
                            $date_array[$j] = '';
                        }
                        $data[$index]['sale'] = $date_array;
                        $sub_total = 0;
                        $day_invoice_count = sizeof($data[$index]['invoice']) - 1;
                        for ($y = 0; $y < sizeof($data[$index]['invoice']); $y++) {
                            if ($subcount == 0) {
                                $date = $data[$index]['invoice'][$y]['date'];
                                $subcount++;
                            }
                            if ($date == $data[$index]['invoice'][$y]['date']) {
                                $total += $data[$index]['invoice'][$y]['total_amount'];
                                $sub_total += $data[$index]['invoice'][$y]['total_amount'];
                                $data[$index]['sale'][$data[$index]['invoice'][$y]['date']] = $sub_total;
                                if ($day_invoice_count == $y) {
                                    $sub_total = 0;
                                }
                            } else {
                                $y--;
                                $sub_total = 0;
                                $subcount = 0;
                            }
                            // $sub_total = 0;
                        }
                        $data[$index]['total'] = $total;
                        $data[$index]['sale_return_total'] = $sale_return_sub_total;
                        $monthtotal += $total;
                    }
                } else {
                    --$i;
                    $data[$index]['outlet'] = $query[$i];
                    $data[$index]['invoice'] = $this->multisort($this->object_to_array($data_sort[$index]['invoice']), 'create_date');
                    $sale_return = InvoiceProductsReturn::where(['outlet_id' => $data[$index]['outlet']['retailer_outlet_id']])
                                    ->whereRaw("created_at > '$from' and created_at < '$to'")
                                    ->orderBy('created_at')->get();
                    $sale_return_price = [];
                    for ($j = 1; $j <= 31; $j++) {
                        $sale_return_price[$j] = null;
                    }
                    for ($l = 0; $l < sizeof($sale_return); $l++) {
                        if ($temp_count == 0) {
                            $temp_date = $sale_return[$l]->created_at;
                            $temp_count++;
                        }
                        if ($sale_return[$l]->created_at == $temp_date) {
                            $temp_amount += $sale_return[$l]->unit_price;
                            $sale_return_total += $sale_return[$l]->unit_price;
                            $sale_return_sub_total += $sale_return[$l]->unit_price;
                            if ($l == sizeof($sale_return) - 1) {
                                $sale_return_price[date('j', strtotime($temp_date))] += $temp_amount;
                            }
                        } else {
                            $l--;
                            $sale_return_price[date('j', strtotime($temp_date))] += $temp_amount;
                            $temp_count = 0;
                            $temp_amount = 0;
                        }
                    }
                    $data[$index]['sale_return'] = $sale_return_price;
                    for ($j = 1; $j <= 31; $j++) {
                        $date_array[$j] = '';
                    }
                    $data[$index]['sale'] = $date_array;
                    $day_invoice_count = sizeof($data[$index]['invoice']) - 1;
                    for ($y = 0; $y < sizeof($data[$index]['invoice']); $y++) {
                        if ($subcount == 0) {
                            $date = $data[$index]['invoice'][$y]['date'];
                            $subcount++;
                        }
                        if ($date == $data[$index]['invoice'][$y]['date']) {
                            $total += $data[$index]['invoice'][$y]['total_amount'];
                            $sub_total += $data[$index]['invoice'][$y]['total_amount'];
                            $data[$index]['sale'][$data[$index]['invoice'][$y]['date']] = $sub_total;
                            if ($day_invoice_count == $y) {
                                $sub_total = 0;
                            }
                        } else {
                            $y--;
                            $sub_total = 0;
                            $subcount = 0;
                        }
                        //   $sub_total = 0;
                    }

                    $monthtotal += $total;
                    $data[$index]['total'] = $total;
                    $data[$index]['sale_return_total'] = $sale_return_sub_total;
                    // $data[$index]['outlet'] = $query[$i];
                    $index++;
                    $count = 0;
                    $total = 0;
                    $sale_return_sub_total = 0;
                }
            }
            $data = $this->calculate_sale_or_salereturn(['data' => $data]);
            return ['status' => true, 'data' => $data['month'], 'total' => $monthtotal
                , 'sale_return' => $sale_return_total, 'day_total' => $data['day_total']];
            //    return $this->calculate_sale_or_salereturn(['status' => true, 'data' => $data, 'total' => $monthtotal, 'sale_return' => $sale_return_total]);
        } else {
            return ['status' => false];
        }
    }

    public function calculate_sale_or_salereturn($data) {
        $sale = [];
        $day_total = $this->create_month_numeric();
        for ($i = 0; $i < sizeof($data['data']); $i++) {
            for ($j = 1; $j <= 31; $j++) {
                $sale_month = $sale[$i][$j] = $data['data'][$i]['sale'][$j] != '' ? $data['data'][$i]['sale'][$j] : 0;
                $sale_return = $data['data'][$i]['sale_return'][$j] != null ? $data['data'][$i]['sale_return'][$j] : 0;
                $sale[$i][$j] = $sale_month - $sale_return;
                $day_total[$j] += $sale[$i][$j];
            }
            $data['data'][$i]['sale_result'] = $sale[$i];
        }
        //   return $data;
        return ['month' => $data, 'day_total' => $day_total];
    }

    public function get_sales_qty(Request $request) {
        if ($request->month == "") {
            return ['status' => false];
        }
        $data = [];
        $data_sort = [];
        $retailer_outlet_id = null;
        $count = 0;
        $index = 0;
        $count_i = 0;
        $date = null;
        $total = 0;
        $sub_total = 0;
        $subcount = 0;
        $monthtotal = 0;
        $sale_return_total = 0;
        $sale_return_sub_total = 0;
        $query = DB::table('tbl_retailer_outlet')
                ->select('tbl_retailer_outlet.name as outletname', 'tbl_retailer_outlet.credit_limit'
                        , 'tbl_retailer_outlet.credit_duration', 'tbl_retailer_outlet.address'
                        , 'tbl_retailer_outlet.id as retailer_outlet_id'
                        , 'tbl_retailer.retailer_no', 'tbl_city.name as cityname'
                        , 'tbl_region.name as region_name', 'tbl_invoice.invoice_no', 'tbl_invoice.id'
                        , 'tbl_invoice.total_amount', 'tbl_invoice.paid', 'tbl_invoice.order_id as invoice_order_id'
                        , 'tbl_invoice_products.product_qty'
                        , 'tbl_invoice.created_at as invoice_created_date', 'tbl_staff.name as sales_officer_name'
                )
                ->join('tbl_retailer_order', 'tbl_retailer_outlet.id', '=', 'tbl_retailer_order.outlet_id')
                ->join('tbl_invoice', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                ->join('tbl_invoice_products', 'tbl_invoice_products.invoice_id', '=', 'tbl_invoice.id')
                ->join('tbl_retailer', 'tbl_retailer_outlet.retailer_id', '=', 'tbl_retailer.id')
                ->join('tbl_city', 'tbl_retailer_outlet.city_id', '=', 'tbl_city.id')
                ->join('tbl_staff', 'tbl_staff.id', '=', 'tbl_retailer_order.sales_officer_id')
                ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id');
        if ($request->state != "all") {
            $query->where(['tbl_city.state_id' => $request->state]);
        }
        if ($request->city != "all" && $request->city != null) {
            $query->where(['tbl_retailer_outlet.city_id' => $request->city]);
        }
        if ($request->locality != "all" && $request->locality != null) {
            $query->where(['tbl_region.id' => $request->locality]);
        }
        if ($request->sales_officer != "all" && $request->sales_officer != "") {
            $query->where(['tbl_retailer_order.sales_officer_id' => $request->sales_officer]);
        }
        if ($request->customer != "") {
            $query->where(['tbl_retailer_outlet.id' => $request->customer]);
        }
        if ($request->month != "") {
            $from = date('Y-m-d H:i:s', strtotime($request->month . "-1 00:00:00"));
            $to = date('Y-m-d H:i:s', strtotime($request->month . "-31 23:59:59"));
            $query->whereRaw("tbl_invoice.created_at > '$from' and tbl_invoice.created_at < '$to'");
        }
        $query = $query->whereNotIn('tbl_invoice.is_invoice', [2, 3])
                        ->orderBy('tbl_invoice.order_id')->get();
        if (sizeof($query)) {
            $query = $this->multisort($this->object_to_array($query), 'retailer_outlet_id');
            $count_i = sizeof($query) - 1;
            for ($i = 0; $i < sizeof($query); $i++) {
                if ($count == 0) {
                    $retailer_outlet_id = $query[$i]['retailer_outlet_id'];
                    $count++;
                }
                $temp_count = 0;
                $temp_date = null;
                $temp_qty = 0;
                if ($query[$i]['retailer_outlet_id'] == $retailer_outlet_id) {
                    $data_sort[$index]['invoice'][$i]['create_date'] = $query[$i]['invoice_created_date'];
                    $data_sort[$index]['invoice'][$i]['product_qty'] = $query[$i]['product_qty'];
                    $data_sort[$index]['invoice'][$i]['outlet_id'] = $query[$i]['retailer_outlet_id'];
                    $data_sort[$index]['invoice'][$i]['date'] = date('j', strtotime($query[$i]['invoice_created_date']));
                    if ($count_i == $i) {
                        $data[$index]['outlet'] = $query[$i];
                        $data[$index]['invoice'] = $this->multisort($this->object_to_array($data_sort[$index]['invoice']), 'create_date');
                        if (isset($data[$index]['invoice'][0]['outlet_id'])) {
                            $sale_return = InvoiceProductsReturn::where(['outlet_id' => $data[$index]['invoice'][0]['outlet_id']])
                                            ->whereRaw("created_at > '$from' and created_at < '$to'")
                                            ->orderBy('created_at')->get();
                            $sale_return_qty = [];
                            for ($j = 1; $j <= 31; $j++) {
                                $sale_return_qty[$j] = null;
                            }
                            for ($l = 0; $l < sizeof($sale_return); $l++) {
                                if ($temp_count == 0) {
                                    $temp_date = $sale_return[$l]->created_at;
                                    $temp_count++;
                                }
                                if ($sale_return[$l]->created_at == $temp_date) {
                                    $temp_qty++;
                                    $sale_return_total++;
                                    $sale_return_sub_total++;
                                    if ($l == sizeof($sale_return) - 1) {
                                        $sale_return_qty[date('j', strtotime($temp_date))] += $temp_qty;
                                    }
                                } else {
                                    $l--;
                                    $sale_return_qty[date('j', strtotime($temp_date))] += $temp_qty;
                                    $temp_count = 0;
                                    $temp_qty = 0;
                                }
                            }
                        }
                        $data[$index]['sale_return_qty'] = $sale_return_qty;
                        for ($j = 1; $j <= 31; $j++) {
                            $date_array[$j] = '';
                        }
                        $data[$index]['product_qty'] = $date_array;
                        $sub_total = 0;
                        for ($y = 0; $y < sizeof($data[$index]['invoice']); $y++) {
                            if ($subcount == 0) {
                                $date = $data[$index]['invoice'][$y]['date'];
                                $subcount++;
                            }
                            if ($date == $data[$index]['invoice'][$y]['date']) {
                                $total += $data[$index]['invoice'][$y]['product_qty'];
                                $sub_total += $data[$index]['invoice'][$y]['product_qty'];
                                $data[$index]['product_qty'][$data[$index]['invoice'][$y]['date']] = $sub_total;
                            } else {
                                $y--;
                                $sub_total = 0;
                                $subcount = 0;
                            }
                        }
                        $data[$index]['sale_return_total'] = $sale_return_sub_total;
                        $sale_return_sub_total = 0;
                        $data[$index]['total'] = $total;
                        $monthtotal += $total;
                        $total = 0;
                    }
                } else {
                    $data[$index]['invoice'] = $this->multisort($this->object_to_array($data_sort[$index]['invoice']), 'create_date');
                    if (isset($data[$index]['invoice'][0]['outlet_id'])) {
                        $sale_return = InvoiceProductsReturn::where(['outlet_id' => $data[$index]['invoice'][0]['outlet_id']])
                                        ->whereRaw("created_at > '$from' and created_at < '$to'")
                                        ->orderBy('created_at')->get();
                        $sale_return_qty = [];
                        for ($j = 1; $j <= 31; $j++) {
                            $sale_return_qty[$j] = null;
                        }
                        for ($l = 0; $l < sizeof($sale_return); $l++) {
                            if ($temp_count == 0) {
                                $temp_date = $sale_return[$l]->created_at;
                                $temp_count++;
                            }
                            if ($sale_return[$l]->created_at == $temp_date) {
                                $temp_qty++;
                                $sale_return_total++;
                                $sale_return_sub_total++;
                                if ($l == sizeof($sale_return) - 1) {
                                    $sale_return_qty[date('j', strtotime($temp_date))] += $temp_qty;
                                }
                            } else {
                                $l--;
                                $sale_return_qty[date('j', strtotime($temp_date))] += $temp_qty;
                                $temp_count = 0;
                                $temp_qty = 0;
                            }
                        }
                    }
                    $data[$index]['sale_return_qty'] = $sale_return_qty;
                    for ($j = 1; $j <= 31; $j++) {
                        $date_array[$j] = '';
                    }
                    $data[$index]['product_qty'] = $date_array;
                    $sub_total = 0;
                    for ($y = 0; $y < sizeof($data[$index]['invoice']); $y++) {
                        if ($subcount == 0) {
                            $date = $data[$index]['invoice'][$y]['date'];
                            $subcount++;
                        }
                        if ($date == $data[$index]['invoice'][$y]['date']) {
                            $total += $data[$index]['invoice'][$y]['product_qty'];
                            $sub_total += (int) $data[$index]['invoice'][$y]['product_qty'];
                            $data[$index]['product_qty'][$data[$index]['invoice'][$y]['date']] = $sub_total;
                        } else {
                            $y--;
                            $sub_total = 0;
                            $subcount = 0;
                        }
                    }
                    --$i;
                    $monthtotal += $total;
                    $data[$index]['sale_return_total'] = $sale_return_sub_total;
                    $data[$index]['total'] = $total;
                    $data[$index]['outlet'] = $query[$i];
                    $sale_return_sub_total = 0;
                    $index++;
                    $count = 0;
                    $total = 0;
                }
            }
            // return $this->calculate_saleqty_or_salereturn(['status' => true, 'data' => $data, 'total' => $monthtotal, 'sale_return_total' => $sale_return_total]);
            $data = $this->calculate_saleqty_or_salereturn(['data' => $data]);
            return ['status' => true, 'data' => $data['month'], 'total' => $monthtotal
                , 'sale_return' => $sale_return_total, 'day_total' => $data['day_total']];
        } else {
            return ['status' => false];
        }
    }

    public function calculate_saleqty_or_salereturn($data) {
        $sale = [];
        $day_total = $this->create_month_numeric();
        for ($i = 0; $i < sizeof($data['data']); $i++) {
            for ($j = 1; $j <= 31; $j++) {
                $sale_month = $sale[$i][$j] = $data['data'][$i]['product_qty'][$j] != '' ? $data['data'][$i]['product_qty'][$j] : 0;
                $sale_return = $data['data'][$i]['sale_return_qty'][$j] != null ? $data['data'][$i]['sale_return_qty'][$j] : 0;
                $sale[$i][$j] = $sale_month - $sale_return;
                $day_total[$j] += $sale[$i][$j];
            }
            $data['data'][$i]['sale_result'] = $sale[$i];
        }
        //return $data;
        return ['month' => $data, 'day_total' => $day_total];
    }

    public function get_sales_qty_product(Request $request) {
        if ($request->month == "") {
            return ['status' => false];
        }
        $data = [];
        $data_sort = [];
        $retailer_outlet_id = null;
        $count = 0;
        $index = 0;
        $count_i = 0;
        $date = null;
        $sub_total = [];
        $subcount = 0;

        $query = DB::table('tbl_retailer_outlet')
                ->select('tbl_retailer_outlet.name as outletname', 'tbl_retailer_outlet.credit_limit'
                        , 'tbl_retailer_outlet.credit_duration', 'tbl_retailer_outlet.address'
                        , 'tbl_retailer_outlet.id as retailer_outlet_id'
                        , 'tbl_retailer.retailer_no', 'tbl_city.name as cityname'
                        , 'tbl_region.name as region_name', 'tbl_invoice.invoice_no', 'tbl_invoice.id'
                        , 'tbl_invoice.total_amount', 'tbl_invoice.paid', 'tbl_invoice.order_id as invoice_order_id'
                        , 'tbl_invoice_products.product_qty', 'tbl_product_color.color', 'tbl_product.name as p_name'
                        , 'tbl_invoice_products.total_amount as product_amount', 'tbl_invoice_products.product_color_id'
                        , 'tbl_invoice.created_at as invoice_created_date', 'tbl_staff.name as sales_officer_name'
                )
                ->join('tbl_retailer_order', 'tbl_retailer_outlet.id', '=', 'tbl_retailer_order.outlet_id')
                ->join('tbl_invoice', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                ->join('tbl_invoice_products', 'tbl_invoice_products.invoice_id', '=', 'tbl_invoice.id')
                ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_invoice_products.product_color_id')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_color.product_id')
                ->join('tbl_retailer', 'tbl_retailer_outlet.retailer_id', '=', 'tbl_retailer.id')
                ->join('tbl_city', 'tbl_retailer_outlet.city_id', '=', 'tbl_city.id')
                ->join('tbl_staff', 'tbl_staff.id', '=', 'tbl_retailer_order.sales_officer_id')
                ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id');
        if ($request->state != "all") {
            $query->where(['tbl_city.state_id' => $request->state]);
        }
        if ($request->city != "all" && $request->city != null) {
            $query->where(['tbl_retailer_outlet.city_id' => $request->city]);
        }
        if ($request->locality != "all" && $request->locality != null) {
            $query->where(['tbl_region.id' => $request->locality]);
        }
        if ($request->sales_officer != "all" && $request->sales_officer != "") {
            $query->where(['tbl_retailer_order.sales_officer_id' => $request->sales_officer]);
        }
        if ($request->customer != "") {
            $query->where(['tbl_retailer_outlet.id' => $request->customer]);
        }
        if ($request->month != "") {
            $from = date('Y-m-d H:i:s', strtotime($request->month . "-1 00:00:00"));
            $to = date('Y-m-d H:i:s', strtotime($request->month . "-31 23:59:59"));
            $query->whereRaw("tbl_invoice.created_at > '$from' and tbl_invoice.created_at < '$to'");
        }
        $query = $query->whereNotIn('tbl_invoice.is_invoice', [2, 3])
                        ->orderBy('tbl_invoice.order_id')->get();
        if (sizeof($query)) {
            $query = $this->multisort($this->object_to_array($query), 'retailer_outlet_id');
            $count_i = sizeof($query) - 1;
            for ($i = 0; $i < sizeof($query); $i++) {
                if ($count == 0) {
                    $retailer_outlet_id = $query[$i]['retailer_outlet_id'];
                    $count++;
                }
                if ($query[$i]['retailer_outlet_id'] == $retailer_outlet_id) {
                    $data_sort[$index]['invoice'][$i]['create_date'] = $query[$i]['invoice_created_date'];
                    $data_sort[$index]['invoice'][$i]['product'] = ['p_name' => $query[$i]['p_name']
                        , 'color' => $query[$i]['color'], 'qty' => $query[$i]['product_qty']
                        , 'product_amount' => $query[$i]['product_amount'], 'id' => $query[$i]['product_color_id']];

                    $data_sort[$index]['invoice'][$i]['date'] = date('j', strtotime($query[$i]['invoice_created_date']));
                    if ($count_i == $i) {
                        $data[$index]['outlet'] = $query[$i];
                        $data[$index]['invoice'] = $this->multisort($this->object_to_array($data_sort[$index]['invoice']), 'create_date');
                        for ($j = 1; $j <= 31; $j++) {
                            $date_array[$j] = '';
                        }
                        $data[$index]['product'] = $date_array;
                        $sub_total = [];
                        for ($y = 0; $y < sizeof($data[$index]['invoice']); $y++) {
                            if ($subcount == 0) {
                                $date = $data[$index]['invoice'][$y]['date'];
                                $subcount++;
                            }
                            if ($date == $data[$index]['invoice'][$y]['date']) {
                                $sub_total[$y] = $data[$index]['invoice'][$y]['product'];
                                $data[$index]['product'][$data[$index]['invoice'][$y]['date']] = $sub_total;
                            } else {
                                $y--;
                                $sub_total = [];
                                $subcount = 0;
                            }
                        }
                    }
                } else {
                    $data[$index]['invoice'] = $this->multisort($this->object_to_array($data_sort[$index]['invoice']), 'create_date');
                    for ($j = 1; $j <= 31; $j++) {
                        $date_array[$j] = '';
                    }
                    $data[$index]['product'] = $date_array;
                    for ($y = 0; $y < sizeof($data[$index]['invoice']); $y++) {
                        if ($subcount == 0) {
                            $date = $data[$index]['invoice'][$y]['date'];
                            $subcount++;
                        }
                        if ($date == $data[$index]['invoice'][$y]['date']) {
                            $sub_total[$y] = $data[$index]['invoice'][$y]['product'];
                            $data[$index]['product'][$data[$index]['invoice'][$y]['date']] = $sub_total;
                        } else {
                            $y--;
                            $sub_total = [];
                            $subcount = 0;
                        }
                    }
                    --$i;
                    $data[$index]['outlet'] = $query[$i];
                    $index++;
                    $count = 0;
                }
            }
            $data = $this->product_sale_qty($data);
            return ['status' => true, 'data' => $data];
        } else {
            return ['status' => false];
        }
    }

    public function product_sale_qty($data) {
        $count = 0;
        $product = "";
        $qty = 0;
        $p_name = null;
        $color = null;
        $total = 0;
        for ($i = 0; $i < sizeof($data); $i++) {
            for ($j = 1; $j <= sizeof($data[$i]['product']); $j++) {
                if (isset($data[$i]['product'][$j])) {
                    if ($data[$i]['product'][$j] != "") {
                        $data[$i]['product'][$j] = $this->multisort($this->object_to_array($data[$i]['product'][$j]), 'id');
                        $i_count = sizeof($data[$i]['product'][$j]) - 1;
                        for ($z = 0; $z < sizeof($data[$i]['product'][$j]); $z++) {
                            if (isset($data[$i]['product'][$j][$z]['id'])) {
                                if ($count == 0) {
                                    $product = $data[$i]['product'][$j][$z]['id'];
                                    $count++;
                                }
                                if ($data[$i]['product'][$j][$z]['id'] == $product) {
                                    $qty += $data[$i]['product'][$j][$z]['qty'];
                                    $p_name = $data[$i]['product'][$j][$z]['p_name'];
                                    $color = $data[$i]['product'][$j][$z]['color'];
                                    $total += $data[$i]['product'][$j][$z]['product_amount'];
                                    if ($i_count == $z) {
                                        $data[$i]['product'][$j]['result'][$z] = ['qty' => $qty, 'p_name' => $p_name, 'color' => $color, 'total' => $total];
                                        $product = "";
                                        $qty = 0;
                                        $p_name = '';
                                        $color = '';
                                        $total = 0;
                                        $count = 0;
                                    }
                                } else {
                                    $z--;
                                    $data[$i]['product'][$j]['result'][$z] = ['qty' => $qty, 'p_name' => $p_name, 'color' => $color, 'total' => $total];
                                    $count = 0;
                                    $product = "";
                                    $qty = 0;
                                    $p_name = '';
                                    $color = '';
                                    $total = 0;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function get_collection(Request $request) {
        $data = [];
        $data_sort = [];
        $count = 0;
        $count_j = 0;
        $outlet_id = null;
        $collection = 0;
        $total = 0;
        $collection_total = 0;
        $index = 1;
        $date = "";
        $day_total = 0;
        $days_sort = [];
        $day_total_array = [];
        $query = DB::table('tbl_retailer_outlet')
                ->select('tbl_retailer_outlet.id as outlet_id', 'tbl_retailer_outlet.city_id as outlet_city_id'
                        , 'tbl_retailer_outlet.region_id as outlet_region_id', 'tbl_retailer_outlet.name as outlet_name'
                        , 'tbl_retailer_outlet.address as outlet_address', 'tbl_retailer_outlet.address as outlet_address'
                        //     , 'tbl_retailer_order.sales_officer_id as order_sale_officer'
                        , 'tbl_retailer_collection.amount as collection_amount', 'tbl_retailer_collection.is_reversible as bonus'
                        , 'tbl_retailer_collection.created_at as collection_created_at', 'tbl_city.name as city_name'
                        , 'tbl_region.name as region_name', 'tbl_retailer.retailer_no'
                )
                ->join('tbl_retailer_collection', 'tbl_retailer_collection.retailer_outlet_id', '=', 'tbl_retailer_outlet.id')
                //->join('tbl_invoice', 'tbl_invoice.id', '=', 'tbl_retailer_collection.invoice_id')
                ->join('tbl_retailer_order', 'tbl_retailer_order.outlet_id', '=', 'tbl_retailer_outlet.id')
                ->join('tbl_city', 'tbl_city.id', '=', 'tbl_retailer_outlet.city_id')
                ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id')
                ->join('tbl_retailer', 'tbl_retailer.id', '=', 'tbl_retailer_outlet.retailer_id');
        if ($request->state != "all") {
            $query->where(['tbl_city.state_id' => $request->state]);
        }
        if ($request->city != "all" && $request->city != null) {
            $query->where(['tbl_retailer_outlet.city_id' => $request->city]);
        }
        if ($request->locality != "all" && $request->locality != null) {
            $query->where(['tbl_region.id' => $request->locality]);
        }
        if ($request->sales_officer != "all" && $request->sales_officer != "") {
            $query->where(['tbl_retailer_order.sales_officer_id' => $request->sales_officer]);
        }
        if ($request->customer != "") {
            $query->where(['tbl_retailer_outlet.id' => $request->customer]);
        }
        if ($request->month != "") {
            $from = date('Y-m-d H:i:s', strtotime($request->month . "-1 00:00:00"));
            $to = date('Y-m-d H:i:s', strtotime($request->month . "-31 23:59:59"));
            $query->whereRaw("tbl_retailer_collection.created_at > '$from' and tbl_retailer_collection.created_at < '$to'");
        }
        $query = $query->distinct()
                //  ->whereNotIn('tbl_invoice.is_invoice', [2, 3])
                //    ->orderBy('tbl_invoice.order_id')
                ->get();
        if (sizeof($query)) {
            $query = $this->multisort($this->object_to_array($query), 'outlet_id');
            $i_count = sizeof($query) - 1;
            for ($i = 0; $i < sizeof($query); $i++) {
                if ($count == 0) {
                    $outlet_id = $query[$i]['outlet_id'];
                    $count++;
                }
                if ($query[$i]['outlet_id'] == $outlet_id) {
                    $data[$index]['outlet_id'] = $query[$i]['outlet_id'];
                    $sort['outlet_name'] = $query[$i]['outlet_name'];
                    $sort['outlet_address'] = $query[$i]['outlet_address'];
                    $sort['city_name'] = $query[$i]['city_name'];
                    $sort['region_name'] = $query[$i]['region_name'];
                    $sort['retailer_no'] = $query[$i]['retailer_no'];
                    $sort['collection_created_at'] = $query[$i]['collection_created_at'];
                    if ($query[$i]['bonus'] == 0) {
                        $sort['collection'] = $query[$i]['collection_amount'];
                    } else {
                        $sort['collection'] = 0 - $query[$i]['collection_amount'];
                    }
                    $sort['date'] = date('j', strtotime($query[$i]['collection_created_at']));
                    array_push($days_sort, $sort);
                    if ($i_count == $i) {

                        $days_sort = $this->multisort($this->object_to_array($days_sort), 'date');
                        $data[$index]['collection_data'] = $days_sort;
                    }
                } else {
                    $days_sort = $this->multisort($this->object_to_array($days_sort), 'date');
                    $data[$index]['collection_data'] = $days_sort;
                    $index++;
                    $i--;
                    $count = 0;
                    $days_sort = [];
                }
            }
            $day_total_array = $this->create_month();
            for ($j = 1; $j <= sizeof($data); $j++) {
                $data_sort[$data[$j]['outlet_id']]['collection'] = $this->create_month();
                for ($z = 0; $z < sizeof($data[$j]['collection_data']); $z++) {
                    if ($count_j == 0) {
                        $date = $data[$j]['collection_data'][$z]['date'];
                        $count_j++;
                    }
                    if ($data[$j]['collection_data'][$z]['date'] == $date) {
                        $collection += $data[$j]['collection_data'][$z]['collection'];
                        $day_total += $data[$j]['collection_data'][$z]['collection'];
                        $collection_total += $data[$j]['collection_data'][$z]['collection'];
                        $total += $data[$j]['collection_data'][$z]['collection'];
                        $data_sort[$data[$j]['outlet_id']]['collection'][$data[$j]['collection_data'][$z]['date']] = $collection;
                        $data_sort[$data[$j]['outlet_id']]['outlet_name'] = $data[$j]['collection_data'][$z]['outlet_name'];
                        $data_sort[$data[$j]['outlet_id']]['outlet_address'] = $data[$j]['collection_data'][$z]['outlet_address'];
                        $data_sort[$data[$j]['outlet_id']]['city_name'] = $data[$j]['collection_data'][$z]['city_name'];
                        $data_sort[$data[$j]['outlet_id']]['region_name'] = $data[$j]['collection_data'][$z]['region_name'];
                        $data_sort[$data[$j]['outlet_id']]['retailer_no'] = $data[$j]['collection_data'][$z]['retailer_no'];
                    } else {
                        $z--;
                        $count_j = 0;
                        $collection = 0;
                    }
                }
                $collection = 0;
                $day_total_array[$date] = (int) $day_total_array[$date] + $day_total;
                $data_sort[$data[$j]['outlet_id']]['total'] = $total;
                $day_total = 0;
                $total = 0;
            }
            return ['status' => true, 'data' => $data_sort, 'collection_total' => $collection_total, 'day_total' => $day_total_array];
        } else {
            return ['status' => false];
        }
    }

    public function get_activate(Request $request) {
        $query = DB::table('tbl_main_warehouse_receive_item')
                ->select('tbl_city.name as city_name', 'tbl_retailer.retailer_no as retailer_no'
                        , 'tbl_retailer_outlet.name as outlet_name', 'tbl_region.name as region_name'
                        , 'tbl_retailer_outlet.address as outlet_address', 'tbl_imei.imei1', 'tbl_product.name as p_name'
                        , 'tbl_product_color.color', 'tbl_main_warehouse_receive_item.activated_date', 'tbl_retailer_order.created_at')
                ->join('tbl_retailer_outlet', 'tbl_retailer_outlet.id', '=', 'tbl_main_warehouse_receive_item.sold_to_outlet_id')
                ->join('tbl_item', 'tbl_item.id', '=', 'tbl_main_warehouse_receive_item.item_id')
                ->join('tbl_imei', 'tbl_imei.item_id', '=', 'tbl_main_warehouse_receive_item.item_id')
                ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_item.product_color_id')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_color.product_id')
                ->join('tbl_city', 'tbl_city.id', '=', 'tbl_retailer_outlet.city_id')
                ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id')
                ->join('tbl_retailer', 'tbl_retailer.id', '=', 'tbl_retailer_outlet.retailer_id')
                ->join('tbl_warehouse_issue_items', 'tbl_warehouse_issue_items.item_id', '=', 'tbl_main_warehouse_receive_item.item_id')
                ->join('tbl_warehouse_issue', 'tbl_warehouse_issue.id', '=', 'tbl_warehouse_issue_items.warehouse_issue_id')
                ->join('tbl_invoice', 'tbl_invoice.id', '=', 'tbl_warehouse_issue.invoice_id')
                ->join('tbl_retailer_order', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                ->join('tbl_staff', 'tbl_staff.id', '=', 'tbl_retailer_order.sales_officer_id');
        if ($request->state != "all") {
            $query->where(['tbl_city.state_id' => $request->state]);
        }
        if ($request->city != "all" && $request->city != null) {
            $query->where(['tbl_retailer_outlet.city_id' => $request->city]);
        }
        if ($request->locality != "all" && $request->locality != null) {
            $query->where(['tbl_region.id' => $request->locality]);
        }
        if ($request->sales_officer != "all" && $request->sales_officer != "") {
            $query->where(['tbl_retailer_order.sales_officer_id' => $request->sales_officer]);
        }
        if ($request->customer != "") {
            $query->where(['tbl_retailer_outlet.id' => $request->customer]);
        }
        if ($request->product != "") {
            $query->where(['tbl_product.id' => $request->product]);
        }
        if ($request->color != "") {
            $query->where(['tbl_product_color.id' => $request->color]);
        }
        if ($request->fdate != "" && $request->tdate != "") {
            $from = date('Y-m-d H:i:s', strtotime($request->fdate . " 00:00:00"));
            $to = date('Y-m-d H:i:s', strtotime($request->tdate . " 23:59:59"));
            $query->whereRaw("tbl_main_warehouse_receive_item.activated_date > '$from' and tbl_main_warehouse_receive_item.activated_date < '$to'");
        } else {
            $query->where('activated_date', '!=', '');
        }
        $query = $query->orderBy('activated_date', 'desc')->get();
        if (sizeof($query)) {
            return ['status' => true, 'data' => $query, 'total' => sizeof($query)];
        } else {
            return ['status' => false];
        }
    }

    public function activation_outlet(Request $request) {
        $data = [];
        $total = 0;
        if ($request->fdate != null && $request->tdate != null) {
            $from = date('Y-m-d H:i:s', strtotime($request->fdate . " 00:00:00"));
            $to = date('Y-m-d H:i:s', strtotime($request->tdate . "  23:59:59"));
            $count_query = "activated_date > '$from' and activated_date < '$to'";
        } else {
            $count_query = "activated_date!=''";
        }
        $query = DB::table('tbl_retailer_outlet')
                ->select(DB::raw("(select count(*) from tbl_main_warehouse_receive_item where sold_to_outlet_id=tbl_retailer_outlet.id and $count_query) as activation")
                        , 'tbl_retailer_outlet.name as outletname'
                        , 'tbl_retailer_outlet.address'
                        , 'tbl_city.name as cityname'
                        , 'tbl_region.name as region_name'
                        , 'tbl_retailer.retailer_no')
                ->join('tbl_retailer', 'tbl_retailer.id', '=', 'tbl_retailer_outlet.retailer_id')
                ->join('tbl_city', 'tbl_retailer_outlet.city_id', '=', 'tbl_city.id')
                ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id');
        if ($request->state != "all") {
            $query->where(['tbl_city.state_id' => $request->state]);
        }
        if ($request->city != "all" && $request->city != null) {
            $query->where(['tbl_retailer_outlet.city_id' => $request->city]);
        }
        if ($request->locality != "all" && $request->locality != null) {
            $query->where(['tbl_region.id' => $request->locality]);
        }
        $query = $query->get();
        if (sizeof($query)) {
            for ($i = 0; $i < sizeof($query); $i++) {
                if ($query[$i]->activation != 0) {
                    $data[$i] = $query[$i];
                    $total += $query[$i]->activation;
                }
            }
            $data = $this->multisort(($data), 'activation');
            return ['status' => true, 'data' => $data, 'total' => $total];
        } else {
            return ['status' => false];
        }
    }

    public function activation_outlet_products(Request $request) {
        $data = [];
        $count = 0;
        $outlet_id = null;
        $index = 0;
        $temp_count = 1;
        $query = DB::table('tbl_main_warehouse_receive_item')
                ->select('tbl_city.name as city_name', 'tbl_retailer.retailer_no as retailer_no'
                        , 'tbl_retailer_outlet.name as outlet_name', 'tbl_region.name as region_name', 'tbl_retailer_outlet.id as outlet_id'
                        , 'tbl_retailer_outlet.address as outlet_address'
                        , 'tbl_product.name as p_name'
                        , 'tbl_main_warehouse_receive_item.activated_date', 'tbl_retailer_order.created_at')
                ->join('tbl_retailer_outlet', 'tbl_retailer_outlet.id', '=', 'tbl_main_warehouse_receive_item.sold_to_outlet_id')
                ->join('tbl_item', 'tbl_item.id', '=', 'tbl_main_warehouse_receive_item.item_id')
                ->join('tbl_imei', 'tbl_imei.item_id', '=', 'tbl_main_warehouse_receive_item.item_id')
                ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_item.product_color_id')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_color.product_id')
                ->join('tbl_city', 'tbl_city.id', '=', 'tbl_retailer_outlet.city_id')
                ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id')
                ->join('tbl_retailer', 'tbl_retailer.id', '=', 'tbl_retailer_outlet.retailer_id')
                ->join('tbl_warehouse_issue_items', 'tbl_warehouse_issue_items.item_id', '=', 'tbl_main_warehouse_receive_item.item_id')
                ->join('tbl_warehouse_issue', 'tbl_warehouse_issue.id', '=', 'tbl_warehouse_issue_items.warehouse_issue_id')
                ->join('tbl_invoice', 'tbl_invoice.id', '=', 'tbl_warehouse_issue.invoice_id')
                ->join('tbl_retailer_order', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                ->join('tbl_staff', 'tbl_staff.id', '=', 'tbl_retailer_order.sales_officer_id');
        if ($request->state != "all") {
            $query->where(['tbl_city.state_id' => $request->state]);
        }
        if ($request->city != "all" && $request->city != null) {
            $query->where(['tbl_retailer_outlet.city_id' => $request->city]);
        }
        if ($request->locality != "all" && $request->locality != null) {
            $query->where(['tbl_region.id' => $request->locality]);
        }
        if ($request->sales_officer != "all" && $request->sales_officer != "") {
            $query->where(['tbl_retailer_order.sales_officer_id' => $request->sales_officer]);
        }
        if ($request->customer != "") {
            $query->where(['tbl_retailer_outlet.id' => $request->customer]);
        }
        if ($request->fdate != "" && $request->tdate != "") {
            $from = date('Y-m-d H:i:s', strtotime($request->fdate . " 00:00:00"));
            $to = date('Y-m-d H:i:s', strtotime($request->tdate . " 23:59:59"));
            $query->whereRaw("tbl_main_warehouse_receive_item.activated_date > '$from' and tbl_main_warehouse_receive_item.activated_date < '$to'");
        } else {
            $query->where('activated_date', '!=', '');
        }
        $query->where('activated_date', '!=', '');
        $query = $query->get();
        if (sizeof($query)) {
            $query = $this->multisort($this->object_to_array($query), 'outlet_id');
            for ($i = 0; $i < sizeof($query); $i++) {
                if ($count == 0) {
                    $outlet_id = $query[$i]['outlet_id'];
                    $count++;
                }
                if ($query[$i]['outlet_id'] == $outlet_id) {
                    $data[$index][$temp_count] = $query[$i];
                    $temp_count++;
                } else {
                    --$i;
                    $count = 0;
                    $index++;
                    $temp_count = 1;
                }
            }
            return $this->activation_sort_model($data);
        }
    }

    public function activation_sort_model($data) {
        $data_sort = [];
        $count = 0;
        $result = [];
        $p_name = null;
        for ($i = 0; $i < sizeof($data); $i++) {
            $data_sort[$i] = $this->multisort($this->object_to_array($data[$i]), 'p_name');
        }
        for ($j = 0; $j < sizeof($data_sort); $j++) {
            $index = 0;
            $i_count = 0;
            $total = 0;
            for ($i = 0; $i < sizeof($data_sort[$j]); $i++) {
                if ($count == 0) {
                    $p_name = $data_sort[$j][$i]['p_name'];
                    $index++;
                    $count++;
                }
                if ($p_name == $data_sort[$j][$i]['p_name']) {
                    $i_count++;
                    if ($index <= 0) {
                        $index++;
                    }
                    $total++;
                    $result[$j]['pro'][$index][$i_count] = $data_sort[$j][$i];
                    $result[$j]['total'] = $total;
                } else {
                    --$i;
                    $count = 0;
                    $i_count = 0;
                }
            }
        }
        // return $result;
        return $this->activation_sort_total($result);
    }

    public function activation_sort_total($data) {
        $result = [];
        $total = 0;
        for ($i = 0; $i < sizeof($data); $i++) {
            for ($j = 1; $j <= sizeof($data[$i]['pro']); $j++) {
                $result[$i]['outlet']['city_name'] = $data[$i]['pro'][$j][1]['city_name'];
                $result[$i]['outlet']['retailer_no'] = $data[$i]['pro'][$j][1]['retailer_no'];
                $result[$i]['outlet']['outlet_name'] = $data[$i]['pro'][$j][1]['outlet_name'];
                $result[$i]['outlet']['region_name'] = $data[$i]['pro'][$j][1]['region_name'];
                $result[$i]['outlet']['outlet_id'] = $data[$i]['pro'][$j][1]['outlet_id'];
                $result[$i]['outlet']['outlet_address'] = $data[$i]['pro'][$j][1]['outlet_address'];
                //$result[$i]['products'][$data[$i]['pro'][$j][1]['p_name']]['model'] = $data[$i]['pro'][$j][1]['p_name'];
                $total += $result[$i]['products'][$data[$i]['pro'][$j][1]['p_name']] = sizeof($data[$i]['pro'][$j]);
                $result[$i]['outlet']['total'] = $data[$i]['total'];
            }
        } //return $result;
        return ['status' => true, 'data' => $result, 'total' => $total];
    }

    public function get_sale_return(Request $request) {
        $count = 0;
        $index = 0;
        $outlet_id = null;
        $temp_count = 0;
        $data = [];
        $query = DB::table('tbl_warehouse_issue_return')
                        ->join('tbl_invoice', 'tbl_invoice.id', '=', 'tbl_warehouse_issue_return.invoice_id')
                        ->join('tbl_retailer_order', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                        ->join('tbl_retailer_outlet', 'tbl_retailer_outlet.id', '=', 'tbl_retailer_order.outlet_id')
                        ->join('tbl_item', 'tbl_item.id', '=', 'tbl_warehouse_issue_return.item_id')
                        ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_item.product_color_id')
                        ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_color.product_id')
                        ->join('tbl_city', 'tbl_city.id', '=', 'tbl_retailer_outlet.city_id')
                        ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id')
                        ->join('tbl_retailer', 'tbl_retailer.id', '=', 'tbl_retailer_outlet.retailer_id')
                        ->select('tbl_retailer_outlet.id as outlet_id', 'tbl_retailer_outlet.name AS outlet_name'
                                //, 'tbl_warehouse_issue_return.item_id'
                                , 'tbl_product.name AS pname', 'tbl_product_color.color'
                                //, 'tbl_product_color.id AS cid'
                                //, 'tbl_product.id AS pid'
                                , 'tbl_warehouse_issue_return.created_at as date'
                                , 'tbl_city.name as city_name', 'tbl_retailer.retailer_no', 'tbl_region.name as locality'
                                , 'tbl_retailer_outlet.address'
                        )->orderBy('outlet_name', 'asc')->orderBy('tbl_product_color.id', 'asc');
//        if ($request->state != "all") {
//            $query->where(['tbl_city.state_id' => $request->state]);
//        }
//        if ($request->city != "all" && $request->city != null) {
//            $query->where(['tbl_retailer_outlet.city_id' => $request->city]);
//        }
//        if ($request->locality != "all" && $request->locality != null) {
//            $query->where(['tbl_region.id' => $request->locality]);
//        }
//        if ($request->sales_officer != "all" && $request->sales_officer != "") {
//            $query->where(['tbl_retailer_order.sales_officer_id' => $request->sales_officer]);
//        }
//        if ($request->customer != "") {
//            $query->where(['tbl_retailer_outlet.id' => $request->customer]);
//            
//        }
        //   if ($request->fdate != "" && $request->tdate != "") {
        $from = date('Y-m-d H:i:s', strtotime('2018-10-01' . " 00:00:00"));
        $to = date('Y-m-d H:i:s', strtotime('2018-10-31' . " 23:59:59"));
        $query->whereRaw("tbl_warehouse_issue_return.created_at > '$from' and tbl_warehouse_issue_return.created_at < '$to'");
        //    }
        $query = $query->get();


        for ($i = 0; $i < sizeof($query); $i++) {
            if ($count == 0) {
                $outlet_id = $query[$i]->outlet_id;
                $count++;
                $data[$index]['outlet']['id'] = $query[$i]->outlet_id;
                $data[$index]['outlet']['name'] = $query[$i]->outlet_name;
                $data[$index]['outlet']['city_name'] = $query[$i]->city_name;
                $data[$index]['outlet']['retailer_no'] = $query[$i]->retailer_no;
                $data[$index]['outlet']['locality'] = $query[$i]->locality;
                $data[$index]['outlet']['address'] = $query[$i]->address;
            }
            if ($query[$i]->outlet_id == $outlet_id) {
                $data[$index]['outlet']['items'][$temp_count]['pname'] = $query[$i]->pname;
                $data[$index]['outlet']['items'][$temp_count]['color'] = $query[$i]->color;
                $temp_count++;
            } else {
                --$i;
                $count = 0;
                $index++;
                $temp_count = 0;
            }
        }

        return $this->sale_return_products_sort($data);
    }

    public function sale_return_products_sort($data) {
        //return $data;

        $count = 0;
        $index = 0;
        $outlet_id = null;
        $temp_count = 0;
        $sort = [];
        $product_index = 0;
        for ($i = 0; $i < sizeof($data); $i++) {
            $item = $this->multisort($this->object_to_array($data[$i]['outlet']['items']), 'pname');
            $sort[$index]['outlet'] = $data[$i]['outlet']['name'];
            $sort[$index]['city_name'] = $data[$i]['outlet']['city_name'];
            $sort[$index]['retailer_no'] = $data[$i]['outlet']['retailer_no'];
            $sort[$index]['locality'] = $data[$i]['outlet']['locality'];
            $sort[$index]['address'] = $data[$i]['outlet']['address'];
            $sort[$index]['total'] = sizeof($item);
            for ($j = 0; $j < sizeof($item); $j++) {
                if ($count == 0) {
                    $outlet_id = $item[$j]['pname'];
                    $count++;
                    $product_index++;
                }
                if ($item[$j]['pname'] == $outlet_id) {
                    $sort[$index]['item'][$product_index]['pname'] = $item[$j]['pname'];
                    $sort[$index]['item'][$product_index]['color'][$temp_count] = $item[$j]['color'];
                    $temp_count++;
                } else {
                    --$j;
                    $count = 0;
                    $temp_count = 0;
                }
            }
            $index++;
            $product_index = 0;
            $temp_count = 0;
            $outlet_id = null;
        }
        return $this->sale_return_color_sort($sort);
    }

    public function sale_return_color_sort($data) {
        // return $data;
        $count = 0;
        $index = 0;
        $outlet_id = null;
        $temp_count = 0;
        $sort = [];
        $product_index = 0;
        $color_total = [];
        $total = 0;
        for ($i = 0; $i < sizeof($data); $i++) {
            $sort[$index]['outlet'] = $data[$i]['outlet'];
            $sort[$index]['city_name'] = $data[$i]['city_name'];
            $sort[$index]['retailer_no'] = $data[$i]['retailer_no'];
            $sort[$index]['locality'] = $data[$i]['locality'];
            $sort[$index]['address'] = $data[$i]['address'];
            $sort[$index]['total'] = $data[$i]['total'];
            $total += $data[$i]['total'];
            for ($j = 1; $j <= sizeof($data[$index]['item']); $j++) {
                $sort[$index]['item'][$j]['pname'] = $data[$index]['item'][$j]['pname'];
                $color_index = 0;
                $color_lenth = sizeof($data[$index]['item'][$j]['color']) - 1;
                for ($k = 0; $k < sizeof($data[$index]['item'][$j]['color']); $k++) {
                    if ($count == 0) {
                        $outlet_id = $data[$index]['item'][$j]['color'][$k];
                        $count++;
                        $product_index++;
                        $color_index++;
                    }
                    if ($data[$index]['item'][$j]['color'][$k] == $outlet_id) {
                        $sort[$index]['item'][$j]['color'][$color_index]['color'] = $data[$index]['item'][$j]['color'][$k];
                        $color_total[$temp_count] = $data[$index]['item'][$j]['color'][$k];
                        $temp_count++;
                        if ($color_lenth == $k) {
                            $sort[$index]['item'][$j]['color'][$color_index]['units'] = sizeof($color_total);
                            $color_total = [];
                        }
                    } else {
                        if (sizeof($color_total) != 0) {
                            $sort[$index]['item'][$j]['color'][$color_index]['units'] = sizeof($color_total);
                            $color_total = [];
                        }
                        --$k;
                        $count = 0;
                        $temp_count = 0;
                    }
                }
                $product_index = 0;
                // $temp_count = 0;
                $outlet_id = null;
            }
            $index++;
        }

        return ['status' => true, 'data' => $sort, 'total' => $total];
    }

    public function create_month() {
        $month = [];
        for ($i = 1; $i <= 31; $i++) {
            $month[$i] = "";
        }
        return $month;
    }

    public function create_month_numeric() {
        $month = [];
        for ($i = 1; $i <= 31; $i++) {
            $month[$i] = 0;
        }
        return $month;
    }

    public function object_to_array($data) {
        return collect($data)->map(function($x) {
                    return (array) $x;
                })->toArray();
    }

    public function multisort($outlet, $sortby) {
        $sortArray = array();
        foreach ($outlet as $outlet_value) {
            foreach ($outlet_value as $key => $value) {
                if (!isset($sortArray[$key])) {
                    $sortArray[$key] = array();
                }
                $sortArray[$key][] = $value;
            }
        }
        $orderby = $sortby;
        array_multisort($sortArray[$orderby], SORT_ASC, $outlet);
        return $outlet;
    }

    public function get_cities($state_id) {
        return City::where(['state_id' => $state_id])->get();
    }

    public function get_states() {
        return State::all();
    }

    public function get_customer($id, $column, $state_id) {
        if ($column == "city_id" || $column == "region_id") {
            if ($id != "all") {
                $data = RetailerOutlet::where([$column => $id])->get();
            } else {
                if ($state_id != "all") {
                    $cities = City::where(['state_id' => $state_id])->select('id')->get();
                    $data = RetailerOutlet::whereIn('city_id', $cities)->get();
                } else {
                    $data = RetailerOutlet::all();
                }
            }
            if (sizeof($data) != 0) {
                return ['status' => true, 'data' => $data];
            } else {
                return ['status' => false];
            }
        }
    }

    public function get_region($city_id) {
        $region = Region::where('city_id', '=', $city_id)->get();
        if (sizeof($region) != 0) {
            return ['status' => true, 'region' => $region];
        } else {
            return ['status' => false];
        }
    }

    public function get_sales_officer($city_id, $state_id) {
        $data = DB::table('tbl_warehouse_staff')
                ->select('tbl_staff.id', 'tbl_staff.name')
                ->join('tbl_staff', 'tbl_staff.id', '=', 'tbl_warehouse_staff.staff_id')
                ->where(['tbl_staff.staff_type_id' => 5]);
        if ($city_id != "all") {
            $data->where(['tbl_staff.city_id' => $city_id]);
        }
        if ($city_id == "all" && $state_id != "all") {
            $cities = City::where(['state_id' => $state_id])->select('id')->get();
            $data->whereIn('tbl_staff.city_id', $cities);
        }
        $data = $data->get();
        if (sizeof($data) != 0) {
            return ['status' => true, 'data' => $data];
        } else {
            return ['status' => false];
        }
    }

    function excel() {
        $customer_data = DB::table('tbl_product')->get()->toArray();
        $customer_array[] = array('Name', 'Id');
        foreach ($customer_data as $customer) {
            $customer_array[] = array(
                'Name' => $customer->name,
                'Id' => $customer->id,
            );
        }
//   return $customer_array;
        Excel::create('report', function($excel) use ($customer_array) {
            $excel->setTitle('report');
            $excel->sheet('report', function($sheet) use ($customer_array) {
                $sheet->fromArray($customer_array, null, 'A1', false, false);
            });
        })->export('xlsx');


//     Excel::create('asd',function($excel){
//       $excel->sheet('asd',function($sheet){
//          $sheet->loadView('excell');
//        //  $sheet->setOrientation('landscape');
//       });  
//     })->export('xlsx');
    }

}
