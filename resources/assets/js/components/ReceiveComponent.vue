<template>

<div class="row">
    <div class="card headcolor">
        <div class="card-header">
                <h3 class="card-title pad-bot"><i class="material-icons">shopping_cart</i> <small>ORDER RECIEVING</small> </h3>
        </div>
    </div>
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">Recieving new Order</div>
            <div class="alert alert-success"  v-if="message">
                <strong>{{message}}</strong>
            </div>
            <div class="panel-body">
                <form @submit.prevent="recieve_order_submit">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="select_order_no">Select Order No</label>
                            <select class="form-control" v-model="new_recieving.order_id" @change="order_change" required>
                                <option value="">Select</option>
                                <option v-for="order in all_orders" v-bind:value="order.id">
                                    ORDER# {{order.id}}
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="select_collected_by">Collected By</label>
                            <select class="form-control" v-model="new_recieving.collected_id" required>
                                <option value="">Select</option>
                                <option v-for="staff in all_staff" v-bind:value="staff.id">{{staff.name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-bind:value="new_recieving.qa_check" id="checkboxFiveInput" name="" @change="change_qa_check"> QA Check
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-9" style="margin-top: 16px;" v-if="new_recieving.qa_check==1">
                                    <label for="select_collected_by">QA Description</label>
                                    <textarea class="form-control" v-model="new_recieving.qa_description">
                            </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-8"  style="margin-top: 13px;">
                                <label for="select_collected_by">Recieved Location Status</label>
                                <select class="form-control" v-model="new_recieving.recieve_status_id" required>
                                    <option value="">Select</option>
                                    <option v-for="status in all_status" v-bind:value="status.id">
                                        {{status.status}}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="select_collected_by"></label>
                                <a href="../general">
                                    <i class="fa fa-plus-circle" style="font-size: 27px; margin-top: 37px;"></i>
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="row" v-for="(find, index) in new_recieving.order_products">
                        <div class="form-section" style="border-left:0px; border-right: 0px; border-bottom:0px; padding-left:0px; padding-right:0px;">
                            <h4 class="form-section-heading" style="left: 18px;">Receiving Product</h4>

                            <div class="col-md-6 form-group">
                                <label for="select_products">Select Order Products</label>
                                <select class="form-control" v-model="selected_order_product_index[index].index_no" @change="change_product(index)" required>
                                    <option value="-1" selected="selected">Select</option>
                                    <option v-for="(products, index) in all_order_products"  v-bind:value="index">{{products.product_color.product.name}} ({{products.product_color.color}}) </option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="product_quanity">Quantity</label>
                                <input type="number" class="form-control" name="product_qty" v-model="new_recieving.order_products[index].quantity" :placeholder="'Total Quantity '+new_recieving.order_products[index].max_qty" v-validate="{ max_value: new_recieving.order_products[index].max_qty }"  @change="qty_change(index)" required>
                                <span class="text-danger" v-show="errors.has('product_qty')">
                                  {{errors.first('product_qty')}}
                                </span>
                            </div>
                            <div class="col-md-12" v-if="index>0">
                                <button class="btn btn-danger" v-on:click="removeProductForm(index)">Remove</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-info" v-on:click="add_more_products"><i class="fa fa-plus"></i> Add More</button>
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
                            <button class="btn btn-tumblr pull-right"><i class="fa fa-check"></i> Order Recieved</button>
                        </div>
                    </div>
                </form>

            </div>
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
                all_orders:[],
                all_status:[],
                all_order_products:[],
                all_staff:[],
                selected_order_product_index:[{
                    index_no:'',
                }],
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
                            max_qty:'',
                            final_qty:''
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
                this.get_all_staff();
            },
            qty_change:function(changing_index){
               // alert(parseInt(this.new_recieving.order_products[changing_index].quantity));
              //  alert(parseInt(this.new_recieving.order_products[changing_index].max_qty));
                this.new_recieving.order_products[changing_index].final_qty=(parseInt(this.new_recieving.order_products[changing_index].max_qty))-(parseInt(this.new_recieving.order_products[changing_index].quantity))
               // console.log(parseInt(this.new_recieving.order_products[changing_index].final_qty));
            },
            change_product:function(changing_index){
                //alert(changing_index);
                //alert(changing_index);
                    this.new_recieving.order_products[changing_index].quantity='';
                if(this.selected_order_product_index[changing_index].index_no!="-1"){
                    this.new_recieving.order_products[changing_index].id=this.all_order_products[this.selected_order_product_index[changing_index].index_no].product_color.id;
                    this.new_recieving.order_products[changing_index].max_qty=this.all_order_products[this.selected_order_product_index[changing_index].index_no].remaining_qty;


                }
                else{
                    this.new_recieving.order_products[changing_index].max_qty="";
                    this.new_recieving.order_products[changing_index].id="";
                }
            },
            removeProductForm:function(index){
                event.preventDefault();
                this.new_recieving.order_products.splice(index,1);
                this.selected_order_product_index.splice(index,1);
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
            get_all_staff:function(){
                axios.get('../allStaff ').then((response)=>{
                    this.all_staff=response.data;
                });

            },
            add_more_products:function(e){
                e.preventDefault();
                this.new_recieving.order_products.push({id:'', quantity:''});
                this.selected_order_product_index.push({index_no: ''});
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
                this.$validator.validateAll();
                if (!this.errors.any()) {
                    axios.post('../order/received', this.new_recieving).then((response) => {
                        if (response.data == 201) {
                            this.new_recieving.order_id = '';
                            this.new_recieving.qa_check = 0;
                            this.new_recieving.collected_id = '';
                            this.new_recieving.qa_description = '';
                            this.new_recieving.recieve_status_id = '';
                            this.new_recieving.order_products.forEach(function (order, index) {
                                order.id = "";
                                order.quantity = "";
                                order.max_qty = "";
                                order.final_qty = "";
                            });
                            this.all_order_products=[];
                            this.get_all_orders();
                            this.message = "Order Recieved Successfully!";
                            $("html, body").animate({
                                scrollTop: 0
                            }, 600);
                        }
                        else {
                            alert(response.data);
                        }
                    });
                }
            }
        }
    }


</script>