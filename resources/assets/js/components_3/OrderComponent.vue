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
                                <div class="col-md-2"><label>Est. Delivery Date<span style="color:red;">*</span></label></div>
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
                                            <option v-for="(product_color, index) in new_order.products[index].product_color" v-bind:value="product_color.id">{{product_color.color}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2"><label>Unit Price(PKR)<span style="color:red;">*</span></label></div>
                                    <div class="col-md-3"><vue-numeric class="textbox" v-model="new_order.products[index].cost_per_set" @change="set_cost()" placeholder="Cost"></vue-numeric></div>
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
        <!-- Modal -->
        <div class="modal fade" id="order_modal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Purchase Order</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td>S.no</td>
                                    <td>Model</td>
                                    <td>Color</td>
                                    <td>Quantity</td>
                                    <td><span>Unit Price (PKR)</span></td>
                                    <td><span>Total Price (PKR)</span></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in final_products">
                                    <td>{{index+1}}</td>
                                    <td>{{product.product_name}}</td>
                                    <td>{{product.product_color}}</td>
                                    <td><span style="float:right;">{{product.quantity}}</span></td>
                                    <td><span style="float:right;">{{product.cost_per_set | currency('')}}</span></td>
                                    <td><span style="float:right;">{{product.total_price | currency('')}}</span></td>
                                </tr>
                            <tr>
                                <td colspan="6"><span style="float:right; font-weight:bold">{{total_order_amount | currency('')}}</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" v-on:click="submit_order()">Submit Order</button>
                    </div>
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
                            cost_per_set:'',
                            product_name:'',
                            product_color_name:'',
                        }
                    ],
                },
                final_products:[],
                total_order_amount:0,

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


                for(var i=0; i<this.allProducts.length; i++){
                    if(this.allProducts[i].id==product_id){
                        this.new_order.products[index].product_name=this.allProducts[i].name;
                    }
                }

            },
            add_more_products:function(e){
                e.preventDefault();
                this.new_order.products.push({product_id:'', product_color:'', quantity:'', cost_per_set:'',product_name:'', product_color_name:''});
            },
            get_products:function(){
                axios.get('../allProducts').then((response) => {
                    this.allProducts= response.data.data;
                });
            },
            add_order:function(e){
                this.$validator.validateAll();
                if (!this.errors.any() && this.estimation_date!='') {
                    this.final_products=[];
                    var found_ids=[];
                    var old_product_color_id=0;
                    for(var i=0; i<this.new_order.products.length; i++){
                        if(this.final_products==""){
                            this.final_products.push({
                                product_id:this.new_order.products[i].product_id,
                                product_color_id:this.new_order.products[i].product_color_id,
                                quantity:parseInt(this.new_order.products[i].quantity),
                                cost_per_set:this.new_order.products[i].cost_per_set,
                                product_name:this.new_order.products[i].product_name,
                                product_color:this.new_order.products[i].product_color_name,
                                total_price:parseInt(this.new_order.products[i].quantity)*parseInt(this.new_order.products[i].cost_per_set)
                            });

                        }
                        else{
                            var is_available=0;
                            //alert(this.final_products.includes({'product_color_id':this.new_order.products[i].product_color_id}));
                            for(var j=0; j<this.final_products.length; j++){
                                if(this.new_order.products[i].product_color_id==this.final_products[j].product_color_id){
                                    is_available=1;
                                    this.final_products[j].quantity+=parseInt(this.new_order.products[i].quantity);
                                    this.final_products[j].total_price+=parseInt(this.new_order.products[i].quantity)*parseInt(this.new_order.products[i].cost_per_set);
                                    break;
                                }
                            }
                            if(is_available==0){
                                this.final_products.push({
                                    product_id:this.new_order.products[i].product_id,
                                    product_color_id:this.new_order.products[i].product_color_id,
                                    quantity:parseInt(this.new_order.products[i].quantity),
                                    cost_per_set:this.new_order.products[i].cost_per_set,
                                    product_name:this.new_order.products[i].product_name,
                                    product_color:this.new_order.products[i].product_color_name,
                                    total_price:parseInt(this.new_order.products[i].quantity)*parseInt(this.new_order.products[i].cost_per_set)
                                });
                            }
                        }

                    }
                    this.total_order_amount=0;
                    for(var j=0; j<this.final_products.length; j++){
                        this.total_order_amount+=this.final_products[j].total_price;

                    }
                    $('#order_modal').modal('show');
                }
                else{
                    alert("Please Select Estimation Date");
                }



             /*   this.$validator.validateAll();
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
                            this.message="Order created successfully";
                            $("html, body").animate({
                                scrollTop: 0
                            }, 600, function() {
                                // window.location.reload();
                            });
                            // window.location.reload();
                        }
                        else{
                            alert(response.data);
                        }
                    });

                }
                else{
                    alert("Please Select Estimation Date");
                } */

            },
            myfunc:function(index){
                //alert(this.new_order.products[index].product_color_id);
                //this.new_order.products[index].product_color_id=
                axios.get('../getproductColor/'+this.new_order.products[index].product_color_id).then((response) => {
                    this.new_order.products[index].cost_per_set=response.data[0].price;
                    for(var i=0; i<this.new_order.products.length; i++){
                        if(this.new_order.products[index].product_color_id==this.new_order.products[i].product_color_id){
                            this.new_order.products[index].cost_per_set=this.new_order.products[i].cost_per_set;

                        }
                    }


                });
                for(var i=0; i<this.new_order.products[index].product_color.length; i++){
                    /* if(this.allProducts[i].id==product_id){
                         this.new_order.products[index].product_color=this.allProducts[i].name;
                     } */
                    if(this.new_order.products[index].product_color[i].id==this.new_order.products[index].product_color_id){
                        this.new_order.products[index].product_color_name=this.new_order.products[index].product_color[i].color;
                    }
                    //alert();
                }


               // alert(this.new_order.products[index].product_color);


            },
            submit_order(){
                axios.post('../order/create',{id: this.new_order.id, estimation_date:this.new_order.estimation_date, products:this.final_products }).then((response) => {
                    if(response.data==201){
                        $('#order_modal').modal('hide');
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
                        this.message="Order created successfully";
                        $("html, body").animate({
                            scrollTop: 0
                        }, 600, function() {
                            // window.location.reload();
                        });

                        location.reload();
                        // window.location.reload();
                    }
                    else{
                        alert(response.data);
                    }
                });
            },
            set_cost(){
                //index, product_color_id
               // index, new_order.products[index].product_color_id

                alert("adasd");
            }
        }
    }


</script>