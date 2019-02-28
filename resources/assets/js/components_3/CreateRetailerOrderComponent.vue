<style>
    .datatable-input{
        
    }
</style>

<template>

<div class="row">
    <div class="col-md-12">
    <!-- <div class="col-md-12">
            <div class="card headcolor">
                <div class="card-header">
                    <h4 class="heading-inline"> Create New Retail Order </h4>
                </div>
            </div>
        <hr/> -->
        <div class="panel panel-info" v-if="is_retailer_select==0">
            <div class="panel-heading">
                <h2 class="panel-title">Select outlet for order</h2>
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
                <tr v-for="project in projects" :key="project.id">
                    


                    <td>{{project.retailer.retailer_no}}</td>
                                <td>{{project.name}}</td>
                                <td>{{project.city.name}}</td>
                                <td :title=project.region.name>{{project.region.name.slice(0, 30)}} ...</td>
                                <td :title=project.address>{{project.address.slice(0, 30)}} ...</td>
                                <td class="text-center"><button class="btn btn-primary btn-sm" v-on:click="create_order_enabled(project.retailer.id, project.id, project.name, project.city.name,project.region.name, project.address, project.retailer.retailer_no)" title="Edit"><i class="fa fa-edit"></i> </button> </td>

                    
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

        





        
        <div class="panel panel-info"  v-if="is_retailer_select==1">
            <div class="panel-heading">


            <div class="col-md-5 paddingmarginzero ">
                New Sale Order
            </div>

            <div class="col-md-6  text-right">

            </div>

            <div class="clearfix"></div>
        </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-2"><label>City<span style="color:red;">*</span></label></div>
                    <div class="col-md-3"><input type="text" v-model="new_order.city" class="textbox" readonly></div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2"><label>Locality<span style="color:red;">*</span></label></div>
                    <div class="col-md-3"><input type="text" v-model="new_order.locality"class="textbox" readonly></div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row">
                    <div class="col-md-2"><label>Address<span style="color:red;">*</span></label></div>
                    <div class="col-md-3"><input type="text" class="textbox" v-model="new_order.address" readonly></div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2"><label>Dealer ID<span style="color:red;">*</span></label></div>
                    <div class="col-md-3"><input type="text" class="textbox" v-model="new_order.dealer_id" readonly></div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row">
                    <div class="col-md-2"><label>Outlet<span style="color:red;">*</span></label></div>
                    <div class="col-md-3"><input type="text" class="textbox" v-model="new_order.retailer_outlet_name" readonly></div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2"><label>Warehouse<span style="color:red;">*</span></label></div>
                    <div class="col-md-3">

                            <select name="select_product" class="textbox_dropdown" v-model="new_order.warehouse_id" @change="get_warehouse_sales_officers()" required>
                                <option v-for="warehouse in warehouses" v-bind:value="warehouse.warehouse.id" selected>{{warehouse.warehouse.name}}</option>
                            </select>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"><label>Sales Officer<span style="color:red;">*</span></label></div>
                    <div class="col-md-3">
                        <select name="select_product" class="textbox_dropdown" v-model="new_order.sales_officer_id" required>
                            <option value="" selected>Sales Officers</option>
                            <option v-for="(officer, index) in sales_officers" v-if="officer.staff!=null" v-bind:value="officer.staff.id">{{officer.staff.name}}</option>
                        </select>

                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-1"></div>
                </div>
                <!--<div class="row" v-for="(find, index) in new_order.products">
                    <hr/>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2"><label>Products<span style="color:red;">*</span></label></div>
                            <div class="col-md-3">
                                <select name="select_product" class="textbox_dropdown" v-model="find.product_id" @change="change_product(index, find.product_id)" required>
                                    <option value="" selected>Select</option>
                                    <option v-for="(product, index) in allProducts.warehouse_stock" v-if="product.product_qty!=0" v-bind:value="product.product_color.product.id">{{product.product_color.product.name}}</option>
                                </select>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2"><label>Color<span style="color:red;">*</span></label></div>
                            <div class="col-md-3">
                                <select class="textbox_dropdown" v-model="new_order.products[index].product_color_id" @change="myfunc(index)" required>
                                    <option value="" selected>Select</option>
                                    <option v-for="(product_color, index) in new_order.products[index].product_color"  v-bind:value="product_color.id">{{product_color.color}}</option>
                                </select>
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-2"><label>Quantity<span style="color:red;">*</span></label></div>
                            <div class="col-md-3">

                                <input type="text" class="textbox" name="total_qty" v-validate="{ max_value: new_order.products[index].actual_qty }" v-model="new_order.products[index].quantity" v-on:input="on_qty_changed"/>
                                <span class="text-danger" v-show="errors.has('total_qty')">
                                  {{errors.first('total_qty')}}
                                </span>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-2"><label>Price(PKR)<span style="color:red;">*</span></label></div>
                            <div class="col-md-3">
                                <input type="text" class="textbox" v-model="new_order.products[index].cost_per_set"/>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" v-if="index>0">
                                <button class="btn btn-danger" v-on:click="removeProductForm(index)"><i class="fa fa-times" title="Delete"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">

                        <div class="col-md-3">
                            <button class="btn btn-primary" v-on:click="add_more_products"><i class="fa fa-plus"></i> Add More Products</button>
                        </div>

                        <!-- <div class="col-md-4 pull-right">
                            <input type="text" v-model="new_order.total_order_price" placeholder='Total Price' class="textbox" />
                        </div> -->

                       <!-- <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-3 pull-right">
                                    <button class="btn btn-primary pull-right" v-on:click="add_order()"><i class="fa fa-check"></i> Create Order</button>
                                </div>
                                <div class="col-md-3 pull-right">
                                    <button class="btn btn-success" v-on:click="hide_order_form()">Select Other Retailer</button>
                                </div>
                            </div>
                        </div> -->
                    <div class="col-md-1"></div>


                </div>
            <table id="warehousestocktable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                <tr>
                    <th class="col-md-1">Select</th>
                    <th>S.No</th>
                    <th>Model</th>
                    <th>Color</th>
                    <th>Stock History</th>
                    <th>In-Stock (Major) Qty</th>
                    <th>Reserved Qty</th>
                    <th>Available Qty</th>
                    <th>Unit Price(PKR)</th>
                    <th>Order Quantity</th>
                </tr>
                </thead>
                <tbody v-for="(stock,index) in stock_products" v-if="stock.instock_qty!=0">
                <tr v-if="stock.isTrue">
                    <td style="background:rgb(51, 151, 156); color:#fff;"><input type="checkbox" v-model="stock.isTrue" @change="change_changebox(index, stock.final_instock_qty)"></td>
                    <td style="background:rgb(51, 151, 156); color:#fff;">{{index + 1}}</td>
                    <td style="background:rgb(51, 151, 156); color:#fff;">{{stock.product_name}}</td>
                    <td style="background:rgb(51, 151, 156); color:#fff;">{{stock.product_color_name}}</td>
                    <td style="background:rgb(51, 151, 156);"><a v-bind:href="'../stock_item_history/'+new_order.warehouse_id+'/'+stock.product_color_id" target="_blank" style="color:#fff;">{{stock.product_name}}, {{stock.product_color_name}}</a></td>
                    <td style="background:rgb(51, 151, 156); color:#fff;">{{stock.instock_qty}}</td>
                    <td style="background:rgb(51, 151, 156); color:#fff;">{{stock.pending_qty}}</td>
                    <td style="background:rgb(51, 151, 156); color:#fff;">{{stock.final_instock_qty}}</td>
                    <td style="background:rgb(51, 151, 156); color:#fff; text-align:right;">{{stock.unit_price | currency('')}}</td>
                    <td style="background:rgb(51, 151, 156);">
                        <input type="text" :name='"order_qty"+index' :placeholder="'Maximum '+stock.final_instock_qty+' Qty'" v-model="stock.order_qty" v-validate="{ max_value: stock.final_instock_qty, min_value:1 }">
                        <span class="text-danger" style="display: block; margin-top:5px; color:red;" v-show="errors.has('order_qty'+index)">Quantity must be {{stock.final_instock_qty}} or less
                        </span>
                    </td>

                </tr>
                <tr v-else>
                    <td><input type="checkbox" v-model="stock.isTrue" @change="change_changebox(index, stock.final_instock_qty)"></td>
                    <td>{{index + 1}}</td>
                    <td>{{stock.product_name}}</td>
                    <td>{{stock.product_color_name}}</td>
                    <td><a v-bind:href="'../stock_item_history/'+new_order.warehouse_id+'/'+stock.product_color_id" target="_blank">{{stock.product_name}}, {{stock.product_color_name}}</a></td>
                    <td>{{stock.instock_qty}}</td>
                    <td>{{stock.pending_qty}}</td>
                    <td>{{stock.final_instock_qty}}</td>
                    <td style="text-align:right;">{{stock.unit_price | currency('')}}</td>
                    <td>
                        <input type="text" :name='"order_qty"+index' :placeholder="'Maximum '+stock.final_instock_qty+' Qty'" v-model="stock.order_qty" v-validate="{ max_value: stock.final_instock_qty, min_value:1 }">
                        <span class="text-danger" style="display: block; margin-top:5px; color:red;" v-show="errors.has('order_qty'+index)">Quantity must be {{stock.final_instock_qty}} or less
                        </span>
                    </td>

                </tr>
                </tbody>
            </table>

            <Br/>
                <button class="btn btn-primary" style="margin-left:10px; margin-top:20px; margin-bottom:20px;" v-on:click="generate_order()">Create Order</button>
            <Br/>

        </div>





    </div>

    <!-- Modal -->
    <div class="modal fade" id="order_modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New Supply Order</h4>
                </div>
                <div class="modal-body">
                    <h5><b>Dealer ID:</b> {{new_order.dealer_id}}</h5>
                    <h5><b>Outlet Name:</b> {{new_order.retailer_outlet_name}}</h5>
                    <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <td>S.no</td>
                            <td>Model</td>
                            <td>Color</td>
                            <td>Quantity</td>
                            <td><span style="float:right;">Unit. Price</span></td>
                            <td><span style="float:right;">Total Price</span></td>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(product, index) in selected_order_products">
                            <td>{{index+1}}</td>
                            <td>{{product.product_name}}</td>
                            <td>{{product.product_color_name}}</td>
                            <td>{{product.order_qty}}</td>
                            <td><span style="float:right;">{{product.unit_price | currency('Rs')}}</span></td>
                            <td><span style="float:right;">{{product.total_price | currency('Rs')}}</span></td>
                        </tr>
                        <tr>
                            <td colspan="6"><span style="float:right; font-weight:bold">{{new_order.total_order_price | currency('Rs')}}</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" v-on:click="add_order()">Submit Order</button>
                </div>
            </div>

        </div>
    </div>
