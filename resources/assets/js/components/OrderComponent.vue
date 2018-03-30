<template>

    <div class="row">

        <div class="card headcolor">
            <div class="card-header">
                    <h3 class="card-title pad-bot">
                        <h4 class="heading-inline" style="text-transform: uppercase; "> Create New Purchase Order </h4> </h3>
            </div>
            <hr/>
        </div>
        <div class="row" v-if="message">
<div class="col-md-12">
    <div class="alert alert-success">
                    <strong>{{message}}</strong>
                </div>


</div>
        </div>
        

                <div class="clearfix"></div>


            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2 class="panel-title">Create New Order</h2>
                </div>
                
                <div class="panel-body">
                    <form @submit.prevent="add_order">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2"><label>Estimate Delivery Date<span style="color:red;">*</span></label></div>
                                <div class="col-md-3">
                                    <date-picker  v-model="estimation_date" style="width: 100%;" format="dd-MM-yyyy" placeholder="dd-mm-yyyy" lang="en" v-validate="'required'"></date-picker>
                                </div>
                            </div>
                            <div  v-for="(find, index) in new_order.products">
                                <hr/>
                                <div class="row">
                                    <div class="col-md-2"><label>Model<span style="color:red;">*</span></label></div>
                                    <div class="col-md-3">
                                        <select class="textbox_dropdown" name="select_product" v-model="find.product_id" @change="change_product(index, find.product_id)" required>
                                            <option value="" selected>Select</option>
                                            <option v-for="(product, index) in allProducts"  v-bind:value="product.id">{{product.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2"><label>Color<span style="color:red;">*</span></label></div>
                                    <div class="col-md-3">
                                        <select class="textbox_dropdown" v-model="new_order.products[index].product_color_id"  @change="myfunc(index)" required>
                                            <option value="" selected>Select</option>
                                            <option v-for="(product_color, index) in new_order.products[index].product_color"  v-bind:value="product_color.id">{{product_color.color}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2"><label>Unit Price(PKR)<span style="color:red;">*</span></label></div>
                                    <div class="col-md-3"><vue-numeric class="textbox" v-model="new_order.products[index].cost_per_set" placeholder="Cost"></vue-numeric></div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2"><label>Quantity<span style="color:red;">*</span></label></div>
                                    <div class="col-md-3"><input type="text" class="textbox" v-model="new_order.products[index].quantity" placeholder="Quantity" required></div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-11" v-if="index>0">
                                        <button class="btn btn-danger pull-right" v-on:click="removeProductForm(index)" title="Delete"><i class="fa fa-times"></i></button>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <br/>
                                <div class="clearfix"></div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <button class="btn btn-info" v-on:click="add_more_products"><i class="fa fa-plus"></i> Add More Products</button>
                                </div>

                                <div class="col-md-8">
                                    <button class="btn btn-tumblr pull-right"><i class="fa fa-check"></i> Create Order</button>
                                </div>
                                <div class="col-md-1"></div>
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
                allProducts:[],
                estimation_date:'',
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
        watch:{
            estimation_date:function(){
                this.new_order.estimation_date=moment(this.estimation_date).format('YYYY-MM-DD');
                console.log(this.new_order.estimation_date);
            },
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
                if (!this.errors.any() && this.estimation_date!='') {
                    axios.post('../order/create',this.new_order).then((response) => {
                        if(response.data==201){
                            this.new_order.id='';
                            this.new_order.estimation_date='';
                            this.new_order.products.product_id='';
                            this.new_order.products.product_color_id='';
                            this.new_order.products.quantity='';
                            this.new_order.products.cost_per_set='';
                            this.estimation_date='';

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
                else{
                    alert("Please Select Estimation Date");
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