<template>
    <div>
        <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h5>INVOICE LIST</h5>
                </div>
                <!-- RETAILER SHOW GRID -->
                <div class="panel-body">
                    <div class="projects">
                        <div class="tableFilters">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="control">
                                        <div class="select">
                                            <Label>Records:</Label>
                                            <select v-model="tableData.length" @change="getProjects()">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="200">200</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input class="textbox" type="text" v-model="tableData.search" placeholder="Search..."
                                           @input="getProjects()">
                                </div>
                            </div>
                        </div>
                        <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                            <tbody>
                            <tr v-for="(invoice, index) in all_invoice" :key="invoice.id">
                                <td>{{invoice.created_at | moment }}</td>
                                <td>{{invoice.retailer_order.retailer_outlet.name}} ({{invoice.retailer_order.retailer_outlet.retailer.retailer_no}})</td>
                             <td>{{invoice.retailer_order.retailer_outlet.city.name}}</td>
                                <td>{{invoice.retailer_order.retailer_outlet.region.name}}</td>
                                <td>{{invoice.retailer_order.sales_officer.name}}</td>
                                <td v-if="invoice.is_invoice==1">{{invoice.retailer_order.order_no}} reversed</td>
                                <td v-else-if="invoice.is_invoice==2">{{invoice.retailer_order.order_no}} reversed entry</td>
                                <td v-else>{{invoice.retailer_order.order_no}}</td>
                                <td>{{invoice.invoice_no}}</td>
                                <td><span class="pull-right">{{invoice.total_amount | currency('')}}</span></td>
                                <td><!-- v-if="invoice.warehouse_issue[0].is_issued==1" -->
                                    <button type="button" title="View Detail" class="btn btn-success btn-xs"
                                            v-on:click="details(invoice.id)"><i class="fa fa-eye"></i></button>
                                    <button class="btn btn-github btn-xs" title="Print" v-on:click="print(invoice.id)"
                                    ><i class="fa fa-print"></i>
                                    </button>
                                    <button class="btn btn-github btn-xs" title="Print Imei" v-if="invoice.warehouse_issue[0] && invoice.warehouse_issue[0].is_issued==1"  v-on:click="print_imei(invoice.id)"
                                    ><i class="fa fa-print"></i>
                                    </button>
                                    <button v-if="invoice.is_invoice==0 && invoice.is_pay==0 && date_format(invoice.created_at)==current_date()" class="btn btn-github btn-xs" v-on:click="reversal(invoice.id)"><span
                                            title="Reversed" class="fa fa-mail-reply-all" style="color: red;"></span>
                                    </button>
                                    <button class="btn btn-github btn-xs" title="Return Imei"  v-on:click="print_return_imei(invoice.id)"
                                    ><i class="fa fa-print"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </datatable>
                        <pagination :pagination="pagination"
                                    @prev="getProjects(pagination.prevPageUrl)"
                                    @next="getProjects(pagination.nextPageUrl)">
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
        <!--model view start-->
        <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog" id="order_details"
             aria-labelledby="bs-add-Model-modal-md">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <div class="row">
                            <div style="margin-left: 10px;">
                                <h4 class="modal-title">Order Details</h4>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label>Invoice No</label> : {{invoice_details.invoice_no}}
                                </div>
                                <div class="col-md-12">
                                    <label>Order No</label> : {{invoice.order_no}}
                                </div>
                                <div class="col-md-12">
                                    <label>Sales Officer</label> : {{sales_oficer_name}}
                                </div>

                                <div class="col-md-12">
                                    <label>Aging Date</label> : {{duedate}}
                                </div>
                                <div class="col-md-12">
                                    <label>Total Amount(PKR)</label> : {{invoice_details.total_amount | currency('')}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label>Outlet Name</label> : {{outlet.name}}
                                </div>
                                <div class="col-md-12">
                                    <label>Outlet Address</label> : {{outlet.address}}
                                </div>
                                <div class="col-md-12">
                                    <label>Mobile No</label> : {{outlet.mobile_no}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Product Name</th>
                                        <th>Product Color</th>
                                        <th>IMEI1</th>
                                        <th>IMEI2</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(details, index) in warehouse_issue">
                                        <td>{{++index}}</td>
                                        <td>{{details.item.product_color.product.name}}</td>
                                        <td>{{details.item.product_color.color}}</td>
                                        <td v-for="(details_imei) in details.item.imei">{{details_imei.imei1}}</td>
                                        <td v-for="(details_imei) in details.item.imei">{{details_imei.imei2}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--model view end -->
    </div>
</template>
<script>
    import Datatable from './DatatableComponent.vue';
    import Pagination from './PaginationComponent.vue';
    export default {
        components: {datatable: Datatable, pagination: Pagination},
        data() {
            let sortOrders = {};
            let columns = [
                //{width: '10%', label: 'S.No', name: 'S.No' },
                {width: '10%', label: 'Date', name: 'Date'},
                {width: '20%', label: 'Outlet Name', name: 'Outlet Name'},
                {width: '10%', label: 'City', name: 'City'},
                {width: '10%', label: 'Region', name: 'Region'},
                {width: '10%', label: 'SO', name: 'SO'},
                {width: '10%', label: 'Order No', name: 'Order No'},
                {width: '10%', label: 'Invoice No', name: 'Invoice No'},
                {width: '10%', label: 'Total Amount(PKR)', name: 'Total Amount(PKR)'},
                {width: '15%', label: 'Action', name: 'Action'},
            ];
            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });
            return {
                projects:[],
                columns: columns,
                sortKey: 'Dealer ID',
                sortOrders: sortOrders,
                tableData: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc',
                },
                pagination: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: ''
                },
                message: '',
                all_invoice: [],
                moment: '',
                date_time: '',
                s_no: 1,
                warehouse_issue: [],
                invoice_details: [],
                invoice: [],
                outlet: [],
                duedate: '',
                is_issued: [],
                sales_oficer_name:'',
            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        created: function () {
            this.init();
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            },
            date_time: function (date) {
                return moment(date).format('DD-MM-YYYY h:m a');
            }
        },
        methods: {
            init: function () {
                //this.get_all_invoice();
                this.getProjects();
            },
            getProjects(url = '../invoice/get_invoice') {
                this.tableData.draw++;
                axios.get(url, {params: this.tableData})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData.draw == data.draw) {
                            this.all_invoice = data.data.data;
                            //   console.log(this.all_invoice);
                            this.configPagination(data.data);
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            configPagination(data) {
                this.pagination.lastPage = data.last_page;
                this.pagination.currentPage = data.current_page;
                this.pagination.total = data.total;
                this.pagination.lastPageUrl = data.last_page_url;
                this.pagination.nextPageUrl = data.next_page_url;
                this.pagination.prevPageUrl = data.prev_page_url;
                this.pagination.from = data.from;
                this.pagination.to = data.to;
            },
            sortBy(key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.getProjects();
            },
            getIndex(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },
            get_all_invoice: function () {
                axios.get('../invoice/get_invoice').then((response) => {
                    this.all_invoice = response.data;
                });
            },
            details: function (id) {
                this.invoice_details=[];
                this.warehouse_issue=[];
                axios.get('../invoice/details/' + id).then((response) => {
                    this.invoice_details = response.data;
                    this.invoice = this.invoice_details.retailer_order;
                    this.outlet = this.invoice.retailer_outlet;
                    this.sales_oficer_name=response.data.retailer_order.sales_officer.name;
                    this.duedate = moment(this.invoice_details.created_at).add(this.outlet.credit_duration, 'days').format('DD-MM-YYYY');
                    if (response.data.warehouse_issue != "") {
                        this.warehouse_issue = response.data.warehouse_issue[0].warehouse_issue_item;
                    }
                    $('#order_details').modal('show');
                });
            }, print: function (id) {
                window.open("../invoice/print/" + id, '_blank');
            }, print_imei: function (id) {
                window.open("../order/imei/print/" + id, '_blank');
            },
            print_return_imei:function(id){
                window.open("../order/imei/return/print/" + id, '_blank');
            },
            reversal: function (id) {
                location.assign("../invoice/reversal/" + id);
            },
            date_format:function(date){
                return moment(date).format('YYYY-MM-DD');
            },
            current_date:function(){
                return moment().format('YYYY-MM-DD');
            },
        }
    }
    $(document).ready(function () {
        setTimeout(function () {
            $('#invoice_table').DataTable({
                "order": [[0, "desc"]],
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            });
        }, 1000);
    });
</script>


