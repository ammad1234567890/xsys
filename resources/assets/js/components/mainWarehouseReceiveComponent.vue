<template>
    <div>
        <div v-if="!showReceive" class="row" style="margin-top: 24px;">

            <div class="col-md-12">
                <div class="panel panel-info">
                        <div class="panel-heading">
                            <h2 class="panel-title">Warehouse Consignment Receive</h2>
                        </div>

                    <div  id="d" class="panel-body">
                       <table id="consignment_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Receive  No</th>
                            <th>Received By</th>
                            <th>QA Status</th>
                            <th>Description</th>
                            <th>Receive Status</th>
                            <th>Receive At</th>
                            <th>Details</th>
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
                            <td><button class="btn btn-success btn-xs" v-on:click="show_products(index)" title="View Details">Details</button></td>
                             <td class="text-center"><!-- <span v-if="receive.main_warehouse_receive!=null">Received</span> -->
                              <button v-if="receive.main_warehouse_receive!=null" class="btn btn-success btn-xs" v-on:click="getMainWarehouseReceive(receive)" title="Receive">Add Items</button>
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
                                  <option v-for="product in products" v-bind:value="product.product_color.product">{{product.product_color.product.name}}</option>
                                </select>
                                  <!-- <v-select label="name" v-model="product" :options="products" @search="searchProduct"></v-select> -->
                              </div>
                              <div class="col-md-1"></div>

                              <div class="col-md-2" >
                                  <label for="product">Select Product Color</label>
                              </div>
                              <div class="col-md-3" >
                                <select class="textbox" name="selectColor" required v-model="selectedColor">
                                  <option value="">Select Color</option>
                                  <option v-for="productColor in productColors" v-bind:value="productColor">{{productColor.color}}</option>
                                </select>
                               <!--  <v-select label="color" v-model="newItems.productColor" :options="productColors"></v-select> -->
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
                            <!-- <div class="col-md-1"></div> -->
                            <div v-if="manual == false" class="col-md-1" style="margin-left: -14px; margin-top: 5px;">
                              <button class="btn btn-primary btn-xs" @click="addIMEI">Add IMEI</button>
                            </div>
                            <div v-else class="col-md-1"></div>

                            <div class="col-md-1">
                              <label for="">Manual</label>
                            </div>
                            <div class="col-md-1" style="margin-left: -28px;">
                              <label class="switch">
                              <input v-model="manual" type="checkbox">
                              <span class="slider round"></span></label>
                            </div>
                            <div class="col-md-2" style="margin-left: -40px;">
                                <label for="">Automatic</label>
                            </div>
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

        <!-- View Details Modal Start-->
        <div v-if="showModal" class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="receive_info_modal" aria-labelledby="bs-add-Model-modal-md">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Product Details</h4>
                    </div>
                    <div class="modal-body">
                        <h4>{{receive_number}}</h4>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Category</td>
                                        <td>Product</td>
                                        <td>Color</td>
                                        <td>Quantity</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="product in products">
                                        <td>{{product.product_color.product.product_category.name}}</td>
                                        <td>{{product.product_color.product.name}}</td>
                                        <td>{{product.product_color.color}}</td>
                                        <td  style="text-align:right;">{{product.product_qty}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-github" data-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- View Details Modal END -->
    </div>


</template>

<script>
import vSelect from "vue-select"
    export default {
        components: {vSelect},
       data(){
         return{
             showModal:false,
             order_no:'',
             receive_no:'',
             receive_number:'',
          newItems:{
              productColor:'',
              main_receive:'',
              imei:[],
              quantity:0,
              warehouse_id:'',
          },
          manual:true,
          all_receive_orders:[],
          showReceive:false,
          mainWarehouseReceive:'',
          productColors:[],
          selectedColor:'',
          product_qty:'',
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
           },
           Details:{
            productName:'',
            productColor:'',
            productQuantity:''
           },
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
            console.log("Response");
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
             // console.log(response.data.data);
                this.products=response.data.data;
            })
        },
        watch:{

          imei:function(){
              if(this.manual==true){
                if(this.imei!=''){
                 if(this.newItems.quantity < this.product_qty){
                  this.newItems.imei.push(this.imei);
                  this.newItems.quantity +=1;
                  this.imei='';  
                }else{
                  alert("Product Limit Exceeded");
                }
                
                //console.log(this.newItems.imei);
            }  
          }
              
          },
          product:function(){
            if(this.product.id!=''){
              axios.get('./productColor/'+this.product.id).then(response=>{
                this.productColors=response.data;
                console.log(this.productColors);
              })
              
            }
          },
          selectedColor:function(){
            if(this.selectedColor!=''){
              this.newItems.productColor=this.selectedColor;
              console.log(this.mainReceiveId);
              console.log(this.selectedColor.id);
              axios.get('./getRemainingQuantity/'+this.mainReceiveId+"/"+this.selectedColor.id).then(response=>{
                this.product_qty=response.data;
                console.log(this.product_qty);
              })
            }
          }

        },
        methods:{
          addIMEI(e){
            e.preventDefault();
            if(this.imei!=''){
                 if(this.newItems.quantity < this.product_qty){
                  this.newItems.imei.push(this.imei);
                  this.newItems.quantity +=1;
                  this.imei='';  
                }else{
                  alert("Product Limit Exceeded");
                }               
            } 
          },
          showDetails(index){
            //console.log(this.all_receive_orders[index]);
           
          },
          searchReceive(search){
            axios.get('./receivSearch/'+search).then(response=>{
              this.receive=response.data;
              //console.log(response.data);
            })
          },
          searchProduct(search){
            axios.get('./productSearch/'+search).then(response=>{
             // console.log(response.data);
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
            console.log(this.mainWarehouseReceive.receive);
            this.products=receive.receive_products;
           distroyTable();
           // this.product_qty=receive.receive_products.product_qty;
          //event.preventDefault();
            axios.post('./createMainWarehouseReceive',this.newWarehouseReceive).then(response=>{
              //console.log(response.data);
                if(response.data.replay==0){
                  this.showReceive=true;
                  console.log(response.data);
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
            show_products:function(index){

                $('#receive_info_modal').modal('show');
                this.products=this.all_receive_orders[index].receive_products;
                this.order_no=this.all_receive_orders[index].manufacturing_order_id;
                this.receive_no=this.all_receive_orders[index].id;
                this.receive_number=this.all_receive_orders[index].receive_no;

                //alert(this.products[0].product_color.product.product_category.name);
                this.showModal=true;
            },
          getMainWarehouseReceive(receive){
            this.newWarehouseReceive.receive=receive;
            console.log(this.newWarehouseReceive.receive);
            function removeDuplicateUsingSet(arr){
            let unique_array = Array.from(new Set(arr))
            return unique_array
            }

            this.products=removeDuplicateUsingSet(receive.receive_products);
            distroyTable();
            //this.product_qty=receive.receive_products.product_qty;
            axios.get('./getMainWarehouseReceive/'+receive.id).then(response=>{                
                  this.showReceive=true;
                 // console.log(response.data);
                  this.newItems.main_receive=response.data;
                  this.mainReceiveId=response.data.id;
                  //console.log(this.mainReceiveId);
                  //console.log(this.mainWarehouseReceive);
                  this.received=true;
                  this.edit=false;              
            })
          },
          createReceiveItems(e){
            e.preventDefault();
            axios.post('./createReceiveItems',this.newItems).then(response=>{
             // console.log(response.data);
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
                window.location.reload();
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
    $(document).ready(function() {

        setTimeout(function(){
            $('#consignment_table').DataTable({             
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search here",
            }
            });
        },3000); 

        
    });
    function distroyTable(){
          $("#consignment_table").DataTable().destroy();
        }
</script>
<style type="text/css">
  .switch {
  position: relative;
  display: inline-block;
  width: 30px;
  height: 15px;
  margin-top: 7px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 15px;
  width: 15px;
  left: 1px;
  bottom: 1px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(15px);
  -ms-transform: translateX(15px);
  transform: translateX(15px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

