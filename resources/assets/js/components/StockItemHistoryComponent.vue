<template>


  <div class="row">
    <div class=" col-md-12 paddingmarginzero">

      <div class="paddingmarginzero">
        <h4 class="heading-inline"> Product History </h4>
      </div>

      <div class="paddingtop5">



        <div class="panel panel-info">

          <div class="panel-heading">
            Product Details

          </div>
          <div class="panel-body ">

            <div class="row">
              <div class="col-md-2"><label>SKU</label></div>
              <div class="col-md-2"><input type="text" class="textbox field_border_null" v-model="product_sku" readonly/></div>

              <div class="col-md-2"><label>Model </label></div>
              <div class="col-md-2"><input type="text" class="textbox field_border_null" v-model="product_name" readonly/></div>

              <div class="col-md-2"><label>Warehouse </label></div>
              <div class="col-md-2">
                <input type="text" class="textbox field_border_null" v-model="warehouse_name" readonly/>
              </div>

            </div>
            <div class="row">
              <div class="col-md-2">
                <label>Unit Price</label>
              </div>
              <div class="col-md-2">
                <input type="text" class="textbox field_border_null" v-model="product_price" readonly/>
              </div>
              <div class="col-md-2">
                <label>Quantity</label>
              </div>
              <div class="col-md-2">
                <input type="text" class="textbox field_border_null"  v-model="product_qty" readonly/>
              </div>
              <div class="col-md-2">
                <label>Color </label>
              </div>
              <div class="col-md-2">
                <input type="text" class="textbox field_border_null"  v-model="product_color" readonly/>
              </div>
            </div>

          </div>

        </div>
        <!--
        <div class="panel panel-info">

          <div class="panel-heading">
            Search Filter

          </div>
          <div class="panel-body">

            <div class="row">
              <div class="col-md-1">
                <label>From</label>
              </div>
              <div class="col-md-2">
                <input type="date" class="textbox" v-model="search_from" />
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-1">
                <label>To </label>
              </div>
              <div class="col-md-2">
                <input type="date" class="textbox" v-model="search_to"  />
              </div>

              <div class="col-md-2 text-right">
                <label>Transactions Type </label>
              </div>
              <div class="col-md-2">
                <select name="transactions"  class="textbox_dropdown">
                  <option value="0">-Select-</option>
                  <option value="1">Warehouse Transactions</option>
                  <option value="2">Sales Transactions</option>
                  <option value="3">Both</option>
                </select>
              </div>
              <div class="col-md-1"></div>
            </div>
            <div class="row paddingtop5">
              <div class="col-md-1">
                <label></label>
              </div>
              <div class="col-md-2">

              </div>
              <div class="col-md-1"></div>
              <div class="col-md-1">

              </div>
              <div class="col-md-2">

              </div>
              <div class="col-md-1"></div>
              <div class="col-md-1">

              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-primary form-control">
                  <i class="fa fa-search"></i> Search</button>
              </div>
              <div class="col-md-1"></div>
            </div>

          </div>

        </div>

        -->
        <div class="panel panel-info">

          <div class="panel-heading">
            Transaction History
          </div>
          <div class="panel-body">

            <div class="portlet portlet-table">



              <div class="portlet-content">


                <div class="table-responsive">

                  <!--<table class="table table-striped table-bordered    ">
                    <thead>
                      <tr>
                        <th class="">Date</th>

                        <th>GMR No.</th>
                        <th>WIN No.</th>
                        <th width="250px">
                         <i class="fa fa-plus-circle"></i> Received From</th>
                        <th width="50px">Qty.</th>
                        <th width="250px"><i class="fa fa-minus-circle"></i> Issued To</th>
                        <th width="50px">Qty.</th>
                        <th class="text-center"  width="100px">Unit Price</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr>
                        <td>11/02/2018 </td>

                        <td>
                          <a href="#" target="_blank">GMR557</a>
                        </td>
                        <td>
                          <a href="#" target="_blank"></a>
                        </td>
                        <td> BB Manufacturer</td>
                        <td> 35000</td>
                        <td> </td>
                        <td> </td>
                        <td  align="right"> 37,000.00</td>
                      </tr>

                      <tr>
                        <td>08/02/2018 </td>

                        <td>
                          <a href="#" target="_blank"></a>
                        </td>
                        <td>
                          <a href="#" target="_blank">WIN557</a>
                        </td>
                        <td> </td>
                        <td> </td>
                        <td>North Warehouse </td>
                        <td>5000 </td>
                        <td  align="right"> 37,000.00</td>
                      </tr>

                      <tr>
                        <td>11/01/2018 </td>

                        <td>
                          <a href="#" target="_blank"></a>
                        </td>
                        <td>
                          <a href="#" target="_blank">WIN557</a>
                        </td>
                        <td> </td>
                        <td> </td>
                        <td>North Warehouse  </td>
                        <td>3500 </td>
                        <td  align="right"> 37,000.00</td>
                      </tr>

                      <tr>
                        <td>30/01/2018 </td>

                        <td>
                          <a href="#" target="_blank">GMR557</a>
                        </td>
                        <td>
                          <a href="#" target="_blank"></a>
                        </td>
                        <td> BB Manufacturer</td>
                        <td> 35000</td>
                        <td> </td>
                        <td> </td>
                        <td  align="right"> 37,000.00</td>
                      </tr>
                    </tbody>

                  </table>-->

                  <table class="table table-striped table-bordered    ">
                    <thead>
                    <tr>
                      <th  width="80px" class="">Date</th>
                      <th width="120px">Transaction</th>
                      <th>From / To</th>
                      <th width="100px">Ref.</th>
                      <th width="150px">Unit Price(PKR)</th>
                      <th width="100px">Item Qty.</th>
                      <th width="150px">Total Price(PKR)</th>
                    </tr>
                    </thead>

                    <tbody>
                    <!--<tr style="border-bottom:2px solid #ddd;">
                      <td></td>
                      <td style="font-weight:bold;">----</td>
                      <td style="font-weight:bold;">----</td>
                      <td style="font-weight:bold;">----</td>

                      <td  align="right" style="font-weight:bold;">{{product_price}}</td>
                      <td  align="right" style="font-weight:bold;">{{product_qty}} </td>
                      <td  align="right" style="font-weight:bold;"> </td>

                    </tr> -->

                    <tr v-for="(trans, index) in history" v-if="trans.transfer_date!=null">
                      <td>{{trans.transfer_date | moment()}} </td>
                      <td>
                        {{trans.status_for}} </td>
                      <td>{{trans.transfer_warehouse_name}}</td>
                      <td><a href="#" target="_blank">{{trans.resource}}</a> </td>

                      <td  align="right"> {{trans.unit_price | currency('Rs')}}</td>
                      <td  align="right"> {{trans.Transfer_qty}}</td>
                      <td  align="right"> {{trans.unit_price * trans.Transfer_qty | currency('Rs')}}</td>

                    </tr>

                    </tbody>

                  </table>



                </div>
                <!-- /.table-responsive -->

              </div>
              <!-- /.portlet-content -->



            </div>

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
        data() {
            return{
                product_price:'',
                product_color:'',
                product_name:'',
                product_sku:'',
                product_qty:'',
                warehouse_name:'',
                history:[],
                supply_history:[],
                history_with_balance:[],
                warehouse_transaction:0,
                sales_transaction:0,

                search_from:'',
                search_to:''
            }
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY hh:mm a');
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            axios.get('../../get_specific_item_history/'+window.location.pathname.split('/')[4]+'/'+window.location.pathname.split('/')[5]).then(response => {
                this.history = _.orderBy(response.data, ['created_at'], ['desc']);

            console.log(this.history);

            /*  var last_qty=this.history[this.history.length-1].Transfer_qty;
              var balance_increment=0;
              for(var i=0; i<this.history.length; i++) {
                  if(i==0){
                      this.history_with_balance.push({
                          'date':this.history[i].transfer_date,
                          'status_for':this.history[i].status_for,
                          'warehouse_name':this.history[i].transfer_warehouse_name,
                          'resource':this.history[i].resource,
                          'unit_price':this.history[i].unit_price,
                          'final_price':(this.history[i].unit_price * this.history[i].Transfer_qty),
                          'final_balance':last_qty
                      });
                      balance_increment+=last_qty;
                  }
                  else{
                      balance_increment+=this.history[i].Transfer_qty;
                      this.history_with_balance.push({
                          'date':this.history[i].transfer_date,
                          'status_for':this.history[i].status_for,
                          'warehouse_name':this.history[i].transfer_warehouse_name,
                          'resource':this.history[i].resource,
                          'unit_price':this.history[i].unit_price,
                          'trans_qty':this.history[i].Transfer_qty,
                          'final_price':(this.history[i].unit_price * this.history[i].Transfer_qty),
                          'final_balance':balance_increment
                      });
                  }

              }*/



            console.log(this.history_with_balance);


        });



            axios.get('../../get_specific_item_supply_history/'+window.location.pathname.split('/')[4]+'/'+window.location.pathname.split('/')[5]).then(response => {
                this.supply_history = response.data;
        });

            axios.get('../../get_warehouse_stock_by_warehouse_id/'+window.location.pathname.split('/')[4]+'/'+window.location.pathname.split('/')[5]).then(response => {
                //alert(response.data);
                this.product_qty=response.data[0].product_qty;
            this.warehouse_name=response.data[0].warehouse.name;
        });



            axios.get('../../get_products_by_color_id/'+window.location.pathname.split('/')[5]).then(response => {
                //alert(response.data);
                this.product_price='Rs ' + accounting.formatMoney(response.data[0].price != null ? response.data[0].price : 0, {symbol: "", format: "%v %s"});
            this.product_color=response.data[0].color;
            this.product_name=response.data[0].product.name;
            this.product_sku=response.data[0].sku;


        });

        },
        methods:{


        }
    }
</script>