<template>
  <div class="row ">
    <div class=" col-md-12 paddingmarginzero">

      <div class="paddingmarginzero">
        <h4 class="heading-inline"> Stock Details</h4>
      </div>

      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
          <a href="#stock_item" aria-controls="stock_item" role="tab" class=" button-info" data-toggle="tab">Warehouse Worth</a>
        </li>
        <li role="presentation">
          <a href="#imei_wise" aria-controls="imei_wise" role="tab" data-toggle="tab">Find IMEI</a>
        </li>
        <!--<li role="presentation">
          <a href="#product_details" aria-controls="product_details" role="tab" data-toggle="tab">Find Product</a>
        </li>-->
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel " class="tab-pane active" id="stock_item">
            <div class="panel panel-info">

              <div class="panel-heading">
                Select Warehouse
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-1">
                    <label>City</label>
                  </div>
                  <div class="col-md-3">
                    <select class="textbox_dropdown" name="city" v-model="select_city_id" @change="change_city" required="">
                      <option value="0">All Cities</option>
                      <option v-for="city in cities" v-bind:value="city.id">{{city.name}}</option>
                    </select>
                  </div>
                  <div class="col-md-1 text-center">
                    <label>Warehouse</label>
                  </div>
                  <div class="col-md-3">
                    <select class="textbox_dropdown" v-model="select_warehouse_id">
                      <option value="0">-Select-</option>
                      <option v-for="(warehouse,index) in allWarehouses"  v-bind:value="warehouse.id">{{warehouse.name}}</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary" @click="search_products">
                      <i class="fa fa-search"></i>  Search
                    </button>
                  </div>

                  <div class="col-md-1"></div>
                </div>


              </div>

            </div>

            <div class="panel panel-info" v-if="search_enabled==1">

              <div class="panel-heading">
                <b>{{selected_warehouse_name}}</b> - Stock List

              </div>

              <div class="panel-body">
                <div class="row">

                  <div class="col-md-12 ">
                    <div class="portlet portlet-table">
                      <div class="portlet-content">
                        <div class="table-responsive">
                          <table class="table table-bordered" width="100%">
                            <thead>
                              <tr>
                                <th class="">SKU</th>
                                <th> Model</th>
                                <th> Color</th>
                                  <th>Major</th>
                                  <th>Mini</th>
                                  <th>Damage</th>
                                  <th> Total Quantity</th>
                                <th> Unit Price(PKR)</th>
                                <th> Net Price(PKR)</th>
                                <th width="200px"> View Details</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="product in product_list">
                                <td>{{product.product_color.sku}}</td>
                                <td>{{product.product_color.product.name}}</td>
                                <td>{{product.product_color.color}}</td>

                                  <td>{{product.warehouse_stock_details[0].major}}</td>
                                  <td>{{product.warehouse_stock_details[0].mini}}</td>
                                  <td>{{product.warehouse_stock_details[0].damage}}</td>
                                  <td style="text-align:right;">{{product.product_qty}}</td>
                                <td style="text-align:right;">{{product.product_color.price  | currency('Rs')}}</td>
                                <td style="text-align:right;">{{product.product_color.price*product.product_qty | currency('Rs')}}</td>
                                <td>
                                  <a v-bind:href="'./stock_item_history/'+product.warehouse.id+'/'+ product.product_color.id" target="_blank">
                                    <i class="fa fa-exchange"></i> View Transaction History
                                  </a>
                                </td>

                              </tr>
                              <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                  <td style="text-align:right;"><b>Total Sets: {{major}}</b></td>
                                  <td style="text-align:right;"><b>Total Sets: {{mini}}</b></td>
                                  <td style="text-align:right;"><b>Total Sets: {{damage}}</b></td>
                                <td style="text-align:right;">
                                  <b>Total Sets: {{total_sets}}</b>
                                </td>
                                <td></td>
                                <td style="text-align:right;">
                                  <b>Worth: {{worth | currency('Rs')}}</b>
                                </td>
                                <td></td>
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
        
        <div role="tabpanel" class="tab-pane" id="imei_wise">
    
            
                    <div class="panel panel-info">
                        <div class="panel-heading">
                     
                                Find IMEI
                          
                        </div>

                        <div class="panel-body">

                                
                                <div class="col-md-4">
                                    <input type="text" class="textbox" v-model="imei" placeholder="Enter IMEI" required="">
                                </div>
                                <div class="col-md-5">
                                    <button class="btn btn-primary" @click="getImeiDetails">Search</button>
                                </div>

                            <!-- <div v-if="itemDetails==''">Imei not Matched</div> -->
                        </div>
                    </div>
         
      
            <div v-if="itemDetails!=''" class="col-md-12 well"  style="margin-top: 20px;" v-cloak>

              <div class="col-md-3">
                  <h3 class="col-md-12 text-center">{{itemDetails.item.product_color.product.name}}</h3>
                  <img v-bind:src="'./product_img/'+itemDetails.item.product_color.product_images[0].image" class=" img-thumbnail" height="auto" />
                  <!-- <h1 class="col-md-12 text-center">{{itemDetails.item.product_color.product.name}}</h1> -->
              </div>
              <div class="col-md-9">
                <table class="table table-borderd table-hover">
                    <thead>
                        <tr>
                            <th><b>Details</b></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-md-4"><b>Model Name:</b> </td>
                            <td>{{itemDetails.item.product_color.product.name}}</td>
                        </tr>
                        <tr>
                            <td><b>Color: </b> </td>
                            <td>{{itemDetails.item.product_color.color}}</td>
                        </tr>
                        <tr>
                            <td><b>Imei 1:</b> </td>
                            <td>{{itemDetails.imei1}}</td>
                        </tr>
                        <tr>
                            <td><b>Imei 2:</b> </td>
                            <td>{{itemDetails.imei2}}</td>
                        </tr>
                        <tr>
                            <td><b>Release Date:</b> </td>
                            <td>{{itemDetails.item.product_color.product.release_date |moment()}}</td>
                        </tr>
                        <tr>
                            <td><b>Discount:</b> </td>
                            <td>{{itemDetails.item.product_color.discount}}%</td>
                        </tr>
                        <tr>
                            <td><b>Price:</b> </td>
                            <td>{{itemDetails.item.product_color.price|currency('Rs')}}</td>
                        </tr>
                        <tr>
                            <td><b>Order No:</b> </td>
                            <td>{{itemDetails.item.receive.order.manufacture_order_no}}</td>
                        </tr>
                        <tr>
                            <td><b>Receiving No:</b> </td>
                            <td>{{itemDetails.item.receive.receive_no}}</td>
                        </tr>
                        <tr>
                            <td><b>Receiving Date:</b> </td>
                            <td>{{itemDetails.item.receive.created_at |moment()}}</td>
                        </tr>



                        <tr>
                            <td><b>Status</b> </td>

                                <td v-if="itemDetails.item.warehouse_issue_item!=null">
                                    <span v-if="itemDetails.item.main_warehouse_receive_item[0].warehouse_id!=null">
                                        {{current_Warehouse}},
                                        <span v-if="itemDetails.item.main_warehouse_receive_item[0].current_stock_status==1" style="color:green;">Major,</span>
                                        <span v-if="itemDetails.item.main_warehouse_receive_item[0].current_stock_status==2" style="color:orange;">Mini,</span>
                                        <span v-if="itemDetails.item.main_warehouse_receive_item[0].current_stock_status==3" style="color:red;">Damage,</span>
                                        <span style="color:red; font-weight:bold;">Sold out</span>
                                    </span>
                                    <span v-else>
                                        Not Received Yet
                                    </span>

                                </td>
                            <td v-else>
                                <span v-if="itemDetails.item.main_warehouse_receive_item[0].warehouse_id!=null">
                                        {{current_Warehouse}},
                                        <span v-if="itemDetails.item.main_warehouse_receive_item[0].current_stock_status==1" style="color:green;">Major,</span>
                                        <span v-if="itemDetails.item.main_warehouse_receive_item[0].current_stock_status==2" style="color:orange;">Mini,</span>
                                        <span v-if="itemDetails.item.main_warehouse_receive_item[0].current_stock_status==3" style="color:red;">Damage,</span>
                                        <span style="color:green; font-weight:bold;">In-stock</span>
                                    </span>
                                    <span v-else>
                                        Not Received Yet
                                    </span>
                                </td>


                        </tr>
                        <tr>
                            <td><b>Sold Date</b> </td>
                            <td v-if="itemDetails.item.warehouse_issue_item!=null">{{itemDetails.item.warehouse_issue_item.created_at |moment()}}</td>
                            <td v-else style="color:green;">-</td>
                        </tr>
                        <tr>
                            <td><b>Activation Date</b></td>
                            <td v-if="itemDetails.item.main_warehouse_receive_item[0].activated_date!=null || itemDetails.item.main_warehouse_receive_item[0].activated_date!=''">{{itemDetails.item.main_warehouse_receive_item[0].activated_date | moment() }}</td>
                            <td v-else>Not Activated</td>
                        </tr>
                      </tbody>
                  </table>
                </div>

                <div class="col-md-12">
                    <h4>Stock Type History</h4>
                    <table class="table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Old Status</th>
                                <th>New Status</th>
                                <th>Warehouse</th>
                                <th>Remarks</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(histo, index) in mhistory">
                                <td>{{index+1}}</td>
                                <td>
                                    <span v-if="histo.old_status==1">Major</span>
                                    <span v-if="histo.old_status==2">Mini</span>
                                    <span v-if="histo.old_status==3">Damage</span>
                                </td>
                                <td>
                                    <span v-if="histo.new_status==1">Major</span>
                                    <span v-if="histo.new_status==2">Mini</span>
                                    <span v-if="histo.new_status==3">Damage</span>
                                </td>
                                <td>{{histo.warehouse.name}}</td>
                                <td>{{histo.remarks}}</td>
                                <td>{{histo.created_date | moment}}</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
        </div>
        </div>
        <div role="tabpanel " class="tab-pane" id="product_details">


          <div class="panel panel-info">
            <div class="panel-heading">
              Select Product
            </div>

            <div class="panel-body">
              <div class="col-md-1">
                <label>Model</label>
              </div>
              <div class="col-md-5">
                <select class="textbox" name="selectProduct" required="" v-model="productId">
                  <option value="">Select Product</option>
                  <option v-for="product in products" v-bind:value="product.id">{{product.name}}</option>
                </select>
              </div>
              <div class="col-md-6">
                <button class="btn btn-primary" @click="getProductDetails">Get Details</button>
              </div>
            </div>
          </div>
          <div v-if="productDetails!=''" class="col-md-12 well"  style="margin-top: 20px;" v-cloak="">

            <div class="col-md-3">
              <h3 class="col-md-12 text-center">{{productDetails.name}}</h3>
              <img v-bind:src="'./category_img/'+productDetails.product_category.image" class=" img-thumbnail" height="auto" />
              <!-- <h1 class="col-md-12 text-center">{{productDetails.name}}</h1> -->
            </div>

            <div class="col-md-9">
              <table class="table table-borderd table-hover">
                <thead>
                  <tr>
                    <th>
                      <b>Details</b>
                    </th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                  <tr>
                    <td class="">
                      <b>Category:</b>
                    </td>
                    <td>{{productDetails.product_category.name}}</td>
                  </tr>
                  <tr>
                    <td>
                      <b>Model Name:</b>
                    </td>
                    <td>{{productDetails.name}}</td>
                  </tr>
                  <tr>
                    <td>
                      <b>Release Date:</b>
                    </td>
                    <td>{{productDetails.release_date|moment()}}</td>
                  </tr>
                  <tr>
                    <th>Color</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th>Price</th>
                    <th>Warehouse</th>
                    <th>Address</th>
                  </tr>
                  <tr>
                    <td>
                      <p v-for="productColor in productDetails.product_color">{{productColor.color}}</p>
                    </td>
                    <td>
                      <p v-for="productColor in productDetails.product_color">
                        <span v-for="quantity in productColor.warehouse_stock">
                          {{quantity.product_qty}} <span style="color:green;">In stock</span><br />
                        </span>
                      </p>
                    </td>
                    <td>
                      <p v-for="productDiscount in productDetails.product_color">{{productDiscount.discount}}% </p>
                    </td>
                    <td>
                      <p v-for="productPrice in productDetails.product_color">{{productPrice.price |currency('Rs')}} </p>
                    </td>
                    <td>
                      <p v-for="productColor in productDetails.product_color">
                        <span v-for="warehousestock in productColor.warehouse_stock">
                          <span>{{warehousestock.warehouse.name}}</span>
                        </span>
                      </p>
                    </td>
                    <td>
                      <p v-for="productColor in productDetails.product_color">
                        <span v-for="warehousestock in productColor.warehouse_stock">
                          <span>{{warehousestock.warehouse.address}}</span>
                        </span>
                      </p>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>

            <!--  <div class="col-md-12">
                   <table class="table table-borderd">
                       <thead>
                           <tr>
                               <th>Category</th>
                               <th>Model</th>
                               <th>Color</th>
                               <th>Release Date</th>
                               <th>Discount</th>
                               <th>Price</th>
                               <th>Quantity</th>
                               <th>Warehouse</th>
                               <th>Address</th>
                           </tr>
                       </thead>
                       <tbody>
                           <tr>
                               <td>{{productDetails.product_category.name}}</td>
                               <td>{{productDetails.name}}</td>
                               <td><p v-for="productColor in productDetails.product_color">{{productColor.color}}</p></td>
                               <td>{{productDetails.release_date|moment()}}</td>
                               <td><p v-for="productDiscount in productDetails.product_color">{{productDiscount.discount}}%, </p></td>
                               <td><p v-for="productPrice in productDetails.product_color">{{productPrice.price}}, </p></td>
                               <td><p v-for="productColor in productDetails.product_color">
                               <span v-for="quantity in productColor.warehouse_stock">{{quantity.product_qty}},</span>
                                </p>
                               </td>
                               <td><p v-for="productColor in productDetails.product_color">
                                       <span v-for="warehousestock in productColor.warehouse_stock">
                                               <span>{{warehousestock.warehouse.name}}</span>
                                       </span>
                                   </p>
                               </td>
                               <td><p v-for="productColor in productDetails.product_color">
                                       <span v-for="warehousestock in productColor.warehouse_stock">
                                               <span>{{warehousestock.warehouse.address}}</span>
                                       </span>
                                   </p>
                               </td>
                           </tr>
                       </tbody>
                   </table>
               
                 
               </div> -->
          </div>



        </div>
      </div>

    </div>
  </div>
