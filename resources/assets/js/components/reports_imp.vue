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
                                    <input type="month" id="month" class="form-control" @change="month"
                                           :value="current_month">
                                </div>
                            </div>
                            <div class="col-md-4 display_none m-p-0" id="div_fdate">
                                <div class="col-md-4">
                                    <label>Date From</label>
                                </div>
                                <div class="col-md-8">
                                    <date-picker name="fdate" v-model="fdate" type="date" format="dd-MM-yyyy" style="width: 100%"
                                                 placeholder="dd-mm-yyyy" lang="en" required></date-picker>
                                </div>
                            </div>
                            <div class="col-md-4 display_none m-p-0" id="div_tdate">
                                <div class="col-md-4">
                                    <label>Date To </label>
                                </div>
                                <div class="col-md-8">
                                    <date-picker name="tdate" v-model="tdate" type="date" format="dd-MM-yyyy" style="width: 100%"
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
                                    <select @change="type" id="type" class="textbox_dropdown form-control">
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
                                    <div id="asdasd"></div>
                                    <select id="sale" class="form-control">
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
                                    <select id="invoice_wise" class="textbox_dropdown form-control ">
                                        <option value="">-Select-</option>
                                        <option value="invoice_wise">Invoice Wise</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 display_none  m-p-0" id="div_activation_wise">
                                <div class="col-md-4">
                                    <label>Type </label>
                                </div>
                                <div class="col-md-8">
                                    <select id="activation_wise" @change="activation_type"
                                            class="select_option textbox_dropdown form-control ">
                                        <option value="">-Select-</option>
                                        <option v-for="(filter_type) in activation_type"
                                                v-bind:value="activation_type.id">
                                            {{activation_type.name}}
                                        </option>
                                        <option value="outlet_wise">Outlet Wise</option>
                                        <option value="outlet_activation_wise">Outlet Activation Wise</option>
                                        <option value="outlet_products_wise">Outlet Products Wise</option>
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
                        <div class="row">
                            <div class="col-md-4 m-p-0 display_none" id="products_div">
                                <div class="col-md-4">
                                    <label>Product</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="products" @change="color" class="textbox_dropdown form-control ">
                                        <option value="">-Select-</option>
                                        <option v-for="(value) in all_products"
                                                v-bind:value="value.id">
                                            {{value.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 m-p-0 display_none" id="colors_div">
                                <div class="col-md-4">
                                    <label>Color</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="colors" class="textbox_dropdown form-control ">
                                        <option value="">-Select-</option>
                                        <option v-for="(value) in all_colors"
                                                v-bind:value="value.id">
                                            {{value.color}}
                                        </option>
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
                <div id="main_panel" class="panel  display_none" >
                    <div class="" style="height:30px;">
                        <button class="btn btn-success pull-right export_to_excell display_none" id="generate-excel"
                                @click="exportTableToExcel(report_name,file_name)"> Export To Excel
                        </button>
                    </div>
                </div>

                <ReportTableComponent :report_data="table_data" :report_table_type="report_table_type" v-if="is_component_loaded==true"></ReportTableComponent>
                <center><img :src="loading" alt="loading" width="70px" id="loading" class="display_none"></center>
            </div>
        </div>
    </div>
</template>
<script>
    import vSelect from "vue-select"
    import {constant} from '../constant.js';
    import test from './ReportTableComponent.vue';

    export default {
        components: {vSelect, ReportTableComponent: test},


        data() {
            return {
                is_component_loaded:false,
                report_table_type:'',
                cities: [],
                states: [],
                locality: [],
                sales_officer: [],
                customer: [],
                total_outstanding_invoice: '',
                red: '',
                report_type: '',
                all_products: [],
                all_colors: [],
                report_name: '',
                file_name: '',
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
                filter_type: [
                    {
                        id: 'outlet_wise',
                        name: 'Outlet Wise'
                    },
                    {
                        id: 'outlet_activation_wise',
                        name: 'Outlet Activation Wise'
                    },
                    {
                        id: 'outlet_products_wise',
                        name: 'Outlet Products Wise'
                    }
                ],
                fdate: '',
                tdate: '',
                total: 0,
                table_data: [],
                loading: constant.base_url + 'img/loading.gif'
            }
        },
        mounted() {
            console.log('Component mounted.')
            $('#btn_expand').show();
            $('#sidebar').hide();
            $('#content_placeholder').removeClass('col-md-10');
            $('#content_placeholder').addClass('col-md-12');
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
                    return accounting.formatMoney(currency, "", ",")
                }
                else {
                    return '';
                }
            },
            month: function () {
                this.current_month = $('#month').val();
            },
            report: function () {
                this.filter = [];
                this.sales_officer = [];
                this.locality = [];
                this.customer = [];
                this.cities = [];
                this.all_products = [];
                this.all_colors = [];
                this.current_month = moment().format('YYYY-MM');
                this.wise_reset();
                $('#locality_div').hide();
                $('#city_div').hide();
                $('#month_div').hide();
                $('#sales_report_type_div').hide();
                this.outstanding_option("hide");
                $('#products_div').hide();
                $('#colors_div').hide();
                $('.export_to_excell').hide();
                $('#div_activation_wise').hide();
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
                if (report_type == "collection") {
                    axios.get('temporary').then((response) => {
                        this.filter_reset();
                    });
                    $('#month_div').show();
                    $('#div_filter').show();
                }
                if (report_type == "activation") {
                    $('#div_activation_wise').show();
                    axios.get('temporary').then((response) => {
                        this.filter_activation();
                    });
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
            activation_type: function () {
                $('#div_fdate').hide();
                $('#div_tdate').hide();
                $('#div_filter').hide();
                $('#products_div').hide();
                $('#colors_div').hide();
                var activation_type = $('#activation_wise').val();
                if (activation_type == "outlet_activation_wise") {
                    axios.get('get_all_products').then((response) => {
                        this.filter_reset();
                        this.all_products = response.data;
                    });
                    $('#div_fdate').show();
                    $('#div_tdate').show();
                    $('#div_filter').show();
                    $('#products_div').show();
                    $('#colors_div').show();
                }
                if (activation_type == "outlet_wise") {
                    this.filter_reset();
                    $('#div_fdate').show();
                    $('#div_tdate').show();
                    $('#div_filter').show();
                }
                if (activation_type == "outlet_products_wise") {
                    this.filter_reset();
                    $('#div_fdate').show();
                    $('#div_tdate').show();
                    $('#div_filter').show();
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
            color: function () {
                var product_id = $('#products').val();
                this.all_colors = [];
                axios.get('get_all_product_colors/' + product_id).then((response) => {
                    this.all_colors = response.data;
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
            }, test: function () {
                alert();
            },
            loading_show: function () {
                $('#main_panel').show();
                $('#loading').hide();
            },
            loading_hide: function () {
                $('#main_panel').hide();
                $('#loading').show();
            },
            no_data_found: function () {
                $('#loading').hide();
                alert("No Data Found");
            },
            search: function () {
                this.is_component_loaded=false;
                this.report_table_type='';
                this.table_data=[];
                this.loading_hide();

                $("#sale_product").hide();


                var fdate = this.fdate;
                var tdate = this.tdate;
                var city = $('#cities').val();
                var locality = $('#locality').val();
                var report_type = $('#report').val();
                var sale_officer = $('#sale').val();
                var customer = $('#customer').val();
                var state = $('#states').val();
                var warehouse = null;
                var activation_type = $('#activation_wise').val();
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
                            if (response.data.status == true) {
                                this.table_data=response.data;
                                this.report_table_type='invoice_wise';
                                this.is_component_loaded=true;
                                this.report_name = 'outstanding_grid';
                                this.file_name = 'Outstanding_Report_' + moment().format('DD-MM-YYYY');
                                $('.export_to_excell').show();
                                this.loading_show();
                            } else {
                                this.no_data_found();
                            }
                        });
                    }
                    else {
                        axios.post('report/get_outstanding_invoice_wise', data).then((response) => {
                            if (response.data.status == true) {
                                this.table_data=response.data;
                                this.report_table_type='outstanding_invoice_wise';
                                this.is_component_loaded=true;
                                this.report_name = 'outstanding_invoice_grid';
                                this.file_name = 'Outstanding_InvoiceWise_Report_' + moment().format('DD-MM-YYYY');
                                $('.export_to_excell').show();
                                this.loading_show();
                            } else {
                                this.no_data_found();
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
                            axios.post('report/get_sales', data).then((response) => {     console.log(response.data);
                                if (response.data.status == true) {
                                    this.table_data=response.data;
                                    this.report_table_type='sale_sales'
                                    this.report_name = 'sale_sales';
                                    this.file_name = 'Sales_Report_' + moment().format('DD-MM-YYYY');
                                    $('.export_to_excell').show();
                                    this.loading_show();
                                    this.is_component_loaded=true;
                                } else {
                                    this.no_data_found();
                                }
                            });
                        }
                        if (sales_report_type == "quantity_wise") {
                            axios.post('report/get_sales_qty', data).then((response) => {
                                if (response.data.status == true) {
                                    this.table_data=response.data;
                                    this.report_table_type='sale_quantity';
                                    this.is_component_loaded=true;
                                    this.report_name = 'sale_qty';
                                    this.file_name = 'Sales_Qty_Report_' + moment().format('DD-MM-YYYY');
                                    $('.export_to_excell').show();
                                    this.loading_show();
                                } else {
                                    this.no_data_found();
                                }
                            });
                        }
                        if (sales_report_type == "product_wise") {
                            axios.post('report/get_sales_qty_product', data).then((response) => {
                                if (response.data.status == true) {
                                    this.table_data=response.data;
                                    this.report_table_type='sale_quantity_products';
                                    this.is_component_loaded=true;
                                    $('.export_to_excell').hide();
                                    this.loading_show();
                                } else {
                                    this.no_data_found();
                                }
                            });
                        }
                    } else {
                        alert('Please Select Month');
                    }
                }
                if (report_type == "collection") {
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
                            this.table_data=response.data;
                            this.report_table_type='collection';
                            this.is_component_loaded=true;
                            this.report_name = 'collection';
                            this.file_name = 'Collection_Report_' + moment().format('DD-MM-YYYY');
                            $('.export_to_excell').show();
                            this.loading_show();
                        } else {
                            this.no_data_found();
                        }
                    });
                }
                if (report_type == "activation") {
                    var product = $("#products").val();
                    var color = $("#colors").val();
                    var data = {
                        'fdate': fdate,
                        'tdate': tdate,
                        'city': city,
                        'locality': locality,
                        'sales_officer': sale_officer,
                        'customer': customer,
                        'state': state,
                        'product': product,
                        'color': color
                    }
                    if (activation_type == "outlet_activation_wise") {
                        axios.post('report/activate', data).then((response) => {
                            if (response.data.status == true) {
                                this.table_data=response.data;
                                this.report_table_type='outlet_activation_wise';
                                this.is_component_loaded=true;
                                this.report_name = 'activate_table';
                                this.file_name = 'Activate_Report_' + moment().format('DD-MM-YYYY');
                                $('.export_to_excell').show();
                                this.loading_show();
                            } else {
                                this.no_data_found();
                            }
                        });
                    }
                    if (activation_type == "outlet_wise") {
                        axios.post('report/activation_outlet', data).then((response) => {
                            if (response.data.status == true) {
                                this.table_data=response.data;
                                this.report_table_type='outlet_wise';
                                this.is_component_loaded=true;
                                this.report_name = 'outlet_activate_table';
                                this.file_name = 'Activate_Report_' + moment().format('DD-MM-YYYY');
                                $('.export_to_excell').show();
                                this.loading_show();
                            } else {
                                this.no_data_found();
                            }
                        });
                    }
                    if (activation_type == "outlet_products_wise") {
                        axios.get('get_all_products').then((response) => {
                            this.table_data['products']=response.data;
                            this.table_data['length']=response.data.length + 5;
                        });
                        axios.post('report/activation_outlet_products', data).then((response) => {
                            if (response.data.status == true) {
                                this.table_data['result']=response.data;
                                this.report_table_type='outlet_products_activate';
                                this.is_component_loaded=true;
                                this.report_name = 'outlet_products_activate_table';
                                this.file_name = 'Activate_Report_' + moment().format('DD-MM-YYYY');
                                $('.export_to_excell').show();
                                this.loading_show();
                            } else {
                                this.no_data_found();
                            }
                        });
                    }
                    if (activation_type == "") {
                        $('#loading').hide();
                    }
                }
            },
            exportTableToExcel: function (tableID, filename = '') {
                var downloadLink;
                var dataType = 'application/vnd.ms-excel';
                var tableSelect = document.getElementById(tableID);
                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
                filename = filename ? filename + '.xls' : 'excel_data.xls';
                downloadLink = document.createElement("a");
                document.body.appendChild(downloadLink);
                if (navigator.msSaveOrOpenBlob) {
                    var blob = new Blob(['\ufeff', tableHTML], {
                        type: dataType
                    });
                    navigator.msSaveOrOpenBlob(blob, filename);
                } else {
                    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
                    downloadLink.download = filename;
                    downloadLink.click();
                }
            }
        }
    }


</script>
