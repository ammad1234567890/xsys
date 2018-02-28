<template>


    <div class="col-md-12">

        <h2 style="margin-top: 6px; font-variant: small-caps; font-weight:bold;">Order Payment</h2>
        <hr/>
        <div class="panel panel-info">
            <div class="panel-heading">Add Order Payment</div>

            <div class="panel-body">
                <form>





                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="select_order_no">Select Order No</label>
                            <select class="form-control" v-model="new_recieving.order_id">
                                <option value="">Select</option>
                                <option v-for="order in all_orders" v-bind:value="order.id">
                                    ORDER# {{order.id}}
                                </option>
                            </select>
                        </div>

                            <div class="col-md-6 form-group">
                                <label for="product_quanity">Amount</label>
                                <input type="text" class="form-control" placeholder="Amount">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="select_products">Select Payment Method</label>
                                <select class="form-control">
                                    <option>Select</option>
                                    <option v-for="payment in all_payment_types" v-bind:value="payment.id">
                                        {{payment.type}}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="select_products">Select Currency</label>
                                <select class="form-control">
                                    <option>Select</option>
                                    <option v-for="currency in all_currencies" v-bind:value="currency.id">
                                        {{currency.name}}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="product_quanity">Exchange Rate</label>
                                <input type="text" class="form-control" placeholder="Exchange Rate">
                            </div>


                            <div class="clearfix"></div>
                        </div>



                    <div class="row">


                        <div class="col-md-12">
                            <button class="btn btn-primary pull-right" v-on:click="add_payment"><i class="fa fa-check"></i> Add Payment</button>
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
                all_currencies:[],
                all_orders:[],
                all_payment_types:[],
                new_recieving:{
                    id:'',
                    order_id:'',
                    collected_id:'',
                    qa_proof:'',
                    qa_description:'',
                    order_products:[
                        {
                            id:'',
                            quantity:'',
                        }
                    ],
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
                axios.post('../order/add_payment',response=>{

                });
            },

        }
    }


</script>