</div>



</template>
<script>
import Vue from 'vue';
    import Datatable from './DatatableComponent.vue';
    import Pagination from './PaginationComponent.vue';
    
    export default {
        components: {datatable: Datatable, pagination: Pagination},
        data(){
            let sortOrders = {};
            let columns = [
                {width: '10%', label: 'Dealer ID', name: 'Dealer ID' },
                {width: '33%', label: 'Outlet Name', name: 'Outlet Name'},
                {width: '10%', label: 'City', name: 'City'},
                {width: '33%', label: 'Locality', name: 'Locality'},
                {width: '33%', label: 'Address', name: 'Address'},
                {width: '10%', label: 'Action', name: 'Action'},
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

                is_retailer_select:0,
                outletsData:[],
                estimation_date:'',
                allProducts:[],
                allRetailers:[],
                retailer_outlets:[],
                warehouses:[],
                sales_officers:[],
                stock_products:[],
                all_staff:[],
                selected_outlet_index:'',
                message:"",
                //total_order_amount:0,
                new_order:{
                    id:'',
                    city:'',
                    locality:'',
                    address:'',
                    dealer_id:'',
                    estimation_date:'',
                    retailer_id:'',
                    retailer_outlet_name:'',
                    retailer_outlet_id:'',
                    retailer_credit_duration:'',
                    sales_officer_id:'',
                    warehouse_id:'',
                    total_order_price:0,
                    products:[],
                       /* {
                            product_id:'',
                            product_color_id:'',
                            product_color:[],
                            quantity:0,
                            actual_qty:0,
                            cost_per_set:0,
                            whole_set_price:0,
                        }*/

                },
                selected_order_products:[]

            }
        },
        mounted() {
            console.log('Component mounted.');

        },
        created:function(){
            this.init();

        },
        watch:{
            estimation_date:function(){
                this.new_order.estimation_date=moment(this.estimation_date).format('YYYY-MM-DD');    
                console.log(this.new_order.estimation_date);
            }
            
        },
        methods:{
            init:function(){
                //this.get_products();
                this.get_all_retailers();
                this.get_staff();
                this.get_warehouse();
                //this.get_all_outlets();
                this.getProjects();

            },
            getProjects(url = '../get_all_outlets_dataTable') {
            this.tableData.draw++;
            axios.get(url, {params: this.tableData})
                .then(response => {
                    let data = response.data;
                    if (this.tableData.draw == data.draw) {
                        this.projects = data.data.data;
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


            get_warehouse:function(){
                axios.get('../warehouse_by_manager').then((response) => {
                    this.warehouses=response.data;
                    //alert(response.data[0].id);
                    this.new_order.warehouse_id=response.data[0].warehouse_id;
                });
            },
            get_warehouse_sales_officers:function(){
                axios.post('../warehouse_salesofficer',this.new_order).then((response) => {
                    this.sales_officers=response.data;
                });



                axios.post('../get_warehouse_products_with_pending',this.new_order).then((product_response) => {
                    this.allProducts=product_response.data[0];
                    //this.allProducts=this.allProducts[0].warehouse_stock;
                    //console.log(this.allProducts);

                    //alert(this.allProducts[0].warehouse_stock);
                    for(var i=0; i<this.allProducts.warehouse_stock.length; i++){
                        this.stock_products.push({
                            'isTrue':false,
                            'product_id':this.allProducts.warehouse_stock[i].product_color.product.id,
                            'product_color_id':this.allProducts.warehouse_stock[i].product_color.id,
                            'product_name':this.allProducts.warehouse_stock[i].product_color.product.name,
                            'product_color_name':this.allProducts.warehouse_stock[i].product_color.color,
                            //'instock_qty':this.allProducts.warehouse_stock[i].product_qty,
                            'instock_qty':this.allProducts.warehouse_stock[i].warehouse_stock_details[0].major,
                            'pending_qty':0,
                            'final_instock_qty':this.allProducts.warehouse_stock[i].warehouse_stock_details[0].major,
                            'unit_price':this.allProducts.warehouse_stock[i].product_color.price,
                            'order_qty':'',
                        });
                    }

                    var pending_order=[];
                    pending_order=product_response.data;

                    for(var j=1; j<pending_order.length; j++){
                        for(var i=0; i<this.stock_products.length; i++){
                            if(pending_order[j].product_color_id==this.stock_products[i].product_color_id){
                                this.stock_products[i].pending_qty=pending_order[j].pending_qty;
                                this.stock_products[i].final_instock_qty-=this.stock_products[i].pending_qty;
                            }
                        }
                    }



                });
            },
            removeProductForm:function(index){
                event.preventDefault();
                this.new_order.products.splice(index,1);

                // Update the total price
                this.update_total_price();
            },
            on_qty_changed:function(){
                // Update the total price
                this.update_total_price();
            },
            change_product:function(index, product_id){
                this.new_order.products[index].product_id=product_id;
                this.new_order.products[index].quantity='';
                this.new_order.products[index].cost_per_set='';
                axios.post('../get_product_colors',this.new_order.products[index]).then((response) => {
                    this.new_order.products[index].product_color=response.data;
                    // alert(response.data);
                });

                // Update the total price
                this.update_total_price();
            },
            get_all_retailers:function(){
                axios.get('../retailer/get_retailers').then((response) => {
                    this.allRetailers= response.data;
                });
            },
            add_more_products:function(e){
                e.preventDefault();
                this.new_order.products.push({product_id:'', product_color:'', quantity:'', cost_per_set:''});
            },
            get_products:function(){
                axios.get('../allProducts').then((response) => {
                    this.allProducts= response.data.data;
                });
            },
            add_order:function(e){
                for(var i=0; i<this.selected_order_products.length; i++){
                    this.new_order.products.push({
                        'product_id':this.selected_order_products[i].product_id,
                        'product_color_id':this.selected_order_products[i].product_color_id,
                        'quantity':this.selected_order_products[i].order_qty,
                        'cost_per_set':this.selected_order_products[i].unit_price,
                    });
                }

                if(this.new_order.products!=''){
                    this.$validator.validateAll();
                    if (!this.errors.any()) {
                        axios.post('../retailer/order/create',this.new_order).then((response) => {
                            if(response.data==201){
                                this.new_order.id='';
                                this.new_order.estimation_date='';
                                this.new_order.products.product_id='';
                                this.new_order.products.product_color_id='';
                                this.new_order.products.quantity='';
                                this.new_order.products.cost_per_set='';
                                this.new_order.retailer_id='';
                                this.new_order.retailer_outlet_id='';
                                this.new_order.sales_officer_id='';
                                this.new_order.retailer_outlet_name='';
                                this.is_retailer_select=0;
                                this.new_order.products.forEach(function(order, index) {
                                    order.product_id="";
                                    order.product_color_id="";
                                    order.quantity="";
                                    order.cost_per_set="";
                                });

                                this.message="Order Created Successfully !";

                                setTimeout(function() {
                                    $('#message_div').fadeOut(2000);
                                }, 1000);
                                $("html, body").animate({
                                    scrollTop: 0
                                }, 600);
                                location.reload();
                            }
                            else{
                                alert(response.data);
                            }
                        });
                       //alert("Succesfully Ordered");

                    }
                }
                else{
                    alert("Products not found!");
                }


            },
            change_retailer:function(){
                axios.post('../outlet/retailer_outlets',this.new_order).then((response) => {
                    this.retailer_outlets=response.data;
                });
            },
            get_staff:function(){

                axios.get('../allStaff').then((response) => {
                    this.all_staff= response.data;
                });

            },
            change_outlet:function(){
                var selected_index=this.selected_outlet_index;
                if(selected_index!=-1){
                    this.new_order.retailer_outlet_id=this.retailer_outlets[selected_index].id;
                    this.new_order.retailer_credit_duration=this.retailer_outlets[selected_index].credit_duration;
                }

            },
            // Calculating total order price
            update_total_price:function(index){
                //console.log('Products length: ' + this.new_order.products.length);
                //this.new_order.total_order_price = 0;
                //for (var i = 0; i < this.new_order.products.length; i++) {
                //    console.log('Set Name: ' + this.new_order.products[i].name + ', Price: ' + this.new_order.products[i].cost_per_set + ', Quantity: ' + this.new_order.products[i].quantity);
                //    this.new_order.products[i].whole_set_price = this.new_order.products[i].cost_per_set * this.new_order.products[i].quantity;
                //    console.log('Single set whole price: ' + this.new_order.products[i].whole_set_price);
                //    this.new_order.total_order_price += this.new_order.products[i].whole_set_price;
                //    console.log('Total Set price: ' + this.new_order.total_order_price);
                //}
            },
            myfunc:function(index){
                //alert(this.new_order.warehouse_id);
                axios.post('../retailer_order/get_orders_with_warehouse_stock',{'warehouse_id':this.new_order.warehouse_id, 'product_color_id':this.new_order.products[index].product_color_id}).then((response)=> {
                    //alert(response.data);
                    this.new_order.products[index].actual_qty= response.data[0].product_qty;
                    this.new_order.products[index].quantity= response.data[0].product_qty;

                });
                //this.new_order.products[index].quantity=this.allProducts.warehouse_stock[index].product_qty;
                axios.get('../getproductColor/'+this.new_order.products[index].product_color_id).then((response) => {
                    this.new_order.products[index].cost_per_set=response.data[0].price;
                });

                // Update the total price
                this.update_total_price();
            },
            get_all_outlets:function(){
                axios.get('../outlet/get_all_outlets').then(response=>{
                    this.outletsData=response.data;
                });
            },
            create_order_enabled:function($retailer_id, $outlet_id, $outletname, $city, $locality, $address, $dealer_id){
                $('#example_wrapper').css('display','none');
                this.new_order.retailer_id=$retailer_id;
                this.new_order.retailer_outlet_id=$outlet_id;
                this.new_order.retailer_outlet_name=$outletname;
                this.new_order.city=$city;
                this.new_order.locality=$locality;
                this.new_order.address=$address;
                this.new_order.dealer_id=$dealer_id;
                this.get_warehouse_sales_officers();
                this.is_retailer_select=1;


            },
            hide_order_form:function(){
                this.is_retailer_select=0;

            },
            change_changebox:function(index, final_qty){
                var current_status=this.stock_products[index].isTrue;

                if(final_qty==0){
                    alert("Quantity is not available in Stock");
                    this.stock_products[index].isTrue=false;
                }

            },
            generate_order:function(){
                this.selected_order_products=[];
                this.$validator.validateAll();
                var is_any_check=0;
                if(this.new_order.sales_officer_id!=''){
                    if (!this.errors.any()){
                        for(var i=0; i<this.stock_products.length; i++){
                            if(this.stock_products[i].isTrue==true){
                                is_any_check=1;
                            }
                        }
                        if(is_any_check==1){
                            for(var i=0; i<this.stock_products.length; i++){
                                if(this.stock_products[i].isTrue==true && this.stock_products[i].order_qty!=''){
                                    this.selected_order_products.push({
                                        'product_id':this.stock_products[i].product_id,
                                        'product_color_id':this.stock_products[i].product_color_id,
                                        'product_name':this.stock_products[i].product_name,
                                        'product_color_name':this.stock_products[i].product_color_name,
                                        'unit_price':this.stock_products[i].unit_price,
                                        'order_qty':this.stock_products[i].order_qty,
                                        'total_price':(this.stock_products[i].order_qty)*(this.stock_products[i].unit_price)
                                    });
                                }
                            }

                            this.new_order.total_order_price=0;
                            for(var j=0; j<this.selected_order_products.length; j++){
                                this.new_order.total_order_price+=this.selected_order_products[j].total_price;

                            }
                            $('#order_modal').modal('show');
                        }
                        else{
                            alert("Please Select any Product!");
                        }
                    }
                }
                else{
                    alert("Please Select Sales Officer");
                }





                //alert(this.selected_order_products);
            }
        }
    }
/*
    $(document).ready(function() {
        
    
    // Setup - add a text input to each footer cell
    $('#retailer_table tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );


    // DataTable
    var table = $('#retailer_table').DataTable();

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
} );*/

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

</style>