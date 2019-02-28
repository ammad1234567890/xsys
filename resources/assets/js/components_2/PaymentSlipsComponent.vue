<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <h2 class="panel-title">Dealer Payments</h2>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table id="bank_detail_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>DS.No</th>
                                <th>Dealer Code</th>
                                <th>Outlet</th>
                                <th>Bank</th>
                                <th class="col-md-2">Payment Type</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(slip, index) in ds">
                                <td><b>{{slip.created_at | moment}}</b></td>
                                <td>{{slip.deposit_slip_number}}</td>
                                <td>{{slip.retailer.retailer_no}}</td>
                                <td>{{slip.retailer_outlet.name}}</td>
                                <td>{{slip.bank.bank_name}}</td>
                                <td class="col-md-2"><b>{{slip.payment_type.type}}</b></td>
                                <td>{{slip.total_amount | currency('Rs')}}</td>
                                <td>

                                    <span v-if="slip.payment_type.id==3">
                                        <a :href="'../retailer_order/order_payment_reversal/'+slip.id">
                                            <button class="btn btn-xs btn-danger" title="Reverse Payment"><i class="fa fa-undo"></i></button>
                                        </a>
                                    </span>
                                    <span v-else>Cash</span>

                                </td>
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
                ds:[],
            }
        },
        created(){
            this.get_all_ds();
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            }
        },
        methods:{
            get_all_ds:function(){
                axios.get("../retailer/deposit_slips").then((response) =>{
                    this.ds=response.data;
                });
            }
        }
    }
</script>
