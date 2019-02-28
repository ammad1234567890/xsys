<template>


    <div class="row">
        <div class=" col-md-12 paddingmarginzero">


<div class="paddingmarginzero">
        <h4 class="heading-inline">Transfer Request</h4>
      </div>
           
           <div class="panel panel-info">
               <div class="panel-heading">


    <div class="col-md-5 paddingmarginzero ">
        New Transfer Request

        </div>
  
        <div class="col-md-6  text-right">

        </div>  &nbsp;


                               </div> 
    <div class="panel-body"> 
        
        <div class="row">
        <div class="col-md-2"><label> From</label></div>
        <div class="col-md-3">
            
        <select class="textbox_dropdown" v-model="from_warehouse" id="select_from">
            <option value="0">-Select Warehouse-</option>
         <option v-for="warehouse in warehouses" v-if="warehouse.id!=to_warehouse" v-bind:value="warehouse.id">{{warehouse.name}}</option>
        </select>

        </div>
        <div class="col-md-2 text-center"><label>To </label></div>
        <div class="col-md-3">
            
            <select class="textbox_dropdown" v-model="to_warehouse" id="select_to" disabled>
         <option value="0">-Select Warehouse-</option>
                <option v-for="warehouse in warehouses" v-if="warehouse.id!=from_warehouse" v-bind:value="warehouse.id" >{{warehouse.name}}</option>
        </select>

        </div>
        <div class="col-md-2">
            <button v-on:click="search_products" id="search_stock_btn">View Stock</button>
        </div>
        </div>
       

        </div>


 
    </div>

            <div class="panel panel-info" v-if="search_enabled==1">

                <div class="panel-heading">
                    Inventory

                </div>

                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-12 ">
                            <div class="portlet portlet-table">
                                <div class="portlet-content">
                                    <div class="table-responsive">
                                        <table id="warehousestocktable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th class="col-md-1">Select</th>
                                                <th>S.No</th>
                                                <th>Model</th>
                                                <th>Color</th>
                                                <th>Stock Quantity</th>
                                                <th>Unit Price(PKR)</th>
                                                <th>Total Price(PKR)</th>
                                                <th>Transfer Quantity</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(stock,index) in product_list" v-if="stock.productQuantity!=0">
                                                <td><input type="checkbox" v-model="stock.isTrue" name=""></td>
                                                <td>{{index + 1}}</td>
                                                <td>{{stock.productColor.product.name}}</td>
                                                <td>{{stock.productColor.color}}</td>
                                                <td style="text-align:right;">{{stock.productQuantity}}</td>
                                                <td style="text-align:right;">{{stock.productPrice | currency('Rs')}}</td>
                                                <td style="text-align:right;">{{(stock.productPrice*stock.productQuantity) | currency('Rs')}}</td>
                                                <td style="text-align:right; ">
                                                    <input type="number" v-model="stock.transferQty" name="Transfer Quantity" min="0" v-validate="{ max_value: stock.productQuantity }" v-bind:max="stock.productQuantity">
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
                            <p>
                                <span class="text-danger" v-show="errors.has('Transfer Quantity')">
                                  {{errors.first('Transfer Quantity')}}
                                </span>
                            </p>
                                <button v-on:click="create_issue_note" class="btn btn-primary">Create Transfer Invoice</button>


                                <button v-on:click="search_disabled" class="pull-right btn btn-danger">Cancel</button>
                        </div>
                        <!-- /.col -->





                    </div>

                </div>








            </div>

</div>


        </div>

</template>
<script>
    export default {
        data() {
            return {
                currentWarehouse:'',
                warehouses:[],
                to_warehouse:0,
                from_warehouse:0,
                product_list:[],
                search_enabled:0,

            }
        },
        mounted() {
            console.log('Component mounted.44')
        },
        created() {
            axios.get('./allWarehouse').then(response=>{
                this.warehouses=response.data;
            });


            axios.get('./currentWarehouse').then(response=>{
                this.currentWarehouse=response.data.name;
                this.to_warehouse=response.data.id;
            });
        },
        methods: {
            search_products:function(){
                this.product_list=[];
                axios.get('./warehouseStockSearch/'+this.from_warehouse).then(response=>{
                    for(var i=0;i<response.data.length;i++){
                        this.product_list.push({
                            isTrue:false,
                            warehouseId:response.data[i].warehouse_id,
                            productColor:response.data[i].product_color,
                            productName:response.data[i].product_color.product.name,
                            productColorName:response.data[i].product_color.color,
                            productColorId:response.data[i].product_color_id,
                            productQuantity:response.data[i].product_qty,
                            productPrice:response.data[i].product_color.price,
                            transferQty:0,
                            productId:response.data[i].product_color.product.id});
                    }
                    //this.product_list=response.data;
                    this.search_enabled=1;
                    document.getElementById("search_stock_btn").disabled = true;
                    document.getElementById("select_from").disabled = true;
                    document.getElementById("select_to").disabled = true;
                });




            },
            search_disabled:function(){
                this.search_enabled=0;
                document.getElementById("search_stock_btn").disabled = false;
                document.getElementById("select_from").disabled = false;
                //document.getElementById("select_to").disabled = false;
            },
            create_issue_note:function(){
                this.$validator.validateAll();
                if (!this.errors.any()) {
                    var quantity_not_valid=0;
                    var product_selected=0;
                    for(var i=0; i<this.product_list.length; i++){
                        if(this.product_list[i].isTrue==true){
                            product_selected=1;
                            if(this.product_list[i].transferQty==0){
                                quantity_not_valid=1;
                            }
                        }
                    }
                    if(product_selected==0){
                        alert("Please Select any Product");
                    }
                    if(quantity_not_valid==1){
                        alert("Transfer quantity must not be zero on checked products");
                    }
                    if(product_selected==1 && quantity_not_valid==0){
                        var confirm_Result=confirm("Create issue note for the selected products?");
                        if(confirm_Result){
                            axios.post('./create_issue_note',{'from':this.from_warehouse,'to':this.to_warehouse,'product_list':this.product_list}).then(response=>{
                                //console.log(response.data);
                                if(response.data==201){
                                    alert("Issue Note has been Created");
                                    window.location.reload();
                                }
                                else{
                                    alert(response.data);
                                }
                            });
                        }
                    }
                }
                else{
                    alert("Invalid Transfer Quantity Found!");
                }


            }

        }

    }
</script>