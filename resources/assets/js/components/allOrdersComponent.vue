<template>
    <div class="row">
        <div class="card headcolor">
            <div class="card-header">
                    <h3 class="card-title pad-bot"><i class="material-icons">shopping_cart</i> <small>ALL ORDERS</small> </h3>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Order Details</div>

                <div class="panel-body">
                    <div class="alert alert-success"  v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <table id="order_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Estimate Delivery</th>
                            <th>Order By</th>
                            <th>Order At</th>
                            <th>Products</th>
                            <th>Status</th>
                            <th class="col-md-3">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(order, index) in all_orders">
                            <td>Order#{{order.id}}</td>
                            <td>{{order.eta}}</td>
                            <td>{{order.user.name}}</td>
                            <td>{{order.created_at}}</td>
                            <td><span v-for="product in all_orders[index].manufacture_order_products"><i style="display:block;">{{product.product_color.product.name}}, {{product.product_color.color}}</i> </span></td>
                            <td  style="text-align:center; font-size: 20px;" v-if="order.transaction_closed==0"><i class="fa fa-times"></i></td>
                            <td  style="text-align:center; font-size: 20px; color: green;"  title="Payment Completed" v-else><i class="fa fa-check"></i></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" v-on:click="editProduct(index)">Edit</a></li>
                                        <li><a href="#" v-on:click="order_delete(index)">Delete</a></li>
                                        <li><a href="#" v-on:click="change_status_btn(index)">Change Status</a></li>
                                    </ul>
                                    <button class="btn btn-tumblr btn-xs" type="button" v-on:click="view_order_details(index)">View Details</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- View Details Modal Start-->
            <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="order_info_modal" aria-labelledby="bs-add-Model-modal-md">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Order Details</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <h5><b>{{view_order.orderno}}</b> <span class="pull-right"><b>Order Date:</b> <i>{{view_order.created_at}}</i> </span></h5>
                                    <table width="100%" class="table table-hovered">
                                        <tr>
                                            <td>Total Order Cost</td>
                                            <td>{{view_order.total_cost}} Rs</td>
                                        </tr>
                                        <tr>
                                            <td>Remaining Order Cost</td>
                                            <td>{{view_order.remaining_payment}} Rs</td>
                                        </tr>
                                        <tr>
                                            <td>Order By</td>
                                            <td>{{view_order.created_by}}</td>
                                        </tr>
                                        <tr>
                                            <td>Current Status</td>

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
                                            <td>Product</td>
                                            <td>Colour</td>
                                            <td>Quantity</td>
                                            <td>Received Quantity</td>
                                            <td>Order Unit Price</td>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="products in view_order.order_products">
                                            <td>{{products.product_color.product.product_category.name}}</td>
                                            <td>{{products.product_color.product.name}}</td>
                                            <td>{{products.product_color.color}}</td>
                                            <td>{{products.quantity}}</td>
                                            <td>{{(products.quantity-products.remaining_qty)}}</td>
                                            <td>{{products.unit_cost}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <hr/>
                                    <h4>Payments</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td>Type</td>
                                            <td>Amount</td>
                                            <td>Currency</td>
                                            <td>XRT</td>
                                            <td>Total Amount</td>
                                            <td>Date</td>
                                            <td>Payment By</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="payment in view_order.order_payments">
                                            <td>{{payment.payment_type.type}}</td>
                                            <td>{{payment.payment_amount}} {{payment.currency.iso}}</td>
                                            <td>{{payment.currency.name}}</td>
                                            <td>{{payment.exchange_rate}}</td>
                                            <td>{{payment.total_amount}} Rs</td>

                                            <td>{{payment.created_at}}</td>
                                            <td>{{payment.user.name}}</td>
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
                                    <h4>Order# {{change_order_status.id}}</h4>
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
            },
            get_all_orders:function(){
                axios.get('../order/get_all_orders').then((response)=>{
                    this.all_orders=response.data;
                });
            },
            change_status_btn:function(index){
                $('#change_status_modal').modal('show');
                this.change_order_status.id=this.all_orders[index].id;
            },
            view_order_details:function(index){
                $('#order_info_modal').modal('show');
                this.view_order.orderno="Order# "+this.all_orders[index].id;
                this.view_order.eta=this.all_orders[index].eta;
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
        setTimeout(function(){
            $('#order_table').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
            });
        },3000);
    });

</script>