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
use App\WarehouseStock;
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
use App\WarehouseIssueReturn;
use App\Ledger;
use App\InvoiceProduct;
use App\RetailerCollectionDS;
use App\Http\Controllers\ReportsController;

class RetailerInvoiceController extends Controller {

    public function index() {
        return view('retailerInvoiceList');
    }

    public function invoice_reverse_list() {
        return view('retailerReverseList');
    }

    public function get_invoice(Request $request) {
        $userId = Auth::user()->staff_id;
        $warehouse_details = warehouseStaff::with('warehouse')->where('staff_id', $userId)->get();
        $warehouse_id = $warehouse_details[0]['warehouse']['id'];
        if ($request->input('client')) {
            return $invoice_list = RetailerInvoice::with(
                            'payment_type'
                            , 'RetailerOrder.retailer_outlet.retailer'
                            , 'RetailerOrder'
                            , 'warehouse_issue'
				   , 'RetailerOrder.retailer_outlet.city'
                            , 'RetailerOrder.retailer_outlet.region'
                            , 'RetailerOrder.sales_officer'
                    )
				/*
				->WhereHas('RetailerOrder', function ( $q ) use ($warehouse_id) {
                        $q->Where('warehouse_id', $warehouse_id);
                    })*/
                    ->where('is_invoice', '!=', 4)
                    ->get();
        }
        $columns = ['order_id', 'invoice_no', 'total_amount'];
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $query = RetailerInvoice::with(
                        'payment_type'
                        , 'RetailerOrder.retailer_outlet.retailer'
                        , 'RetailerOrder'
                        , 'warehouse_issue'
			   , 'RetailerOrder.retailer_outlet.city'
                            , 'RetailerOrder.retailer_outlet.region'
                            , 'RetailerOrder.sales_officer'
                )
			/*
			->WhereHas('RetailerOrder', function ( $q ) use ($warehouse_id) {
                    $q->Where('warehouse_id', $warehouse_id);
                })*/
                ->where('is_invoice', '!=', 4)
                ->orderBy($columns[$column], $dir);
        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('invoice_no', 'like', '%' . $searchValue . '%')
                        ->orWhere('total_amount', 'like', '%' . $searchValue . '%')
                        ->orWhereHas('RetailerOrder', function ( $q ) use ($searchValue) {
                            $q->Where('order_no', 'like', '%' . $searchValue . '%');
                        })
                        ->orWhereHas('RetailerOrder.retailer_outlet', function ( $q ) use ($searchValue) {
                            $q->Where('name', 'like', '%' . $searchValue . '%');
                        })
                        ->orWhereHas('RetailerOrder.retailer_outlet.retailer', function ( $q ) use ($searchValue) {
                            $q->Where('retailer_no', 'like', '%' . $searchValue . '%');
                        })
					  ->orWhereHas('RetailerOrder.retailer_outlet.city', function ( $q ) use ($searchValue) {
                            $q->Where('name', 'like', '%' . $searchValue . '%');
                        })
                        ->orWhereHas('RetailerOrder.retailer_outlet.region', function ( $q ) use ($searchValue) {
                            $q->Where('name', 'like', '%' . $searchValue . '%');
                        })
                        ->orWhereHas('RetailerOrder.sales_officer', function ( $q ) use ($searchValue) {
                            $q->Where('name', 'like', '%' . $searchValue . '%');
                        });
            });
        }
        $projects = $query->paginate($length);
        return ['data' => $projects, 'draw' => $request->input('draw')];
    }

    public function invoiceCreate($order_id) {
        return view('retailerInvoice', compact('order_id'));
    }

    /*
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
      'final_amount' => $request->total_amount,
      'description' => $request->decs,
      'created_by' => Auth::user()->id,
      ]);
      $invoice_id = $invoice->id;
      RetailerInvoice::where(['id' => $invoice_id])->update(['invoice_no' => $request->order_id_pattern . $this->make_number($invoice_id)]);
      for ($i = 0; $i < count($request->amount); $i++) {
      //    return $request;
      if ($request->productamount[$i] != 0) {
      $product[$i]['invoice_id'] = $invoice_id;
      $product[$i]['product_color_id'] = $request->colorid[$i];
      $product[$i]['product_qty'] = $request->quantity[$i];
      $product[$i]['product_price'] = $request->unitcost[$i];
      $product[$i]['total_amount'] = $request->productamount[$i];
      //  $product[$i]['final_amount'] = $request->productamount[$i];
      $product[$i]['created_by'] = Auth::user()->id;
      if ($request->qty_db[$i] <= $request->quantity[$i]) {
      RetailerOrderProduct::where(['id' => $request->product_id[$i]])->update(['is_delivered' => 1, 'remaining_qty' => 0]);
      } else {
      RetailerOrderProduct::where(['id' => $request->product_id[$i]])->update(['remaining_qty' => $request->qty_db[$i] - $request->quantity[$i]]);
      }
      }
      }
      $count_status = RetailerOrderProduct::where(['retailer_order_id' => $request->order_id, 'is_delivered' => 0])->count();
      if ($count_status == 0) {
      RetailerOrder::where(['id' => $request->order_id])->update(['is_delivered' => 1]);
      }
      RetailerInvoice_Products::insert($product);
      WarehouseIssue::create([
      'invoice_id' => $invoice_id,
      'invoice_no' => $request->order_id_pattern . $this->make_number($invoice_id),
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
      return ['message' => 'fail create invoice', 'Exception' => $ex];
      }
      }

     */

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
                        'final_amount' => $request->total_amount,
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
                    //  $product[$i]['final_amount'] = $request->productamount[$i];
                    $product[$i]['discount'] = $request->discount_percent[$i];
                    $product[$i]['created_by'] = Auth::user()->id;
                    if ($request->qty_db[$i] <= $request->quantity[$i]) {
                        RetailerOrderProduct::where(['id' => $request->product_id[$i]])->update(['is_delivered' => 1, 'remaining_qty' => 0]);
                    } else {
                        RetailerOrderProduct::where(['id' => $request->product_id[$i]])->update(['remaining_qty' => $request->qty_db[$i] - $request->quantity[$i]]);
                    }
                }
            }
            $count_status = RetailerOrderProduct::where(['retailer_order_id' => $request->order_id, 'is_delivered' => 0])->count();
            if ($count_status == 0) {
                RetailerOrder::where(['id' => $request->order_id])->update(['is_delivered' => 1]);
            }
            RetailerInvoice_Products::insert($product);
            WarehouseIssue::create([
                'invoice_id' => $invoice_id,
                'invoice_no' => $request->order_id_pattern . $this->make_number($invoice_id),
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
            return ['message' => 'fail create invoice', 'Exception' => $ex];
        }
    }

    public function invoice_reversal(Request $request) {
        if (date('Y-m-d') == date('Y-m-d', strtotime($request->created_date))) {
            $item = [];
            $item_insert = [];
            $stock = [];
            $product = [];
            try {
                DB::beginTransaction();
                $warehouse_issue_return = WarehouseIssueReturn::where(['invoice_id' => $request->invoice_id])->count();
                if ($warehouse_issue_return == 0) {
                    $invoice_items = DB::select("Select issue_items.item_id,warehouse_issue.warehouse_id from tbl_warehouse_issue warehouse_issue inner join tbl_warehouse_issue_items issue_items on issue_items.warehouse_issue_id=warehouse_issue.id where warehouse_issue.invoice_id=$request->invoice_id");
                    foreach ($invoice_items as $in_items) {
                        array_push($item, $in_items->item_id);
                        array_push($item_insert, ['item_id' => $in_items->item_id
                            , 'invoice_id' => $request->invoice_id
                            , 'warehouse_id' => $in_items->warehouse_id
                        ]);
                    }
                    DB::table('tbl_main_warehouse_receive_item')->whereIn('item_id', $item)->update(['is_sold' => 0, 'sold_to_outlet_id' => null]);
                    DB::table('tbl_warehouse_issue_return')->insert($item_insert);
                    DB::table('tbl_warehouse_issue_items')->whereIn('item_id', $item)->delete();
                    if ($request->warehouseissue == 1) {
                        $WarehouseIssueController = new WarehouseIssueController();
                        $WarehouseIssueController->inverseIssue($request->invoice_id);
                    }
                    RetailerInvoice::where(['id' => $request->invoice_id])->update(['is_invoice' => 3, 'is_pay' => 3, 'updated_by' => Auth::user()->id]);
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
                    RetailerInvoice::where(['id' => $invoice_id])->update(['is_invoice' => 2, 'invoice_no' => $request->order_id_pattern . $this->make_number($invoice_id)]);
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
                    Ledger::create(['invoice_id' => $invoice_id, 'TransDate' => date('Y-m-d H:i:s'), 'is_reverse' => 1,
                        'description' => "invoice  (" . $request->order_id_pattern . $this->make_number($request->invoice_id) . ") Reversed", 'Collection' => $request->total_amount,
                        'retailer_id' => $request->retailer_id]);
                    Ledger::where(['invoice_id' => $request->invoice_id])->update(['is_reverse' => 1]);
                    if ($request->warehouseissue == 1) {
                        for ($j = 0; $j < sizeof($product); $j++) {
                            $add_qty = $product[$j]['product_qty'];
                            $current = WarehouseStock::where(['product_color_id' => $product[$j]['product_color_id']
                                        , 'warehouse_id' => $item_insert[0]['warehouse_id']])->select('product_qty')->first();
                            $add_qty += $current['product_qty'];
                            WarehouseStock::where(['product_color_id' => $product[$j]['product_color_id']
                                        , 'warehouse_id' => $item_insert[0]['warehouse_id']])
                                    ->update(['product_qty' => $add_qty]);
                        }
                    }
                    DB::commit();
                    return 201;
                } else {
                    return [401];
                }
            } catch (Exception $ex) {
                DB::rollBack();
                return ['message' => 'fail create invoice', 'Exception' => $ex];
            }
        } else {
            return ['status' => false];
        }
    }

    public function get_aging_outstanding($outlet_id) {
        $data['aging'] = $this->outlet_aging($outlet_id);
        $data['outstanding'] = $this->retailer_ledger_balance($outlet_id);
        return $data;
    }

    public function outlet_aging($outlet_id) {
        $aging_total_amount = 0;
        $aging_paid = 0;
        $query = DB::table('tbl_retailer_outlet')
                ->select('tbl_retailer_outlet.credit_duration'
                        , 'tbl_invoice.total_amount', 'tbl_invoice.paid'
                        , 'tbl_invoice.created_at as invoice_created_date')
                ->join('tbl_retailer_order', 'tbl_retailer_outlet.id', '=', 'tbl_retailer_order.outlet_id')
                ->join('tbl_invoice', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id');
        $query->where(['tbl_retailer_outlet.id' => $outlet_id]);
        $query = $query->whereNotIn('tbl_invoice.is_pay', [1, 3])
                        ->whereNotIn('tbl_invoice.is_invoice', [2, 3])->orderBy('tbl_invoice.order_id')->get();
        for ($i = 0; $i < sizeof($query); $i++) {
            if (date('Y-m-d', strtotime(date('Y-m-d'))) >= date('Y-m-d', strtotime($query[$i]->invoice_created_date . " + " . $query[$i]->credit_duration . " days"))) {
                $aging_total_amount += $query[$i]->total_amount;
                $aging_paid += $query[$i]->paid;
            }
        }
        if ($aging_total_amount - $aging_paid > 0) {
            return ['aging' => $aging_total_amount - $aging_paid];
        } else {
            return ['aging' => 0];
        }
    }

    public function retailer_ledger_balance($outlet_id) {
        $ledgerData = DB::select('SELECT 
                                        SUM(
                                            COALESCE(y.Credit, 0) - COALESCE(y.Collection, 0)
                                          ) AS Outstanding 
                                        FROM
                                          tbl_ledger X
                                        INNER JOIN tbl_ledger Y
                                        ON y.TransDate <= x.TransDate                                            
                                        WHERE x.`retailer_id` = ' . $outlet_id . ' AND y.`retailer_id` = ' . $outlet_id . '
                                        GROUP BY x.TransDate,
                                          x.Credit,
                                          x.Collection,
                                          x.description,
                                          x.invoice_id,
                                          x.collection_id,
                                          x.retailer_id 
						ORDER BY x.TransDate DESC
						LIMIT 1
                                          ');
        if ($ledgerData) {
            return $ledgerData[0];
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
                    'RetailerOrder.sales_officer',
                    'warehouse_issue' => function($q) {
                        $q->where('is_issued', 1);
                    },
                    'warehouse_issue.warehouseIssueItem.item.productColor.product',
                    'warehouse_issue.warehouseIssueItem.item.imei'
                ])->where(['id' => $id])->first();
    }

    public function order_imei_details($id) {
        $count = 0;
        $product_id = null;
        $product_name = null;
        $data = [];
        $records_array = [];
        $object = new ReportsController();
        $records = RetailerInvoice::with([
                    'RetailerOrder.retailer_outlet',
                    'RetailerOrder.retailer_outlet.retailer',
                    'RetailerOrder.retailer_outlet.city',
                    'RetailerOrder.retailer_outlet.region',
                    'warehouse_issue' => function($q) {
                        $q->where('is_issued', 1);
                    },
                    'warehouse_issue.warehouseIssueItem.item.productColor.product',
                    'warehouse_issue.warehouseIssueItem.item.imei'
                ])->where(['id' => $id])->first();
        $records_array = $object->object_to_array($records);
        if ($records != "") {
            $records_sort = $object->object_to_array($records['warehouse_issue'][0]);
            $size = sizeof($records_sort['warehouse_issue_item']) - 1;
            $records_sort['total_unit'] = sizeof($records_sort['warehouse_issue_item']);
            for ($i = 0; $i < sizeof($records_sort['warehouse_issue_item']); $i++) {
                if ($count == 0) {
                    $product_id = $records_sort['warehouse_issue_item'][$i]['item']['product_color']['product']['id'];
                    $product_name = $records_sort['warehouse_issue_item'][$i]['item']['product_color']['product']['name'];
                    $count++;
                }
                if ($records_sort['warehouse_issue_item'][$i]['item']['product_color']['product']['id'] == $product_id) {
                    $data['products'][$product_name][$i]['color'] = $records_sort['warehouse_issue_item'][$i]['item']['product_color']['color'];
                    $data['products'][$product_name][$i]['productname'] = $records_sort['warehouse_issue_item'][$i]['item']['product_color']['product']['name'];
                    $data['products'][$product_name][$i]['imei1'] = $records_sort['warehouse_issue_item'][$i]['item']['imei'][0]['imei1'];
                    if ($i == $size) {
                        $data['products'][$product_name][$i]['color'] = $records_sort['warehouse_issue_item'][$i]['item']['product_color']['color'];
                        $data['products'][$product_name][$i]['productname'] = $records_sort['warehouse_issue_item'][$i]['item']['product_color']['product']['name'];
                        $data['products'][$product_name][$i]['imei1'] = $records_sort['warehouse_issue_item'][$i]['item']['imei'][0]['imei1'];
                    }
                } else {
                    --$i;
                    $count = 0;
                }
            }
            $data['invoice'] = $records['invoice_no'];
            $data['outlet_name'] = $records_array['retailer_order']['retailer_outlet']['name'];
            $data['address'] = $records_array['retailer_order']['retailer_outlet']['address'];
            $data['retailer_no'] = $records_array['retailer_order']['retailer_outlet']['retailer']['retailer_no'];
            $data['name_city'] = $records_array['retailer_order']['retailer_outlet']['city']['name'];
            $data['region'] = $records_array['retailer_order']['retailer_outlet']['region']['name'];
            $data['total_unit'] = $records_sort['total_unit'];
            return $this->sort_color($data);
        } else {
            return ['status' => false];
        }
    }

    public function sort_color($data) {
        $object = new ReportsController();
        $count = 0;
        $index = 0;
        $data_sort = null;
        $color_index = 0;
        $result['invoice'] = $data['invoice'];
        $result['outlet_name'] = $data['outlet_name'];
        $result['address'] = $data['address'];
        $result['retailer_no'] = $data['retailer_no'];
        $result['name_city'] = $data['name_city'];
        $result['region'] = $data['region'];
        $result['total_unit'] = $data['total_unit'];
        $color = "";
        foreach ($data['products'] as $value) {
            $data_sort[$index++] = $object->multisort($object->object_to_array($value), 'color');
        }
        for ($i = 0; $i < sizeof($data_sort); $i++) {
            for ($j = 0; $j < sizeof($data_sort[$i]); $j++) {
                if ($count == 0) {
                    $color = $data_sort[$i][$j]['color'];
                    $count++;
                    $color_index++;
                }
                if ($data_sort[$i][$j]['color'] == $color) {
                    $result['products'][$i]['name'] = $data_sort[$i][$j]['productname'];
                    $result['products'][$i]['imei_details'][$color_index]['color'] = $color;
                    $result['products'][$i]['imei_details'][$color_index]['imei_no'][$j + 1] = $data_sort[$i][$j]['imei1'];
                } else {
                    --$j;
                    $count = 0;
                    $color = "";
                }
            }
            $color_index = 1;
        }
        if (sizeof($result) >= 1) {
            return ['status' => true, 'data' => $result];
        } else {
            return ['status' => false];
        }
    }

    public function order_imei_return_details($id) {
        $count = 0;
        $data = [];
        $product_name = null;
        $index = 0;
        $sno = 0;
        $total = 0;
        $query = DB::table('tbl_invoice')
                        ->join('tbl_warehouse_issue_return', 'tbl_warehouse_issue_return.invoice_id', '=', 'tbl_invoice.id')
                        ->join('tbl_imei', 'tbl_imei.item_id', '=', 'tbl_warehouse_issue_return.item_id')
                        ->join('tbl_product', 'tbl_product.id', '=', 'tbl_imei.product_id')
                        ->join('tbl_item', 'tbl_item.id', '=', 'tbl_warehouse_issue_return.item_id')
                        ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_item.product_color_id')
                        ->join('tbl_retailer_order', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                        ->join('tbl_retailer_outlet', 'tbl_retailer_outlet.id', '=', 'tbl_retailer_order.outlet_id')
                        ->join('tbl_retailer', 'tbl_retailer.id', '=', 'tbl_retailer_outlet.retailer_id')
                        ->join('tbl_city', 'tbl_city.id', '=', 'tbl_retailer_outlet.city_id')
                        ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id')
                        ->where(['tbl_invoice.id' => $id])
                        ->select('tbl_invoice.invoice_no', 'tbl_retailer.retailer_no', 'tbl_imei.imei1'
                                //, 'tbl_imei.imei2'
                                , 'tbl_product.name as pname', 'tbl_product_color.color'
                                , 'tbl_retailer_outlet.name as outlet_name', 'tbl_retailer_outlet.address'
                                , 'tbl_city.name as city_name', 'tbl_region.name as region_name')
                        ->orderBy('tbl_product.id', 'asc')->orderBy('tbl_product_color.id', 'asc')->get();
        if (sizeof($query) > 0) {
            $total = sizeof($query);
            $size = sizeof($query) - 1;
            for ($i = 0; $i < sizeof($query); $i++) {
                if ($count == 0) {
                    $product_name = $query[$i]->pname;
                    $count++;
                }
                if ($product_name == $query[$i]->pname) {
                    $data[$index][$sno++] = $query[$i];
                } else {
                    --$i;
                    $count = 0;
                    $index++;
                    $sno = 0;
                }
            }
            return $this->sales_return_sort_color($data,$total);
        } else {
            return ['status' => false];
        }
    }

    public function sales_return_sort_color($query,$total) {  
        $count = 0;
        $data = [];
        $product_color = null;
        $index = 0;
        $sno = 0;
        $pro_sno = 1;
        $data['outlet_details']['outlet_name'] = $query[0][0]->outlet_name;
        $data['outlet_details']['address'] = $query[0][0]->address;
        $data['outlet_details']['city_name'] = $query[0][0]->city_name;
        $data['outlet_details']['region_name'] = $query[0][0]->region_name;
        $data['outlet_details']['retailer_no'] = $query[0][0]->retailer_no;
        $data['outlet_details']['invoice_no'] = $query[0][0]->invoice_no;
        for ($i = 0; $i < sizeof($query); $i++) {
            for ($j = 0; $j < sizeof($query[$i]); $j++) {
                if ($count == 0) {
                    $product_color = $query[$i][$j]->color;
                    $count++;
                    $index++;
                    $data['products'][$pro_sno]['product']['product_name'] = $query[$i][$j]->pname;
                }
                if ($product_color == $query[$i][$j]->color) {
                    $data['products'][$pro_sno]['product']['list'][$index]['color'] = $query[$i][$j]->color;
                    $data['products'][$pro_sno]['product']['list'][$index]['imeis'][$sno++]['imei1'] = $query[$i][$j]->imei1;
                } else {
                    --$j;
                    $count = 0;
                    $sno = 0;
                }
            }
            $pro_sno++;
            $index = 0;
        }
        return ['status' => true, 'data' => $data,'total'=>$total];
    }

    public function print_invoice() {
        return view('retailerInvoicePrint');
    }

    public function print_invoice_imei() {
        return view('retailerInvoice_Imei_Print');
    }

    public function print_invoice_imei_return() {
        return view('retailerInvoice_Imei_Return_Print');
    }

    public function generate_invoice($id) {
        $warehouse_details = DB::table('tbl_staff')
                        ->join('tbl_warehouse_staff', 'tbl_warehouse_staff.staff_id', '=', 'tbl_staff.id')
                        ->join('tbl_warehouse', 'tbl_warehouse.id', '=', 'tbl_warehouse_staff.warehouse_id')
                        ->select('tbl_staff.id', 'tbl_staff.name', 'tbl_warehouse.phone_no', 'tbl_warehouse.address')
                        ->where(['tbl_staff.id' => Auth::user()->staff_id])->first();
        $data = DB::table('tbl_invoice')
                ->join('tbl_invoice_products', 'tbl_invoice_products.invoice_id', '=', 'tbl_invoice.id')
                ->join('tbl_retailer_order', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_invoice_products.product_color_id')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_color.product_id')
                ->join('tbl_retailer', 'tbl_retailer.id', '=', 'tbl_retailer_order.retailer_id')
                ->join('tbl_retailer_outlet', 'tbl_retailer_outlet.id', '=', 'tbl_retailer_order.outlet_id')
                ->join('tbl_city', 'tbl_city.id', '=', 'tbl_retailer_outlet.city_id')
                ->join('tbl_region', 'tbl_region.id', '=', 'tbl_retailer_outlet.region_id')
                ->select('tbl_invoice.invoice_no', 'tbl_invoice.final_amount as invoice_total_amount', 'tbl_invoice_products.product_qty'
                        , 'tbl_invoice_products.product_price', 'tbl_invoice_products.discount', 'tbl_invoice_products.total_amount as invoice_product_total_amount'
                        , 'tbl_product_color.color', 'tbl_product.name as product_name'
                        , 'tbl_retailer.retailer_no', 'tbl_city.name as city_name', 'tbl_region.name as region_name'
                        , 'tbl_retailer_outlet.address', 'tbl_retailer_outlet.id as outlet_id'
                        , 'tbl_retailer_outlet.name as outlet_name'
                        , 'tbl_retailer_outlet.phone_no', 'tbl_retailer_outlet.credit_duration'
                        , 'tbl_retailer_order.order_no', 'tbl_invoice.created_at')
                ->where(['tbl_invoice.id' => $id])->orderBy('tbl_product.id', 'desc')
                ->get();
        $balance['aging'] = $this->outlet_aging($data[0]->outlet_id);
        $balance['outstanding'] = $this->retailer_ledger_balance($data[0]->outlet_id);
        return ['data' => $data, 'warehouse_details' => $warehouse_details, 'balance' => $balance];
    }

    public function invoice_reverse($id) {
        return $records = RetailerInvoice::with([
                    'invoice_Products.productColor.product'
                    , 'RetailerOrder.retailer_outlet.city'
                    , 'RetailerOrder.retailer_outlet.region'
                    , 'warehouse_issue'
                ])->where(['id' => $id])->first();
    }

    public function reversal($id) {
        return view('retailerInvoiceReversal');
    }

    public function get_invoice_by_retailer(Request $request) {
        $outlet_id = $request->input('selected_invoice_retailer_outlet_id');
        $records = RetailerInvoice::with('RetailerOrder.retailer', 'RetailerOrder.retailer_outlet')->whereHas('RetailerOrder.retailer_outlet', function($q) use ($outlet_id) {
                    $q->where('id', $outlet_id);
                })->get();
        return Response::json($records);
    }

    public function get_outlet_outstanding_invoices($deposit_slip, $outlet_id, $sales_officer_id) {
        if (RetailerCollectionDS::where('deposit_slip_number', $deposit_slip)->exists()) {
            return 409;
        } else {
            if ($sales_officer_id == 0) {
                $data = DB::select("Select r_order.order_no as order_no,invoice.invoice_no as invoice_no, invoice.id as invoice_id, r_order.id as order_id, invoice.total_amount as invoice_total_amount, invoice.paid as invoice_paid_amount from tbl_invoice invoice inner join tbl_retailer_order r_order on r_order.id=invoice.order_id where r_order.outlet_id= $outlet_id AND invoice.is_pay!=1");
                return $data;
            } else {
                $data = DB::select("Select r_order.order_no as order_no,invoice.invoice_no as invoice_no, invoice.id as invoice_id, r_order.id as order_id, invoice.total_amount as invoice_total_amount, invoice.paid as invoice_paid_amount from tbl_invoice invoice inner join tbl_retailer_order r_order on r_order.id=invoice.order_id where r_order.outlet_id= $outlet_id AND r_order.sales_officer_id=$sales_officer_id AND invoice.is_pay!=1");
                return $data;
            }
        }
    }

}
