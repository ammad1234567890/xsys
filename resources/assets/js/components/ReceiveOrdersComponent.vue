<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2 class="panel-title">Receive Order Details</h2>
                </div>

                <div class="panel-body">
                    <div class="alert alert-success"  v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <table id="receive_orders_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Receive  No</th>
                            <th>Received By</th>
                            <th>QA Status</th>
                            <th>Description</th>
                            <th>Receive Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(receive, index) in all_receive_orders">
                            <td>{{receive.order.manufacture_order_no}}</td>
                            <td>{{receive.receive_no}}</td>
                            <td>{{receive.staff.name}}</td>
                            <td  style="text-align:center; font-size: 20px;" title="QA Failed" v-if="receive.is_qa_pass==0"><i class="fa fa-times"></i></td>
                            <td  style="text-align:center; font-size: 20px; color: green;"  title="QA Passed" v-else><i class="fa fa-check"></i></td>
                            <td v-if="receive.qa_description==null"> ---- </td>
                            <td v-else>{{receive.qa_description}}</td>
                            <td>{{receive.receive_status.status}}</td>
                            <td><button class="btn btn-success btn-xs" v-on:click="show_products(index)"><i class="fa fa-eye"></i></button></td>
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
                            <h4>{{receive_number}}</span></h4>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td>Category</td>
                                            <td>Product</td>
                                            <td>Color</td>
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
                        <div class="modal-footer">
                            <button class="btn btn-github" data-dismiss="modal" aria-label="Close">Close</button>
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
                receive_no:'',
                receive_number:''
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
                this.receive_number=this.all_receive_orders[index].receive_no;
            }
        }
    }

    $(document).ready(function() {
        setTimeout(function(){
            $('#receive_orders_table').DataTable({
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