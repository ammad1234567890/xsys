<template>
    <div class="row">
        <div class="card headcolor">
            <div class="card-header">
                    <h3 class="card-title pad-bot"><i class="material-icons">shopping_cart</i> <small>ALL RECEIVED ORDERS</small> </h3>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Receive Order Details</div>

                <div class="panel-body">
                    <div class="alert alert-success"  v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <table id="outlet_table" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Receive No</th>
                            <th>Collected By</th>
                            <th>QA Status</th>
                            <th>Description</th>
                            <th>Receive Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(receive, index) in all_receive_orders">
                            <td>Order#{{receive.manufacturing_order_id}}</td>
                            <td>Receive#{{receive.id}}</td>
                            <td>{{receive.staff.name}}</td>
                            <td  style="text-align:center; font-size: 20px;" title="QA Failed" v-if="receive.is_qa_pass==0"><i class="fa fa-times"></i></td>
                            <td  style="text-align:center; font-size: 20px; color: green;"  title="QA Passed" v-else><i class="fa fa-check"></i></td>
                            <td v-if="receive.qa_description==null"> ---- </td>
                            <td v-else>{{receive.qa_description}}</td>
                            <td>{{receive.receive_status.status}}</td>
                            <td><button class="btn btn-primary" v-on:click="show_products(index)">Products</button></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- View Details Modal Start-->
            <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="receive_info_modal" aria-labelledby="bs-add-Model-modal-md">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Product Details</h4>
                        </div>
                        <div class="modal-body">
                            <h4>Order# {{order_no}} <span style="font-size:14px; font-weight:bold;">Receive# {{receive_no}}</span></h4>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td>Category</td>
                                            <td>Product</td>
                                            <td>Colour</td>
                                            <td>Quantity</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="product in products">
                                            <td>{{product.product_color.product.product_category.name}}</td>
                                            <td>{{product.product_color.product.name}}</td>
                                            <td>{{product.product_color.color}}</td>
                                            <td>{{product.product_qty}}</td>
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
                all_receive_orders:[],
                products:[],
                order_no:'',
                receive_no:''
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
                this.get_all_receiveOrders();
            },
            get_all_receiveOrders:function(){
                axios.get('../order/received_order_details').then((response)=>{
                    this.all_receive_orders=response.data;
                });
            },
            show_products:function(index){
                $('#receive_info_modal').modal('show');
                this.products=this.all_receive_orders[index].receive_products;
                this.order_no=this.all_receive_orders[index].manufacturing_order_id;
                this.receive_no=this.all_receive_orders[index].id;
            }
        }
    }


</script>