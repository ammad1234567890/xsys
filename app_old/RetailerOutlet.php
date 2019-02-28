<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Http\Controllers\RetailerInvoiceController;
use App\Http\Controllers\ReportsController;

class RetailerOutlet extends Model {

    //
    protected $table = "tbl_retailer_outlet";
    protected $fillable = ['retailer_id',
        'city_id', 'region_id', 'name',
        'latitude', 'longitude', 'address',
        'phone_no', 'business_person_name', 'mobile_no',
        'business_person_cnic', 'security_deposit_amount', 'security_deposit_image',
        'credit_limit', 'credit_duration', 'credit_remaining',
        'sales_officer_id',
        'aging_amount', 'is_deleted', 'created_by',
        'updated_by'];

    public function __construct() {
        $this->retailer_invoice = new RetailerInvoiceController();
        $this->reports = new ReportsController();
    }

    public function retailer() {
        return $this->belongsTo('App\Retailer');
    }

    public function city() {
        return $this->belongsTo('App\City');
    }

    public function region() {
        return $this->belongsTo('App\Region');
    }

    public function sales_officer(){
        return $this->belongsTo("App\Staff", "sales_officer_id");
    }

    public function retailer_order() {
        // return $this->hasMany('App\RetailerOrder','outlet_id');
        return $this->hasMany('App\RetailerOrder');
    }

