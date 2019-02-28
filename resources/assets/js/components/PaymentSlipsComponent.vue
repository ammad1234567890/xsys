<template>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#deposit_slips" aria-controls="deposit_slips" role="tab" class=" button-info" data-toggle="tab">Deposit Slips</a>
                </li>
                <li role="presentation">
                    <a href="#advance_payment" aria-controls="advance_payment" role="tab" data-toggle="tab">Payment From Advance</a>
                </li>
                <li role="presentation">
                    <a href="#credit_notes" aria-controls="credit_notes" role="tab" data-toggle="tab">Credit Notes</a>
                </li>

                <!--<li role="presentation">
                  <a href="#product_details" aria-controls="product_details" role="tab" data-toggle="tab">Find Product</a>
                </li>-->
            </ul>

            <div class="tab-content">
                <div role="tabpanel " class="tab-pane active" id="deposit_slips">
                    <div class="panel panel-info" >
                        <div class="panel-heading">
                            <h2 class="panel-title">Dealers (Deposit Slips)</h2>
                        </div>
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
                                <div><b>Total Amount:</b> {{total_deposit_slip_amount | currency('Rs')}}</div>
                                <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                                    <tbody>
                                    <tr v-for="(ds, index) in ds" :key="ds.id">
                                        <td>{{ds.created_at | moment}}</td>
                                        <td><b>{{ds.deposit_slip_number}}</b></td>
                                        <td>{{ds.retailer.retailer_no}}</td>
                                        <td>{{ds.retailer_outlet.name}}</td>
                                        <td><b>{{ds.bank.bank_name}}</b></td>
                                        <td><b>{{ds.payment_type.type}}</b></td>
                                        <td>{{ds.total_amount | currency('Rs')}}</td>

                                        <td>

                                    <span v-if="ds.payment_type.id==3 && ds.transaction_closed==0">
                                        <a :href="'../retailer_order/order_payment_reversal/'+ds.id">
                                            <button class="btn btn-xs btn-danger" title="Reverse Payment"><i class="fa fa-undo"></i></button>
                                        </a>

                                            <button class="btn btn-xs btn-success" title="Transaction Closed" @click="transaction_closed(ds.id)"><i class="fa fa-check"></i></button>

                                    </span>
                                            <button class="btn btn-xs btn-primary" @click="get_ds_details(ds.id)"><span class="fa fa-eye"></span></button>

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
                <div role="tabpanel " class="tab-pane" id="advance_payment">
                    <div class="panel panel-info" >
                        <div class="panel-heading">
                            <h2 class="panel-title">Dealers (Advance Payment Deduction)</h2>
                        </div>
                        <div class="panel-body">
                            <div class="projects">
                                <div class="tableFilters">

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="control">
                                                <div class="select">
                                                    <Label>Records:</Label>
                                                    <select v-model="tableData2.length" @change="getAdvancePayments()">
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

                                            <input class="textbox" type="text" v-model="tableData2.search" placeholder="Search..."
                                                   @input="getAdvancePayments()">
                                        </div>
                                    </div>
                                </div>
                                <div><b>Total Amount:</b> {{total_advance_deduction_amount | currency('Rs')}}</div>
                                <datatable :columns="columns2" :sortKey="sortKey2" :sortOrders="sortOrders2" @sort="sortBy2">
                                    <tbody>
                                    <tr v-for="(advance, index) in advance_payments" :key="">
                                        <td>{{advance.created_at | moment}}</td>
                                        <td>{{advance.retailer.retailer_no}}</td>
                                        <td>{{advance.retailer_outlet.name}}</td>
                                        <td>{{advance.invoice.invoice_no}}</td>
                                        <td>{{advance.amount | currency('Rs') }}</td>
                                    </tr>
                                    </tbody>
                                </datatable>
                                <pagination :pagination="pagination2"
                                            @prev="getAdvancePayments(pagination2.prevPageUrl)"
                                            @next="getAdvancePayments(pagination2.nextPageUrl)">
                                </pagination>
                            </div>

                        </div>
                    </div>
                </div>
                <div role="tabpanel " class="tab-pane" id="credit_notes">
                    <div class="panel panel-info" >
                        <div class="panel-heading">
                            <h2 class="panel-title">Dealers (Credit Notes)</h2>
                        </div>
                        <div class="panel-body">
                            <div class="projects">
                                <div class="tableFilters">

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="control">
                                                <div class="select">
                                                    <Label>Records:</Label>
                                                    <select v-model="tableData3.length" @change="getCreditPayments()">
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

                                            <input class="textbox" type="text" v-model="tableData3.search" placeholder="Search..."
                                                   @input="getCreditPayments()">
                                        </div>
                                    </div>
                                </div>
                                <div><b>Total Amount:</b> {{total_credit_note_amount | currency('Rs') }}</div>
                                <datatable :columns="columns3" :sortKey="sortKey3" :sortOrders="sortOrders3" @sort="sortBy3">
                                    <tbody>
                                    <tr v-for="(credit, index) in credit_payments" :key="credit.id">
                                        <td>{{credit.created_at | moment}}</td>
                                        <td>{{credit.cr_no}}</td>
                                        <td>{{credit.retailer.retailer_no}}</td>
                                        <td>{{credit.retailer_outlet.name}}</td>
                                        <td><b>{{credit.cr_type.name}}</b></td>
                                        <td>{{credit.amount | currency('Rs')}}</td>
                                        <td>{{credit.remarks}}</td>
                                    </tr>
                                    </tbody>
                                </datatable>
                                <pagination :pagination="pagination3"
                                            @prev="getAdvancePayments(pagination3.prevPageUrl)"
                                            @next="getAdvancePayments(pagination3.nextPageUrl)">
                                </pagination>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="payment_details_modal" aria-labelledby="bs-add-Model-modal-md">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Collection Details</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <h5><b>Deposit Slip: </b>{{this.ds_details.deposit_slip_number}}</h5>
                                <h5><b>Total Amount: </b>{{this.ds_details.total_amount}}</h5>
                                <h5><b>Outlet: </b>{{this.outlet}}</h5>
                                <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Invoice No/Advance</th>
                                        <th>Amount</th>
                                        <th>Cheque/Cash</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(details, index) in ds_details.get_ds_collections">
                                            <td><span v-if="details.invoice_id!=null" style="color: green; font-weight:bold;">{{details.invoice.invoice_no}}</span><span v-else  style="color: orange; font-weight:bold;">Advance</span></td>
                                            <td>{{details.amount}}</td>
                                            <td><span v-if="details.cheque_number!=null">{{details.cheque_number}}</span><span v-else>Cash</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>


    </div>

