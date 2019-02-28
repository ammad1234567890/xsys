<template>

    <div class="row">
        <div class="card headcolor">
            <div class="card-header">
                <h3 class="card-title pad-bot">
                    <h4 class="heading-inline" style="text-transform: uppercase; "> Dealer Overview</h4> </h3>
            </div>
            <hr/>
        </div>

        <div class="">
            <table width="50%">
                <tr style="border-bottom:1px solid black;">
                    <td>
                        <b>Dealer Code:</b>
                    </td>
                    <td>
                        {{retailer_no}}
                    </td>
                </tr>
                <tr style="border-bottom:1px solid black;">
                    <td>
                        <b>Dealer Name:</b>
                    </td>
                    <td>
                        {{retailer_name}}
                    </td>
                </tr>
                <tr style="border-bottom:1px solid black;">
                    <td>
                        <b>Outlet:</b>
                    </td>
                    <td>
                        {{outlet_name}}
                    </td>
                </tr>
                <tr style="border-bottom:1px solid black;">
                    <td>
                        <b>City:</b>
                    </td>
                    <td>
                        {{city}}
                    </td>
                </tr>
                <tr style="border-bottom:1px solid black;">
                    <td>
                        <b>Locality:</b>
                    </td>
                    <td>
                        {{locality}}
                    </td>
                </tr>
                <tr style="border-bottom:1px solid black;">
                    <td>
                        <b>Address:</b>
                    </td>
                    <td>
                        {{address}}
                    </td>
                </tr>
                <tr style="border-bottom:1px solid black;">
                    <td>
                        <b>Credit Limit:</b>
                    </td>
                    <td>
                        {{credit_limit | currency('Rs')}}
                    </td>
                </tr>
                <tr style="border-bottom:1px solid black;">
                    <td>
                        <b>Credit Duration:</b>
                    </td>
                    <td>
                        {{credit_duration}} Days
                    </td>
                </tr>

            </table>
            <br/>
            <!-- RETAILER Order SHOW GRID -->
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2 class="panel-title">Orders History</h2>
                </div>

                <div class="panel-body">
                    <div class="alert alert-success"  v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                            <tr>
                                <th  class="col-md-1">Date</th>
                                <th>Order No</th>
                                <th>City</th>
                                <th>Total Price(PKR)</th>
                                <th class="col-md-1 text-center">Action</th>
                                <th class="col-md-1">Clearance</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(order, index) in all_orders">
                                <td>{{order.created_at | moment}}</td>
                                <td>{{order.order_no}}</td>
                                <td>{{order.retailer_outlet.city.name}}</td>
                                <td style="text-align:right;">{{order.total_cost | currency(' ')}}</td>
                                <td class="text-center col-md-1">
                                    <div class="dropdown">

                                        <button class="btn btn-success btn-xs" type="button" v-on:click="view_order_details(index)" title="View Detail"><i class="fa fa-eye"></i></button>

                                    </div>
                                </td>

                                <td v-if="order.is_account_clearance==1" class="col-md-1"><i class="fa fa-check" title="Cleared from Finance" style="text-align:center; display:block; font-size:25px; color:green;"></i> </td>
                                <td v-else><i class="fa fa-rotate-right" style="text-align:center; display:block; font-size:25px; color:red;"></i></td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <!-- LEDGER SHOW GRID -->
            <div class="panel panel-info">
                <div class="panel-heading"><h5 style="margin-top: 6px; font-variant: small-caps;"> Ledger - Details</h5>
                </div>
                <div class="panel-body">
                    <table id="ledger-table" class="table table-bordered">
                        <thead>
                        <tr>
                            <!--<th>SNO</th>-->
                            <th>Date</th>
                            <th>Narration</th>
                            <th>Debit(PKR)</th>
                            <th>Credit(PKR)</th>
                            <th>Balance(PKR)</th>
                            <!--<th>Details</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                            <td style="font-weight: bold;" colspan="5" align="right">
                                Opening Balance: {{open_outstanding | currency('')}}
                            </td>

                        </tr>
                        <tr v-for="(ledger,index) in ledgerData">
                            <!--<td>{{index +1}}</td>-->
                            <td>{{ledger.TransDate | moment}}</td>
                            <td>{{ledger.description}}</td>
                            <td align="right">{{ledger.Credit | currency('')}}</td>
                            <td align="right">{{ledger.Collection | currency('')}}</td>
                            <td align="right">{{ledger.Outstanding | currency('')}}</td>
                            <!--
                            <td v-if="ledger.invoice_id==null"><button class="btn btn-success btn-xs" v-on:click="view_collection(ledger.collection_id)">view collection</button></td>
                            <td v-if="ledger.collection_id==null"><button class="btn btn-success btn-xs" v-on:click="view_invoice(ledger.invoice_id)">view invoice</button></td>
                            -->
                        </tr>
                        <tr>
                            <td style="font-weight: bold;" colspan="5" align="right">
                                Closing Balance: {{last_outstanding | currency('')}}
                            </td>

                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- View Details Modal Start-->
            <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="order_info_modal" style="z-index:9999;" aria-labelledby="bs-add-Model-modal-md">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Order Details </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5> <span class="pull-right"></span></h5>


                                    <h5><b>{{view_order.order_no}} </b> <span class="pull-right"><b>Date:</b> <i> {{view_order.created_at | moment}}</i> </span></h5>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label><strong>Total Price :</strong></label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{view_order.total_cost | currency('Rs')}}</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Order By :</strong></label>
                                        </div>

                                        <div class="col-md-3 m-p-0">
                                            <label >{{view_order.created_by}}</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label><strong>Account Clearance :</strong></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label v-if="view_order.is_account_clear"><i class="fa fa-check"  title="Order Cleared!" style="color:green;"></i></label>
                                            <label v-else><i class="fa fa-rotate-right"  title="Order Cancel!" style="color:red;"></i></label>
                                        </div>

                                        <div class="col-md-3">
                                            <label><strong>Credit Limit:</strong></label>
                                        </div>
                                        <div class="col-md-3 m-p-0">
                                            <label>{{view_order.credit_limit | currency('Rs')}}</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6" v-if="view_order.is_forcely_approved==1">
                                            <span class="label label-danger" v-if="view_order.is_forcely_approved==1">Approved</span>
                                        </div>
                                    </div>
                                    <div class="row" v-if="view_order.reason!=null">
                                        <div class="col-md-3">
                                            <label><strong>Reason:</strong></label>
                                        </div>
                                        <div class="col-md-3 m-p-0" >
                                            <label>{{view_order.reason}}</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label><strong>Sales Officer :</strong></label>
                                        </div>
                                        <div class="col-md-3 m-p-0" >
                                            <label>{{view_order.sales_officer_name}}</label>
                                        </div>

                                    </div>

                                    <!-- <table width="100%" class="table table-hovered">
                                        <tr>
                                            <td>Total Order Cost</td>
                                            <td>{{view_order.total_cost | currency('Rs')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Order By</td>
                                            <td>{{view_order.created_by}}</td>
                                        </tr>
                                        <tr>
                                            <td>Account Clearance</td>
                                            <td v-if="view_order.is_account_clear"><i class="fa fa-check"  title="Order Cleared!"></i></td>
                                            <td v-else><i class="fa fa-times"  title="Order Cleared!"></i> </td>
                                        </tr>


                                    </table> -->
                                    <hr/>
                                    <h4>Product Details</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td>Category</td>
                                            <td>Model</td>
                                            <td>Color</td>
                                            <td>Quantity</td>
                                            <td>Unit Price(PKR)</td>
                                            <td>Total(PKR)</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="products in view_order.order_products">
                                            <td>{{products.product_color.product.product_category.name}}</td>
                                            <td>{{products.product_color.product.name}}</td>
                                            <!-- <td>Gray</td> -->
                                            <td>{{products.product_color.color}}</td>
                                            <td style="text-align:right;">{{products.product_qty}}</td>
                                            <td style="text-align:right;">{{products.unit_price  | currency(' ')}}</td>
                                            <td style="text-align:right;">{{products.unit_price * products.product_qty  | currency(' ')}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-github" data-dismiss="modal" aria-label="Close">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View Details Modal END -->

            <!-- View collection Modal Start-->
            <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="collection_info_modal" style="z-index:9999;" aria-labelledby="bs-add-Model-modal-md">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Collection Details </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5> <span class="pull-right"></span></h5>
                                    <table width="100%">
                                        <tr style="border-bottom: 1px solid black;">
                                            <td>Invoice No</td>
                                            <td>{{collection_data.invoice}}</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid black;">
                                            <td>Deposit Slip No</td>
                                            <td>{{collection_data.deposit_slip_number}}</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid black;">
                                            <td>Bank</td>
                                            <td>{{collection_data.bank}}</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid black;">
                                            <td>Amount</td>
                                            <td>{{collection_data.amount | currency(collection_data.currency)}}</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid black;">
                                            <td>Payment Type</td>
                                            <td>{{collection_data.payment}}</td>
                                        </tr>
                                        <tr v-if="collection_data.is_reversible==1">
                                            <td><span class="label label-danger">Reversed</span></td>
                                        </tr>
                                    </table>







                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-github" data-dismiss="modal" aria-label="Close">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View collection Modal END -->
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                message:'',
                all_orders:[],
                ledgerData:[],
                outletsData:[],
                retailer_name:'',
                retailer_no:'',
                outlet_name:'',
                city:'',
                locality:'',
                address:'',
                credit_limit:'',
                credit_duration:'',
                last_outstanding:'',
                open_outstanding:'',
                view_order:{
                    orderno:'',
                    order_no:'',
                    credit_limit:'',
                    eta:'',
                    remaining_payment:'',
                    total_cost:'',
                    is_account_clear:'',
                    is_forcely_approved:'',
                    total_qty:'',
                    retailer_name:'',
                    sales_officer_name:'',
                    outlet_name:'',
                    is_approved:'',
                    created_by:'',
                    created_at:'',
                    reason:'',
                    order_products:[],
                    order_payments:[],
                    current_status:[],
                    remove_product_ids:[]
                },
                collection_data:{
                    amount:'',
                    cheque_number:'',
                    deposit_slip_number:'',
                    is_reversible:'',
                    bank:'',
                    currency:'',
                    payment:'',
                    invoice:'',
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created:function(){
            this.init();
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            },

            getdate: function (date) {
                return moment(date).format('DD');
            },

            getmonth: function (date) {
                return moment(date).format('MM');
            },
        },
        methods: {
            init: function () {
                this.get_all_orders();
                this.get_ledgers();
                this.get_outlet();
            },
            get_all_orders:function(){
                axios.get('../get_orders_by_outlet/'+ window.location.pathname.split('/')[5]).then((response)=>{
                    this.all_orders=response.data;
                });
            },
            get_ledgers:function(){
                axios.get('../get_all_ledger_by_outlet/'+ window.location.pathname.split('/')[5]).then((response)=>{
                    this.ledgerData=response.data;
                    this.last_outstanding=this.ledgerData[this.ledgerData.length - 1].Outstanding;
                    this.open_outstanding=this.ledgerData[0].Outstanding;
                });
            },
            get_outlet:function(){
                axios.get('../../outlet/get_all_outlets_by_id/'+ window.location.pathname.split('/')[5]).then(response=>{
                    this.outletsData=response.data;
                    this.retailer_name=this.outletsData[0].retailer.name;
                    this.retailer_no=this.outletsData[0].retailer.retailer_no;
                    this.outlet_name=this.outletsData[0].name;
                    this.city=this.outletsData[0].city.name;
                    this.locality=this.outletsData[0].region.name;
                    this.address=this.outletsData[0].address;
                    this.credit_limit=this.outletsData[0].credit_limit;
                    this.credit_duration=this.outletsData[0].credit_duration;
                });
            },
            view_order_details:function(index){
                $('#order_info_modal').modal('show');

                this.view_order.orderno=this.all_orders[index].id;
                this.view_order.eta=this.all_orders[index].expected_delivery_date;
                this.view_order.remaining_payment=this.all_orders[index].remaining_payment;
                this.view_order.total_cost=this.all_orders[index].total_cost;
                this.view_order.is_account_clear=this.all_orders[index].is_account_clearance;
                this.view_order.is_approved=this.all_orders[index].is_approved;

                this.view_order.retailer_name=this.all_orders[index].retailer.name;
                this.view_order.sales_officer_name=this.all_orders[index].retailer.name;
                this.view_order.outlet_name=this.all_orders[index].retailer_outlet.name;
                this.view_order.order_products=this.all_orders[index].order_products;
                this.view_order.created_by=this.all_orders[index].user.name;
                this.view_order.created_at=this.all_orders[index].created_at;
                this.view_order.credit_limit=this.all_orders[index].retailer_outlet.credit_limit;
                this.view_order.order_no=this.all_orders[index].order_no;
                this.view_order.is_forcely_approved=this.all_orders[index].is_forcefully_approve;
                this.view_order.reason=this.all_orders[index].clearance_remarks;

            },
            view_collection($id){
                axios.post('../../get_collection',{'collection_id':$id}).then((response)=>{
                    this.collection_data.amount=response.data[0].amount;
                    this.collection_data.cheque_number=response.data[0].cheque_number;
                    this.collection_data.deposit_slip_number=response.data[0].deposit_slip_number;
                    this.collection_data.is_reversible=response.data[0].is_reversible;

                    this.collection_data.bank=response.data[0].bank.bank_name;
                    this.collection_data.currency=response.data[0].currency.name;
                    this.collection_data.payment=response.data[0].payment_type.type;
                    this.collection_data.invoice=response.data[0].invoice.invoice_no;

                    $('#collection_info_modal').modal('show');
                });
            },
            view_invoice($id){
                alert($id);
            }
        }
    }
</script>