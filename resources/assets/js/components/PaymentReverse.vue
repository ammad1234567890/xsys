<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <h2 class="panel-title">Payment Reverse</h2>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h5><b class="size_change">Dealer Details</b></h5>
                                <table width="100%">
                                    <tr>
                                        <td><b>Name:</b></td>
                                        <td> {{ds_details.retailer.name}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Dealer No:</b></td>
                                        <td> {{ds_details.retailer.retailer_no}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Phone:</b></td>
                                        <td> {{ds_details.retailer.phone_no}}</td>
                                    </tr>

                                    <tr>
                                        <td><b>Outlet Name:</b></td>
                                        <td> {{ds_details.retailer_outlet.name}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Outlet Address</b></td>
                                        <td> {{ds_details.retailer_outlet.address}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5><b class="size_change">Deposit Slip Details</b></h5>
                                <table width="100%">
                                    <tr>
                                        <td><b>Slip No:</b></td>
                                        <td> {{ds_details.deposit_slip_number}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Bank:</b></td>
                                        <td> {{ds_details.bank.bank_name}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Payment Type:</b></td>
                                        <td> {{ds_details.payment_type.type}}</td>
                                    </tr>

                                    <tr>
                                        <td><b>Total Amount:</b></td>
                                        <td> {{ds_details.total_amount | currency('Rs')}}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <br/>
                                <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" border="1">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Cheque No</th>
                                            <th>
                                                    Invoice No
                                            </th>

                                            <th>Amount</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="(cheque, index) in cheques" v-if="cheques!=null">
                                        <tr v-for="(invoice, index) in cheque.invoice_data">
                                            <td v-if="index==0" :rowspan="cheque.invoice_data.length"><input type="checkbox" v-model="cheque.selected_for_reverse"/> </td>
                                            <td v-if="index==0" :rowspan="cheque.invoice_data.length"><b>{{cheque.cheque_no}}</b></td>
                                            <td v-if="invoice.invoice_no!=null">{{invoice.invoice_no}}</td>
                                            <td v-else>Advance Payment</td>
                                            <td>{{invoice.amount | currency('Rs')}}</td>
                                            <td v-if="index==0" :rowspan="cheque.invoice_data.length"><b>{{cheque.total_cheque_amount | currency('Rs')}}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-primary" @click="check_bounce_btn()">Bounce Cheques</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {constant} from '../constant.js';
    export default {
        data() {
            return {
                ds_details:[],
                cheques:[],


            }
        },
        created(){
            var ds_id= window.location.pathname.split('/')[5];
            this.get_deposit_slip_details(ds_id);
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            }
        },
        methods:{

            get_deposit_slip_details:function(ds_id){
                axios.get("../../retailer/get_ds_details/"+ds_id).then((response) =>{
                    if(response.data['data']['DS'][0].transaction_closed==1){
                        alert("Sorry, Transaction has been Closed!");
                        window.location = constant.base_url+"retailer/payment_slips";
                    }
                    else{
                        this.ds_details=response.data['data']['DS'][0];

                        this.cheques=response.data['data']['cheques'];
                    }

                });
            },
            check_bounce_btn:function(){
                var is_any_select=0;
                for(var i=0; i<this.cheques.length; i++){
                    if(this.cheques[i]['selected_for_reverse']==true){
                        is_any_select=1;
                    }
                }

                if(is_any_select==1){
                    axios.post('../../retailer/check_bounce',{'cheques':this.cheques}).then(response=> {
                        if(response.data==201){
                            alert("Payment has been reversed!");
                            location.reload();
                        }
                    });
                }
                else{
                    alert("Cheque is not selected!");
                }
            }

        }
    }
</script>
<style>
    .reverse_details_ul{
        width:100%;
        list-style-type: none;
        margin-left:0px;
        padding-left:0px;
    }
    reverse_details_ul li{
        width:100%;
        margin-left:0px;
        padding-left:0px;
        list-style-type: none;
        list-style: none;
    }

    .size_change{
        font-size: 16px;
        border-bottom: 1px solid black;
    }
</style>