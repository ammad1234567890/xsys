<template>

    <div class="row">
        <div class="card headcolor">
            <div class="card-header">
                    <h3 class="card-title pad-bot">
                        <h4 class="heading-inline" style="text-transform: uppercase; "> Purchase Orders Payments</h4> </h3>
            </div>
            <hr/>
        </div>
        <div class="alert alert-success"  v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <div class="clearfix"></div>
        
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        Create Order Payment
                    </h2>
                </div>

                <div class="panel-body">
                    
                    <form @submit.prevent="add_payment">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2"><label>Purchase Order</label></div>
                                <div class="col-md-3">
                                    <select class="textbox_dropdown" v-model="payment_data.order_id" @change="change_order()" required>
                                        <option value="">Select</option>
                                        <option v-for="order in all_orders" v-bind:value="order.id">
                                            {{order.manufacture_order_no}}
                                        </option>
                                     </select>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"><label>Select Payment Method</label></div>
                                <div class="col-md-3">
                                    <select class="textbox_dropdown" v-model="payment_data.method_id" required>
                                        <option value="">Select</option>
                                        <option v-for="payment in all_payment_types" v-bind:value="payment.id">
                                            {{payment.type}}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"><label>Amount</label></div>
                                <div class="col-md-3">
                                    <input type="text" class="textbox" placeholder="Amount" v-model="payment_data.amount" @change="change_amount()" required>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"><label>Select Currency</label></div>
                                <div class="col-md-3">
                                    <select class="textbox_dropdown" v-model="selected_currency_index" @change="change_currency()" required>
                                    <option value="">Select</option>
                                    <option v-for="(currency, index) in all_currencies" v-bind:value="index">
                                        {{currency.name}}
                                    </option>
                                </select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"><label>Exchange Rate</label></div>
                                <div class="col-md-3">
                                    <input type="text" v-model="payment_data.exchange_rate" class="textbox" placeholder="Exchange Rate" readonly>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2"><label>Total Cost (PKR)</label></div>
                                <div class="col-md-3">
                                    <vue-numeric class="textbox" name="remaining_payment" v-validate="{ max_value: remaining_payment }" currency="Rs" separator="," v-model="payment_data.total_payment" placeholder="Total Payment" readonly></vue-numeric>


                                <span class="text-danger" v-show="errors.has('remaining_payment')">
                                  {{errors.first('remaining_payment')}}
                                </span>
                                </div>
                                <div class="col-md-1"></div>
                            </div>

                            

                            <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-11">
                                <button class="btn btn-primary pull-right"><i class="fa fa-check"></i> Add Payment</button>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                        </div>
                        



                        
                    </form>

                </div>
        
        </div>
    </div>



</template>
<script>

    import Vue from 'vue';
    export default {
        data(){
            return{
                message:'',
                all_currencies:[],
                all_orders:[],
                all_payment_types:[],
                remaining_payment:'',
                selected_currency_index:'',
                payment_data:{
                    id:'',
                    order_id:'',
                    amount:'',
                    method_id:'',
                    currency_id:'',
                    exchange_rate:'',
                    total_payment:'',
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created:function(){
            this.init();
        },
        methods:{
            init:function(){
                this.get_all_orders();
                this.get_all_currencies();
                this.get_all_payment_types();
            },
            change_amount(){
                this.selected_currency_index='';
                this.payment_data.total_payment='';
                this.payment_data.exchange_rate='';
            },
            change_order(){
                axios.post('../order/get_orders_by_id',this.payment_data).then((response)=>{
                    this.remaining_payment=response.data[0].remaining_payment;
                });
            },
            change_currency:function(){
                var index=this.selected_currency_index;
                this.payment_data.currency_id=this.all_currencies[index].id;
                this.payment_data.exchange_rate=this.all_currencies[index].exchange_rate;
                this.payment_data.total_payment=this.all_currencies[index].exchange_rate*this.payment_data.amount;
            },
            get_all_orders:function(){
                axios.get('../order/get_orders').then((response)=>{
                    this.all_orders=response.data;
                });
            },
            get_all_currencies:function(){
                axios.get('../get_currencies').then((response)=>{
                    this.all_currencies=response.data;
                });
            },
            get_all_payment_types:function(){
                axios.get('../get_payment_types').then((response)=>{
                    this.all_payment_types=response.data;
                });
            },
            add_more_products:function(e){
                e.preventDefault();
                this.new_recieving.order_products.push({id:'', quantity:''});
            },
            add_payment:function(e){
                e.preventDefault();
                this.$validator.validateAll();
                if (!this.errors.any()) {

                    axios.post('../order/add_payment',this.payment_data).then((response)=>{
                        if(response.data==201){
                            this.message='New Payment has been Added!';

                            this.payment_data.id='';
                            this.payment_data.order_id='';
                            this.payment_data.amount='';
                            this.payment_data.method_id='';
                            this.payment_data.currency_id='';
                            this.payment_data.exchange_rate='';
                            this.payment_data.total_payment='';
                            this.get_all_orders();
                            $("html, body").animate({
                                scrollTop: 0
                            }, 600);
                        }
                        else{
                            alert(response.data);
                        }
                    });
                }

            },

        }
    }


</script>