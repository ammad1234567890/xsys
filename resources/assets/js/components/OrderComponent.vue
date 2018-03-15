<template>

    <div class="row">
        <div class="col-md-12">

            <h2 style="margin-top: 6px; font-variant: small-caps; font-weight:bold;">Create New Order</h2>
            <hr/>
            <div class="panel panel-info">
                <div class="panel-heading">Create Order</div>
                <div class="alert alert-success"  v-if="message">
                    <strong>{{message}}</strong>
                </div>
                <div class="panel-body">
                    <form @submit.prevent="add_order">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="estimation_delivery">Estimate Delivery Date</label>
                                <input name="estimation_delivery" type="date" class="form-control" v-model="new_order.estimation_date" required>
                            </div>
                        </div>

                        <div class="row" v-for="(find, index) in new_order.products">
                            <div class="form-section" style="border-left:0px; border-right: 0px; border-bottom:0px; padding-left:0px; padding-right:0px;">
                                <h4 class="form-section-heading" style="left: 18px;">Product Details</h4>
                                <div class="col-md-6 form-group">
                                    <label for="select_product">Select Product</label>
                                    <select name="select_product" class="form-control" v-model="find.product_id" @change="change_product(index, find.product_id)" required>
                                        <option value="" selected>Select</option>
                                        <option v-for="(product, index) in allProducts"  v-bind:value="product.id">{{product.name}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="select_product_color">Select Product Color</label>
                                    <select class="form-control" v-model="new_order.products[index].product_color_id" required>
                                        <option value="" selected>Select</option>
                                        <option v-for="(product_color, index) in new_order.products[index].product_color"  v-bind:value="product_color.id">{{product_color.color}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="product_quanity">Quantity</label>
                                    <input type="text" class="form-control" v-model="new_order.products[index].quantity" placeholder="Quantity" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="cost_per_set">Order Unit Price</label>
                                    <input type="text" class="form-control" v-model="new_order.products[index].cost_per_set" placeholder="Cost" required>
                                </div>

                                <div class="col-md-12" v-if="index>0">
                                    <button class="btn btn-danger" v-on:click="removeProductForm(index)">Remove</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-default" v-on:click="add_more_products"><i class="fa fa-plus"></i> Add More Products</button>
                            </div>

                            <div class="col-md-9">
                                <button class="btn btn-primary pull-right"><i class="fa fa-check"></i> Create Order</button>
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
                allProducts:[],
                message:"",
                new_order:{
                    id:'',
                    estimation_date:'',
                    products:[
                        {
                            product_id:'',
                            product_color_id:'',
                            product_color:[],
                            quantity:'',
                            cost_per_set:''
                        }
                    ],
                },

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
              this.get_products();
            },
            removeProductForm:function(index){
                event.preventDefault();
                this.new_order.products.splice(index,1);
            },
            change_product:function(index, product_id){
                this.new_order.products[index].product_id=product_id;
                axios.post('../get_product_colors',this.new_order.products[index]).then((response) => {
                    this.new_order.products[index].product_color=response.data;
                   // alert(response.data);
                });
            },
            add_more_products:function(e){
                e.preventDefault();
                this.new_order.products.push({product_id:'', product_color:'', quantity:'', cost_per_set:''});
            },
            get_products:function(){
                axios.get('../allProducts').then((response) => {
                    this.allProducts= response.data.data;
                });
            },
            add_order:function(e){
                this.$validator.validateAll();
                if (!this.errors.any()) {
                    axios.post('../order/create',this.new_order).then((response) => {
                        if(response.data==201){
                            this.new_order.id='';
                            this.new_order.estimation_date='';
                            this.new_order.products.product_id='';
                            this.new_order.products.product_color_id='';
                            this.new_order.products.quantity='';
                            this.new_order.products.cost_per_set='';

                            this.new_order.products.forEach(function(order, index) {
                                order.product_id="";
                                order.product_color_id="";
                                order.quantity="";
                                order.cost_per_set="";
                            });
                            this.message="New Order has been Successfully Created!";
                            $("html, body").animate({
                                scrollTop: 0
                            }, 600);
                        }
                        else{
                            alert(response.data);
                        }
                    });

                }

            }
        }
    }


</script>