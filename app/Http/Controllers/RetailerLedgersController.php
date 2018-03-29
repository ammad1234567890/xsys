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
use App\Ledger;
use Response;

class RetailerLedgersController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * this function will displays retailer  ledger View
     */

    public function index()
    {
        return view("retailer_ledger");
    }


    /**
     * this function will display retailers outstanding amount
     * searching retailer by
     * from-date
     * to-date  and
     * retailer id
     * @param Array $request  declare having retailer id
     * @param Array $request  declare having fdate
     * @param Array $request  declare having tdate
     */

    public function get_all_ledger(Request $request)
    {
        $retailer_id = $request->input('retailer_id');
        $retailer_fromDate = $request->input('fdate');
        $retailer_toDate = $request->input('tdate');

        return $ledgerData = DB::select('SELECT 
                                          x.TransDate,
                                          x.`retailer_id`,
                                          x.`invoice_id`,
                                          x.`collection_id`,
                                          x.description,
                                          x.Credit,
                                          x.Collection,
                                            SUM(
                                                COALESCE(y.Credit, 0) - COALESCE(y.Collection, 0)
                                                ) AS Outstanding 
                                            FROM
                                          tbl_ledger X
                                            INNER JOIN tbl_ledger Y
                                            ON y.TransDate <= x.TransDate                                           
                                            WHERE x.`TransDate` >= "' . $retailer_fromDate . '" AND x.`TransDate` <="' . $retailer_toDate . '" 
                                            AND x.`retailer_id` = ' . $retailer_id . ' AND y.`retailer_id` = ' . $retailer_id . '
                                            GROUP BY x.TransDate,
                                          x.Credit,
                                          x.Collection,
                                          x.description,
                                          x.invoice_id,
                                          x.collection_id,
                                          x.retailer_id 
                                          ');


    }


    /**
     * this function will displays retailer  outstanding amount
     * @param Array $request declare having retailer id
     */

    public function retailer_ledger_balance(Request $request)
    {
        $retailer_id = $request->input('retailer_id');

        return $ledgerData = DB::select('SELECT 
                                        SUM(
                                            COALESCE(y.Credit, 0) - COALESCE(y.Collection, 0)
                                          ) AS Outstanding 
                                        FROM
                                          tbl_ledger X
                                        INNER JOIN tbl_ledger Y
                                        ON y.TransDate <= x.TransDate                                            
                                        WHERE x.`retailer_id` = ' . $retailer_id . ' AND y.`retailer_id` = ' . $retailer_id . '
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


    }

    public function get_all_ledger_by_outlet($outlet_id)
    {
        $retailer_id = $outlet_id;

        return $ledgerData = DB::select('SELECT 
                                          x.TransDate,
                                          x.`retailer_id`,
                                          x.`invoice_id`,
                                          x.`collection_id`,
                                          x.description,
                                          x.Credit,
                                          x.Collection,
                                            SUM(
                                                COALESCE(y.Credit, 0) - COALESCE(y.Collection, 0)
                                                ) AS Outstanding 
                                            FROM
                                          tbl_ledger X
                                            INNER JOIN tbl_ledger Y
                                            ON y.TransDate <= x.TransDate                                           
                                            WHERE x.`retailer_id` = ' . $retailer_id . ' AND y.`retailer_id` = ' . $retailer_id . '
                                            GROUP BY x.TransDate,
                                          x.Credit,
                                          x.Collection,
                                          x.description,
                                          x.invoice_id,
                                          x.collection_id,
                                          x.retailer_id 
                                          ');
    }
}
