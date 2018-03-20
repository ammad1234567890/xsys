<template>

    <div class="row">
        <div class="card headcolor">
            <div class="card-header">
                    <h3 class="card-title pad-bot"><i class="material-icons">shopping_cart</i> <small>CREATE NEW MANUFACTURER ORDER</small> </h3>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Create Manufacturer Order</h2>
                </div>
                <div class="alert alert-success"  v-if="message">
                    <strong>{{message}}</strong>
                </div>
                <div class="panel-body">
                    <form @submit.prevent="add_order">
                        <div class="col-md-12">

                            <div class="col-md-12 form-group">
                                <label for="estimation_delivery">Estimated Delivery Date</label>
                                <date-picker  v-model="new_order.estimation_date" type="date" style="width: 100%;" format="dd-MM-yyyy" placeholder="dd-mm-yyyy" lang="en"></date-picker>
                            </div>

                            <div  v-for="(find, index) in new_order.products">

                                <div class="col-md-6 form-group">
                                    <label for="select_product">Select Product</label>
                                    <select name="select_product" class="form-control" v-model="find.product_id" @change="change_product(index, find.product_id)" required>
                                        <option value="" selected>Select</option>
                                        <option v-for="(product, index) in allProducts"  v-bind:value="product.id">{{product.name}}</option>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="select_product_color">Select Product Color</label>
                                    <select class="form-control" v-model="new_order.products[index].product_color_id"  @change="myfunc(index)" required>
                                        <option value="" selected>Select</option>
                                        <option v-for="(product_color, index) in new_order.products[index].product_color"  v-bind:value="product_color.id">{{product_color.color}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="cost_per_set">Order Unit Price</label>
                                    <input type="text" class="form-control" v-model="new_order.products[index].cost_per_set" placeholder="Cost" required readonly>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="product_quanity">Quantity</label>
                                    <input type="text" class="form-control" v-model="new_order.products[index].quantity" placeholder="Quantity" required>
                                </div>



                                <div class="col-md-12" v-if="index>0">
                                    <button class="btn btn-pinterest pull-right" v-on:click="removeProductForm(index)">Remove</button>
                                </div>

                                <div class="clearfix"></div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-info" v-on:click="add_more_products"><i class="fa fa-plus"></i> Add More Products</button>
                            </div>

                            <div class="col-md-9">
                                <button class="btn btn-tumblr pull-right"><i class="fa fa-check"></i> Create Order</button>
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

            },
            myfunc:function(index){
                //alert(this.new_order.products[index].product_color_id);
                //this.new_order.products[index].product_color_id=
                axios.get('../getproductColor/'+this.new_order.products[index].product_color_id).then((response) => {
                    this.new_order.products[index].cost_per_set=response.data[0].price;
                });
            }
        }
    }


</script>