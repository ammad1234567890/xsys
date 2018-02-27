<template>


    <div class="col-md-12">

        <h2 style="margin-top: 6px; font-variant: small-caps; font-weight:bold;">Order Recieving</h2>
        <hr/>
        <div class="panel panel-info">
            <div class="panel-heading">Recieving new Order</div>

            <div class="panel-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="select_order_no">Select Order No</label>
                            <select class="form-control" v-model="new_recieving.order_id" @change="order_change">
                                <option value="">Select</option>
                                <option v-for="order in all_orders" v-bind:value="order.id">
                                    ORDER# {{order.id}}
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                                    <label for="select_collected_by">Collected By</label>
                                    <select class="form-control">
                                        <option>Select</option>
                                    </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="select_collected_by">QA Check</label>
                                    <div class="checkboxFive">
                                        <input type="checkbox" v-bind:value="new_recieving.qa_check" id="checkboxFiveInput" name="" @change="change_qa_check"/>
                                        <label for="checkboxFiveInput">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-9 form-group" v-if="new_recieving.qa_check==1">
                                    <label for="select_collected_by">QA Description</label>
                                    <textarea class="form-control" v-model="new_recieving.qa_description">
                            </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="select_collected_by">Recieved Location Status</label>
                            <select class="form-control" v-model="new_recieving.recieve_status_id">
                                <option>Select</option>
                                <option v-for="status in all_status" v-bind:value="status.id">
                                    {{status.status}}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row" v-for="(find, index) in new_recieving.order_products">
                        <div class="form-section" style="border-left:0px; border-right: 0px; border-bottom:0px; padding-left:0px; padding-right:0px;">
                            <h4 class="form-section-heading" style="left: 18px;">Receiving Product</h4>

                            <div class="col-md-6 form-group">
                                <label for="select_products">Select Order Products</label>
                                <select class="form-control" v-model="new_recieving.order_products[index].id">
                                    <option value="">Select</option>
                                    <option v-for="(product, index) in all_order_products"  v-bind:value="product.id">{{product.product_color.color}}</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="product_quanity">Quantity</label>
                                <input type="text" class="form-control"  v-model="new_recieving.order_products[index].quantity" placeholder="Quantity">
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-default" v-on:click="add_more_products"><i class="fa fa-plus"></i> Add More</button>
                        </div>
                    </div>
                    <br/>
                    <!--
                    <div class="row">
                        <div class="form-section" style="border-left:0px; border-right: 0px; border-bottom:0px; padding-left:0px; padding-right:0px;">
                            <h4 class="form-section-heading" style="left: 18px;">Payment Details</h4>

                            <div class="col-md-6 form-group">
                                <label for="product_quanity">Amount</label>
                                <input type="text" class="form-control" placeholder="Amount">
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="select_products">Select Payment Method</label>
                                <select class="form-control">
                                    <option>Select</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="select_products">Select Currency</label>
                                <select class="form-control">
                                    <option>Select</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="product_quanity">Exchange Rate</label>
                                <input type="text" class="form-control" placeholder="Exchange Rate">
                            </div>


                            <div class="clearfix"></div>
                        </div>

                    </div>
                    -->
                    <div class="row">


                        <div class="col-md-12">
                            <button class="btn btn-primary pull-right" v-on:click="recieve_order_submit"><i class="fa fa-check"></i> Order Recieved</button>
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
                all_orders:[],
                all_status:[],
                all_order_products:[],
                new_recieving:{
                    id:'',
                    order_id:'',
                    qa_check:0,
                    collected_id:'',
                    qa_description:'',
                    recieve_status_id:'',
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
                this.get_all_status();
            },
            get_all_orders:function(){
                axios.get('../order/get_orders').then((response)=>{
                    this.all_orders=response.data;
                });
            },
            get_all_status:function(){
                axios.get('../order/get_status').then((response)=>{
                    this.all_status=response.data;
                });
            },
            add_more_products:function(e){
                e.preventDefault();
                this.new_recieving.order_products.push({id:'', quantity:''});
            },
            order_change:function(){
                axios.post('../order/get_products',this.new_recieving).then((response)=>{
                    this.all_order_products=response.data
                });
            },
            change_qa_check:function(){
                if(this.new_recieving.qa_check==1){
                    this.new_recieving.qa_check=0;
                }
                else{
                    this.new_recieving.qa_check=1;
                }

            },
            recieve_order_submit:function(e){
                e.preventDefault();
                axios.post('../order/received',this.new_recieving).then((response)=>{
                    alert(response.data);
                });
            }
        }
    }


</script>