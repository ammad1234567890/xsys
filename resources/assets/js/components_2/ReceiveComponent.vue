<template>

<div class="row">
    <div class="card headcolor">
            <div class="card-header">
                    <h3 class="card-title pad-bot">
                        <h4 class="heading-inline" style="text-transform: uppercase; ">New Consignment</h4> </h3>
            </div>
            <hr/>
        </div>
    
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">Details</h2>
            </div>

            <div class="panel-body">
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Purchase Order No.<span style="color:red;">*</span></label> 
                            </div>
                        <div class="col-md-3">    
                            <select class="textbox_dropdown" v-model="new_recieving.order_id" @change="order_change" required>
                                <option value="">Select</option>
                                <option v-for="order in all_orders" v-bind:value="order.id">
                                    {{order.manufacture_order_no}}
                                </option>
                            </select>
                        </div>
                            <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label for="select_collected_by">Transit Status<span style="color:red;">*</span></label> 
                        </div>
                        <div class="col-md-3">
                                <select class="textbox_dropdown" v-model="new_recieving.recieve_status_id" required disabled="disabled">

                                    <option v-for="status in all_status" v-bind:value="status.id">

                                        {{status.status}}
                                    </option>
                                </select> 
                        </div>
                        <div class="col-md-1"></div>
                        
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <label for="select_collected_by">QA Passed<span style="color:red;">*</span></label>
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" v-model="new_recieving.qa_check" disabled="disabled" id="checkboxFiveInput" name="" @change="change_qa_check">
                        </div>

                        <!-- <div class="col-md-2">
                            <textarea class="textbox" v-model="new_recieving.qa_description" placeholder="Description" v-if="new_recieving.qa_check==1">
                            </textarea>
                        </div> -->
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label for="select_collected_by">Received By<span style="color:red;">*</span></label>
                        </div>
                        <div class="col-md-3">
                            <select class="textbox_dropdown" v-model="new_recieving.collected_id" required>
                                <option value="">Select</option>
                                <option v-for="staff in all_staff" v-bind:value="staff.id">{{staff.name}}</option>
                            </select>
                        </div>
                        <div class="col-md-1"></div>
                        
                    </div>
                    <div class="row">


                        <div class="col-md-11">
                            <button class="btn btn-primary pull-right" v-on:click="View_order_for_Receive($event)">
                                <i class="fa fa-check"></i> Receive Products</button>
                        </div>
                        <div class="col-md-1">
                        </div>
                    </div>

                    <!-- <div class="row" v-for="(find, index) in new_recieving.order_products">
                        <hr/>
                        <div class="col-md-2">
                            <label for="select_collected_by">Model<span style="color:red;">*</span></label> 
                        </div>
                        <div class="col-md-3">
                            <select class="textbox_dropdown" v-model="selected_order_product_index[index].index_no" @change="change_product(index)" required>
                                    <option value="-1" selected="selected">Select</option>
                                    <option v-for="(products, index) in all_order_products"  v-bind:value="index">{{products.product_color.product.name}} ({{products.product_color.color}}) </option>
                                </select>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-2">
                            <label for="select_collected_by">Quantity<span style="color:red;">*</span></label> 
                        </div>
                        <div class="col-md-3">
                            <input type="number" class="textbox_dropdown" :name="'Product Quantity '+index" v-model="new_recieving.order_products[index].quantity" :placeholder="''+new_recieving.order_products[index].max_qty" v-validate="{ max_value: new_recieving.order_products[index].max_qty, min_value:0 }"  @change="qty_change(index)" required>
                                <span class="text-danger" v-show="errors.has('Product Quantity '+index)">
                                  Please Enter {{new_recieving.order_products[index].max_qty}} or less
                                </span>
                        </div>
                            
                            
                            <div class="col-md-11" v-if="index>0">
                                <button class="btn btn-danger pull-right" v-on:click="removeProductForm(index)">Remove</button>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="clearfix"></div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-info" v-on:click="add_more_products"><i class="fa fa-plus"></i> Add More Products</button>
                        </div>
                    </div> -->
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
                    <!--<div class="row">


                        <div class="col-md-11">
                            <button class="btn btn-primary pull-right" v-on:click="recieve_order_submit()"><i class="fa fa-check"></i> Order Recieved</button>
                        </div>
                        <div class="col-md-1">
                        </div>
                    </div> -->
                </form>

            </div>
        
    </div>

    <!-- Modal -->
    <div class="modal fade" id="receive_modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New Consignment Receiving - {{new_recieving.selected_PO_no}}</h4>
                </div>
                <div class="modal-body">

                    <div class="alert alert-success"  v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <td>S.no</td>
                            <td>Model</td>
                            <td>Color</td>
                            <td>Total Qty.</td>
                            <td>Remaining Qty.</td>
                            <td>Receiving Qty.</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(find, index) in new_recieving.order_products">
                            <td>{{index+1}}</td>
                            <td>{{find.product_name}}</td>
                            <td>{{find.product_color_name}}</td>
                            <td><span style="float:right;">{{find.final_qty}}</span></td>
                            <td><span style="float:right;">{{find.max_qty}}</span></td>
                            <td>
                                <input type="text" :name='"final_qty"+index' :placeholder="'Must be less than '+find.max_qty" v-validate="{ max_value: find.max_qty, min_value:1 }"  v-model="find.quantity"/>

                                <span class="text-danger" style="display: block; margin-top:5px;" v-show="errors.has('final_qty'+index)">Quantity must be {{find.max_qty}} or less
                                </span>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                    <b>Collected By</b> <b style="color:#4f9ef1;">{{new_recieving.collected_person_name}}</b> in <b style="color:#4f9ef1;">{{new_recieving.warehouse_status}}</b>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary pull-right" v-on:click="recieve_order_submit($event)"><i class="fa fa-check"></i> Order Recieved</button>
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

                message:'',
                all_orders:[],
                all_status:[],
                all_order_products:[],
                all_staff:[],
                change_index:'',

                all_receiving_products:[],
                selected_order_product_index:[{
                    index_no:'',
                }],
                new_recieving:{
                    selected_PO_no:'',
                    id:'',
                    order_id:'',
                    qa_check:1,
                    warehouse_status:'',
                    collected_person_name:'',
                    collected_id:'',
                    qa_description:'',
                    recieve_status_id:1,
                    order_products:[
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
                this.change_index=changing_index;

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
                var is_any_qty_fill=0;
                for(var i=0; i<this.new_recieving.order_products.length; i++){
                    if(this.new_recieving.order_products[i].quantity!=''){
                        is_any_qty_fill=1;
                    }
                }
                if(is_any_qty_fill==1){
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
                                location.reload();
                            }
                            else {
                                alert(response.data);
                            }
                        });
                    }
                }
                else{
                    alert("Quantities are not set");
                }


            },
            View_order_for_Receive:function(e){
                e.preventDefault();
                    if(this.new_recieving.collected_id!='' && this.new_recieving.order_id!=''){
                        $('#receive_modal').modal('show');

                        this.new_recieving.order_products=[];
                        for(var i=0; i<this.all_orders.length; i++){
                            if(this.all_orders[i].id==this.new_recieving.order_id){
                                this.new_recieving.selected_PO_no=this.all_orders[i].manufacture_order_no;
                            }
                        }

                        for(var i=0; i<this.all_staff.length; i++){
                            if(this.all_staff[i].id==this.new_recieving.collected_id){
                                this.new_recieving.collected_person_name=this.all_staff[i].name;
                            }
                        }

                        for(var i=0; i<this.all_status.length; i++){
                            if(this.new_recieving.recieve_status_id==this.all_status[i].id){
                                this.new_recieving.warehouse_status=this.all_status[i].status;
                            }

                        }


                        axios.post('../order/get_products',this.new_recieving).then((response)=>{
                            this.all_order_products=response.data
                            for(var i=0; i<this.all_order_products.length; i++){
                                this.new_recieving.order_products.push({
                                    id:this.all_order_products[i].product_color.id,
                                    final_qty:this.all_order_products[i].quantity,
                                    max_qty:this.all_order_products[i].remaining_qty,
                                    quantity:'',
                                    product_name:this.all_order_products[i].product_color.product.name,
                                    product_color_name:this.all_order_products[i].product_color.color,
                                });
                            }
                        });
                    }
                    else{
                        alert("PLease Select Order No & Receiving Person");
                    }




            }
        }
    }


</script>