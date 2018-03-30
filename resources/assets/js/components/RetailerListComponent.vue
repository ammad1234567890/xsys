<template>
    <div>
        <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h5>INVOICE LIST</h5>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table id="invoice_table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Order NO</th>
                                <th>Invoice NO</th>
                                <th>Total Amount (PKR)</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(invoice, index) in all_invoice">
                                <td>{{s_no+index}}</td>
                                <td>{{invoice.created_at | moment }}</td>
                                <td>{{invoice.retailer_order.order_no}}</td>
                                <td>{{invoice.invoice_no}}</td>
                                <td><span class="pull-right">{{invoice.total_amount | currency('')}}</span></td>
                                <td><!-- v-if="invoice.warehouse_issue[0].is_issued==1" -->
                                    <button type="button" title="View Detail" class="btn btn-success btn-xs"

                                            v-on:click="details(invoice.id)"><i class="fa fa-eye"></i></button>
                                    <button class="btn btn-github btn-xs" title="Print" v-on:click="print(invoice.id)"

                                    ><i class="fa fa-print"></i>
                                    </button>
                                    <button class="btn btn-github btn-xs" v-on:click="reversal(invoice.id)"><span title="Reversed" class="fa fa-mail-reply-all" style="color: red;"></span></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
                                    <label>Due Date</label> : {{duedate}}
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
    export default {
        data() {
            return {
                message: '',
                all_invoice: [],
                moment: '',
                date_time: '',
                s_no: 0,
                warehouse_issue:[],
                invoice_details:[],
                invoice:[],
                outlet:[],
                duedate:'',
                is_issued:[]


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
                this.get_all_invoice();

            },
            get_all_invoice: function () {
                axios.get('../invoice/get_invoice').then((response) => {
                    this.all_invoice = response.data;
                   // this.is_issued=response.data[0].warehouse_issue
                    // this.s_no=this.all_invoice.length;
                    this.s_no = 1;
                    //  console.log(this.all_invoice);
                });

            },
            details: function (id) {
                //  alert(id);
                axios.get('../invoice/details/'+id).then((response) => {
                    if(response.data.warehouse_issue!="") {
                        this.invoice_details = response.data;
                        this.warehouse_issue = response.data.warehouse_issue[0].warehouse_issue_item;
                        this.invoice = this.invoice_details.retailer_order;
                        this.outlet = this.invoice.retailer_outlet;
                        this.duedate = moment(this.invoice_details.created_at).add(this.outlet.credit_duration, 'days').format('DD-M-YYYY');

                        $('#order_details').modal('show');
                        // order_no.retailer_outlet
                        // this.s_no=this.all_invoice.length;
                    }
                    else {
                        alert("Item Is Not Issue");
                    }
                });
             //   console.log(this.duedate);

            },print:function (id) {
                //alert(id);
               // location.assign("../invoice/print/"+id);
                window.open("../invoice/print/"+id, '_blank');
            },reversal:function (id) {
                //alert(id);
                location.assign("../invoice/reversal/"+id);
            }
        }
    }
    $(document).ready(function () {
        setTimeout(function () {
            $('#invoice_table').DataTable({
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
        }, 3000);
    });
</script>


