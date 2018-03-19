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
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr >
                                    <th>Order No</th>
                                    <th>Date</th>
                                    <th>Invoice NO</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(invoice, index) in all_invoice">
                                    <td>{{++index}}</td>
                                    <td>{{invoice.created_at}}</td>
                                    <td>{{invoice.id}}</td>
                                    <td>{{invoice.total_amount}}</td>
                                    <td>Approved</td>
                                    <td><button class="btn btn-github btn-xs">Print</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                message: '',
                all_invoice: [],



            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        created: function () {
            this.init();

        },
        methods: {
            init: function () {
                this.get_all_invoice();

            },
            get_all_invoice: function () {
                axios.get('../invoice/get_invoice').then((response) => {
                    this.all_invoice = response.data;
                 //  console.log(this.all_invoice);
                });
            },


        }
    }
</script>