    public function dealer_dashboard($retailer_id) {
        $count = 0;
        $count_i = 0;
        $amount_day = 0;
        $day_total = 0;
        $amount = null;
        $date = null;
        $sales_date = null;
        $sales_data = [];
        $sales_data_sort = [];
        $outlet_id = DB::table('tbl_retailer_outlet')
                        ->select('id')
                        ->where(['retailer_id' => $retailer_id])->first();
        $activate = DB::table('tbl_main_warehouse_receive_item')
                        ->where(['sold_to_outlet_id' => $outlet_id->id, 'item_is_activate' => 1])->count();
        $ledger = DB::table('tbl_ledger')
                        ->select('Collection', 'Credit')
                        ->where(['retailer_id' => $outlet_id->id, 'is_reverse' => 0])
                        ->orderBy('created_at', 'desc')->take(20)->get();
        $from = date('Y-m-d H:i:s', strtotime(date('Y-m') . "-1 00:00:00"));
        $to = date('Y-m-d H:i:s', strtotime(date('Y-m-t') . " 23:59:59"));
        $sales = DB::table('tbl_main_warehouse_receive_item')
                ->select('tbl_product_color.price', 'tbl_main_warehouse_receive_item.activated_date')
                ->join('tbl_item', 'tbl_item.id', '=', 'tbl_main_warehouse_receive_item.item_id')
                ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_item.product_color_id')
                ->where('activated_date', '!=', null)
                ->where(['sold_to_outlet_id' => $outlet_id->id])
                ->whereRaw("tbl_main_warehouse_receive_item.activated_date > '$from' and tbl_main_warehouse_receive_item.activated_date < '$to'")
                ->get();
        $in_stock = DB::table('tbl_main_warehouse_receive_item')->where('activated_date', '=', null)
                        ->where(['sold_to_outlet_id' => $outlet_id->id])->count();
        if (sizeof($sales)) {
            $query = $this->reports->multisort($this->reports->object_to_array($sales), 'activated_date');
            $count_i = sizeof($query) - 1;
            for ($i = 0; $i < sizeof($query); $i++) {
                if ($count == 0) {
                    $sales_date = date('Y-m-d', strtotime($query[$i]['activated_date']));
                    $count++;
                }
                if (date('Y-m-d', strtotime($query[$i]['activated_date'])) == $sales_date) {
                    $day_total++;
                    $amount_day += $query[$i]['price'];
                    if ($i == $count_i) {
                        $date = date('d-m', strtotime($query[$i]['activated_date']));
                        $sales_data_sort['date'] = $date;
                        $sales_data_sort['day_total'] = $day_total;
                        $sales_data_sort['amount'] = $amount_day;
                        array_push($sales_data, $sales_data_sort);
                    }
                } else {
                    --$i;
                    $date = date('d-m', strtotime($query[$i]['activated_date']));
                    $sales_data_sort['date'] = $date;
                    $sales_data_sort['day_total'] = $day_total;
                    $sales_data_sort['amount'] = $amount_day;
                    array_push($sales_data, $sales_data_sort);
                    $count = 0;
                    $day_total = 0;
                    $amount_day = 0;
                }
            }
        }
        for ($i = 0; $i < sizeof($ledger); $i++) {
            if ($ledger[$i]->Collection != null) {
                $amount[$i] = '-' . number_format($ledger[$i]->Collection, 0, ',', ',');
            } else {
                $amount[$i] = number_format($ledger[$i]->Credit, 0, ',', ',');
            }
        }
        $outlet_aging = $this->retailer_invoice->outlet_aging($outlet_id->id);
        $outstanding = $this->retailer_invoice->retailer_ledger_balance($retailer_id);
        $data['sales'] = $sales_data;
        $data['ledger'] = $amount;
        $data['aging'] = number_format($outlet_aging['aging'], 0, ',', ',');
        if ($outstanding != "") {
            $data['outstanding'] = number_format($outstanding->Outstanding, 0, ',', ',');
        } else {
            $data['outstanding'] = "0";
        }
        $data['activation_count'] = $activate;
        $data['in_stock'] = $in_stock;
        return $data;


        $count = 0;
        $count_i = 0;
        $amount_day = 0;
        $day_total = 0;
        $date = null;
        $sales_date = null;
        $sales_data = [];
        $sales_data_sort = [];

        $outlet_id = DB::table('tbl_retailer_outlet')
                        ->select('id')
                        ->where(['retailer_id' => $retailer_id])->first();
        $activate = DB::table('tbl_main_warehouse_receive_item')
                        ->where(['sold_to_outlet_id' => $outlet_id->id, 'item_is_activate' => 1])->count();
        $ledger = DB::table('tbl_ledger')
                        ->select('Collection', 'Credit')
                        ->where(['retailer_id' => $retailer_id, 'is_reverse' => 0])
                        ->orderBy('created_at', 'desc')->take(20)->get();
        $from = date('Y-m-d H:i:s', strtotime(date('Y-m') . "-1 00:00:00"));
        $to = date('Y-m-d H:i:s', strtotime(date('Y-m') . "-31 23:59:59"));
        $sales = DB::table('tbl_main_warehouse_receive_item')
                ->select('tbl_product_color.price', 'tbl_main_warehouse_receive_item.activated_date')
                ->join('tbl_item', 'tbl_item.id', '=', 'tbl_main_warehouse_receive_item.item_id')
                ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_item.product_color_id')
                ->where('activated_date', '!=', null)
                ->where(['sold_to_outlet_id' => $retailer_id])
                ->whereRaw("tbl_main_warehouse_receive_item.activated_date > '$from' and tbl_main_warehouse_receive_item.activated_date < '$to'")
                ->get();
        $in_stock = DB::table('tbl_main_warehouse_receive_item')->where('activated_date', '=', null)
                        ->where(['sold_to_outlet_id' => $retailer_id])->count();
        if (sizeof($sales)) {
            $query = $this->reports->multisort($this->reports->object_to_array($sales), 'activated_date');
            $count_i = sizeof($query) - 1;
            for ($i = 0; $i < sizeof($query); $i++) {
                if ($count == 0) {
                    $sales_date = date('Y-m-d', strtotime($query[$i]['activated_date']));
                    $count++;
                }
                if (date('Y-m-d', strtotime($query[$i]['activated_date'])) == $sales_date) {
                    $day_total++;
                    $amount_day += $query[$i]['price'];
                    if ($i == $count_i) {
                        $date = date('d-m', strtotime($query[$i]['activated_date']));
                        $sales_data_sort['date'] = $date;
                        $sales_data_sort['day_total'] = $day_total;
                        $sales_data_sort['amount'] = $amount_day;
                        array_push($sales_data, $sales_data_sort);
                    }
                } else {
                    --$i;
                    $date = date('d-m', strtotime($query[$i]['activated_date']));
                    $sales_data_sort['date'] = $date;
                    $sales_data_sort['day_total'] = $day_total;
                    $sales_data_sort['amount'] = $amount_day;
                    array_push($sales_data, $sales_data_sort);
                    $count = 0;
                    $day_total = 0;
                    $amount_day = 0;
                }
            }
        }
        for ($i = 0; $i < sizeof($ledger); $i++) {
            if ($ledger[$i]->Collection != null) {
                $amount[$i] = '-' . number_format($ledger[$i]->Collection, 0, ',', ',');
            } else {
                $amount[$i] = number_format($ledger[$i]->Credit, 0, ',', ',');
            }
        }
        $outlet_aging = $this->retailer_invoice->outlet_aging($outlet_id->id);
        $outstanding = $this->retailer_invoice->retailer_ledger_balance($retailer_id);
        $data['sales'] = $sales_data;
        $data['ledger'] = $amount;
        $data['aging'] = number_format($outlet_aging['aging'], 0, ',', ',');
        $data['outstanding'] = number_format($outstanding->Outstanding, 0, ',', ',');
        $data['activation_count'] = $activate;
        $data['in_stock'] = $in_stock;
        return $data;
    }


