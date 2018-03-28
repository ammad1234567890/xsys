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
                <h2 class="panel-title">Select Retailer for Order</h2>
            </div>



            <!-- RETAILER SHOW GRID -->
            <div class="panel-body">
                <div class="alert alert-success"  v-if="message">
                    <strong>{{message}}</strong>
                </div>
                    <!-- <table id="example" class="table display table-bordered " width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>City</th>
                            <th>Locality</th>
                            <th>Address</th>
                            <th>Outlet Name</th>
                            <th>Dealer ID</th>
                            <th class="col-md-3">Action</th>
                        </tr>
                        </thead>
                        
                        <tbody>
                    
                        <tr v-for="(outlets,index) in outletsData">
                    
                            <td>{{outlets.city.name}}</td>
                            <td>{{outlets.region.name}}</td>
                            <td>{{outlets.address}}</td>
                            <td>{{outlets.name}}</td>
                            <td>{{outlets.retailer.retailer_no}}</td>
                            <td><button class="btn btn-primary btn-sm" v-on:click="create_order_enabled(outlets.retailer.id, outlets.id, outlets.name, outlets.city.name,outlets.region.name, outlets.address, outlets.retailer.retailer_no)">Create Order</button> </td>
                        </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>City</th>
                                <th>Locality</th>
                                <th>Address</th>
                                <th>Outlet Name</th>
                                <th>Dealer ID</th>
                            </tr>
                        </tfoot>
                    </table> -->
                    <table id="example" class="display table-bordered" style="width:100%">
                        <thead>
                           <tr>
                             <th>City</th>
                            <th>Locality</th>
                            <th>Address</th>
                            <th>Outlet Name</th>
                            <th>Dealer ID</th>
                            <th class="col-md-1">Action</th>
                        </tr>
                        </thead>
                        
                        <tbody>
                            <tr v-for="(outlets,index) in outletsData">
                                <td>{{outlets.city.name}}</td>
                                <td>{{outlets.region.name}}</td>
                                <td>{{outlets.address}}</td>
                                <td>{{outlets.name}}</td>
                                <td>{{outlets.retailer.retailer_no}}</td>
                                <td class="text-center"><button class="btn btn-primary btn-sm" v-on:click="create_order_enabled(outlets.retailer.id, outlets.id, outlets.name, outlets.city.name,outlets.region.name, outlets.address, outlets.retailer.retailer_no)" title="Edit"><i class="fa fa-edit"></i> </button> </td>
                            </tr>
            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>City</th>
                                <th>Locality</th>
                                <th>Address</th>
                                <th>Outlet Name</th>
                                <th>Dealer ID</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
            </div>
        </div>
        <div class="panel panel-info"  v-if="is_retailer_select==1">
            <div class="panel-heading">


            <div class="col-md-5 paddingmarginzero ">
                Create Supply Order
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
                    <div class="col-md-2"><label>Warehouses<span style="color:red;">*</span></label></div>
                    <div class="col-md-3">

                            <select name="select_product" class="textbox_dropdown" v-model="new_order.warehouse_id" @change="get_warehouse_sales_officers()" required>
                                <option value="" selected>Select Warehouse</option>
                                <option v-for="warehouse in warehouses" v-bind:value="warehouse.warehouse.id">{{warehouse.warehouse.name}}</option>
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
                    <div class="col-md-3"><label> </label></div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row" v-for="(find, index) in new_order.products">
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
                            <div class="col-md-2"><label>Colors<span style="color:red;">*</span></label></div>
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

                                <input type="text" class="textbox" v-model="new_order.products[index].quantity"/>
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

                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-3 pull-right">
                                    <button class="btn btn-primary pull-right" v-on:click="add_order()"><i class="fa fa-check"></i> Create Order</button>
                                </div>
                                <div class="col-md-3 pull-right">
                                    <button class="btn btn-success" v-on:click="hide_order_form()">Select Other Retailer</button>
                                </div>
                            </div>
                        </div>
                    <div class="col-md-1"></div>


                </div>



            </div>

        </div>





    </div>
</div>



</template>
<script>

    import Vue from 'vue';
    export default {

        data(){
            return{
                is_retailer_select:0,
                outletsData:[],
                estimation_date:'',
                allProducts:[],
                allRetailers:[],
                retailer_outlets:[],
                warehouses:[],
                sales_officers:[],
                all_staff:[],
                selected_outlet_index:'',
                message:"",
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
                    products:[
                        {
                            product_id:'',
                            product_color_id:'',
                            product_color:[],
                            quantity:'',
                            cost_per_set:''
                        }
                    ],
                },

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
                this.get_all_outlets();
            },
            get_warehouse:function(){
                axios.get('../warehouse_by_manager').then((response) => {
                    this.warehouses=response.data;
                });
            },
            get_warehouse_sales_officers:function(){
                axios.post('../warehouse_salesofficer',this.new_order).then((response) => {
                    this.sales_officers=response.data;
                });

                axios.post('../warehouse_products',this.new_order).then((product_response) => {
                    this.allProducts=product_response.data[0];
                    //this.allProducts=this.allProducts[0].warehouse_stock;
                    console.log(this.allProducts);
                });
            },
            removeProductForm:function(index){
                event.preventDefault();
                this.new_order.products.splice(index,1);
            },
            change_product:function(index, product_id){
                this.new_order.products[index].product_id=product_id;
                axios.post('../get_product_colors',this.new_order.products[index]).then((response) => {
                    this.new_order.products[index].product_color=response.data;
                    // alert(response.data);
                });

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
                            this.message="Order Created Successfully";
                            $("html, body").animate({
                                scrollTop: 0
                            }, 600);
                        }
                        else{
                            alert(response.data);
                        }
                    });

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
            myfunc:function(index){
                //alert(this.new_order.products[index].product_color_id);
                //this.new_order.products[index].product_color_id=
                axios.get('../getproductColor/'+this.new_order.products[index].product_color_id).then((response) => {
                    this.new_order.products[index].cost_per_set=response.data[0].price;
                });
                //this.new_order.products[index].quantity=this.allProducts.warehouse_stock[index].product_qty;

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
                this.is_retailer_select=1;


            },
            hide_order_form:function(){
                this.is_retailer_select=0;

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