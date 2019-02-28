<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model {

    function sale_validation($imei) {
        return DB::table('tbl_imei')->select(
                                DB::raw("tbl_invoice_products.product_price-((tbl_invoice_products.product_price/100)*tbl_invoice_products.discount) as product_unit_price_discount")
                                , 'tbl_product_color.color', 'tbl_imei.imei1', 'tbl_imei.imei2', 'tbl_retailer_outlet.id as outlet_id'
                                , 'tbl_retailer_outlet.name as outlet_name', 'tbl_retailer_outlet.address as outlet_address', 'tbl_retailer_order.id as order_id'
                                , 'tbl_retailer_order.order_no', 'tbl_invoice.id as invoice_id', 'tbl_invoice.invoice_no', 'tbl_product.name as product_name'
                                , 'tbl_product.id as product_id', 'tbl_product_color.id as product_color_id'
                                , 'tbl_invoice_products.id as item_invoice_products_id', 'tbl_warehouse_issue.warehouse_id as warehouse_id'
                                , 'tbl_invoice_products.product_price as product_unit_price', 'tbl_invoice_products.discount as invoice_discount'
                                , 'tbl_invoice.created_at as invoice_date', 'tbl_main_warehouse_receive_item.item_is_activate'
                                , 'tbl_staff.name as staff_name', 'tbl_staff.id as staff_id', 'tbl_item.id as item_id')
                        ->join('tbl_item', 'tbl_item.id', '=', 'tbl_imei.item_id')
                        ->join('tbl_main_warehouse_receive_item', 'tbl_item.id', '=', 'tbl_main_warehouse_receive_item.item_id')
                        ->join('tbl_warehouse_issue_items', 'tbl_warehouse_issue_items.item_id', '=', 'tbl_main_warehouse_receive_item.item_id')
                        ->join('tbl_warehouse_issue', 'tbl_warehouse_issue_items.warehouse_issue_id', '=', 'tbl_warehouse_issue.id')
                        ->join('tbl_invoice', 'tbl_invoice.id', '=', 'tbl_warehouse_issue.invoice_id')
                        // ->join('tbl_invoice_products', 'tbl_invoice.id', '=', 'tbl_invoice_products.invoice_id')
                        ->join('tbl_retailer_order', 'tbl_retailer_order.id', '=', 'tbl_invoice.order_id')
                        ->join('tbl_retailer_order_products', 'tbl_retailer_order_products.retailer_order_id', '=', 'tbl_retailer_order.id')
                        ->join('tbl_product_color', 'tbl_product_color.id', '=', 'tbl_retailer_order_products.product_color_id')
                        ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_color.product_id')
                        ->join('tbl_retailer_outlet', 'tbl_retailer_outlet.id', '=', 'tbl_retailer_order.outlet_id')
                        ->join('tbl_staff', 'tbl_staff.id', '=', 'tbl_retailer_order.sales_officer_id')
                        ->join("tbl_invoice_products", function($join) {
                            $join->on('tbl_invoice.id', '=', 'tbl_invoice_products.invoice_id')
                            ->on("tbl_retailer_order_products.product_color_id", "=", "tbl_invoice_products.product_color_id");
                        })
                        ->whereRaw('tbl_item.product_color_id = tbl_retailer_order_products.product_color_id')
                        ->whereIn('tbl_imei.imei1', $imei)
                        //  ->orwhereIn('tbl_imei.imei2', $imei)
                        ->groupBy('tbl_imei.imei1')
                        ->get();
    }

//    function sale_return($data) {
//
//        $data_sort = [];
//        for ($i = 0; $i < sizeof($data->products['data']); $i++) {
//            $data_sort[$i]['imei1'] = $data->products['data'][$i]['imei1'];
//            $data_sort[$i]['invoice_no'] = $data->products['data'][$i]['invoice_no'];
//            $data_sort[$i]['product_color_id'] = $data->products['data'][$i]['product_color_id'];
//            $data_sort[$i]['product_price'] = $data->products['data'][$i]['product_unit_price'];
//        }
//        return $data_sort;
//    }

    function invoice($data) {
        return DB::table('tbl_invoice')->select('total_amount', 'final_amount', 'is_pay', 'total_amount', 'paid')
                        ->where(['id' => $data['invoice_id']])->first();
    }

}