	    public function dealer_activations($dealer_id) { 
        return DB::table('tbl_retailer')
                        ->join('tbl_retailer_outlet', 'tbl_retailer_outlet.retailer_id', '=', 'tbl_retailer.id')
                        ->join('tbl_main_warehouse_receive_item', 'tbl_main_warehouse_receive_item.sold_to_outlet_id', '=', 'tbl_retailer_outlet.id')
                        ->join('tbl_imei', 'tbl_imei.item_id', '=', 'tbl_main_warehouse_receive_item.item_id')
                        ->join('tbl_item', 'tbl_item.id', '=', 'tbl_imei.item_id')
                        ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_item.product_color_id')
                        ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_color.product_id')
                        ->select('tbl_product.name as model', 'tbl_product_color.color', 'tbl_imei.imei1', 'tbl_imei.imei2')
						->selectRaw("DATE_FORMAT(tbl_main_warehouse_receive_item.activated_date,'%d-%m-%y' ) as activated_date")
					   ->where(['tbl_retailer.id' => $dealer_id])
                        ->where('tbl_main_warehouse_receive_item.activated_date', '!=', null)
						->orderBy('tbl_main_warehouse_receive_item.activated_date','desc')
                        ->get();
    }
	
	    public function get_dealer_shelf($dealer_id) {
        return DB::table('tbl_retailer')
                        ->join('tbl_retailer_outlet', 'tbl_retailer_outlet.retailer_id', '=', 'tbl_retailer.id')
                        ->join('tbl_main_warehouse_receive_item', 'tbl_main_warehouse_receive_item.sold_to_outlet_id', '=', 'tbl_retailer_outlet.id')
                        ->join('tbl_imei', 'tbl_imei.item_id', '=', 'tbl_main_warehouse_receive_item.item_id')
                        ->join('tbl_item', 'tbl_item.id', '=', 'tbl_imei.item_id')
                        ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_item.product_color_id')
                        ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_color.product_id')
                        ->select('tbl_product.name as model', 'tbl_product_color.color', 'tbl_imei.imei1'
                                , 'tbl_imei.imei2')
                        ->where(['tbl_retailer.id' => $dealer_id])
                        ->where('tbl_main_warehouse_receive_item.activated_date', '=', null)
                        ->orderBy('tbl_product.name')->orderBy('tbl_product_color.color')
                        ->get();
    }
	
    static $a;

    public static function updated($v) {
        Retailer_outlet::$a = $v;
    }

    public function user() {
        if (Retailer_outlet::$a == 1) {
            return $this->belongsTo("App\User", 'updated_by');
        }
        return $this->belongsTo("App\User", 'created_by');
    }

}
