<template>
    <div>
        <div class="row" style="margin-top: 24px;">

            <div class="col-md-12">
                <div class="panel panel-info">
                        <div class="panel-heading">
                            <h2 class="panel-title">Warehouse Consignment Receive</h2>
                        </div>

                    <div id="d" class="panel-body collapse" v-bind:class="{in:edit}">
                        <form @submit="createMainWarehouseReceive">
                          <div class="row">
                              <div class="col-md-2">
                                  <label for="warehouse">Warehouse</label>
                              </div>
                              <div class="col-md-3">
                                  <input type="text" readonly v-model="warehouse.name" class="textbox"  placeholder="Warehouse">
                              </div>
                              <div class="col-md-1"></div>

                              <div class="col-md-2">
                                  <label for="receive">Receive ID</label>
                              </div>
                              <div class="col-md-3">
                                  <!-- <input type="text" class="form-control"  placeholder="Receive ID"> -->
                                  <v-select label="id" :filterable="false" v-model="newWarehouseReceive.receive" :options="receive" @search="searchReceive" ></v-select>
                              </div>
                              <div class="col-md-1"></div>
                          </div>
                          <div class="row">
                            <div class="col-md-2">
                                <input type="Submit" value="Submit" class="btn btn-tumblr" />
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!showError" class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                        <div class="panel-heading">
                    <a href="#imei" data-toggle="collapse" style="color:#333333">
                            <h2 class="panel-title">Warehouse Product Receive</h2>
                    </a>
                        </div>
                    <div id="imei" class="panel-body collapse" v-bind:class="{in:received}">
                        <form @submit="createReceiveItems">
                          <div class="row">
                              <div class="col-md-2">
                                  <label for="product">Warehouse Receive ID</label>
                              </div>
                              <div class="col-md-3">
                                <v-select label="id" :filterable="false" v-model="newItems.main_receive" :options="mainWarehouseReceive" @search="searchProduct"></v-select>
                             <!--   <input type="text" v-bind:value="newItems.main_receive.id" readonly class="form-control" /> -->
                              </div>
                              <div class="col-md-1"></div>

                            <div class="col-md-2">
                                <label for="product">Receive Date</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" v-bind:value="newItems.main_receive.created_at | moment" readonly class="form-control" />
                                <!-- <p class="col-md-12">{{newItems.main_receive.created_at | moment}}</p> -->
                                <!-- <v-select label="created_at" v-model="newItems.main_receive" :options="mainWarehouseReceive" @search="searchProduct"></v-select> -->
                            </div>
                            <div class="col-md-1"></div>
                          </div>
                          <div class="row">
                              <div class="col-md-2">
                                  <label for="product">Select Product</label>
                              </div>
                              <div class="col-md-3">
                                  <v-select label="name" v-model="product" :options="products" @search="searchProduct"></v-select>
                              </div>
                              <div class="col-md-1"></div>

                              <div class="col-md-2" >
                                  <label for="product">Select Product Color</label>
                              </div>
                              <div class="col-md-3" @click="getColors">
                                <v-select label="color" v-model="newItems.productColor" :options="productColors"></v-select>
                              </div>
                              <div class="col-md-1"></div>
                          </div>

                          <div class="row">
                            <div class="col-md-2">
                                <label for="">IMEI</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" v-model="imei" class="textbox">
                            </div>
                            <div class="col-md-1"></div>
                          </div>
                          <div class="row">
                            <div class="col-md-12" style="margin-top: 10px;">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="col-md-1">S.No</th>
                                        <th>IMEI</th>
                                        <th class="col-md-1">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(imei, index) in newItems.imei">
                                        <td>{{index + 1}}</td>
                                        <td>{{imei}}</td>
                                        <td><button class="btn btn-danger btn-sm" @click="removeIMEI(index)"><i class="fa fa-times"></i></button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-tumblr" value="Submit">
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
         <div v-if="showError" class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <a href="#imei" data-toggle="collapse" style="color:#333333">
                        <div class="panel-heading">
                            <h2 class="panel-title">Warehouse Product Receive</h2>
                        </div>
                    </a>
                    <div class="panel-body collapse">
                      <div class="col-md-6">
                      <ul class="list-group">
                        <li v-for="imei in alocatedIMEI" class="list-group-item">
                          {{imei}}
                        </li>
                      </ul>
                     </div>
                      <div class="col-md-6">
                      <ul class="list-group">
                        <li v-for="imei in notInDB" class="list-group-item">
                          {{imei}}
                        </li>
                      </ul>
                     </div>
                     <dir>
                       <button class="btn btn-default" @click="close">Close</button>
                     </dir>
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
       data(){
         return{
          newItems:{
              productColor:'',
              main_receive:'',
              imei:[],
              quantity:0,
              warehouse_id:'',
          },
          mainWarehouseReceive:[],
          productColors:[],
          edit:true,//use for acordion
          received:false,//use for acordion
          product:'',
          alocatedIMEI:[],
          notInDB:[],
          showError:false,
          products:[],
          imei:'',
          receive:false,
          warehouse:{},
          receive:[],
          newWarehouseReceive:{
             warehouse_id:'',
             receive:''
           }
         }
       },
       filters: {
          moment: function (date) {
            return moment(date).format('DD-MM-YYYY');
          }
        },
        mounted() {
            console.log('Component mounted.');

        },
        created(){
          axios.get('./currentWarehouse').then(response=>{
            console.log(response.data.id);
            this.warehouse=response.data;
            this.newItems.warehouse_id=response.data.id;
            this.newWarehouseReceive.warehouse_id=response.data.id;
          });
          // axios.get('/allProducts').then(response=>{
          //   this.products=response.data.data;
          //   //console.log(this.products);
          // })
          axios.get('./lastWarehouseReceive').then(response=>{
            if(response.data.replay==0){
              this.mainWarehouseReceive.push(response.data.data);
            }
            console.log(response.data);
          })
        },
        watch:{
          imei:function(){
              if(this.imei!=''){
                this.newItems.imei.push(this.imei);
                this.newItems.quantity +=1;
                this.imei='';
                //console.log(this.newItems.imei);
            }
          }
        },
        methods:{
          searchReceive(search){
            axios.get('./receivSearch/'+search).then(response=>{
              this.receive=response.data;
              //console.log(response.data);
            })
          },
          searchProduct(search){
            axios.get('./productSearch/'+search).then(response=>{
              console.log(response.data);
                this.products=response.data;
            })
          },
          removeIMEI(index){
            event.preventDefault();
            this.newItems.imei.splice(index,1);
          },
          getColors(){
            if(this.product.id!=''){
              axios.get('./productColor/'+this.product.id).then(response=>{
                this.productColors=response.data;
              })
            }

          },
          createMainWarehouseReceive(e){
          e.preventDefault();
            axios.post('./createMainWarehouseReceive',this.newWarehouseReceive).then(response=>{
                if(response.data.replay==0){
                  this.mainWarehouseReceive.push(response.data.data);
                  console.log(this.mainWarehouseReceive);
                  this.received=true;
                  this.edit=false;
                  alert('Record Inserted Succcessfully');
                }else {
                  alert('Fail to Insert Record');
                  console.log(response.data.data);
                }
            })
          },
          createReceiveItems(e){
            e.preventDefault();
            axios.post('./createReceiveItems',this.newItems).then(response=>{
              console.log(response.data);
              if(response.data.replay==0){
                if(response.data.alocated.length > 0){
                  this.alocatedIMEI=response.data.alocated;
                  console.log(this.alocatedIMEI);
                  this.showError=true;
                }
                if(response.data.notInDB.length > 0){
                  this.notInDB=response.data.notInDB;
                  console.log(this.notInDB);  
                  this.showError=true;
                }                                
                this.newItems={
                    productColor:'',
                    main_receive:'',
                    imei:[],
                    quantity:0,
                    warehouse_id:'',
                },
                alert("Record Created");
              }else{
                if(response.data.replay==2){
                  alert(response.data.data);
                }else{
                  alert("Fail to create");
                  console.log(response.data.data);
                }
              }
            })
          },
          close(){
            this.showError=false;
          }
        }
    }
</script>