</template>
<script>
    import {constant} from '../constant.js';
    import Datatable from './DatatableComponent.vue';
    import Pagination from './PaginationComponent.vue';
    export default {
        components: {datatable: Datatable, pagination: Pagination},
        data() {
            let sortOrders = {};
            let columns = [
                {width: '10%', label: 'Date', name: 'Date' },
                {width: '10%', label: 'DS#', name: 'DS#'},
                {width: '10%', label: 'Dealer Code', name: 'Dealer Code'},
                {width: '20%', label: 'Outlet', name: 'Outlet'},
                {width: '10%', label: 'Bank', name: 'Bank'},
                {width: '20%', label: 'Payment Type', name: 'Payment Type'},
                {width: '10%', label: 'Total Amount', name: 'Total Amount'},
                {width: '25%', label: 'Action', name: 'Action'},
            ];
            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });


            let sortOrders2 = {};
            let columns2 = [
                {width: '10%', label: 'Date', name: 'Date' },
                {width: '10%', label: 'Dealer Code', name: 'Dealer Code'},
                {width: '20%', label: 'Outlet', name: 'Outlet'},
                {width: '20%', label: 'Invoice#', name: 'Invoice#'},
                {width: '10%', label: 'Amount', name: 'Amount'},
            ];
            columns2.forEach((column) => {
                sortOrders2[column.name] = -1;
            });



            let sortOrders3 = {};
            let columns3 = [
                {width: '10%', label: 'Date', name: 'Date' },
                {width: '10%', label: 'Credit Note#', name: 'Credit Note#'},
                {width: '10%', label: 'Dealer Code', name: 'Dealer Code'},
                {width: '10%', label: 'Outlet', name: 'Outlet'},
                {width: '10%', label: 'Type', name: 'Type'},
                {width: '10%', label: 'Amount', name: 'Amount'},
                {width: '20%', label: 'Comments', name: 'Comments'},
            ];
            columns3.forEach((column) => {
                sortOrders3[column.name] = -1;
            });

            return {
                projects:[],
                columns: columns,
                sortKey: 'Dealer Code',
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


                columns2: columns2,
                sortKey2: 'Dealer Code',
                sortOrders2: sortOrders,
                tableData2: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc',
                },
                pagination2: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: ''
                },


                columns3: columns3,
                sortKey3: 'Dealer Code',
                sortOrders3: sortOrders,
                tableData3: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc',
                },
                pagination3: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: ''
                },


                ds:[],
                advance_payments:[],
                credit_payments:[],
                ds_details:[],
                outlet:"",
                total_deposit_slip_amount:0,
                total_advance_deduction_amount:0,
                total_credit_note_amount:0,
            }
        },
        created(){
            this.getProjects();
            this.getAdvancePayments();
            this.getCreditPayments();
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            }
        },
        methods:{
            getProjects(url = '../retailer/deposit_slips') {
                this.tableData.draw++;
                axios.get(url, {params: this.tableData})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData.draw == data.draw) {
                            this.ds = data.data.data;
                            this.total_deposit_slip_amount=data.total_deposit_slip;
                            console.log(this.ds);
                            this.configPagination(data.data);
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            getAdvancePayments(url = constant.base_url+'get_all_advance_payments') {
                this.tableData2.draw++;
                axios.get(url, {params: this.tableData2})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData2.draw == data.draw) {
                            this.advance_payments = data.data.data;
                            this.total_advance_deduction_amount=data.total_amount;
                            console.log(this.advance_payments);
                            this.configPagination2(data.data);
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            getCreditPayments(url = constant.base_url+'get_all_credit_notes_payments') {
                this.tableData3.draw++;
                axios.get(url, {params: this.tableData3})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData3.draw == data.draw) {
                            this.credit_payments = data.data.data;
                            this.total_credit_note_amount=data.total_amount;
                            this.configPagination3(data.data);
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





            configPagination2(data) {
                this.pagination2.lastPage = data.last_page;
                this.pagination2.currentPage = data.current_page;
                this.pagination2.total = data.total;
                this.pagination2.lastPageUrl = data.last_page_url;
                this.pagination2.nextPageUrl = data.next_page_url;
                this.pagination2.prevPageUrl = data.prev_page_url;
                this.pagination2.from = data.from;
                this.pagination2.to = data.to;
            },
            sortBy2(key) {
                this.sortKey2 = key;
                this.sortOrders2[key] = this.sortOrders2[key] * -1;
                this.tableData2.column = this.getIndex(this.columns, 'name', key);
                this.tableData2.dir = this.sortOrders2[key] === 1 ? 'asc' : 'desc';
                this.getAdvancePayments();
            },
            getIndex2(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },



            configPagination3(data) {
                this.pagination3.lastPage = data.last_page;
                this.pagination3.currentPage = data.current_page;
                this.pagination3.total = data.total;
                this.pagination3.lastPageUrl = data.last_page_url;
                this.pagination3.nextPageUrl = data.next_page_url;
                this.pagination3.prevPageUrl = data.prev_page_url;
                this.pagination3.from = data.from;
                this.pagination3.to = data.to;
            },
            sortBy3(key) {
                this.sortKey3 = key;
                this.sortOrders3[key] = this.sortOrders3[key] * -1;
                this.tableData3.column = this.getIndex(this.columns, 'name', key);
                this.tableData3.dir = this.sortOrders3[key] === 1 ? 'asc' : 'desc';
                this.getCreditPayments();
            },
            getIndex3(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },


            get_all_ds:function(){
                axios.get("../retailer/deposit_slips").then((response) =>{
                    this.ds=response.data;
                });
            },
            get_ds_details: function(id){
                axios.get(constant.base_url+"deposit_slip_details/"+id).then((response)=>{
                    this.ds_details=response.data[0];
                    this.outlet=response.data[0].retailer_outlet.name;
                    $('#payment_details_modal').modal('show');
                });
            },


            transaction_closed:function($ds_id){
                var result=confirm("Are you sure, You want to close this payment");

                if(result){
                    //alert($ds_id);
                    axios.post(constant.base_url+"transaction_closed", {ds_id: $ds_id}).then((response)=>{
                        if(response.data==201){
                            alert("Transaction Completed Successfully");
                            this.getProjects();
                        }
                    });
                }
            }
        }
    }
</script>
