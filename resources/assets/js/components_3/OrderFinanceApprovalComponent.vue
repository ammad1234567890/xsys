<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">Finance Orders For Approval</h2>
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
                            <!-- <td>{{order.expected_delivery_date | moment}}</td> -->
                            <!-- <td>{{order.retailer.name}}</td> -->


                            <td style="text-align: right;">{{order.total_cost | currency('')}}</td>
                            <td v-if="order.is_account_clearance==1"><i class="fa fa-check" title="Cleared from Finance" style="text-align:center; display:block; font-size:25px; color:green;"></i> </td>
                            
                            <td v-else><i class="fa fa-rotate-right" style="text-align:center; display:block; font-size:25px; color:red;"></i></td>
                            <td>
                                
                                <!-- <div class="dropdown">
                                    <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown"  v-if="order.is_account_clearance==0">Action
                                        <span class="caret"></span></button>
                                
                                    <ul class="dropdown-menu">
                                        <li><a href="#" v-on:click="edit_order_modal(index)">Edit</a></li>
                                        <li><a href="#" v-on:click="approve_order(index)">Approve</a></li>
                                    </ul>
                                </div> -->
                                    <a href="#" v-on:click="edit_order_modal(index)" class="btn btn-primary btn-xs" title="Edit" v-if="order.is_account_clearance==0 && order.is_delivered==0"><i class="fa fa-edit"></i></a>
                                    <a href="#" v-on:click="approve_order(index)" class="btn btn-info btn-xs" v-if="order.is_account_clearance==0"><i class="fa fa-check" title="Approve order"></i></a>
                                    <button class="btn btn-success btn-xs" type="button" v-on:click="view_order_details(index)" title="View Detail"><i class="fa fa-eye"></i></button>
                                <a class="btn btn-danger btn-xs" v-bind:href="'../retailer/master_details/'+order.retailer_outlet.id" title="Retailer Master Details" target="_blank"><i class="fa fa-info"></i></a>
                                
                                <a class="btn btn-default btn-xs" v-bind:href="'../invoice/create/'+order.id" v-if="order.is_account_clearance==1 && order.is_delivered==0" title="Generate Invoice"><i class="fa fa-file"></i></a>
                               <!-- <a class="btn btn-tumblr btn-xs">Invoice Received</a> -->
                               
                            </td>

                    
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
            <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="order_info_modal" style="z-index:9999;" aria-labelledby="bs-add-Model-modal-md">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Order Details </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5> <span class="pull-right"></span></h5>


                                    <h5><b>{{view_order.order_no}} </b> <span class="pull-right"><b>Date:</b> <i> {{view_order.created_at | moment}}</i> </span></h5>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label><strong>Total Price :</strong></label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{view_order.total_cost | currency('Rs')}}</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Order By :</strong></label>
                                        </div>
                                        
                                        <div class="col-md-3 m-p-0">
                                            <label >{{view_order.created_by}}</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label><strong>Account Clearance :</strong></label>
                                        </div>
                                        <div class="col-md-2">
                                            <label v-if="view_order.is_account_clear"><i class="fa fa-check"  title="Order Cleared!" style="color:green;"></i></label>
                                            <label v-else><i class="fa fa-rotate-right"  title="Order Cancel!" style="color:red;"></i></label>
                                        </div>

                                        <div class="col-md-3">
                                            <label><strong>Credit Limit :</strong></label>
                                        </div>
                                        <div class="col-md-3 m-p-0">
                                            <label>{{view_order.credit_limit | currency('Rs')}}</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Aging Amount :</strong></label>
                                        </div>
                                        <div class="col-md-3 m-p-0">
                                            <label>{{view_order.aging_amount | currency('Rs')}}</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label><strong>Sales Officer :</strong></label>
                                        </div>
                                        <div class="col-md-3 m-p-0" >
                                            <label>{{view_order.sales_officer_name}}</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6" v-if="view_order.is_forcely_approved==1">
                                            <span class="label label-danger" v-if="view_order.is_forcely_approved==1">Approved</span>
                                        </div>
                                        <div v-if="view_order.reason!=null">
                                            <div class="col-md-3">
                                                <label><strong>Reason :</strong></label>
                                            </div>
                                            <div class="col-md-3 m-p-0" >
                                                <label>{{view_order.reason}}</label>
                                            </div>
                                        </div>

                                    </div>


                                    <!-- <table width="100%" class="table table-hovered">
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
                                    
                                    
                                    </table> -->
                                    <hr/>
                                    <h4>Product Details</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td>Category</td>
                                            <td>Model</td>
                                            <td>Color</td>
                                            <td>Quantity</td>
                                            <td>Unit Price(PKR)</td>
                                            <td>Net Price(PKR)</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="products in view_order.order_products">
                                            <td>{{products.product_category}}</td>
                                            <td>{{products.product_color}}</td>
                                            <td>{{products.product_name}}</td>
                                            <td style="text-align:right;">{{products.product_qty}}</td>
                                            <td style="text-align:right;">{{products.unit_price  | currency(' ')}}</td>
                                            <td style="text-align:right;">{{products.unit_price * products.product_qty | currency(' ')}}</td>
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
            <div class="modal fade bs-add-Model-modal-lg" tabindex="5" role="dialog"  id="order_edit_modal" aria-labelledby="bs-add-Model-modal-md">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Order {{view_order.order_no}}</h4>
                         
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="row" v-for="(products, index) in view_order.order_products">
                                                <div class="col-md-12">
                                                    <div class="form-group col-md-3 is-empty">
                                                    <label for="Product">Model</label>
                                                    <input type="text" class="textbox" v-model="products.product_name" readonly/>
                                                </div>
                                                <div class="form-group col-md-2 is-empty">
                                                    <label for="ProductColor">Color</label>
                                                    <input type="text" class="textbox" v-model="products.product_color" readonly/>
                                                </div>
                                                <div class="form-group col-md-3 is-empty">
                                                    <label for="Quantity">Quantity</label>
                                                    <input type="text" :name="'quantity'+index" class="textbox" v-validate="{max_value: products.product_qty, min_value:1}" v-model="products.m_quantity" style="text-align:right;"/>
                                                    <span class="text-danger" v-show="errors.has('quantity'+index)">
                                                        Quantity must be less than {{products.product_qty}}
                                                    </span>
                                                </div>
                                                <div class="form-group col-md-2 is-empty">
                                                    <label for="Price">Unit Price(PKR)</label>
                                                    <vue-numeric currency="" class="textbox" separator="," v-model="products.unit_price" readonly style="text-align:right;"> </vue-numeric>
                                                </div>
                                                <div class="form-group col-md-1 is-empty " style="margin-top: 35px;">
                                                    <button class="btn btn-danger btn-sm pull-right" v-on:click="remove_product(index)" title="Delete"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            

                                                </div>
                                            <div class="col-md-12">
                                                    <button class="btn btn-tumblr" v-on:click="save_products()">Submit</button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- EDIT ORDER MODAL END -->

            <!-- Approval Modal -->
            <div id="approval_modal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Order Approval </h4>
                        </div>
                        <form @submit.prevent="approve_order_btn_action">
                        <div class="modal-body">
                            Order No: <b>{{approve_order_var.order_no}}</b>
                            <p v-if="approve_order_var.total_cost > approve_order_var.credit_limit" style="color:red; font-weight:bold;">Order Amount Exceeded from Credit limit ! Are you sure to approve this Order. <button class="btn btn-link" style="padding:0px;" v-on:click="view_order_details(approve_order_var.index_no)">View Details</button></p>

                                <textarea class="textbox" v-model="approve_order_var.remarks" placeholder="Reason (Mandatory)" rows="5" v-if="approve_order_var.total_cost > approve_order_var.credit_limit" required>

                            </textarea>
                                <textarea class="textbox" v-model="approve_order_var.remarks" placeholder="Reason (OPTIONAL)" rows="5" v-else>

                            </textarea>


                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" v-if="approve_order_var.total_cost > approve_order_var.credit_limit">
                                Approve
                            </button>
                            <button type="submit" class="btn btn-primary" v-else>
                                Approve
                            </button>

                        </div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- Approval Modal -->
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
                {width: '15%', label: 'Price(PKR)', name: 'Price(PKR)'},
                {width: '10%', label: 'Clearance', name: 'Clearance'},
                {width: '33%', label: 'Action', name: 'Action'},
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


                currentWarehouseId:0,
                m_quantity:'',
                message:'',
                all_orders:[],
                approve_order_var:{
                    id:'',
                    order_no:'',
                    credit_limit:'',
                    total_cost:'',
                    index_no:'',
                    remarks:'',
                },
                view_order:{
                    orderno:'',
                    order_no:'',
                    credit_limit:'',
                    eta:'',
                    remaining_payment:'',
                    total_cost:'',
                    is_account_clear:'',
                    is_forcely_approved:'',
                    total_qty:'',
                    retailer_name:'',
                    sales_officer_name:'',
                    outlet_name:'',
                    is_approved:'',
                    created_by:'',
                    created_at:'',
                    reason:'',
                    order_products:[],
                    order_payments:[],
                    current_status:[],
                    remove_product_ids:[],
                    sales_officer_name:'',
                    aging_amount:''
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
                        console.log(this.all_orders);
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
                axios.get('../get_ageing_amount/'+this.all_orders[index].retailer_outlet.id).then((response)=> {
                    //alert(response.data.aging);
                    this.view_order.aging_amount=response.data.aging;
                });

                this.view_order.order_products=[];
                this.view_order.orderno=this.all_orders[index].id;
                this.view_order.eta=this.all_orders[index].expected_delivery_date;
                this.view_order.remaining_payment=this.all_orders[index].remaining_payment;
                this.view_order.total_cost=this.all_orders[index].total_cost;
                this.view_order.is_account_clear=this.all_orders[index].is_account_clearance;
                this.view_order.is_approved=this.all_orders[index].is_approved;

                this.view_order.retailer_name=this.all_orders[index].retailer.name;
                this.view_order.sales_officer_name=this.all_orders[index].retailer.name;
                this.view_order.outlet_name=this.all_orders[index].retailer_outlet.name;

                this.view_order.created_by=this.all_orders[index].user.name;
                this.view_order.created_at=this.all_orders[index].created_at;
                this.view_order.credit_limit=this.all_orders[index].retailer_outlet.credit_limit;
                this.view_order.order_no=this.all_orders[index].order_no;
                this.view_order.is_forcely_approved=this.all_orders[index].is_forcefully_approve;
                this.view_order.reason=this.all_orders[index].clearance_remarks;
                this.view_order.sales_officer_name=this.all_orders[index].sales_officer.name;

                //this.view_order.order_products=this.all_orders[index].order_products;
                for(var i=0; i<this.all_orders[index].order_products.length; i++){
                    this.view_order.order_products.push(
                        {
                            'product_category':this.all_orders[index].order_products[i].product_color.product.product_category.name,
                            'product_name':this.all_orders[index].order_products[i].product_color.product.name,
                            'product_color':this.all_orders[index].order_products[i].product_color.color,
                            'product_qty':this.all_orders[index].order_products[i].product_qty,
                            'unit_price': this.all_orders[index].order_products[i].unit_price,
                            'm_quantity': this.all_orders[index].order_products[i].product_qty,
                        });
                }

            },
            approve_order:function(index){
                this.approve_order_var.index_no=index;
                this.approve_order_var.id=this.all_orders[index].id;
                this.approve_order_var.order_no=this.all_orders[index].order_no;
                this.approve_order_var.credit_limit=this.all_orders[index].retailer_outlet.credit_limit;
                this.approve_order_var.total_cost=this.all_orders[index].total_cost;
                $('#approval_modal').modal('show');

            },

            approve_order_btn_action:function(){
                //var result=confirm("Are you sure for approving the order?");
                //if(result){
                    axios.post('../finance/approve_order',this.approve_order_var).then((response)=>{
                        if(response.data==201){
                            this.message="Order has been Approved!";
                           // this.get_all_orders(this.currentWarehouseId);
                           this.getProjects();
                            this.approve_order_var.remarks="";
                            $('#approval_modal').modal('hide');
                        }
                        else{
                            alert(response.data);
                        }
                    });
               // }
            },
            edit_order_modal:function(index){
                this.view_order.order_products=[];
                $('#order_edit_modal').modal('show');

                this.view_order.order_no=this.all_orders[index].order_no;
                this.view_order.orderno=this.all_orders[index].id;
                this.view_order.eta=this.all_orders[index].expected_delivery_date;
                this.view_order.retailer_name=this.all_orders[index].retailer.name;
                this.view_order.sales_officer_name=this.all_orders[index].retailer.name;
                this.view_order.outlet_name=this.all_orders[index].retailer_outlet.name;

                for(var i=0; i<this.all_orders[index].order_products.length; i++){
                    console.log(this.all_orders[index].order_products);
                    this.view_order.order_products.push(
                        {
                            'id': this.all_orders[index].order_products[i].id,
                            'product_category':this.all_orders[index].order_products[i].product_color.product.product_category.name,
                            'product_name':this.all_orders[index].order_products[i].product_color.product.name,
                            'product_color':this.all_orders[index].order_products[i].product_color.color,
                            'product_qty':this.all_orders[index].order_products[i].product_qty,
                            'unit_price': this.all_orders[index].order_products[i].unit_price,
                            'm_quantity': this.all_orders[index].order_products[i].product_qty,
                        });
                }
                
            },
            save_products:function(){
                axios.post('../retailer_order/edit_products',this.view_order).then((response)=>{
                    if(response.data==201){
                        $('#order_edit_modal').modal('hide');
                        this.message="Order has been updated!";
                        //this.get_all_orders();
                        this.getProjects();
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
                "order": [[ 1,"desc" ]],
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

<style>
    .m-p-0{
        margin: 0px;
        padding: 0px;
    }
</style>