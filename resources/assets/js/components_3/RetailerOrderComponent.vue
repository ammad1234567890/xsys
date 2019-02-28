<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">All Sales Orders List</h2>
            </div>



            <!-- RETAILER SHOW GRID -->
            <div class="panel-body">

                    <div class="alert alert-success" id="message_div" v-if="message">
                        <strong>{{message}}</strong>
                    </div>

                    <div class="projects">
        <div class="tableFilters">
            
           <div class="row">
            <div class="col-md-8">
                <div class="control">
                    <div class="select">
                        <Label>Records:</Label>
                        <select v-model="tableData.length" @change="getProjects()">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                 
                    <input class="textbox" type="text" v-model="tableData.search" placeholder="Search..."
                   @input="getProjects()">
            </div>
            </div>
        </div>
        <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
            <tbody>
                <tr v-for="(order, index) in all_orders" :key="order.id">
                    


                   <td>{{order.created_at | moment}}</td>
                                <td>{{order.order_no}}</td>
                                <td>{{order.retailer_outlet.name}}</td>
                                <td>{{order.retailer_outlet.city.name}}</td>
                                <td style="text-align:right;">{{order.total_cost | currency(' ')}}</td>
                                <td class="text-center col-md-1">
                                    <div class="dropdown">

                                        <button class="btn btn-success btn-xs" type="button" v-on:click="view_order_details(index)" title="View Detail"><i class="fa fa-eye"></i></button>

                                        <a class="btn btn-primary btn-xs" v-bind:href="'../invoice/create/'+order.id" v-if="order.is_account_clearance==1" title="Generate invoice"><i class="fa fa-file"></i></a>
                                        <!-- <button class="btn btn-danger btn-xs" type="button" v-if="order.is_account_clearance==0" v-on:click="order_delete(index)">Delete </button> -->
                                    </div>
                                </td>

                                <td v-if="order.is_account_clearance==1" class="col-md-1"><i class="fa fa-check" title="Cleared from Finance" style="text-align:center; display:block; font-size:25px; color:green;"></i> </td>
                                <td v-else><i class="fa fa-times" style="text-align:center; display:block; font-size:25px; color:red;"></i></td>

                    
                </tr>
            </tbody>
        </datatable>
        <pagination :pagination="pagination"
                    @prev="getProjects(pagination.prevPageUrl)"
                    @next="getProjects(pagination.nextPageUrl)">
        </pagination>
    </div>

            </div>
        </div>





            

            <!-- View Details Modal Start-->
            <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="order_info_modal" aria-labelledby="bs-add-Model-modal-md">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Summary</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5> <span class="pull-right"></span></h5>


                                    <h5><b>{{view_order.order_no}}</b> <span class="pull-right"><b>Date:</b> <i> {{view_order.created_at | moment}}</i> </span></h5>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label><strong>Total Price :</strong></label>
                                        </div>
                                        <div class="col-md-3 m-p-0">
                                            <label>{{view_order.total_cost | currency('Rs')}} </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Sales Officer :</strong></label>
                                        </div>
                                        <div class="col-md-3 m-p-0">
                                            <label>{{view_order.sales_officer_name}}</label>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label><strong>Clearance :</strong></label>
                                        </div>
                                        <div class="col-md-3 m-p-0">
                                            <label v-if="view_order.is_account_clear"><i class="fa fa-check"  title="Order Cleared!" style="color:green;"></i></label>
                                            <label v-else> <i class="fa fa-times"  title="Order Cancel!" style="color:red;"></i></label>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Order Cleared By :</strong></label>
                                        </div>
                                        <div class="col-md-3 m-p-0">
                                            <label>{{view_order.updated_by}}</label>
                                        </div>
                                    </div>
                                   <!--  <table class="table table-hovered">
                                       <tr>
                                           <td style="width: 170px;">Total Cost :</td>
                                           <td>{{view_order.total_cost | currency('Rs')}} </td>
                                       </tr>
                                       <tr>
                                           <td style="width: 170px;">Sales Officer/Manager :</td>
                                           <td>{{view_order.sales_officer_name}}</td>
                                       </tr>
                                       <tr>
                                           <td style="width: 170px;">Account Clearance :</td>
                                           <td v-if="view_order.is_account_clear"><i class="fa fa-check"  title="Order Cleared!"></i></td>
                                           <td v-else><i class="fa fa-times"  title="Order Cleared!"></i> </td>
                                       </tr>
                                       <tr v-if="view_order.is_account_clear">
                                           <td style="width: 170px;">Order Cleared By :</td>
                                           <td>{{view_order.updated_by}}</td>
                                       </tr>
                                   
                                   
                                   </table> -->
                                    <hr/>
                                    <h4>Products</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td>Category</td>
                                            <td>Model</td>
                                            <td>Color</td>
                                            <td>Quantity</td>
                                            <td>Unit Price(PKR)</td>
                                            <td>Discount</td>
                                            <td>Net Price(PKR)</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="products in view_order.order_products">
                                            <td>{{products.product_color.product.product_category.name}}</td>
                                            <td>{{products.product_color.product.name}}</td>
                                            <td>{{products.product_color.color}}</td>
                                            <td style="text-align:right;">{{products.product_qty}}</td>
                                            <td style="text-align:right;">{{products.unit_price | currency('')}}</td>
                                            <td style="text-align:right;">{{products.product_color.discount}}%</td>
                                            <td style="text-align:right;">{{(products.product_qty*products.unit_price)-((products.product_qty*products.unit_price)/100)*(products.product_color.discount) | currency('')}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-github" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- View Details Modal END -->



        </div>
    </div>

</template>
<script>
import {constant} from '../constant.js';
    import Vue from 'vue';
    import Datatable from './DatatableComponent.vue';
    import Pagination from './PaginationComponent.vue';
    export default {
        components: {datatable: Datatable, pagination: Pagination},
        data(){
            let sortOrders = {};
            let columns = [
                {width: '10%', label: 'Date', name: 'Date' },
                {width: '10%', label: 'Order No', name: 'Order No'},
                {width: '33%', label: 'Outlet', name: 'Outlet'},
                {width: '15%', label: 'City', name: 'City'},
                {width: '10%', label: 'Price(PKR)', name: 'Price(PKR)'},
                {width: '33%', label: 'Action', name: 'Action'},
                {width: '10%', label: 'Clearance', name: 'Clearance'},
            ];
            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });
            return{
                projects:[],
            columns: columns,
            sortKey: 'Dealer ID',
            sortOrders: sortOrders,
            tableData: {
                draw: 0,
                length: 10,
                search: '',
                column: 0,
                dir: 'desc',
            },
            pagination: {
                lastPage: '',
                currentPage: '',
                total: '',
                lastPageUrl: '',
                nextPageUrl: '',
                prevPageUrl: '',
                from: '',
                to: ''
            },

                message:'',
                all_orders:[],
                view_order:{
                    orderno:'',
                    order_no:'',
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
                axios.get(constant.base_url+'currentWarehouse').then(response=>{
                    this.currentWarehouse=response.data.name;
                    this.currentWarehouseId=response.data.id;

                    //this.get_all_orders(this.currentWarehouseId);
                    this.getProjects();
                });
                
            },
            getProjects(url = '../get_all_orders_warehouse_datatable/'+this.currentWarehouseId) {
            this.tableData.draw++;
            axios.get(url, {params: this.tableData})
                .then(response => {
                    let data = response.data;
                    if (this.tableData.draw == data.draw) {
                        this.all_orders = data.data.data;
                        console.log(this.projects);
                        this.configPagination(data.data);
                    }
                })
                .catch(errors => {
                    console.log(errors);
                });
        },
        configPagination(data) {
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
        },
        sortBy(key) {
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            this.tableData.column = this.getIndex(this.columns, 'name', key);
            this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
            this.getProjects();
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value)
        },

            get_all_orders:function(warehouse_id){
                axios.get('../retailer_order/get_warehouse_orders/'+warehouse_id).then((response)=>{
                    this.all_orders=response.data;
                });
            },
            change_status_btn:function(index){
                $('#change_status_modal').modal('show');
                this.change_order_status.id=this.all_orders[index].id;
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
                this.view_order.created_at=this.all_orders[index].created_at;
                this.view_order.order_no=this.all_orders[index].order_no;
                this.view_order.sales_officer_name=this.all_orders[index].sales_officer.name;
                this.view_order.outlet_name=this.all_orders[index].retailer_outlet.name;
                this.view_order.order_products=this.all_orders[index].order_products;
                this.view_order.created_by=this.all_orders[index].user.name;
                this.view_order.updated_by=this.all_orders[index].updated_user.name;
                this.view_order.created_at=this.all_orders[index].created_at;


                //alert(this.all_orders[index].created_at);


            },


        }
    }
/*$(document).ready(function() {
    setTimeout(function () {
        $('#retailer_order_table').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });
    }, 2000);
});*/

$(document).ready(function() {
    // Setup - add a text input to each footer cell
   setTimeout(function(){ mydatatable(); }, 3000);
} );

function mydatatable(){
     $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
}
</script>

<style>
 tfoot {
    display: table-header-group;
}
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

    .m-p-0{
    margin: 0px;
    padding: 0px;
    }

</style>