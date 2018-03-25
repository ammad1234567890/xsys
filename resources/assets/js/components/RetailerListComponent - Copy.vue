<template>
    <div>
        <div class="row">
            <div class="card headcolor">
                <div class="card-header">
                    <h3 class="card-title pad-bot"><i class="material-icons">description</i> <small>INVOICE LIST</small> </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Invoices</h5>
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
                                <td>{{invoice.created_at  | moment }}</td>
                                <td>{{invoice.retailer_order.order_no}}</td>
                                <td>{{invoice.invoice_no}}</td>
                                <td><span class="pull-right">{{invoice.total_amount | currency('')}}</span></td>
                                <td>
								<button type="button" title="View Detail" class="btn btn-success btn-xs" v-on:click="details(invoice.id)"><i class="fa fa-eye"></i></button>
								<button class="btn btn-github btn-xs">P</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--model view start-->
        <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="order_details" aria-labelledby="bs-add-Model-modal-md">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div class="row">
                            <h4 class="modal-title">Order Is Not Approve</h4>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">

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
                moment:'',
                date_time:'',
                s_no:0,



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
                   // this.s_no=this.all_invoice.length;
				    this.s_no=1;
                    //  console.log(this.all_invoice);
                });
            },
            details:function (id) {
                //alert(id);
                $('#order_details').modal('show');
            },
        }
    }
    $(document).ready(function() {
        setTimeout(function(){
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
        },3000);
    });
</script>


