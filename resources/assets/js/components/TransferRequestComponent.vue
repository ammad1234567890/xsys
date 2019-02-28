<template>


    <div class="row">
        <div class=" col-md-12 paddingmarginzero">


            <div class="paddingmarginzero">
                <h4 class="heading-inline"> ALL Transfer Request</h4>
            </div>

            <div class="panel panel-info">

                <div class="panel-heading">
                    Display List

                </div>

                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-12 ">
                            <div class="portlet portlet-table">
                                <div class="portlet-content">
                                    <div class="table-responsive">
                                        <table id="approved-win" class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <td>Sno</td>
                                                <td>TI No</td>
                                                <td>Warehouse From</td>
                                                <td>Warehouse To</td>
                                                <td>Approved Status</td>
                                                <td>Approved By</td>
                                                <td>Created Date</td>
                                                <td>Action</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(issue_note, index) in all_requests">
                                                <td>{{index+1}}</td>
                                                <td>{{issue_note.win_no}}</td>
                                                <td>{{issue_note.warehouse_from.name}}</td>
                                                <td>{{issue_note.warehouse_to.name}}</td>
                                                <td><i class="fa fa-check"></i> </td>
                                                <td>{{issue_note.approved_by.name}}</td>
                                                <td>{{issue_note.updated_at | moment}}</td>
                                                <td>
                                                    <button v-on:click="show_products(index)">Products</button>
                                                    <a v-bind:href="'./warehouseTransfer/'+issue_note.id"><button>Transfer Stock</button></a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.portlet-content -->
                            </div>
                            <!-- /.portlet -->
                        </div>
                        <!-- /.col -->





                    </div>

                </div>








            </div>

        </div>
        <!-- View Details Modal Start-->
        <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="issue_note_info_modal" aria-labelledby="bs-add-Model-modal-md">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Summary - Issue Notes</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <h5><b>Date:</b> {{created_date | moment}}</h5>
                                <h5><b>From:</b> {{from_warehouse}} <span style="float:right;"><b>To:</b> {{to_warehouse}}</span></h5>

                                <hr/>
                                <h4>Transfer Product Details</h4>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Model</td>
                                        <td>Color</td>
                                        <td>Transfer Qty</td>
                                        <td>Price(PKR)</td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="products in all_products.transfer_products">
                                        <td>{{products.product.name}}</td>
                                        <td>{{products.product_color.color}}</td>
                                        <td style="text-align:right;">{{products.quantity}}</td>
                                        <td style="text-align:right;">{{products.price | currency(' ')}}</td>
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

    </div>

</template>
<script>
    export default {
        data() {
            return {
                currentWarehouseId:'',
                currentWarehouse:'',
                all_requests:[],
                all_products:[],
                from_warehouse:[],
                to_warehouse:[],
                created_date:[]
            }
        },
        watch:{
            currentWarehouseId:function(){
                axios.get('./get_warehouse_requests/'+this.currentWarehouseId).then(response=>{
                    this.all_requests=response.data;
                });
            }
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
        created(){
            axios.get('./currentWarehouse').then(response=>{
                this.currentWarehouse=response.data.name;
                this.currentWarehouseId=response.data.id;
            });


        },
        methods: {
            show_products:function(index){
                //alert(index);
                this.all_products=this.all_requests[index];
                this.from_warehouse=this.all_requests[index].warehouse_from.name;
                this.to_warehouse=this.all_requests[index].warehouse_to.name;
                this.created_date=this.all_requests[index].updated_at;
                $('#issue_note_info_modal').modal('show');
            },


        }
    }
</script>