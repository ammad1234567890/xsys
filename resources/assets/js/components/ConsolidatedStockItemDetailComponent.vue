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
          <li role="presentation">
              <a href="#imei_details" aria-controls="imei_wise" role="tab" data-toggle="tab">IN-STOCK Items</a>
          </li>
          <li role="presentation">
              <a href="#sold_item" aria-controls="imei_wise" role="tab" data-toggle="tab">SOLD Items</a>
          </li>
          <li role="presentation">
              <a href="#return_item" aria-controls="imei_wise" role="tab" data-toggle="tab">Return Items</a>
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
                                  <b>Total Sets: {{total_sets | currency('')}}</b>
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
                                        <span v-if="itemDetails.item.main_warehouse_receive_item[0].current_stock_status==4" style="color:red;">Travelling,</span>
                                        <span style="color:red; font-weight:bold;">Sold out</span>
                                    </span>
                                    <span v-else>
                                        Not Received Yet
                                    </span>

                                </td>
                            <td v-else>
                                <span v-if="itemDetails.item.main_warehouse_receive_item[0].warehouse_id!=null">
                                        {{current_Warehouse}},
                                        <span v-if="itemDetails.item.main_warehouse_receive_item[0].current_stock_status==1" style="color:green;">Major, In-stock</span>
                                        <span v-if="itemDetails.item.main_warehouse_receive_item[0].current_stock_status==2" style="color:orange;">Mini, In-stock</span>
                                        <span v-if="itemDetails.item.main_warehouse_receive_item[0].current_stock_status==3" style="color:red;">Damage, In-stock</span>
                                        <span v-if="itemDetails.item.main_warehouse_receive_item[0].current_stock_status==4" style="color:red;">Travelling,</span>
                                        <span style="color:green; font-weight:bold;"></span>
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
                            <td v-if="itemDetails.item.main_warehouse_receive_item[0].activated_date!=null">{{itemDetails.item.main_warehouse_receive_item[0].activated_date | moment() }}</td>
                            <td v-else>Not Activated</td>
                        </tr>
                    <tr v-if="itemDetails.outlet_details!=''">
                        <td><b>Dealer Name</b></td>
                        <td>{{itemDetails.outlet_details.outlet_name}}</td>
                    </tr>
                        <tr v-if="itemDetails.outlet_details!=''">
                            <td><b>Dealer City</b></td>
                            <td>{{itemDetails.outlet_details.city_name}}</td>
                        </tr>
                        <tr v-if="itemDetails.outlet_details!=''"Activation Date	>
                            <td><b>Dealer Region</b></td>
                            <td>{{itemDetails.outlet_details.region_name}}</td>
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

          <div role="tabpanel" class="tab-pane" id="imei_details">
            <div class="panel panel-info">

                <div class="panel-heading">
                    In-Stock Items
                </div>

                <div class="panel-body">

                    <div class="projects">
                        <div class="tableFilters">

                            <h5 style="font-weight:bold;">Filters:</h5>

                            <div class="row">


                                <div class="col-md-6">
                                    <select v-model="tableData.selected_product" class="form-control" @change="change_product()">
                                        <option value="">Products</option>
                                        <option v-for="(product, index) in allProducts"  v-bind:value="product.id">{{product.name}}</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <select v-model="tableData.selected_product_color" class="form-control">
                                        <option value="">Product Colors</option>
                                        <option v-for="(product_color, index) in product_colors"  v-bind:value="product_color.id">{{product_color.color}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-6">
                                    <select class="form-control" v-model="tableData.stock_type">
                                        <option value="">Stock Type</option>
                                        <option value="1">Major</option>
                                        <option value="2">Mini</option>
                                        <option value="3">Damage</option>
                                        <option value="4">Travelling</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" @click="filter_items()">Filter Items</button>
                                    <div class="dropdown" style="float:right;">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="color:#fff;">Export to Excel
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><input type="text" v-model="tableData.excel_filename" placeholder="Filename"/> </li>
                                            <li><a :href="'./get_warehouse_instock_items?draw='+this.tableData.draw+'&length='+this.tableData.length+'&search='+this.tableData.search+'&column='+this.tableData.column+'&dir='+this.tableData.dir+'&selected_product='+this.tableData.selected_product+'&selected_product_color='+this.tableData.selected_product_color+'&stock_type='+this.tableData.stock_type+'&excel_export=1&file_name='+this.tableData.excel_filename">Current Grid Records</a></li>
                                            <li><a :href="'./get_warehouse_instock_items?draw='+this.tableData.draw+'&length='+this.tableData.length+'&search='+this.tableData.search+'&column='+this.tableData.column+'&dir='+this.tableData.dir+'&selected_product='+this.tableData.selected_product+'&selected_product_color='+this.tableData.selected_product_color+'&stock_type='+this.tableData.stock_type+'&excel_export=1&excel_type=1&file_name='+this.tableData.excel_filename">All Records</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>

                            <hr/>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="control">
                                        <div class="select">
                                            <Label>Records:</Label>
                                            <select v-model="tableData.length" @change="get_instock_items()">
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="200">200</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <input class="textbox" type="text" v-model="tableData.search" placeholder="Search..."
                                           @input="get_instock_items()">
                                </div>
                            </div>
                        </div>
                        <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                            <tbody>
                            <tr v-for="(in_items, index) in instock_items" :key="in_items.id">
                                <td>{{index+1}}</td>
                                <td>{{in_items.item.product_color.product.name}}</td>
                                <td>{{in_items.item.product_color.color}}</td>
                                <td>
                                    <span v-if="in_items.current_stock_status==1">Major</span>
                                    <span v-if="in_items.current_stock_status==2">Mini</span>
                                    <span v-if="in_items.current_stock_status==3">Damage</span>
                                    <span v-if="in_items.current_stock_status==4">Travelling</span>
                                </td>
                                <td>{{in_items.item.imei[0].imei1}}</td>
                                <td>{{in_items.item.imei[0].imei2}}</td>
                            </tr>
                            </tbody>
                        </datatable>
                        <pagination :pagination="pagination"
                                    @prev="get_instock_items(pagination.prevPageUrl)"
                                    @next="get_instock_items(pagination.nextPageUrl)">
                        </pagination>
                    </div>

                </div>
              </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="sold_item">
              <div class="panel panel-info">
                  <div class="panel-heading">
                      SOLD ITEMS
                  </div>
                  <div class="panel-body">

                      <div class="projects">
                          <div class="tableFilters">
                              <h5 style="font-weight:bold;">Filters:</h5>

                              <div class="row">

                                  <div class="col-md-6">
                                      <select v-model="tableData_sold.selected_state" @change="get_cities_by_state()" class="form-control">
                                          <option value="">State Wise</option>
                                          <option value="1">Central</option>
                                          <option value="2">South</option>
                                          <option value="3">North</option>
                                      </select>
                                  </div>
                                  <div class="col-md-6">
                                      <select v-model="tableData_sold.selected_city" class="form-control" @change="get_outlet_by_city_state()">
                                          <option value="">All</option>
                                          <option v-for="(c, index) in all_cities" :value="c.id">
                                              {{c.name}}
                                          </option>
                                      </select>
                                  </div>
                              </div>

                              <div class="row" style="margin-top:10px;">
                                  <div class="col-md-6">
                                      <select v-model="tableData_sold.selected_filter_type" class="form-control">
                                          <option value="">Filter Type</option>
                                          <option value="1">SalesOfficer Wise</option>
                                          <option value="2">Outlet Wise</option>
                                          <option value="3">Product Wise</option>
                                      </select>
                                  </div>


                                  <div class="col-md-6" v-if="tableData_sold.selected_filter_type==1">
                                      <select v-model="tableData_sold.selected_sales_officer" class="form-control">
                                          <option value="">SalesOfficers</option>
                                          <option v-for="(so, index) in SalesOfficerData" :value="so.id">{{so.name}}</option>
                                      </select>
                                  </div>

                                  <div class="col-md-6" v-if="tableData_sold.selected_filter_type==2">
                                      <select v-model="tableData_sold.selected_outlet" class="form-control">
                                          <option value="">Outlets</option>
                                          <option v-for="(outlets, index) in all_outlets" :value="outlets.id">
                                              {{outlets.name}}
                                          </option>
                                      </select>
                                  </div>

                                  <div class="col-md-3" v-if="tableData_sold.selected_filter_type==3">
                                      <select v-model="tableData_sold.selected_product" class="form-control" @change="change_product_sold()">
                                          <option value="">Products</option>
                                          <option v-for="(product, index) in allProducts"  v-bind:value="product.id">{{product.name}}</option>
                                      </select>
                                  </div>

                                  <div class="col-md-3" v-if="tableData_sold.selected_filter_type==3">
                                      <select v-model="tableData_sold.selected_product_color" class="form-control">
                                          <option value="">Product Colors</option>
                                          <option v-for="(product_color, index) in product_colors"  v-bind:value="product_color.id">{{product_color.color}}</option>
                                      </select>
                                  </div>




                              </div>
                              <div class="row" style="margin-top:10px;">
                                  <div class="col-md-6">
                                      <select v-model="tableData_sold.activate_status" class="form-control">
                                          <option value="">ALL Status</option>
                                          <option value="1">Activated</option>
                                          <option value="2">Not Activated</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="row" style="margin-top:10px;">
                                  <div class="col-md-12">
                                      <button class="btn btn-primary" @click="filter_sold_items()">Filter Items</button>
                                      <div class="dropdown" style="float:right;">
                                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="color:#fff;">Export to Excel
                                              <span class="caret"></span></button>
                                          <ul class="dropdown-menu">
                                              <li><input type="text" v-model="tableData_sold.excel_filename" placeholder="Filename"/> </li>
                                              <li><a :href="'./get_warehouse_sold_items?draw='+this.tableData_sold.draw+'&length='+this.tableData_sold.length+'&search='+this.tableData_sold.search+'&column='+this.tableData_sold.column+'&dir='+this.tableData_sold.dir+'&selected_sales_officer='+this.tableData_sold.selected_sales_officer+'&selected_state='+this.tableData_sold.selected_state+'&selected_city='+this.tableData_sold.selected_city+'&selected_filter_type='+this.tableData_sold.selected_filter_type+'&selected_product='+this.tableData_sold.selected_product+'&selected_product_color='+this.tableData_sold.selected_product_color+'&selected_outlet='+this.tableData_sold.selected_outlet+'&excel_export=1&excel_filename='+this.tableData_sold.excel_filename+'&activate_status='+this.tableData_sold.activate_status+''">Current Grid Records</a></li>
                                              <li><a :href="'./get_warehouse_sold_items?draw='+this.tableData_sold.draw+'&length='+this.tableData_sold.length+'&search='+this.tableData_sold.search+'&column='+this.tableData_sold.column+'&dir='+this.tableData_sold.dir+'&selected_sales_officer='+this.tableData_sold.selected_sales_officer+'&selected_state='+this.tableData_sold.selected_state+'&selected_city='+this.tableData_sold.selected_city+'&selected_filter_type='+this.tableData_sold.selected_filter_type+'&selected_product='+this.tableData_sold.selected_product+'&selected_product_color='+this.tableData_sold.selected_product_color+'&selected_outlet='+this.tableData_sold.selected_outlet+'&excel_export=1&excel_type=1&excel_filename='+this.tableData_sold.excel_filename+'&activate_status='+this.tableData_sold.activate_status+''">All Records</a></li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>

                              <hr/>
                              <div class="row">
                                  <div class="col-md-8">
                                      <div class="control">
                                          <div class="select">
                                              <Label>Records:</Label>
                                              <select v-model="tableData_sold.length" @change="get_sold_items()">
                                                  <option value="10">10</option>
                                                  <option value="20">20</option>
                                                  <option value="30">30</option>
                                                  <option value="50">50</option>
                                                  <option value="100">100</option>
                                                  <option value="200">200</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-4">

                                      <input class="textbox" type="text" v-model="tableData_sold.search" placeholder="Search..."
                                             @input="get_sold_items()">
                                  </div>
                              </div>
                          </div>
                          <datatable :columns="columns_sold" :sortKey="sortKey_sold" :sortOrders="sortOrders_sold" @sort="sortBy_sold">
                              <tbody>
                              <tr v-for="(in_items, index) in sold_items" :key="in_items.id">
                                  <td>{{index+1}}</td>
                                  <td>{{in_items.item.product_color.product.name}}</td>
                                  <td>{{in_items.item.product_color.color}}</td>
                                  <td>{{in_items.outlet.name}}</td>
                                  <td>
                                      <span v-if="in_items.activated_date==null" style="color:red;">Not Activated Yet</span>
                                      <span style="color:green;" v-else>{{in_items.activated_date}}</span>
                                  </td>
                                  <td>{{in_items.item.imei[0].imei1}}</td>
                                  <td>{{in_items.item.imei[0].imei2}}</td>
                              </tr>

                              </tbody>
                          </datatable>
                          <pagination :pagination="pagination_sold"
                                      @prev="get_sold_items(pagination_sold.prevPageUrl)"
                                      @next="get_sold_items(pagination_sold.nextPageUrl)">
                          </pagination>

                      </div>

                  </div>
              </div>
          </div>
          <div role="tabpanel" class="tab-pane" id="return_item">
              <div class="panel panel-info">
                  <div class="panel-heading">
                      RETURN ITEMS
                  </div>
                  <div class="panel-body">

                      <div class="projects">
                          <div class="tableFilters">
                              <h5 style="font-weight:bold;">Filters:</h5>







                              <div class="row">
                                  <div class="col-md-8">
                                      <div class="control">
                                          <div class="select">
                                              <Label>Records:</Label>
                                              <select v-model="tableData_return.length" @change="get_return_items()">
                                                  <option value="10">10</option>
                                                  <option value="20">20</option>
                                                  <option value="30">30</option>
                                                  <option value="50">50</option>
                                                  <option value="100">100</option>
                                                  <option value="200">200</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-4">

                                      <input class="textbox" type="text" v-model="tableData_return.search" placeholder="Search..."
                                             @input="get_return_items()">
                                  </div>
                              </div>
                          </div>
                          <datatable :columns="columns_return" :sortKey="sortKey_return" :sortOrders="sortOrders_return" @sort="sortBy_return">
                              <tbody>
                              <tr v-for="(in_items, index) in return_items" :key="in_items.id">
                                  <td>{{index+1}}</td>
                                  <td>{{in_items.sku}}</td>
                                  <td>{{in_items.color}}</td>
                                  <td>{{in_items.business_person_name}}</td>
                                  <td>{{in_items.imei1}}</td>
                                  <td>{{in_items.imei2}}</td>
                              </tr>

                              </tbody>
                          </datatable>
                          <pagination :pagination="pagination_return"
                                      @prev="get_return_items(pagination_return.prevPageUrl)"
                                      @next="get_return_items(pagination_return.nextPageUrl)">
                          </pagination>

                      </div>

                  </div>
              </div>
          </div>
      </div>

    </div>
  </div>
</template>

<script>
    import vSelect from "vue-select"
    import Datatable from './DatatableComponent.vue';
    import Pagination from './PaginationComponent.vue';
    import {constant} from '../constant.js';
    export default {
        components: {datatable: Datatable, pagination: Pagination, vSelect},
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            }
        },
        data() {
            let sortOrders = {};
            let columns = [
                {width: '20%', label: 'S.no', name: 'S.no' },
                {width: '10%', label: 'Model', name: 'Model'},
                {width: '20%', label: 'Color', name: 'Color'},
                {width: '10%', label: 'Stock Type', name: 'Stock Type'},
                {width: '10%', label: 'IMEI1', name: 'IMEI1'},
                {width: '25%', label: 'IMEI2', name: 'IMEI2'},
            ];
            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });


            let sortOrders_sold = {};
            let columns_sold = [
                {width: '10%', label: 'S.no', name: 'S.no' },
                {width: '10%', label: 'Model', name: 'Model'},
                {width: '10%', label: 'Color', name: 'Color'},
                {width: '25%', label: 'Sold to Dealer', name: 'Sold to Dealer'},
                {width: '25%', label: 'Activated', name: 'Activated'},
                {width: '10%', label: 'IMEI1', name: 'IMEI1'},
                {width: '15%', label: 'IMEI2', name: 'IMEI2'},
            ];
            columns_sold.forEach((column) => {
                sortOrders_sold[column.name] = -1;
            });


            let sortOrders_return = {};
            let columns_return = [
                {width: '10%', label: 'S.no', name: 'S.no' },
                {width: '10%', label: 'Sku', name: 'Sku'},
                {width: '10%', label: 'Dealer Name', name: 'Dealer Name'},
                {width: '25%', label: 'Color', name: 'Color'},
                {width: '10%', label: 'IMEI1', name: 'IMEI1'},
                {width: '15%', label: 'IMEI2', name: 'IMEI2'},
            ];
            columns_return.forEach((column) => {
                sortOrders_return[column.name] = -1;
            });

            return{
              // Stock level
                instock_items:[],
                columns: columns,
                sortKey: 'Dealer Code',
                sortOrders: sortOrders,
                tableData: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc',
                    selected_product:'',
                    selected_product_color:'',
                    stock_type:'',
                    excel_filename:''
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


                sold_items:[],
                columns_sold: columns_sold,
                sortKey_sold: 'Dealer Code',
                sortOrders_sold: sortOrders_sold,
                tableData_sold: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc',
                    selected_sales_officer:'',
                    selected_state:'',
                    selected_city:'',
                    selected_filter_type:'',
                    selected_product:'',
                    selected_product_color:'',
                    selected_outlet:'',
                    excel_export:0,
                    excel_filename:"",
                    activate_status:""
                },
                pagination_sold: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: ''
                },


                return_items:[],
                columns_return: columns_return,
                sortKey_return: 'Dealer Code',
                sortOrders_return: sortOrders_return,
                tableData_return: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc',

                },
                pagination_return: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: ''
                },

                mhistory:[],
                cities:[],
                major:0,
                mini:0,
                damage:0,
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
                current_Warehouse:'',
                allProducts:[],
                product_colors:[],
                all_cities:[],
                SalesOfficerData:[],
                all_outlets:[],
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

            this.get_instock_items();
            this.get_sold_items();
            this.get_products();
            this.get_all_sales_officers();
            this.get_return_items();
        },
        methods:{
            get_instock_items(url = './get_warehouse_instock_items') {
                this.tableData.draw++;
                axios.get(url, {params: this.tableData})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData.draw == data.draw) {
                            this.instock_items = data.data.data;
                            console.log(this.instock_items);
                            this.configPagination(data.data);
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            get_sold_items(url = './get_warehouse_sold_items') {
                this.tableData_sold.draw++;
                axios.get(url, {params: this.tableData_sold})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData_sold.draw == data.draw) {
                            this.sold_items = data.data.data;
                            console.log(this.sold_items);
                            this.configPagination_sold(data.data);
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            get_return_items(url = './sale_return_imeis_details') {
                this.tableData_return.draw++;
                axios.get(url, {params: this.tableData_return})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData_return.draw == data.draw) {
                            this.return_items = data.data.data;
                            console.log(this.return_items);
                            this.configPagination_return(data.data);
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
                this.get_instock_items();
            },
            getIndex(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },


            configPagination_return(data) {
                this.pagination_return.lastPage = data.last_page;
                this.pagination_return.currentPage = data.current_page;
                this.pagination_return.total = data.total;
                this.pagination_return.lastPageUrl = data.last_page_url;
                this.pagination_return.nextPageUrl = data.next_page_url;
                this.pagination_return.prevPageUrl = data.prev_page_url;
                this.pagination_return.from = data.from;
                this.pagination_return.to = data.to;
            },
            sortBy_return(key) {
                this.sortKey_return = key;
                this.sortOrders_return[key] = this.sortOrders_return[key] * -1;
                this.tableData_return.column = this.getIndex_return(this.columns_return, 'name', key);
                this.tableData_return.dir = this.sortOrders_return[key] === 1 ? 'asc' : 'desc';
                this.get_return_items();
            },
            getIndex_return(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },




            configPagination_sold(data) {
                this.pagination_sold.lastPage = data.last_page;
                this.pagination_sold.currentPage = data.current_page;
                this.pagination_sold.total = data.total;
                this.pagination_sold.lastPageUrl = data.last_page_url;
                this.pagination_sold.nextPageUrl = data.next_page_url;
                this.pagination_sold.prevPageUrl = data.prev_page_url;
                this.pagination_sold.from = data.from;
                this.pagination_sold.to = data.to;
            },
            sortBy_sold(key) {
                this.sortKey_sold = key;
                this.sortOrders_sold[key] = this.sortOrders_sold[key] * -1;
                this.tableData_sold.column = this.getIndex_sold(this.columns_sold, 'name', key);
                this.tableData_sold.dir = this.sortOrders_sold[key] === 1 ? 'asc' : 'desc';
                this.get_sold_items();
            },
            getIndex_sold(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },
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
                            this.total_sets+=parseInt(this.product_list[i]['product_qty']);
                            this.major+=parseInt(this.product_list[i].warehouse_stock_details[0].major);
                            this.mini+=parseInt(this.product_list[i].warehouse_stock_details[0].mini);
                            this.damage+=parseInt(this.product_list[i].warehouse_stock_details[0].damage);

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
            },

            get_products:function(){
                axios.get(constant.base_url+"allProducts").then((response) => {
                    this.allProducts= response.data.data;
                });
            },
            change_product:function(){
                this.tableData.selected_product_color="";
                axios.post(constant.base_url+'get_product_colors',{product_id:this.tableData.selected_product}).then((response) => {
                    this.product_colors=response.data;
                    console.log(response.data);
                    // alert(response.data);
                });
            },

            change_product_sold:function(){
                this.tableData_sold.selected_product_color="";
                axios.post(constant.base_url+'get_product_colors',{product_id:this.tableData_sold.selected_product}).then((response) => {
                    this.product_colors=response.data;
                    console.log(response.data);
                    // alert(response.data);
                });
            },
            get_all_sales_officers:function(){
                axios.get(constant.base_url+"/get_all_sales_officers").then((response)=>{
                    this.SalesOfficerData=response.data;
                });
            },
            get_cities_by_state:function(){
                this.selected_city="";
                axios.get(constant.base_url+"get_cities_by_state/"+this.tableData_sold.selected_state).then((response)=>{
                    this.all_cities=response.data;
                });

                axios.get(constant.base_url+"get_outlet_by_city_state/"+this.tableData_sold.selected_state).then((response)=>{
                    this.all_outlets=response.data;
                });
            },
            get_all_outlets:function(){
                axios.get(constant.base_url+"outlet/get_all_outlets").then((response)=>{
                    this.all_outlets=response.data;
                });
            },
            get_outlet_by_city_state(){
                axios.get(constant.base_url+"get_outlet_by_city_state/"+this.tableData_sold.selected_state+"/"+this.tableData_sold.selected_city).then((response)=>{
                    this.all_outlets=response.data;
                });
            },
            filter_items(){
                this.get_instock_items();
            },
            filter_sold_items(){
                this.get_sold_items();
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