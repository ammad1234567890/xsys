<template>
  <div class="row">
    <div class=" col-md-12 paddingmarginzero">

      <div class="paddingmarginzero">
        <h4 class="heading-inline"> Stock Item Details</h4>
      </div>

      <div class="paddingtop5">



        <div class="panel panel-info">

          <div class="panel-heading">
            Search Details

          </div>
          <div class="panel-body">

            <!--        <div class="row">
        <div class="col-md-2"><label>Employee Name</label></div>
        <div class="col-md-3"><input type="text" class="textbox" /></div>
        <div class="col-md-1"></div>
        <div class="col-md-2"><label>Address1 </label></div>
        <div class="col-md-3"><input type="text" class="textbox" /></div>
        <div class="col-md-1"></div>
        </div>-->
            <div class="row">
              <div class="col-md-1">
                <label>City</label>
              </div>
              <div class="col-md-3">
                <select class="textbox_dropdown" name="city" v-model="select_city_id" @change="change_city" required>
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
            <b>{{selected_warehouse_name}}</b> - Display Stock List

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
                          <th> Product Name</th>
                          <th> Color</th>
                          <th> Qty.</th>
                          <th> Unit Price(PKR)</th>
                          <th> Total Price</th>
                          <th width="200px"> View Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="product in product_list">
                          <td>{{product.product_color.sku}}</td>
                          <td>{{product.product_color.product.name}}</td>
                          <td>{{product.product_color.color}}</td>
                          <td>{{product.product_qty}}</td>
                          <td>{{product.product_color.price  | currency('Rs')}}</td>
                          <td>{{product.product_color.price*product.product_qty | currency('Rs')}}</td>
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
                          <td><b>Total Sets: {{total_sets}}</b></td>
                          <td></td>
                          <td><b>Worth: {{worth | currency('Rs')}}</b></td>
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
    </div>
  </div>
</template>

<script>
    import vSelect from "vue-select"
    export default {
        components: {vSelect},
        data() {
            return{
                cities:[],
                select_city_id:'0',
                select_warehouse_id:'0',
                allWarehouses:[],
                search_enabled:0,
                product_list:[],
                total_sets:0,
                worth:0,
                selected_warehouse_name:'',
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
                    axios.get('./warehouseStockSearch/'+this.select_warehouse_id).then(response=>{
                        this.product_list=response.data;
                        for(var i=0; i<this.product_list.length; i++){
                            this.worth+=this.product_list[i]['product_color']['price']*this.product_list[i]['product_qty'];
                            this.total_sets+=this.product_list[i]['product_qty'];
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




            }

        }
    }
</script>
