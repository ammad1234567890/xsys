<template>
    <div>
        <div v-if="!showReceive" class="row" style="margin-top: 24px;">

            <div class="col-md-12">
                <div class="panel panel-info">
                        <div class="panel-heading">
                            <h2 class="panel-title">Warehouse Consignment Receive</h2>
                        </div>

                    <div  id="d" class="panel-body">
                       <table id="" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Receive  No</th>
                            <th>Received By</th>
                            <th>QA Status</th>
                            <th>Description</th>
                            <th>Receive Status</th>
                            <th>Receive At</th>
                            <th class="col-md-1">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(receive, index) in all_receive_orders">
                            <td>{{receive.order.manufacture_order_no}}</td>
                            <td>{{receive.receive_no}}</td>
                            <td>{{receive.staff.name}}</td>
                            <td  style="text-align:center; font-size: 20px;" title="QA Failed" v-if="receive.is_qa_pass==0"><i class="fa fa-times"></i></td>
                            <td  style="text-align:center; font-size: 20px; color: green;"  title="QA Passed" v-else><i class="fa fa-check"></i></td>
                            <td v-if="receive.qa_description==null"> ---- </td>
                            <td v-else>{{receive.qa_description}}</td>
                            <td>{{receive.receive_status.status}}</td>
                            <td>{{receive.created_at | moment}}</td>
                             <td class="text-center"><span v-if="receive.main_warehouse_receive!=null">Received</span>
                              <button v-if="receive.main_warehouse_receive==null" class="btn btn-success btn-xs" v-on:click="createMainWarehouseReceive(receive)" title="Receive">Receive</button></td>
                             
                           <!--  <td class="text-center"><button class="btn btn-success btn-xs" v-on:click="show_products(index)" title="View Detial"><i class="fa fa-eye"></i></button></td> -->
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div v-if="!showError" class="row"> -->
          <div v-if="showReceive" class="row">
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
                                <input type="text" class="textbox" name="" v-model="mainReceiveId" readonly>
                               <!--  <v-select label="id" :filterable="false" v-model="newItems.main_receive" :options="mainWarehouseReceive" @search="searchProduct"></v-select> -->
                             <!--   <input type="text" v-bind:value="newItems.main_receive.id" readonly class="form-control" /> -->
                              </div>
                              <div class="col-md-1"></div>

                            <div class="col-md-2">
                                <label for="product">Receive Date</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text"  v-bind:value="newItems.main_receive.created_at | moment" readonly class="textbox" />
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
                                <select class="textbox" name="selectProduct" required v-model="product">
                                  <option value="">Select Product</option>
                                  <option v-for="product in products" v-bind:value="product">{{product.name}}</option>
                                </select>
                                  <!-- <v-select label="name" v-model="product" :options="products" @search="searchProduct"></v-select> -->
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
          all_receive_orders:'',
          showReceive:false,
          mainWarehouseReceive:'',
          productColors:[],
          mainReceiveId:'',
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
          // axios.get('./lastWarehouseReceive').then(response=>{
          //   if(response.data.replay==0){
          //     this.mainWarehouseReceive.push(response.data.data);
          //     //console.log(response.data);
          //   }
          //   //console.log(response.data);
          // });
          axios.get('./order/received_order_status').then((response)=>{
                    this.all_receive_orders=response.data;
                    console.log(this.all_receive_orders);
                });

          axios.get('./allProducts').then(response=>{
              console.log(response.data.data);
                this.products=response.data.data;
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
          createMainWarehouseReceive(receive){
            this.newWarehouseReceive.receive=receive;
          //event.preventDefault();
            axios.post('./createMainWarehouseReceive',this.newWarehouseReceive).then(response=>{
                if(response.data.replay==0){
                  this.showReceive=true;
                 // console.log(response.data);
                  this.newItems.main_receive=response.data.data;
                  this.mainReceiveId=response.data.data.id;
                  console.log(this.mainReceiveId);
                  //console.log(this.mainWarehouseReceive);
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


