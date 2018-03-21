<template>
    <div>
        <div class="row">
          <div class="card headcolor">
                <div class="card-header">
                        <h3 class="card-title pad-bot"><i class="material-icons">store</i> <small>Add Stock | Add New Stock</small> </h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <a href="#d" data-toggle="collapse" style="color:#333333">
                        <div class="panel-heading">
                            <h2 class="panel-title">Warehouse Consignment Receive</h2>
                        </div>
                    </a>
                    <div id="d" class="panel-body collapse" v-bind:class="{in:edit}">
                        <form @submit="createMainWarehouseReceive">
                            <div class="form-group col-md-6">
                                <label for="warehouse">Warehouse</label>
                                <input type="text" readonly v-model="warehouse.name" class="form-control"  placeholder="Warehouse">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="receive">Receive ID</label>
                                <!-- <input type="text" class="form-control"  placeholder="Receive ID"> -->
                                <v-select label="id" :filterable="false" v-model="newWarehouseReceive.receive" :options="receive" @search="searchReceive" ></v-select>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="Submit" value="Submit" class="btn btn-tumblr" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <a href="#imei" data-toggle="collapse" style="color:#333333">
                        <div class="panel-heading">
                            <h2 class="panel-title">Warehouse Product Receive</h2>
                        </div>
                    </a>
                    <div id="imei" class="panel-body collapse" v-bind:class="{in:received}">
                        <form @submit="createReceiveItems">
                            <div class="form-group col-md-6">
                                <label for="product">Warehouse Receive ID</label>
                                <v-select label="id" :filterable="false" v-model="newItems.main_receive" :options="mainWarehouseReceive" @search="searchProduct"></v-select>
                             <!--   <input type="text" v-bind:value="newItems.main_receive.id" readonly class="form-control" /> -->
                            </div>
                            <div class="form-group col-md-6">
                                <label for="product">Receive Date</label>
                                <input type="text" v-bind:value="newItems.main_receive.created_at | moment" readonly class="form-control" />
                                <!-- <p class="col-md-12">{{newItems.main_receive.created_at | moment}}</p> -->
                                <!-- <v-select label="created_at" v-model="newItems.main_receive" :options="mainWarehouseReceive" @search="searchProduct"></v-select> -->
                            </div>
                            <div class="form-group col-md-6">
                                <label for="product">Select Product</label>
                                <v-select label="name" v-model="product" :options="products" @search="searchProduct"></v-select>
                            </div>
                            <div class="form-group col-md-6" @click="getColors">
                                <label for="product">Select Product Color</label>
                                <v-select label="color" v-model="newItems.productColor" :options="productColors"></v-select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">IMEI</label>
                                <input type="text" v-model="imei" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>IMEI</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(imei, index) in newItems.imei">
                                        <td>{{index + 1}}</td>
                                        <td>{{imei}}</td>
                                        <td><button class="btn btn-danger btn-sm" @click="removeIMEI(index)">Remove</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="submit" class="btn btn-tumblr col-md-12" value="Submit">
                            </div>
                        </form>
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
          }
        }
    }
</script>
