<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2 class="panel-title">Order Details</h2>
                </div>

                <div class="panel-body">
                    <div class="alert alert-success"  v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <table id="order_detail_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order No</th>
                            <th>Outlet</th>
                            <!-- <th>Estimated Delivery</th> -->
                            <!-- <th>Retailer</th> -->
                            <!-- <th>Account Clearance</th> -->
                            <th>Price(PKR)</th>
                            <th>Account Clearance</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(order, index) in all_orders">
                            <td>{{order.created_at | moment}}</td>
                            <td>CR{{order.created_at | getdate}}{{order.created_at | getmonth}}00{{order.id}}</td>
                            <td>{{order.retailer_outlet.name}}</td>
                            <!-- <td>{{order.expected_delivery_date | moment}}</td> -->
                            <!-- <td>{{order.retailer.name}}</td> -->


                            <td style="text-align: right;">{{order.total_cost | currency('')}}</td>
                            <td v-if="order.is_account_clearance==1"><i class="fa fa-check" title="Cleared from Finance" style="text-align:center; display:block; font-size:25px; color:green;"></i> </td>
                            
                            <td v-else><i class="fa fa-times" style="text-align:center; display:block; font-size:25px; color:red;"></i></td>
                            <td>
                                
                                <div class="dropdown">
                                    <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown"  v-if="order.is_account_clearance==0">Action
                                        <span class="caret"></span></button>

                                    <ul class="dropdown-menu">
                                        <li><a href="#" v-on:click="edit_order_modal(index)">Edit</a></li>
                                        <li><a href="#" v-on:click="approve_order(index)">Approve</a></li>
                                    </ul>
                                    <button class="btn btn-success btn-xs" type="button" v-on:click="view_order_details(index)" title="View Detail"><i class="fa fa-eye"></i></button> &nbsp;
                                
                                <a class="btn btn-default btn-xs" v-bind:href="'../invoice/create/'+order.id" v-if="order.is_account_clearance==1" title="Generate Invoice"><i class="fa fa-file"></i></a>
                               <!-- <a class="btn btn-tumblr btn-xs">Invoice Received</a> -->
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


                                    <h5><b>CR{{view_order.created_at | getdate}}{{view_order.created_at | getmonth}}00{{view_order.orderno}}</b> <span class="pull-right"><b>Created at:</b> <i> {{view_order.created_at | moment}}</i> </span></h5>
                                    <table width="100%" class="table table-hovered">
                                        <tr>
                                            <td>Total Order Cost</td>
                                            <td>{{view_order.total_cost | currency('Rs')}}</td>
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
                                            <td>{{products.unit_price  | currency('Rs')}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-github" data-dismiss="modal" aria-label="Close">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View Details Modal END -->

            <!-- EDIT ORDER MODAL START -->
            <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="order_edit_modal" aria-labelledby="bs-add-Model-modal-md">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <div class="row">
                            <h4 class="modal-title">Edit Order#{{view_order.orderno}}</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div v-for="(products, index) in view_order.order_products">

                                                <div class="form-group col-md-3 is-empty">
                                                    <label for="Product">Product</label>
                                                    <input type="text" class="form-control" v-model="products.product_color.product.name" readonly/>
                                                </div>
                                                <div class="form-group col-md-2 is-empty">
                                                    <label for="ProductColor">Color</label>
                                                    <input type="text" class="form-control" v-model="products.product_color.color" readonly/>
                                                </div>
                                                <div class="form-group col-md-2 is-empty">
                                                    <label for="Quantity">Quantity</label>
                                                    <input type="text" class="form-control" v-model="products.product_qty"/>
                                                </div>
                                                <div class="form-group col-md-2 is-empty">
                                                    <label for="Price">Unit Price</label>
                                                    <input type="text" class="form-control" v-model="products.unit_price" readonly/>
                                                </div>
                                                <div class="form-group col-md-3 is-empty">
                                                    <button class="btn btn-danger" v-on:click="remove_product(index)">Remove</button>
                                                </div>
                                            </div>
                                        <button class="btn btn-tumblr" v-on:click="save_products()">Submit</button>
                                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>




                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- EDIT ORDER MODAL END -->

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
                    created_at:'',
                    order_products:[],
                    order_payments:[],
                    current_status:[],
                    remove_product_ids:[]
                },
                change_order_status:{
                    id:'',
                    status:'',
                },
                order_for_approve:{
                    id:''
                },

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
                this.view_order.created_at=this.all_orders[index].created_at;




            },
            approve_order:function(index){
                this.order_for_approve.id=this.all_orders[index].id;
                var result=confirm("Are you sure for approving the order?");
                if(result){
                    axios.post('../finance/approve_order',this.order_for_approve).then((response)=>{
                        if(response.data==201){
                            this.message="Order has been Approved!";
                            this.get_all_orders();
                        }
                        else{
                            alert(response.data);
                        }
                    });
                }

            },
            edit_order_modal:function(index){
                $('#order_edit_modal').modal('show');
                this.view_order.orderno=this.all_orders[index].id;
                this.view_order.eta=this.all_orders[index].expected_delivery_date;
                this.view_order.retailer_name=this.all_orders[index].retailer.name;
                this.view_order.sales_officer_name=this.all_orders[index].retailer.name;
                this.view_order.outlet_name=this.all_orders[index].retailer_outlet.name;
                this.view_order.order_products=this.all_orders[index].order_products;
            },
            save_products:function(){
                axios.post('../retailer_order/edit_products',this.view_order).then((response)=>{
                    if(response.data==201){
                        this.message="Order has been updated!";
                        this.get_all_orders();
                    }
                    else{
                        alert(response.data);
                    }
                });
            },
            remove_product:function(index){
                this.view_order.remove_product_ids.push({'id':this.view_order.order_products[index].id});
                this.view_order.order_products.splice(index,1);
            }
        }
    }


    $(document).ready(function() {
        setTimeout(function(){
            $('#order_detail_table').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search here",
            }
            });
        },3000);
    });


</script>