<template>
                
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="card" >
                            <div class="card-header card-header-text card-header-icon">
                                <i class="material-icons">monetization_on</i>
                            </div>
                            <div class="card-content">
                                    <h4 class="card-title">Create Collection</h4>
                                <form @submit.prevent="submit_payment">
                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group">
                                            <div class="select">
                                                <select class="form-control" v-model="selected_invoice_index" @change="change_invoice()" required>
                                                    <option value="">Select Invoice No</option>
                                                    <option v-for="(invoice, index) in invoices" v-bind:value="index">Invoice#{{invoice.id}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group">
                                            <div class="select">
                                                <select class="form-control">
                                                    <option v-bind:value="new_payment.selected_invoice_retailer_id">{{new_payment.selected_invoice_retailer}}</option>
                                                </select>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group">
                                            <div class="select">
                                                <select class="form-control">
                                                    <option v-bind:value="new_payment.selected_invoice_retailer_outlet_id">{{new_payment.selected_invoice_retailer_outlet}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group">
                                            <div class="select">
                                                <select class="form-control" v-model="new_payment.bank_id" required>
                                                    <option value="">Bank Name</option>
                                                    <option v-for="(bank, index) in banks" v-bind:value="bank.id">{{bank.bank_name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group">
                                            <div class="select">
                                                <select class="form-control" v-model="new_payment.currency_id" required>
                                                    <option value="">Select Currency</option>
                                                    <option v-for="(currency, index) in currencies" v-bind:value="currency.id">{{currency.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group">
                                            <div class="select">
                                                <select class="form-control" v-model="selected_payment_index" @change="change_payment()" required>
                                                    <option value="">Select Payment Type</option>
                                                    <option v-for="(payment, index) in payments" v-bind:value="index">{{payment.type}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-sm-3" v-if="selected_payment_index==1">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Cheque no</label>
                                            <input type="text" class="form-control" v-model="new_payment.cheque_no" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Amount in RS</label>
                                            <input type="text" class="form-control" v-model="new_payment.amount_in_rs" required>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Deposit Slip Number</label>
                                            <input type="text" class="form-control" v-model="new_payment.deposit_slip_no" required>
                                        </div>
                                    </div>



                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Remarks</label>
                                            <textarea class="form-control" v-model="new_payment.remarks" required>

                                            </textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="">
                                        <div class="text-center pull-right">
                                            <button type="submit" class="btn btn-rose btn-fill btn-wd">Submit</button>
                                        </div>
                                    </div>
                                </form>
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
                invoices:[],
                banks:[],
                currencies:[],
                payments:[],
                selected_invoice_index:'',
                selected_payment_index:'',
                new_payment:{
                    bank_id:'',
                    invoice_id:'',
                    payment_id:'',
                    currency_id:'',
                    selected_invoice_retailer_id:'',
                    selected_invoice_retailer_outlet_id:'',
                    selected_invoice_retailer:'',
                    selected_invoice_retailer_outlet:'',
                    cheque_no:'',
                    amount_in_rs:'',
                    deposit_slip_no:'',
                    outstanding_amount:'',
                    remarks:'',
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            this.get_all_invoices();
            this.get_all_banks();
            this.get_all_currencies();
            this.get_all_payment();
        },
        methods:{
            get_all_invoices:function(){
                axios.get('../retailer/get_invoices').then((response)=>{
                    this.invoices=response.data;
                });
            },
            get_all_banks:function(){

                axios.get('../bank/get_all_banks').then((response)=>{
                    this.banks=response.data;
                });
            },
            get_all_currencies:function(){

                axios.get('../get_currencies').then((response)=>{
                    this.currencies=response.data;
                });
            },
            get_all_payment:function(){
                axios.get('../get_payment_types').then((response)=>{
                    this.payments=response.data;
                });
            },
            change_invoice:function(){
                this.new_payment.invoice_id= this.invoices[this.selected_invoice_index].id;
                this.new_payment.selected_invoice_retailer=this.invoices[this.selected_invoice_index].order.retailer.name;
                this.new_payment.selected_invoice_retailer_outlet=this.invoices[this.selected_invoice_index].order.retailer_outlet.name;

                this.new_payment.selected_invoice_retailer_id=this.invoices[this.selected_invoice_index].order.retailer.id;
                this.new_payment.selected_invoice_retailer_outlet_id=this.invoices[this.selected_invoice_index].order.retailer_outlet.id;
            },
            change_payment:function(){
                this.new_payment.payment_id=this.payments[this.selected_payment_index].id;
            },
            submit_payment:function(){
                axios.post('../retailer/order/add_payment',this.new_payment).then((response)=> {
                    alert(response.data);
                });

            }
        }
    }
</script>