</template>

<script>
    import vSelect from "vue-select"
    export default {
        components: {vSelect},
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            }
        },
        data() {
            return{
              // Stock level
                mhistory:[],
                cities:[],
                major:'',
                mini:'',
                damage:'',
                select_city_id:'0',
                select_warehouse_id:'0',
                allWarehouses:[],
                search_enabled:0,
                product_list:[],
                total_sets:0,
                worth:0,
                selected_warehouse_name:'',
                // IMEI level
                imei:'',
                itemDetails:'',
                // Product level
                productId:'',
                products:[],
                productDetails:'',
                current_Warehouse:''
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            axios.get('./generalData').then(response => {
                this.cities = response.data.city;
            });
            axios.get('./allWarehouse').then(response=>{
                this.allWarehouses=response.data;
                console.log(this.allWarehouses);
            });
            axios.get('./allProducts').then(response=>{
                this.products=response.data.data;
                console.log(this.products);
            });
        },
        methods:{
            change_city:function(){
                if(this.select_city_id==0){
                    axios.get('./allWarehouse').then(response=>{
                        this.allWarehouses=response.data;
                        console.log(this.allWarehouses);
                    });
                }
                else{
                    axios.post('./get_warehouse_by_city',{city_id:this.select_city_id}).then(response=>{
                        this.allWarehouses=response.data;
                    });
                }
            },
            search_products:function(){

                if(this.select_warehouse_id!=0){
                    this.worth=0;
                    this.total_sets=0;
                    this.major=0;
                    this.mini=0;
                    this.damage=0;
                    axios.get('./warehouseStockSearch/'+this.select_warehouse_id).then(response=>{
                        this.product_list=response.data;
                        for(var i=0; i<this.product_list.length; i++){
                            this.worth+=this.product_list[i]['product_color']['price']*this.product_list[i]['product_qty'];
                            this.total_sets+=this.product_list[i]['product_qty'];
                            this.major+=this.product_list[i].warehouse_stock_details[0].major;
                            this.mini+=this.product_list[i].warehouse_stock_details[0].mini;
                            this.damage+=this.product_list[i].warehouse_stock_details[0].damage;

                        }

                        this.search_enabled=1;
                    });

                    for(var i=0; i<this.allWarehouses.length; i++){
                        if(this.allWarehouses[i].id==this.select_warehouse_id){
                            this.selected_warehouse_name= this.allWarehouses[i].name;
                        }
                    }
                }
                else{
                    alert("Please select warehouse!");
                }
            },
            // IMEI level
            getImeiDetails(){
                this.itemDetails='';
                if(this.imei==''){
                    alert("Please provide the IMEI");
                }
                else{
                    axios.get('./itemDetails/'+this.imei).then(response=>{
                        if(response.data==404){
                            alert("Invalid Imei");
                            this.itemDetails='';
                        }
                        else{
                            this.itemDetails=response.data;

                            axios.get('./get_all_stock_type_history/'+this.itemDetails.item.id).then(response=>{
                                this.mhistory=response.data;
                            })


                            this.current_Warehouse=response.data.item.main_warehouse_receive_item[response.data.item.main_warehouse_receive_item.length-1].warehouse.name;
                            console.log("Created at: " + this.itemDetails.model.name);
                            if(this.itemDetails.model.name == '' || this.itemDetails.model.name == null){
                                alert("IMEI not found");
                            }
                            console.log(this.itemDetails);
                        }




                    })


                }
            },
            // Product level
            getProductDetails(){
              if(this.productId != null && this.productId != ''){
                axios.get('./productDetails/'+this.productId).then(response=>{
                    this.productDetails=response.data;
                    console.log(response.data);
                })
              } else {
                alert("Please select the product");
              }
            }
        }
    }
</script>

<style>
ul{
    list-style-type: none;
}

[v-cloak] > * { display:none; }
[v-cloak]::before { 
  content: " ";
  display: block;
  width: 16px;
  height: 16px;
  background-image: url('data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==');
}

p {
    padding: 0;
    margin: 0;
}

</style>