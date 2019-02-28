<template>
    <div class="row">
        <div class=" col-md-12 paddingmarginzero">
            <div class="paddingmarginzero">
                <h4 class="heading-inline"> Sales and Collection Report </h4>
            </div>
            <div class="paddingtop5">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Search Filter
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4 m-p-0">
                                <div class="col-md-4">
                                    <label>Report</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="report" @change="report()" v-model="report_type"
                                            class="textbox_dropdown form-control ">
                                        <option value="">-Select-</option>
                                        <option value="sales">Sales</option>
                                        <option value="collection">Collection</option>
                                        <option value="outstanding">Outstanding</option>
                                        <option value="activation">Activation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 m-p-0">
                                <div class="col-md-4">
                                    <label>Region</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="states" @change="state()" class="textbox_dropdown form-control ">
                                        <option value="all">All</option>
                                        <option v-for="(state, index) in states" v-bind:value="state.id">
                                            {{state.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 display_none m-p-0" id="city_div">
                                <div class="col-md-4 ">
                                    <label>City </label>
                                </div>
                                <div class="col-md-8 ">
                                    <select id="cities" @change="city()" class="textbox_dropdown form-control ">
                                        <option value="all">All</option>
                                        <option v-for="(cities, index) in cities" v-bind:value="cities.id">
                                            {{cities.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 display_none m-p-0" id="locality_div">
                                <div class="col-md-4">
                                    <label>Locality</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="locality" @change="localities" class="textbox_dropdown form-control ">
                                        <option v-for="(locality, index) in locality"
                                                v-bind:value="locality.id">
                                            {{locality.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 display_none m-p-0" id="month_div">
                                <div class="col-md-4">
                                    <label>Month</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="month" id="month" class="form-control" :value="current_month">
                                </div>
                            </div>
                            <div class="col-md-4 display_none m-p-0" id="div_fdate">
                                <div class="col-md-4">
                                    <label>Date From</label>
                                </div>
                                <div class="col-md-8">
                                    <date-picker name="fdate" v-model="fdate" type="date" format="dd-MM-yyyy"
                                                 placeholder="dd-mm-yyyy" lang="en" required></date-picker>
                                </div>
                            </div>
                            <div class="col-md-4 display_none m-p-0" id="div_tdate">
                                <div class="col-md-4">
                                    <label>Date To </label>
                                </div>
                                <div class="col-md-8">
                                    <date-picker name="tdate" v-model="tdate" type="date" format="dd-MM-yyyy"
                                                 placeholder="dd-mm-yyyy" lang="en" required></date-picker>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 display_none m-p-0" id="div_filter">
                                <div class="col-md-4">
                                    <label>Filter </label>
                                </div>
                                <div class="col-md-8">
                                    <select @change="type" id="type" class="textbox_dropdown form-control ">
                                        <option value="">-Select-</option>
                                        <option
                                                v-for="(filter, index) in filter"
                                                v-bind:value="filter.id">
                                            {{filter.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 display_none m-p-0" id="sales_officer_div">
                                <div class="col-md-4 ">
                                    <label>Sales Officer</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="sale" class="textbox_dropdown form-control ">
                                        <option value="">-Select-</option>
                                        <option v-for="(sales_officer, index) in sales_officer"
                                                v-bind:value="sales_officer.id">
                                            {{sales_officer.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 display_none m-p-0" id="customer_div">
                                <div class="col-md-4">
                                    <label>Customer </label>
                                </div>
                                <div class="col-md-8">
                                    <select id="customer" class="textbox_dropdown form-control ">
                                        <option value="">-Select-</option>
                                        <option v-for="(customer, index) in customer"
                                                v-bind:value="customer.id">
                                            {{customer.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 display_none  m-p-0" id="div_invoice_wise">
                                <div class="col-md-4">
                                    <label>Type </label>
                                </div>
                                <div class="col-md-8">
                                    <select  id="invoice_wise" class="textbox_dropdown form-control ">
                                        <option value="">-Select-</option>
                                        <option value="invoice_wise">Invoice Wise</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 m-p-0 display_none" id="sales_report_type_div">
                                <div class="col-md-4 ">
                                    <label>Report Type</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="sales_report_type" class="textbox_dropdown form-control ">
                                        <option value="sales_wise">Sales Wise</option>
                                        <option value="quantity_wise">Quantity Wise</option>
                                        <option value="product_wise">Sale Product Wise</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row paddingtop5">
                            <div class="col-md-1">
                                <label></label>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary" @click="search()">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Outlets
                    </div>
                    <div class="panel-body">
                        <div class="portlet portlet-table">
                            <div class="portlet-content ">
                                <div class="" style=" width:1000px;  overflow-x:scroll;">
                                    <table class="table table-striped table-bordered display_none"
                                           id="outstanding_grid">
                                        <thead>
                                        <tr>
                                            <th>City</th>
                                            <th class="">Dealer Code</th>
                                            <th>Outlet</th>
                                            <th>Locality</th>
                                            <th>Address</th>
                                            <th class="hide">Sales Officer</th>
                                            <th>Credit Limit(PKR)</th>
                                            <th>Credit Duration(Days)</th>
                                            <th>Outstanding(PKR)</th>
                                            <th>Aging(PKR)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(value) in data_outstanding">
                                            <td>{{value.outlet.cityname}}</td>
                                            <td>{{value.outlet.retailer_no}}</td>
                                            <td>{{value.outlet.outletname}}</td>
                                            <td>{{value.outlet.region_name}}</td>
                                            <td>{{value.outlet.address}}</td>
                                            <td class="hide">{{value.unique_sales_officer}}</td>
                                            <td class="text-right">{{value.outlet.credit_limit | currency('')}}</td>
                                            <td class="text-right">{{value.outlet.credit_duration }}</td>
                                            <td class="text-right">{{value.outstanding-value.paid | currency('')}}
                                            </td>
                                            <td class="text-right "><span v-if="value.aging>0" class="red">{{value.aging | currency('')}}</span>
                                                <span v-else>{{0 | currency('')}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right"><b>Total</b></td>
                                            <td class="text-right"><b>{{total_outstanding.outstanding| currency('')
                                                }}</b></td>
                                            <td class="text-right red"><b>{{total_outstanding.aging | currency('')}}</b>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table id="outstanding_invoice_grid"
                                           class="table table-striped table-bordered display_none"
                                           style="width:1000px">
                                        <thead>
                                        <tr>
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
                                            <th>Aging</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(value) in data_outstanding_invoice_wise">
                                            <td>{{value.outlet.cityname}}</td>
                                            <td>{{value.outlet.retailer_no}}</td>
                                            <td>{{value.outlet.outletname}}</td>
                                            <td>{{value.outlet.region_name}}</td>
                                            <td>{{value.outlet.outletname}}</td>
                                            <td class="text-right">{{value.outlet.credit_limit | currency('')}}</td>
                                            <td class="text-center">{{value.outlet.credit_duration}}</td>
                                            <td style=" padding:0; margin:0;">
                                                <table width="400px">
                                                    <tr class="tr " v-for="(i_value) in value.invoice">
                                                        <span v-bind:class="i_value.color">
                                                        <td width="100px">{{i_value.invoice_no}}</td>
                                                             <td width="100px" class="border_table ">
                                                            {{i_value.invoice_created_date |moment }}
                                                        </td>
                                                        <td width="100px" class="border_table ">
                                                            {{i_value.invoice_created_date |
                                                            getafterdate(value.outlet.credit_duration)}}
                                                        </td>
                                                        <td width="100px" class="border_table text-right">
                                                            {{i_value.total_amount-i_value.paid | currency('')}}
                                                        </td>
                                                            </span>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="text-right">{{value.outstanding-value.paid |currency('')}}</td>
                                            <td class="text-right"><span v-if="value.aging>0"
                                                                         class="red">{{value.aging | currency('')}}</span>
                                                <span v-else>{{0 | currency('')}}</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" class="text-right"><b>Total</b></td>
                                            <td class="text-right"><b>{{total_outstanding_invoice |currency('')}}</b>
                                            <td class="text-right red"><b>{{aging |currency('')}}</b></td>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table id="sale_sales" style="width: 3000px;"
                                           class="table table-striped table-bordered   display_none ">
                                        <thead>
                                        <tr>
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
                                            <th width="80px" class="text-center">
                                                1
                                            </th>
                                            <th width="80px" class="text-center">
                                                2
                                            </th>
                                            <th width="80px" class="text-center">
                                                3
                                            </th>
                                            <th width="80px" class="text-center">
                                                4
                                            </th>
                                            <th width="80px" class="text-center">
                                                5
                                            </th>
                                            <th width="80px" class="text-center">
                                                6
                                            </th>
                                            <th width="80px" class="text-center">
                                                7
                                            </th>
                                            <th width="80px" class="text-center">
                                                8
                                            </th>
                                            <th width="80px" class="text-center">
                                                9
                                            </th>
                                            <th width="80px" class="text-center">
                                                10
                                            </th>
                                            <th width="80px" class="text-center">
                                                11
                                            </th>
                                            <th width="80px" class="text-center">
                                                12
                                            </th>
                                            <th width="80px" class="text-center">
                                                13
                                            </th>
                                            <th width="80px" class="text-center">
                                                14
                                            </th>
                                            <th width="80px" class="text-center">
                                                15
                                            </th>
                                            <th width="80px" class="text-center">
                                                16
                                            </th>
                                            <th width="80px" class="text-center">
                                                17
                                            </th>
                                            <th width="80px" class="text-center">
                                                18
                                            </th>
                                            <th width="80px" class="text-center">
                                                19
                                            </th>
                                            <th width="80px" class="text-center">
                                                20
                                            </th>
                                            <th width="80px" class="text-center">
                                                21
                                            </th>
                                            <th width="80px" class="text-center">
                                                22
                                            </th>
                                            <th width="80px" class="text-center">
                                                23
                                            </th>
                                            <th width="80px" class="text-center">
                                                24
                                            </th>
                                            <th width="80px" class="text-center">
                                                25
                                            </th>
                                            <th width="80px" class="text-center">
                                                26
                                            </th>
                                            <th width="80px" class="text-center">
                                                27
                                            </th>
                                            <th width="80px" class="text-center">
                                                28
                                            </th>
                                            <th width="80px" class="text-center">
                                                29
                                            </th>
                                            <th width="80px" class="text-center">
                                                30
                                            </th>
                                            <th width="80px" class="text-center">
                                                31
                                            </th>
                                            <th>Total Sale(PKR)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(value ,index ) in data_sales">
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
                                            <td class="text-right"
                                                v-for="(value_sale ,key,count ) in value.sale_result">
                                                {{currency_filter(value_sale)}}
                                            </td>
                                            <td class="text-right">
                                                {{value.total -value.sale_return_total| currency('')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="36" class="text-right">
                                                <b>Total</b>
                                            </td>
                                            <td class="text-right"><b>{{total_sales | currency('')}}</b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table id='sale_qty' style="width: 3000px;"
                                           class="table table-striped table-bordered    display_none">
                                        <thead>
                                        <tr>
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
                                            <th width="80px" class="text-center">
                                                1
                                            </th>
                                            <th width="80px" class="text-center">
                                                2
                                            </th>
                                            <th width="80px" class="text-center">
                                                3
                                            </th>
                                            <th width="80px" class="text-center">
                                                4
                                            </th>
                                            <th width="80px" class="text-center">
                                                5
                                            </th>
                                            <th width="80px" class="text-center">
                                                6
                                            </th>
                                            <th width="80px" class="text-center">
                                                7
                                            </th>
                                            <th width="80px" class="text-center">
                                                8
                                            </th>
                                            <th width="80px" class="text-center">
                                                9
                                            </th>
                                            <th width="80px" class="text-center">
                                                10
                                            </th>
                                            <th width="80px" class="text-center">
                                                11
                                            </th>
                                            <th width="80px" class="text-center">
                                                12
                                            </th>
                                            <th width="80px" class="text-center">
                                                13
                                            </th>
                                            <th width="80px" class="text-center">
                                                14
                                            </th>
                                            <th width="80px" class="text-center">
                                                15
                                            </th>
                                            <th width="80px" class="text-center">
                                                16
                                            </th>
                                            <th width="80px" class="text-center">
                                                17
                                            </th>
                                            <th width="80px" class="text-center">
                                                18
                                            </th>
                                            <th width="80px" class="text-center">
                                                19
                                            </th>
                                            <th width="80px" class="text-center">
                                                20
                                            </th>
                                            <th width="80px" class="text-center">
                                                21
                                            </th>
                                            <th width="80px" class="text-center">
                                                22
                                            </th>
                                            <th width="80px" class="text-center">
                                                23
                                            </th>
                                            <th width="80px" class="text-center">
                                                24
                                            </th>
                                            <th width="80px" class="text-center">
                                                25
                                            </th>
                                            <th width="80px" class="text-center">
                                                26
                                            </th>
                                            <th width="80px" class="text-center">
                                                27
                                            </th>
                                            <th width="80px" class="text-center">
                                                28
                                            </th>
                                            <th width="80px" class="text-center">
                                                29
                                            </th>
                                            <th width="80px" class="text-center">
                                                30
                                            </th>
                                            <th width="80px" class="text-center">
                                                31
                                            </th>
                                            <th>Total (QTY)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(value ,index ) in data_sales_qty">
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
                                            <td class="text-center"
                                                v-for="(product_qty ,key,count ) in value.sale_result">
                                                {{product_qty!=0?product_qty:''}}
                                            </td>
                                            <td class="text-center">
                                                {{value.total-value.sale_return_total}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="36" class="text-right">
                                                <b>Total (QTY)</b>
                                            </td>
                                            <td class="text-center"><b>{{total_sales_qty}}</b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table id="sale_product" style="width: 5000px;"
                                           class="table table-striped table-bordered    display_none">
                                        <thead>
                                        <tr>
                                            <th width="70px">
                                                City
                                            </th>
                                            <th width="100px">
                                                Dealer Code
                                            </th>
                                            <th width="100px">
                                                Outlet
                                            </th>
                                            <th width="90px">
                                                Locality
                                            </th>
                                            <th width="120px">
                                                Address
                                            </th>
                                            <th class="text-center w-150">
                                                1
                                            </th>
                                            <th class="text-center w-150">
                                                2
                                            </th>
                                            <th class="text-center w-150">
                                                3
                                            </th>
                                            <th class="text-center w-150">
                                                4
                                            </th>
                                            <th class="text-center w-150">
                                                5
                                            </th>
                                            <th w class="text-center w-150">
                                                6
                                            </th>
                                            <th class="text-center w-150">
                                                7
                                            </th>
                                            <th class="text-center w-150">
                                                8
                                            </th>
                                            <th class="text-center w-150">
                                                9
                                            </th>
                                            <th class="text-center w-150">
                                                10
                                            </th>
                                            <th class="text-center w-150">
                                                11
                                            </th>
                                            <th class="text-center w-150">
                                                12
                                            </th>
                                            <th class="text-center w-150">
                                                13
                                            </th>
                                            <th class="text-center w-150">
                                                14
                                            </th>
                                            <th class="text-center w-150">
                                                15
                                            </th>
                                            <th class="text-center w-150">
                                                16
                                            </th>
                                            <th class="text-center w-150">
                                                17
                                            </th>
                                            <th class="text-center w-150">
                                                18
                                            </th>
                                            <th class="text-center w-150">
                                                19
                                            </th>
                                            <th class="text-center w-150">
                                                20
                                            </th>
                                            <th class="text-center w-150">
                                                21
                                            </th>
                                            <th class="text-center w-150">
                                                22
                                            </th>
                                            <th class="text-center w-150">
                                                23
                                            </th>
                                            <th class="text-center w-150">
                                                24
                                            </th>
                                            <th class="text-center w-150">
                                                25
                                            </th>
                                            <th class="text-center w-150">
                                                26
                                            </th>
                                            <th class="text-center w-150">
                                                27
                                            </th>
                                            <th class="text-center w-150">
                                                28
                                            </th>
                                            <th class="text-center w-150">
                                                29
                                            </th>
                                            <th class="text-center w-150">
                                                30
                                            </th>
                                            <th class="text-center w-150">
                                                31
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(value ,index ) in sale_qty_product">
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
                                        </tbody>
                                    </table>
                                    <table id="collection" style="width: 3000px;"
                                           class="table table-striped table-bordered   display_none ">
                                        <thead>
                                        <tr>
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
                                            <th width="80px" class="text-center">
                                                1
                                            </th>
                                            <th width="80px" class="text-center">
                                                2
                                            </th>
                                            <th width="80px" class="text-center">
                                                3
                                            </th>
                                            <th width="80px" class="text-center">
                                                4
                                            </th>
                                            <th width="80px" class="text-center">
                                                5
                                            </th>
                                            <th width="80px" class="text-center">
                                                6
                                            </th>
                                            <th width="80px" class="text-center">
                                                7
                                            </th>
                                            <th width="80px" class="text-center">
                                                8
                                            </th>
                                            <th width="80px" class="text-center">
                                                9
                                            </th>
                                            <th width="80px" class="text-center">
                                                10
                                            </th>
                                            <th width="80px" class="text-center">
                                                11
                                            </th>
                                            <th width="80px" class="text-center">
                                                12
                                            </th>
                                            <th width="80px" class="text-center">
                                                13
                                            </th>
                                            <th width="80px" class="text-center">
                                                14
                                            </th>
                                            <th width="80px" class="text-center">
                                                15
                                            </th>
                                            <th width="80px" class="text-center">
                                                16
                                            </th>
                                            <th width="80px" class="text-center">
                                                17
                                            </th>
                                            <th width="80px" class="text-center">
                                                18
                                            </th>
                                            <th width="80px" class="text-center">
                                                19
                                            </th>
                                            <th width="80px" class="text-center">
                                                20
                                            </th>
                                            <th width="80px" class="text-center">
                                                21
                                            </th>
                                            <th width="80px" class="text-center">
                                                22
                                            </th>
                                            <th width="80px" class="text-center">
                                                23
                                            </th>
                                            <th width="80px" class="text-center">
                                                24
                                            </th>
                                            <th width="80px" class="text-center">
                                                25
                                            </th>
                                            <th width="80px" class="text-center">
                                                26
                                            </th>
                                            <th width="80px" class="text-center">
                                                27
                                            </th>
                                            <th width="80px" class="text-center">
                                                28
                                            </th>
                                            <th width="80px" class="text-center">
                                                29
                                            </th>
                                            <th width="80px" class="text-center">
                                                30
                                            </th>
                                            <th width="80px" class="text-center">
                                                31
                                            </th>
                                            <th>Total Collection(PKR)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(value ,index ) in collection.data">
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
                                                v-for="(value_collcetion ,key,count ) in value.collection">
                                                {{currency_filter(value_collcetion)}}
                                            </td>
                                            <td class="text-right">
                                                {{value.total| currency('')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="36" class="text-right">
                                                <b>Total</b>
                                            </td>
                                            <td class="text-right"><b>{{collection_total | currency('')}}</b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table id="activate_table" style="display: none"
                                           class="table table-striped table-bordered    ">
                                        <thead>
                                        <tr>
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
                                            <th>IMEI</th>
                                            <th>Delivery Date</th>
                                            <th>Activation Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr  v-for="(value) in activation">
                                            <td>{{value.city_name}}</td>
                                            <td>{{value.retailer_no}}</td>
                                            <td>{{value.outlet_name}}</td>
                                            <td>{{value.region_name}}</td>
                                            <td>{{value.outlet_address}}</td>
                                            <td>{{value.outlet_name}}</td>
                                            <td>{{value.imei1}}</td>
                                            <td>{{value.created_at | moment()}}</td>
                                            <td>{{value.activated_date | moment()}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right"><b>Total</b></td>
                                            <td><b>{{total_activate}}</b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--    <div class="container">
                <nav aria-label="Page navigation">
                    <ul class="pagination" id="pagination"></ul>
                </nav>
            </div>-->
    </div>
</template>
<script>
    import vSelect from "vue-select"

    export default {
        components: {vSelect},
        data() {
            return {
                data_outstanding: [],
                data_outstanding_invoice_wise: [],
                data_sales: [],
                data_sales_qty: [],
                cities: [],
                states: [],
                locality: [],
                sales_officer: [],
                customer: [],
                total_outstanding_invoice: '',
                total_outstanding: '',
                total_sales: '',
                total_sales_qty: '',
                sale_qty_product: [],
                aging: 0,
                red: '',
                report_type: '',
                collection:[],
                collection_total:0,
                activation:[],
                total_activate:'',
                current_month: moment().format('YYYY-MM'),
                filter: [
                    {
                        id: 'customer_wise',
                        name: 'Customer Wise'
                    },
                    {
                        id: 'sales_officer_wise',
                        name: 'Sales Officer Wise'
                    }
                ],
                fdate: '',
                tdate: '',
                total: 0,
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created: function () {
            this.all_states();
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
                    return accounting.formatMoney(currency, {symbol: "", format: "%v %s"})
                }
                else {
                    return '';
                }
            },
            report: function () {
                this.filter = [];
                this.sales_officer = [];
                this.locality = [];
                this.customer = [];
                this.cities = [];
                this.wise_reset();
                $('#locality_div').hide();
                $('#city_div').hide();
                $('#month_div').hide();
                $('#sales_report_type_div').hide();
                this.outstanding_option("hide");
                var report_type = $('#report').val();
                if (report_type == "outstanding") {
                    this.outstanding_option("show");
                    axios.get('temporary').then((response) => {
                        this.filter_reset();
                });
                }
                if (report_type == "sales") {
                    axios.get('temporary').then((response) => {
                        this.filter_reset();
                });
                    $('#month_div').show();
                    $('#div_filter').show();
                    $('#sales_report_type_div').show();
                }
                if(report_type == "collection"){
                    axios.get('temporary').then((response) => {
                        this.filter_reset();
                });
                    $('#month_div').show();
                    $('#div_filter').show();
                }
                if(report_type == "activation"){
                    axios.get('temporary').then((response) => {
                        this.filter_reset();
                });
                    $('#div_fdate').show();
                    $('#div_tdate').show();
                    $('#div_filter').show();
                }
            },
            outstanding_option: function (action) {
                if (action == "hide") {
                    $('#div_fdate').hide();
                    $('#div_tdate').hide();
                    $('#div_filter').hide();
                    $('#div_invoice_wise').hide();

                }
                if (action == "show") {
                    $('#div_fdate').show();
                    $('#div_tdate').show();
                    $('#div_filter').show();
                    $('#div_invoice_wise').show();
                }
            },
            all_cities: function (id) {
                axios.get('get_cities/' + id).then((response) => {
                    this.cities = response.data;
            });
            },
            all_states: function () {
                axios.get('get_states').then((response) => {
                    this.states = response.data;
            });
            },
            state: function () {
                var state_id = $('#states').val();
                this.all_cities(state_id);
                this.filter = [];
                this.sales_officer = [];
                this.locality = [];
                this.customer = [];
                this.cities = [];
                this.wise_reset();
                $('#locality_div').hide();
                $('#city_div').hide();
                axios.get('temporary').then((response) => {
                    this.filter_reset();
            });
                if (state_id != "all") {
                    $('#city_div').show();
                }

            },
            city: function () {
                this.filter = [];
                this.sales_officer = [];
                this.locality = [];
                this.customer = [];
                this.wise_reset();
                $('#locality_div').hide();
                var city_id = $('#cities').val();
                axios.get('region/' + city_id).then((response) => {
                    this.filter_reset();
                if (city_id != "all") {
                    $('#locality_div').show();
                }
                if (response.data.status == true) {
                    response.data.region[response.data.region.length] = {'id': 'all', 'name': 'All'};
                    this.locality = response.data.region.reverse();
                }
            });
            },
            type: function () {
                this.sales_officer = [];
                this.customer = [];
                this.wise_reset();
                var type = $('#type').val();
                var city_id = $('#cities').val();
                var state_id = $('#states').val();
                if (type == "sales_officer_wise") {
                    axios.get('get_sales_officer/' + city_id + "/" + state_id).then((response) => {
                        if (response.data.status == true) {
                        $('#sales_officer_div').show();
                        this.sales_officer = response.data.data;
                    }
                });
                }
                if (type == "customer_wise") {
                    var column = null;
                    var id = null;
                    var locality = $('#locality').val();
                    if (locality != null && locality != "all") {
                        column = "region_id";
                        id = locality;
                    }
                    else {
                        column = "city_id";
                        id = city_id;
                    }
                    axios.get('get_customer/' + id + '/' + column + '/' + state_id).then((response) => {
                        if (response.data.status == true) {
                        $('#customer_div').show();
                        this.customer = response.data.data;
                    }
                });
                }
            },
            localities: function () {
                this.filter = [];
                this.customer = [];
                this.wise_reset();
                axios.get('temporary').then((response) => {
                    this.filter_reset();
            });
            },
            filter_reset: function () {
                this.filter = [{
                    id: 'customer_wise',
                    name: 'Customer Wise'
                },
                    {
                        id: 'sales_officer_wise',
                        name: 'Sales Officer Wise'
                    },
                ];
            },
            wise_reset: function () {
                $('#customer_div').hide();
                $('#sales_officer_div').hide();
            },test :function () {
                alert();
            },
            search: function () {
                this.data_outstanding = [];
                this.data_outstanding_invoice_wise = [];
                this.data_sales = [];
                this.total_sales = [];
                this.data_sales_qty = [];
                this.total_sales_qty = [];
                this.sale_qty_product = [];
                this.collection=[];
                this.activation=[];
                $("#outstanding_grid").hide();
                $("#outstanding_invoice_grid").hide();
                $("#sale_sales").hide();
                $("#sale_qty").hide();
                $("#sale_product").hide();
                $("#collection").hide();
                $("#activate_table").hide();
                var fdate = this.fdate;
                var tdate = this.tdate;
                var city = $('#cities').val();
                var locality = $('#locality').val();
                var report_type = $('#report').val();
                var sale_officer = $('#sale').val();
                var customer = $('#customer').val();
                var state = $('#states').val();
                var warehouse = null;
                if (fdate != "") {
                    fdate = moment(fdate).format('YYYY-MM-DD');
                }
                if (tdate != "") {
                    tdate = moment(tdate).format('YYYY-MM-DD');
                }
                if (report_type == "outstanding") {
                    var data = {
                        'fdate': fdate,
                        'tdate': tdate,
                        'city': city,
                        'locality': locality,
                        'sales_officer': sale_officer,
                        'customer': customer,
                        'state': state,
                    }
                    if ($('#invoice_wise').val() != "invoice_wise") {
                        axios.post('report/get_outstanding', data).then((response) => {
                            console.log(response.data);
                        if (response.data.status == true) {
                            this.data_outstanding = response.data.data;
                            this.total_outstanding = {
                                'outstanding': response.data.outstanding_paid.total_outstanding - response.data.outstanding_paid.total_paid,
                                'aging': response.data.aging
                            };
                            $("#outstanding_grid").removeClass("hide");
                            $("#outstanding_grid").show();
                        } else {
                            alert("No Data Found");
                        }
                    });
                    }
                    else {
                        axios.post('report/get_outstanding_invoice_wise', data).then((response) => {
                            if (response.data.status == true) {
                            this.data_outstanding_invoice_wise = response.data.data;
                            this.total_outstanding_invoice = response.data.outstanding_paid.total_outstanding.total_outstanding - response.data.outstanding_paid.total_paid.total_paid;
                            this.aging = response.data.aging;
                            $("#outstanding_invoice_grid").removeClass("hide");
                            $("#outstanding_invoice_grid").show();
                        } else {
                            alert("No Data Found");
                        }
                    });
                    }
                }
                if (report_type == "sales") {
                    var sales_report_type = $("#sales_report_type").val();
                    var month = $("#month").val();
                    var data = {
                        'state': state,
                        'city': city,
                        'locality': locality,
                        'month': month,
                        'sales_officer': sale_officer,
                        'customer': customer,
                    }
                    if (month != "") {
                        if (sales_report_type == "sales_wise") {
                            axios.post('report/get_sales', data).then((response) => {
                                console.log(response.data);
                            if (response.data.status == true) {
                                this.data_sales = response.data.data;
                                this.total_sales = response.data.total - response.data.sale_return;
                                $("#sale_sales").show();
                            } else {
                                alert("No Data Found");
                            }
                        });
                        }
                        if (sales_report_type == "quantity_wise") {
                            axios.post('report/get_sales_qty', data).then((response) => {
                                console.log(response.data);
                            if (response.data.status == true) {
                                this.data_sales_qty = response.data.data;
                                this.total_sales_qty = response.data.total-response.data.sale_return_total;
                                $("#sale_qty").show();
                            } else {
                                //  alert("No Data Found");
                            }
                        });
                        }
                        if (sales_report_type == "product_wise") {
                            axios.post('report/get_sales_qty_product', data).then((response) => {
                                if (response.data.status == true) {
                                this.sale_qty_product = response.data.data;
                                $("#sale_product").show();
                            } else {
                                alert("No Data Found");
                            }
                        });
                        }
                    } else {
                        alert('Please Select Month');
                    }
                }
                if(report_type == "collection"){
                    var month = $("#month").val();
                    var data = {
                        'state': state,
                        'city': city,
                        'locality': locality,
                        'month': month,
                        'sales_officer': sale_officer,
                        'customer': customer,
                    }
                    axios.post('report/collection', data).then((response) => {

                        if (response.data.status == true) {
                        this.collection=response.data;
                        this.collection_total=response.data.collection_total;
                        $("#collection").show();

                    } else {
                        alert("No Data Found");
                    }
                });
                }
                if(report_type=="activation"){
                    var month = $("#month").val();
                    var data = {
                        'fdate': fdate,
                        'tdate': tdate,
                        'city': city,
                        'locality': locality,
                        'sales_officer': sale_officer,
                        'customer': customer,
                        'state': state,
                    }
                    axios.post('report/activate', data).then((response) => {
                        console.log(response.data);
                    if (response.data.status == true) {
                        this.activation=response.data.data;
                        this.total_activate=response.data.total;
                        $("#activate_table").show();
                    } else {
                        alert("No Data Found");
                    }
                });
                }
            }
        }
    }
    /*
    $(document).ready(function () {

        $(function () {
            var obj = $('#pagination').twbsPagination({
                totalPages: 35,
                visiblePages: 5,

                onPageClick: function (event, page) {
                    console.info(page);
                    $.ajax({url: "temporary", success: function(result){
                            test();
                        }});
                }
            });
            //console.info(obj.data());
        });

    })*/
</script>
<style>
    .width {
        width: 100px;
    }

    .tr {
        border-bottom: 1px solid #ddd;
    }

    .display_none {
        display: none;
    }

    .border_table {
        border-left: 1px solid #ddd;
    }

    .red {
        color: red;
    }

    .m-p-0 {
        margin: 0px;
        padding: 0px
    }

    .v-a-t {
        vertical-align: top !important;
    }

    .w-150 {
        width: 180px;
    }
    p{
        text-align: center;
    }

</style>