<template>
    <div class="row">
        <div class="col-md-12">
            <h2 style="margin-top: 6px; font-variant: small-caps; font-weight:bold;">All Retailer Orders</h2>
            <hr/>
            <div class="panel panel-info">
                <div class="panel-heading">Order Details</div>

                <div class="panel-body">
                    <div class="alert alert-success"  v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <table id="outlet_table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Estimate Delivery</th>
                            <th>Retailer</th>
                            <th>Outlet</th>
                            <th>Account Clearance</th>
                            <th>Total Amount</th>
                            <th>Created Order Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(order, index) in all_orders">
                            <td>Order#{{order.id}}</td>
                            <td>{{order.expected_delivery_date}}</td>
                            <td>{{order.retailer.name}}</td>
                            <td>{{order.retailer_outlet.name}}</td>
                            <td v-if="order.is_account_clearance==1"><i class="fa fa-check" title="Cleared from Finance" style="text-align:center; display:block; font-size:25px; color:green;"></i> </td>
                            <td v-else><i class="fa fa-times" style="text-align:center; display:block; font-size:25px; color:red;"></i></td>

                            <td>{{order.total_cost}}</td>
                            <td>{{order.created_at}}</td>
                            <td>
                                <div class="dropdown">

                                    <button class="btn btn-primary" type="button" v-on:click="view_order_details(index)">View Details</button>

                                    <button class="btn btn-success" type="button" v-if="order.is_account_clearance==1">Generate Invoice</button>
                                    <button class="btn btn-danger" type="button" v-if="order.is_account_clearance==0" v-on:click="order_delete(index)"><i class="fa fa-trash-o"></i> </button>
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
                                    <h5> <span class="pull-right"></span></h5>


                                    <h5><b>Order#{{view_order.orderno}}</b> <span class="pull-right"><b>Created at:</b> <i> {{view_order.created_at}}</i> </span></h5>
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
                                            <td>Account Clearance</td>
                                            <td v-if="view_order.is_account_clear"><i class="fa fa-check"  title="Order Cleared!"></i></td>
                                            <td v-else><i class="fa fa-times"  title="Order Cleared!"></i> </td>
                                        </tr>
                                        <tr v-if="view_order.is_account_clear">
                                            <td>Order Cleared By</td>
                                            <td>{{view_order.updated_by}}</td>
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
                                            <td>Sales Unit Price</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="products in view_order.order_products">
                                            <td>{{products.product_color.product.product_category.name}}</td>
                                            <td>{{products.product_color.product.name}}</td>
                                            <td>{{products.product_color.color}}</td>
                                            <td>{{products.product_qty}}</td>
                                            <td>{{products.unit_price}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View Details Modal END -->



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
                view_order:{
                    orderno:'',
                    eta:'',
                    remaining_payment:'',
                    total_cost:'',
                    is_account_clear:'',
                    total_qty:'',
                    retailer_name:'',
                    sales_officer_name:'',
                    outlet_name:'',
                    is_approved:'',
                    created_by:'',
                    updated_by:'',
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
                axios.get('../retailer_order/get_orders').then((response)=>{
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
                var result=confirm("Are you want to Delete?");
                if(result){
                    axios.post('../retailer_order/delete',this.change_order_status).then((response)=>{
                        if(response.data==201){
                            this.get_all_orders();
                        }
                        else{
                            alert(response.data);
                        }
                    });
                }
            },
            view_order_details:function(index){
                $('#order_info_modal').modal('show');

                this.view_order.orderno=this.all_orders[index].id;
                this.view_order.eta=this.all_orders[index].expected_delivery_date;
                this.view_order.remaining_payment=this.all_orders[index].remaining_payment;
                this.view_order.total_cost=this.all_orders[index].total_cost;
                this.view_order.is_account_clear=this.all_orders[index].is_account_clearance;
                this.view_order.is_approved=this.all_orders[index].is_approved;

                this.view_order.retailer_name=this.all_orders[index].retailer.name;
                this.view_order.sales_officer_name=this.all_orders[index].retailer.name;
                this.view_order.outlet_name=this.all_orders[index].retailer_outlet.name;
                this.view_order.order_products=this.all_orders[index].order_products;
                this.view_order.created_by=this.all_orders[index].user.name;
                this.view_order.updated_by=this.all_orders[index].updated_user.name;
                this.view_order.created_at=this.all_orders[index].created_at;




            },

        }
    }


</script>