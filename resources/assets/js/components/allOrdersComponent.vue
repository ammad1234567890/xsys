<template>
    <div class="row">
        <div class="card headcolor">
            <div class="card-header">
                    <h3 class="card-title pad-bot">
                        <h4 class="heading-inline" style="text-transform: uppercase; "> Purchase Orders Details</h4> </h3>
            </div>
            <hr/>
        </div>
        
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2 class="panel-title">Order Details</h2>
                </div>

                <div class="panel-body">
                    <div class="alert alert-success"  v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <table id="order_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Model</th>
                            <th>Date</th>
                            <th>Est. Delivery Date</th>
                            <!-- <th>Order By</th> -->
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(order, index) in all_orders">
                            <td>{{order.manufacture_order_no}}</td>
                            <td><span v-for="product in all_orders[index].manufacture_order_products"><i style="display:block;">{{product.product_color.product.name}}, {{product.product_color.color}}</i> </span></td>
                            <td>{{order.created_at | moment}}</td>
                            <td>{{order.eta | moment}}</td>
                            <!-- <td>{{order.user.name}}</td> -->
                            <td  style="text-align:center; font-size: 20px;" v-if="order.transaction_closed==0"><i class="fa fa-rotate-right"></i></td>
                            <td  style="text-align:center; font-size: 20px; color: green;"  title="Payment Completed" v-else><i class="fa fa-check"></i></td>
                            <td>
                                <!-- <div class="dropdown">
                                    <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" v-on:click="editProduct(index)">Edit</a></li>
                                        <li><a href="#" v-on:click="order_delete(index)">Delete</a></li>
                                        <li><a href="#" v-on:click="change_status_btn(index)">Change Status</a></li>
                                    </ul>
                                </div> -->
                                    <button class="btn btn-info btn-xs" type="button" v-on:click="editProduct(index)" title="Edit"><i class="fa fa-edit"></i></button>

                                    <button class="btn btn-default btn-xs" type="button" v-on:click="change_status_btn(index)" title="Change Status"><i class="fa fa-file-text"></i></button>

                                    <button class="btn btn-success btn-xs" type="button" v-on:click="view_order_details(index)" title="View Detail"><i class="fa fa-eye"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            

            <!-- View Details Modal Start-->
            <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="order_info_modal" aria-labelledby="bs-add-Model-modal-md">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Summary - Purchase Order</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5><b>Order No: {{view_order.order_no}}</b> <span class="pull-right"><b>Date:</b> <i>{{view_order.created_at | moment}}</i> </span></h5>
                                    <table class="table table-hovered">
                                        <tr>
                                            <td style="width: 136px;"><strong>Total Order Cost :</strong></td>
                                            <td >{{view_order.total_cost | currency('Rs')}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Remaining Cost :</strong></td>
                                            <td>{{view_order.remaining_payment | currency('Rs')}}</td>
                                        </tr>
                                        <tr><!--
                                            <td>Order By</td>
                                            <td>{{view_order.created_by}}</td>
                                        </tr> -->
                                        <tr>
                                            <td style="width: 136px;"><strong>Current Status :</strong></td>

                                            <td v-if="view_order.current_status!=''">
                                                <span  v-for="last_status in view_order.current_status">{{last_status.status}}</span>
                                            </td>
                                            <td v-else>---</td>
                                        </tr>
                                    </table>
                                    <hr/>
                                    <h4>Product Details</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td>Category</td>
                                            <td>Model</td>
                                            <td>Color</td>
                                            <td>Quantity</td>
                                            <td>Received Qty</td>
                                            <td>Price(PKR)</td>
                                            <td>Total Price (PKR)</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="products in view_order.order_products">
                                            <td>{{products.product_color.product.product_category.name}}</td>
                                            <td>{{products.product_color.product.name}}</td>
                                            <td>{{products.product_color.color}}</td>
                                            <td style="text-align:right;">{{products.quantity}}</td>
                                            <td style="text-align:right;">{{(products.quantity-products.remaining_qty)}}</td>
                                            <td style="text-align:right;">{{products.unit_cost | currency(' ')}}</td>
                                            <td style="text-align:right;">{{products.unit_cost*products.quantity | currency(' ')}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <hr/>
                                    <h4>Payments</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td>Date</td>
                                            <td>Type</td>
                                            <td>Currency</td>
                                            <td>Amount</td>
                                            <td>XRT</td>
                                            <td>Total Amount (PKR)</td>
                                            <!-- <td>Payment By</td> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="payment in view_order.order_payments">
                                            <td>{{payment.created_at | moment}}</td>
                                            <td>{{payment.payment_type.type}}</td>
                                            <td>{{payment.currency.name}}</td>
                                            <td style="text-align:right;">{{payment.payment_amount | currency(' ')}} </td>
                                            <td  style="text-align:right;">{{payment.exchange_rate}}</td>
                                            <td style="text-align:right;">{{payment.total_amount | currency(' ')}}</td>
                                            <!-- <td>{{payment.user.name}}</td> -->
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-github" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- View Details Modal END -->


            <!-- Change Status Modal Start-->
            <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="change_status_modal" aria-labelledby="bs-add-Model-modal-md">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Change Order Status</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-success"  v-if="message">
                                <strong>{{message}}</strong>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>{{change_order_status.order_no}}</h4>
                                    <form @submit.prevent="add_order_status">
                                        <textarea class="form-control" v-model="change_order_status.status" placeholder="Status Text ..." required></textarea>
                                        <br/>
                                        <button type="submit" class="btn btn-primary">Add Status</button>
                                    </form>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-github" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View Status Modal END -->

 
        </div>
 <!-- Modal -->
 <!-- Modal -->
<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->          

    </div>
                  
</template>

<script>


    export default {
        data(){
            return{
                message:'',
                all_orders:[],
                view_order:{
                    orderno:'',
                    order_no:'',
                    eta:'',
                    remaining_payment:'',
                    total_cost:'',
                    transaction_closed:'',
                    created_by:'',
                    created_at:'',
                    order_products:[],
                    order_payments:[],
                    current_status:[]
                },
                change_order_status:{
                    id:'',
                    status:'',
                    order_no:''
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created:function(){
            this.init();
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            },

            getdate: function (date) {
                return moment(date).format('DD');
            },

            getmonth: function (date) {
                return moment(date).format('MM');
            },
        },
        methods:{
            init:function(){
                this.get_all_orders();
            },
            get_all_orders:function(){
                axios.get('../order/get_all_orders').then((response)=>{
                   // this.all_orders=response.data;
                    this.all_orders = _.orderBy(response.data, ['manufacture_order_no'], ['desc']);
                });


            },
            change_status_btn:function(index){
                $('#change_status_modal').modal('show');
                this.change_order_status.id=this.all_orders[index].id;
                this.change_order_status.order_no=this.all_orders[index].manufacture_order_no;
            },
            view_order_details:function(index){
                $('#order_info_modal').modal('show');
                this.view_order.orderno="Order# "+this.all_orders[index].id;
                this.view_order.eta=this.all_orders[index].eta;
                this.view_order.order_no=this.all_orders[index].manufacture_order_no;
                this.view_order.remaining_payment=this.all_orders[index].remaining_payment;
                this.view_order.total_cost=this.all_orders[index].total_cost;
                this.view_order.transaction_closed=this.all_orders[index].transaction_closed;
                this.view_order.created_by=this.all_orders[index].user.name;
                this.view_order.created_at=this.all_orders[index].created_at;
                this.view_order.current_status=this.all_orders[index].order_status;
                this.view_order.order_products=this.all_orders[index].manufacture_order_products;
                this.view_order.order_payments=this.all_orders[index].payment;
            },
            add_order_status:function(e){
                e.preventDefault();
                this.$validator.validateAll();
                if (!this.errors.any()) {
                    axios.post('../order/change_order_status',this.change_order_status).then((response)=>{
                        if(response.data==201){
                            this.message="Status Changed Successfully!";
                            this.change_order_status.status='';
                            this.get_all_orders();
                        }
                        else{
                            alert(response.data);
                        }
                    });
                }
            },
            order_delete:function(index){
                this.change_order_status.id=this.all_orders[index].id;
                var result=confirm("Are you want to Delete? It'll also delete all received & payment details");
                if(result){
                    axios.post('../order/delete',this.change_order_status).then((response)=>{
                        if(response.data==201){
                            this.get_all_orders();
                        }
                        else{
                            alert(response.data);
                        }
                    });
                }
            }
        }
    }

    $(document).ready(function() {

    });

</script>