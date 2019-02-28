<template>
    <div>
        <div id="sales_div" class="display_none">
            <table cellspacing="0" id="sale_sales" class="table_custom">
                <tr class="GridViewScrollHeader">
                    <th>City</th>
                    <th>Dealer Code</th>
                    <th>Outlet</th>
                    <th>Locality</th>
                    <th> Address</th>
                    <th>SO</th>
                    <th>
                        1
                    </th>
                    <th class="text-center">
                        2
                    </th>
                    <th class="text-center">
                        3
                    </th>
                    <th class="text-center">
                        4
                    </th>
                    <th class="text-center">
                        5
                    </th>
                    <th class="text-center">
                        6
                    </th>
                    <th class="text-center">
                        7
                    </th>
                    <th class="text-center">
                        8
                    </th>
                    <th class="text-center">
                        9
                    </th>
                    <th class="text-center">
                        10
                    </th>
                    <th class="text-center">
                        11
                    </th>
                    <th class="text-center">
                        12
                    </th>
                    <th class="text-center">
                        13
                    </th>
                    <th class="text-center">
                        14
                    </th>
                    <th class="text-center">
                        15
                    </th>
                    <th class="text-center">
                        16
                    </th>
                    <th class="text-center">
                        17
                    </th>
                    <th class="text-center">
                        18
                    </th>
                    <th class="text-center">
                        19
                    </th>
                    <th class="text-center">
                        20
                    </th>
                    <th class="text-center">
                        21
                    </th>
                    <th class="text-center">
                        22
                    </th>
                    <th class="text-center">
                        23
                    </th>
                    <th class="text-center">
                        24
                    </th>
                    <th class="text-center">
                        25
                    </th>
                    <th class="text-center">
                        26
                    </th>
                    <th class="text-center">
                        27
                    </th>
                    <th class="text-center">
                        28
                    </th>
                    <th class="text-center">
                        29
                    </th>
                    <th class="text-center">
                        30
                    </th>
                    <th class="text-center">
                        31
                    </th>
                    <th style=" white-space: nowrap; ">Total Sale (PKR)</th>
                </tr>
                <tr class="GridViewScrollItem" v-for="(value ,index ) in sales.data">
                    <td>
                        {{value.outlet.cityname}}
                    </td>
                    <td>
                        {{value.outlet.retailer_no}}
                    </td>
                    <td>
                        {{value.outlet.outletname}}
                    </td>
                    <td>
                        {{value.outlet.region_name}}
                    </td>
                    <td>
                        {{value.outlet.address}}
                    </td>
                    <td>
                        {{value.outlet.sales_officer_name}}
                    </td>
                    <td class="text-right"
                        v-for="(value_sale ,key,count ) in value.sale_result">
                        {{currency_filter(value_sale)}}
                    </td>
                    <td class="text-right">
                        <b>{{value.total -value.sale_return_total| currency('',',',0)}}</b>
                    </td>
                </tr>
                <tr class="GridViewScrollItem">
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="text-right" v-for="(sales_days ,key,count ) in sales_days">
                        <b> {{ sales_days==0?'': currency_filter(sales_days)}} </b>
                    </td>
                    <td class="text-right"><b>{{total_sales | currency('',',',0)}}</b></td>
                </tr>
            </table>
        </div>
        <div id="sale_qty_div" class="display_none">
            <table cellspacing="0" id="sale_qty" class="table_custom">
                <tr class="GridViewScrollHeader">
                    <th>City</th>
                    <th>Dealer Code</th>
                    <th>Outlet</th>
                    <th>Locality</th>
                    <th>Address</th>
                    <th>SO</th>
                    <th>
                        1
                    </th>
                    <th class="text-center">
                        2
                    </th>
                    <th class="text-center">
                        3
                    </th>
                    <th class="text-center">
                        4
                    </th>
                    <th class="text-center">
                        5
                    </th>
                    <th class="text-center">
                        6
                    </th>
                    <th class="text-center">
                        7
                    </th>
                    <th class="text-center">
                        8
                    </th>
                    <th class="text-center">
                        9
                    </th>
                    <th class="text-center">
                        10
                    </th>
                    <th class="text-center">
                        11
                    </th>
                    <th class="text-center">
                        12
                    </th>
                    <th class="text-center">
                        13
                    </th>
                    <th class="text-center">
                        14
                    </th>
                    <th class="text-center">
                        15
                    </th>
                    <th class="text-center">
                        16
                    </th>
                    <th class="text-center">
                        17
                    </th>
                    <th class="text-center">
                        18
                    </th>
                    <th class="text-center">
                        19
                    </th>
                    <th class="text-center">
                        20
                    </th>
                    <th class="text-center">
                        21
                    </th>
                    <th class="text-center">
                        22
                    </th>
                    <th class="text-center">
                        23
                    </th>
                    <th class="text-center">
                        24
                    </th>
                    <th class="text-center">
                        25
                    </th>
                    <th class="text-center">
                        26
                    </th>
                    <th class="text-center">
                        27
                    </th>
                    <th class="text-center">
                        28
                    </th>
                    <th class="text-center">
                        29
                    </th>
                    <th class="text-center">
                        30
                    </th>
                    <th class="text-center">
                        31
                    </th>
                    <th style=" white-space: nowrap; ">Total QTY</th>
                </tr>
                <tr class="GridViewScrollItem" v-for="(value ,index ) in data_sales_qty">
                    <td>
                        {{value.outlet.cityname}}
                    </td>
                    <td>
                        {{value.outlet.retailer_no}}
                    </td>
                    <td>
                        {{value.outlet.outletname}}
                    </td>
                    <td>
                        {{value.outlet.region_name}}
                    </td>
                    <td>
                        {{value.outlet.address}}
                    </td>
                    <td>
                        {{value.outlet.sales_officer_name}}
                    </td>
                    <td class="text-center"
                        v-for="(product_qty ,key,count ) in value.sale_result">
                        {{product_qty!=0?product_qty:''}}
                    </td>
                    <td class="text-center">
                        {{value.total-value.sale_return_total}}
                    </td>
                </tr>
                <tr class="GridViewScrollItem">
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="text-center" v-for="(sales_days ,key,count ) in sales_qty_days">
                        <b> {{ sales_days==0?'': sales_days}} </b>
                    </td>
                    <td class="text-center"><b>{{total_sales_qty}}</b></td>
                </tr>
            </table>
        </div>
        <div id="sale_product_div" class="display_none">
            <table cellspacing="0" id="sale_product" class="table_custom">
                <tr class="GridViewScrollHeader">
                    <th>City</th>
                    <th>Dealer Code</th>
                    <th>Outlet</th>
                    <th>Locality</th>
                    <th>Address</th>
                    <th>SO</th>
                    <th>
                        1
                    </th>
                    <th class="text-center">
                        2
                    </th>
                    <th class="text-center">
                        3
                    </th>
                    <th class="text-center">
                        4
                    </th>
                    <th class="text-center">
                        5
                    </th>
                    <th class="text-center">
                        6
                    </th>
                    <th class="text-center">
                        7
                    </th>
                    <th class="text-center">
                        8
                    </th>
                    <th class="text-center">
                        9
                    </th>
                    <th class="text-center">
                        10
                    </th>
                    <th class="text-center">
                        11
                    </th>
                    <th class="text-center">
                        12
                    </th>
                    <th class="text-center">
                        13
                    </th>
                    <th class="text-center">
                        14
                    </th>
                    <th class="text-center">
                        15
                    </th>
                    <th class="text-center">
                        16
                    </th>
                    <th class="text-center">
                        17
                    </th>
                    <th class="text-center">
                        18
                    </th>
                    <th class="text-center">
                        19
                    </th>
                    <th class="text-center">
                        20
                    </th>
                    <th class="text-center">
                        21
                    </th>
                    <th class="text-center">
                        22
                    </th>
                    <th class="text-center">
                        23
                    </th>
                    <th class="text-center">
                        24
                    </th>
                    <th class="text-center">
                        25
                    </th>
                    <th class="text-center">
                        26
                    </th>
                    <th class="text-center">
                        27
                    </th>
                    <th class="text-center">
                        28
                    </th>
                    <th class="text-center">
                        29
                    </th>
                    <th class="text-center">
                        30
                    </th>
                    <th class="text-center">
                        31
                    </th>
                </tr>
                <tr class="GridViewScrollItem" v-for="(value ,index ) in sale_qty_product">
                    <td>
                        {{value.outlet.cityname}}
                    </td>
                    <td>
                        {{value.outlet.retailer_no}}
                    </td>
                    <td>
                        {{value.outlet.outletname}}
                    </td>
                    <td>
                        {{value.outlet.region_name}}
                    </td>
                    <td>
                        {{value.outlet.address}} {{value.outlet.sales_officer_name}}
                    </td>
                    <td> {{value.outlet.sales_officer_name}}</td>
                    <td class="v-a-t"
                        v-for="(product ,key,count ) in value.product">
                        <div class="v-a-t"
                             v-for="(product_details ,key,count ) in product.result"><b>{{product_details.p_name}}</b>
                            ({{product_details.color}}) <br class="m-p-0">
                            {{product_details.total/product_details.qty | currency('')}} x
                            {{product_details.qty}} = {{product_details.total | currency('')}}
                            <hr class="m-p-0">
                        </div>
                    </td>
                </tr>

            </table>
        </div>
        <div id="outstanding_div" class="display_none">
            <table cellspacing="0" class="table_custom"
                   id="outstanding_grid">
                <tr class="GridViewScrollHeader">
                    <th>City</th>
                    <th>Dealer Code</th>
                    <th>Outlet</th>
                    <th>Locality</th>
                    <th>Address</th>
                    <th class="hide">Sales Officer</th>
                    <th>Credit Limit(PKR)</th>
                    <th>Credit Duration(Days)</th>
                    <th>Outstanding(PKR)</th>
                    <th>Aging(PKR)</th>
                </tr>
                <tr class="GridViewScrollItem" v-for="(value) in data_outstanding">
                    <td>{{value.outlet.cityname}}</td>
                    <td>{{value.outlet.retailer_no}}</td>
                    <td>{{value.outlet.outletname}}</td>
                    <td>{{value.outlet.region_name}}</td>
                    <td>{{value.outlet.address}}</td>
                    <td class="hide">{{value.unique_sales_officer}}</td>
                    <td class="text-right">{{value.outlet.credit_limit | currency('',',',0)}}
                    </td>
                    <td class="text-right">{{value.outlet.credit_duration }}</td>
                    <td class="text-right">{{value.outstanding-value.paid | currency('',',',0)}}
                    </td>
                    <td class="text-right "><span v-if="value.aging>0" class="red"><b>{{value.aging | currency('',',',0)}}</b></span>
                        <span v-else>{{0 | currency('',',',0)}}</span>
                    </td>
                </tr>
                <tr class="GridViewScrollItem">
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="text-right"><b>Total</b></td>
                    <td class="text-right"><b>{{total_outstanding.outstanding|
                        currency('',',',0)
                        }}</b></td>
                    <td class="text-right red"><b>{{total_outstanding.aging |
                        currency('',',',0)}}</b>
                    </td>
                </tr>
            </table>
        </div>
        <div id="outstanding_invoice_div" class="display_none">
            <table id="outstanding_invoice_grid">
                <tr class="GridViewScrollHeader">
                    <th>City</th>
                    <th width="80px" class="">Dealer Code</th>
                    <th width="120px">Outlet</th>
                    <th>Locality</th>
                    <th>Address</th>
                    <th>Credit Limit(PKR)</th>
                    <th>Credit Duration</th>
                    <th style=" padding:0; margin:0;">
                        <table width="400px">
                            <tr>
                                <th width="100px">Invoice No</th>
                                <th width="100px">Invoice Date</th>
                                <th width="100px">Due Date</th>
                                <th width="100px">Outstanding(PKR)</th>
                            </tr>
                        </table>
                    </th>
                    <th>Total(PKR)</th>
                    <th style="white-space: nowrap;">Aging (PKR)</th>
                </tr>
                <tr v-for="(value) in data_outstanding_invoice_wise" class="GridViewScrollItem">
                    <td>{{value.outlet.cityname}}</td>
                    <td>{{value.outlet.retailer_no}}</td>
                    <td>{{value.outlet.outletname}}</td>
                    <td>{{value.outlet.region_name}}</td>
                    <td>{{value.outlet.outletname}}</td>
                    <td class="text-right">{{value.outlet.credit_limit | currency('',',',0)}}
                    </td>
                    <td class="text-center">{{value.outlet.credit_duration}}</td>
                    <td style=" padding:0; margin:0;">
                        <table width="100%">
                            <tr v-for="(i_value) in value.invoice">
                                <td v-bind:class="i_value.color" width="100px"><span v-bind:class="i_value.color">{{i_value.invoice_no}}</span>
                                </td>
                                <td width="100px" class="border_table "><span v-bind:class="i_value.color">
                                                                 {{i_value.invoice_created_date |moment }}</span>
                                </td>
                                <td width="100px" class="border_table ">
                                                       <span v-bind:class="i_value.color">     {{i_value.invoice_created_date |
                                                           getafterdate(value.outlet.credit_duration)}}</span>
                                </td>
                                <td width="100px" class="border_table text-right">
                                    <span v-bind:class="i_value.color">  {{i_value.total_amount-i_value.paid | currency('',',',0)}}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="text-right">{{value.outstanding-value.paid
                        |currency('',',',0)}}
                    </td>
                    <td class="text-right"><span v-if="value.aging>0"
                                                 class="red"><b>{{value.aging | currency('',',',0)}}</b></span>
                        <span v-else>{{0 | currency('',',',0)}}</span></td>
                </tr>
                <tr class="GridViewScrollItem">
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="text-right"><b>Total</b></td>
                    <td class="text-right"><b>{{total_outstanding_invoice
                        |currency('',',',0)}}</b></td>
                    <td class="red" style="text-align: left;"><b>{{aging |currency('',',',0)}}</b></td>
                </tr>
            </table>
        </div>
        <div id="activation_div" class="display_none">
            <table id="activate_table" cellspacing="0"
                   class="table_custom">
                <tr class="GridViewScrollHeader">
                    <th>
                        City
                    </th>
                    <th>
                        Dealer Code
                    </th>
                    <th>
                        Outlet
                    </th>
                    <th>
                        Locality
                    </th>
                    <th>
                        Address
                    </th>
                    <th>Model</th>
                    <th>Color</th>
                    <th>IMEI</th>
                    <th>Delivery Date</th>
                    <th>Activation Date</th>
                </tr>
                <tr class="GridViewScrollItem" v-for="(value) in activation">
                    <td>{{value.city_name}}</td>
                    <td>{{value.retailer_no}}</td>
                    <td>{{value.outlet_name}}</td>
                    <td>{{value.region_name}}</td>
                    <td>{{value.outlet_address}}</td>
                    <td>{{value.p_name}}</td>
                    <td>{{value.color}}</td>
                    <td>{{value.imei1}}</td>
                    <td>{{value.created_at | moment()}}</td>
                    <td>{{value.activated_date | moment()}}</td>
                </tr>
                <tr class="GridViewScrollItem">
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="text-right"><b>Total</b></td>
                    <td><b>{{total_activate}}</b></td>
                </tr>
            </table>
        </div>
        <div id="outlet_activate_div" class="display_none">
            <table id="outlet_activate_table"
                   class="table_custom">
                <tr class="GridViewScrollHeader">
                    <th>
                        City
                    </th>
                    <th>
                        Dealer Code
                    </th>
                    <th>
                        Outlet
                    </th>
                    <th>
                        Locality
                    </th>
                    <th>
                        Address
                    </th>
                    <th>Activation</th>
                </tr>
                <tr class="GridViewScrollItem" v-for="(value) in activation_outlet">
                    <td>{{value.cityname}}</td>
                    <td>{{value.retailer_no}}</td>
                    <td>{{value.outletname}}</td>
                    <td>{{value.region_name}}</td>
                    <td>{{value.address}}</td>
                    <td>{{value.activation}}</td>
                </tr>
                <tr class="GridViewScrollItem">
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="text-right"><b>Total</b></td>
                    <td><b>{{total_activate}}</b></td>
                </tr>
            </table>
        </div>
        <div id="outlet_products_activation_div" class="display_none">
            <table id="outlet_products_activate_table"
                   class="table_custom">
                <tr class="GridViewScrollHeader">
                    <th>
                        City
                    </th>
                    <th>
                        Dealer Code
                    </th>
                    <th>
                        Outlet
                    </th>
                    <th>
                        Locality
                    </th>
                    <th>
                        Address
                    </th>
                    <td v-for="(product) in all_product_list">{{product.name}}</td>
                    <th>Total</th>
                </tr>
                <tr class="GridViewScrollItem" v-for="(value) in activation_outlet_products">
                    <td>{{value.outlet.city_name}}</td>
                    <td>{{value.outlet.retailer_no}}</td>
                    <td>{{value.outlet.outlet_name}}</td>
                    <td>{{value.outlet.region_name}}</td>
                    <td>{{value.outlet.outlet_address}}</td>

                    <td v-for="(product_head) in all_product_list">
                        {{value.products[product_head.name]}}
                    </td>
                    <td><b>{{value.outlet.total}}</b></td>
                </tr>
                <tr class="GridViewScrollItem">
                    <td class="white" v-for="(value) in product_total">.</td>
                    <td class="text-right"><b>Total</b></td>
                    <td><b>{{total_activate}}</b></td>
                </tr>
            </table>
        </div>
        <div id="collection_div" class="display_none">
            <table cellspacing="0" id="collection" class="table_custom">
                <tr class="GridViewScrollHeader">
                    <th>City</th>
                    <th>Dealer Code</th>
                    <th>Outlet</th>
                    <th>Locality</th>
                    <th>Address</th>
                    <th>
                        1
                    </th>
                    <th class="text-center">
                        2
                    </th>
                    <th class="text-center">
                        3
                    </th>
                    <th class="text-center">
                        4
                    </th>
                    <th class="text-center">
                        5
                    </th>
                    <th class="text-center">
                        6
                    </th>
                    <th class="text-center">
                        7
                    </th>
                    <th class="text-center">
                        8
                    </th>
                    <th class="text-center">
                        9
                    </th>
                    <th class="text-center">
                        10
                    </th>
                    <th class="text-center">
                        11
                    </th>
                    <th class="text-center">
                        12
                    </th>
                    <th class="text-center">
                        13
                    </th>
                    <th class="text-center">
                        14
                    </th>
                    <th class="text-center">
                        15
                    </th>
                    <th class="text-center">
                        16
                    </th>
                    <th class="text-center">
                        17
                    </th>
                    <th class="text-center">
                        18
                    </th>
                    <th class="text-center">
                        19
                    </th>
                    <th class="text-center">
                        20
                    </th>
                    <th class="text-center">
                        21
                    </th>
                    <th class="text-center">
                        22
                    </th>
                    <th class="text-center">
                        23
                    </th>
                    <th class="text-center">
                        24
                    </th>
                    <th class="text-center">
                        25
                    </th>
                    <th class="text-center">
                        26
                    </th>
                    <th class="text-center">
                        27
                    </th>
                    <th class="text-center">
                        28
                    </th>
                    <th class="text-center">
                        29
                    </th>
                    <th class="text-center">
                        30
                    </th>
                    <th class="text-center">
                        31
                    </th>
                    <th style=" white-space: nowrap; ">Total</th>
                </tr>
                <tr class="GridViewScrollItem" v-for="(value ) in collection.data">
                    <td>
                        {{value.city_name}}
                    </td>
                    <td>
                        {{value.retailer_no}}
                    </td>
                    <td>
                        {{value.outlet_name}}
                    </td>
                    <td>
                        {{value.region_name}}
                    </td>
                    <td>
                        {{value.outlet_address}}
                    </td>
                    <td class="text-right"
                        v-for="(value_collcetion  ) in value.collection">
                        {{currency_filter(value_collcetion)}}
                    </td>
                    <td class="text-right">
                        {{value.total| currency('')}}
                    </td>
                </tr>
                <tr class="GridViewScrollItem">
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="white">.</td>
                    <td class="text-right"
                        v-for="(value ) in collection_total_day">
                        <b>{{currency_filter(value)}}</b>
                    </td>
                    <td class="text-right"><b>{{collection_total | currency('')}}</b></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['report_data', 'report_table_type'],

        data() {
            return {
                sales: [],
                sales_days: [],
                data_sales_qty: [],
                sales_qty_days: [],
                sale_qty_product: [],
                data_outstanding: [],
                total_outstanding: [],
                data_outstanding_invoice_wise: [],
                total_outstanding_invoice: [],
                activation: [],
                activation_outlet: [],
                activation_outlet_products: [],
                all_product_list: [],
                product_total: [],
                collection: [],
                collection_total: [],
                collection_total_day: [],
                total_sales_qty: '',
                total_sales: 0,
                total_activate: 0,
                aging: 0,
            }
        },
        mounted() {
            this.report_type(this.report_table_type);
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            },
            date_time: function (date) {
                return moment(date).format('DD-MM-YYYY h:m a');
            },
            getdate: function (date) {
                return moment(date).format('DD');
            },
            getmonth: function (date) {
                return moment(date).format('MM');
            },
            getafterdate: function (date, add_days) {
                return moment(date).add(add_days, 'days').format('DD-MM-YYYY');
            },
            color: function (color) {
                return "red";
            }
        }, methods: {
            currency_filter: function (currency) {
                if (currency != "") {
                    return accounting.formatMoney(currency, "", ",")
                }
                else {
                    return '';
                }
            },
            report_type: function (report_table_type) {
                if (report_table_type == 'sale_sales') {
                    this.sale_sales();
                }
                if (report_table_type == 'sale_quantity') {
                    this.sale_quantity();
                }
                if (report_table_type == 'sale_quantity_products') {
                    this.sale_quantity_products();
                }
                if (report_table_type == 'invoice_wise') {
                    this.outstanding();
                }
                if (report_table_type == 'outstanding_invoice_wise') {
                    this.outstanding_invoice();
                }
                if (report_table_type == 'outlet_activation_wise') {
                    this.outlet_activation();
                }
                if (report_table_type == 'outlet_wise') {
                    this.outlet_wise();
                }
                if (report_table_type == 'outlet_products_activate') {
                    this.activation_products();
                }
                if (report_table_type == 'collection') {
                    this.amount_collection();
                }
            },
            sale_sales: function () {
                this.sales = this.report_data.data;
                this.sales_days = this.report_data.day_total;
                this.total_sales = this.report_data.total - this.report_data.sale_return;
                this.table_freeze("sale_sales",6,"GridViewScrollFooterFreeze");
                $("#sales_div").show();
            },
            sale_quantity: function () {
                this.data_sales_qty = this.report_data.data.data;
                this.sales_qty_days = this.report_data.day_total;
                this.total_sales_qty = this.report_data.total - this.report_data.sale_return;
                this.table_freeze("sale_qty",6,"GridViewScrollFooterFreeze");
                $("#sale_qty_div").show();
            },
            sale_quantity_products: function () {
                this.sale_qty_product = this.report_data.data;
                setTimeout(function () {
                    var gridViewScroll = null;
                    gridViewScroll = new GridViewScroll({
                        elementID: 'sale_product',
                        width: '100%',
                        height: 600,
                        freezeColumn: true,
                        freezeColumnCssClass: "GridViewScrollItemFreeze",
                        freezeHeaderRowCount: 1,
                        freezeColumnCount: 6,
                    });
                    gridViewScroll.enhance();
                });
                $("#sale_product_div").show();
            },
            amount_collection: function () {
                this.collection = this.report_data;
                this.collection_total = this.report_data.collection_total;
                this.collection_total_day = this.report_data.day_total;
                this.table_freeze("collection",5,"GridViewScrollFooterFreeze");
                $("#collection_div").show();
            },
            outstanding: function () {
                this.data_outstanding = this.report_data.data;
                this.total_outstanding = {
                    'outstanding': this.report_data.outstanding_paid.total_outstanding - this.report_data.outstanding_paid.total_paid,
                    'aging': this.report_data.aging
                };
                this.table_freeze("outstanding_grid",6,"GridViewScrollFooterFreeze_outstanding");
                $("#outstanding_div").show();
            },
            outstanding_invoice: function () {
                this.data_outstanding_invoice_wise = this.report_data.data;
                this.total_outstanding_invoice = this.report_data.outstanding_paid.total_outstanding.total_outstanding - this.report_data.outstanding_paid.total_paid.total_paid;
                this.aging = this.report_data.aging;
                this.table_freeze("outstanding_invoice_grid",6,"GridViewScrollFooterFreeze_invoice_outstanding");
                $("#outstanding_invoice_div").show();
            },
            outlet_activation: function () {
                this.activation = this.report_data.data;
                this.total_activate = this.report_data.total;
                this.table_freeze("activate_table",6,"GridViewScrollFooterFreeze");
                $("#activation_div").show();
            },
            outlet_wise: function () {
                this.activation_outlet = this.report_data.data;
                this.total_activate = this.report_data.total;
                this.table_freeze("outlet_activate_table",6,"GridViewScrollFooterFreeze");
                $("#outlet_activate_div").show();
            },
            activation_products: function () {
                this.activation_outlet_products = this.report_data.result.data;
                this.total_activate = this.report_data.result.total;
                this.all_product_list = this.report_data.products;
                this.product_total = (this.report_data.length) - 1;
                this.table_freeze("outlet_products_activate_table",5,"GridViewScrollFooterFreeze");
                $("#outlet_products_activation_div").show();
            },
            table_freeze: function (table_name,column,footer) {
                setTimeout(function () {
                    var gridViewScroll = null;
                    gridViewScroll = new GridViewScroll({
                        elementID: table_name,
                        width: '100%',
                        height: 600,
                        freezeColumn: true,
                        freezeFooter: true,
                        freezeColumnCssClass: "GridViewScrollItemFreeze",
                        freezeFooterCssClass: footer,
                        freezeHeaderRowCount: 1,
                        freezeColumnCount: column,
                    });
                    gridViewScroll.enhance();
                });
            },
        }
    }
</script>
<style>
    .red {
        color: red;
    }
</style>