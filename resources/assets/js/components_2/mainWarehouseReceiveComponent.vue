<template>
    <div>
        <div class="row" style="margin-top: 24px;">

            <div class="col-md-12">

              <!-- Alert Dialog with user action required -->
              <div class="modal  fade" id="div_detailed_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                  <div class="modal-content">
              
                    <div class="modal-body">
                    
                      <div class="row">
                      <div class="col-md-2 paddingtop5">
                      <img :src="alert_image_url" />
                      </div>
                      <div class="col-md-8 paddingtop5">


                      <p class="  text-center " style=" padding-top:12px;">{{detailedMessage}}</p>       
                      </div>
                      <div class="col-md-2">
                    
                      <button type="button" class="  close close_btn_settings" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </div>
                      </div>
                    </div>
                  <!-- <div class="modal-footer  " style="text-align:center; margin-top:0;">
                      <button type="button" class="btn btn-primary ">  Login Account</button>
                      <button type="button" class="btn btn-primary"  data-dismiss="modal">Cancel</button>
                    </div> -->
                  </div>
                </div>
              </div>

                <div class="panel panel-info">
                        <div class="panel-heading">
                            <h2 class="panel-title">Consignment Receiving</h2>
                        </div>

                    <div  id="d" class="panel-body">
                       <table id="consignment_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Receive No</th>
                            <th>Received By</th>
                            <th>QA Status</th>
                            <th>Description</th>
                            <th>Receive Status</th>
                            <th>Date</th>
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
                                 <a v-if="receive.main_warehouse_receive!=null" v-bind:href="'consignment_item_scanning/'+receive.main_warehouse_receive.id"><button class="btn btn-success btn-xs" title="Items Entry">Scan Items</button></a>
                              <button v-if="receive.main_warehouse_receive==null" class="btn btn-success btn-xs" v-on:click="createMainWarehouseReceive(receive)" title="Receive">Receive Stock</button></td>
                             
                           <!--  <td class="text-center"><button class="btn btn-success btn-xs" v-on:click="show_products(index)" title="View Detial"><i class="fa fa-eye"></i></button></td> -->
                        </tr>
                        </tbody>
                    </table>
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
                        <h4 class="modal-title"><b>{{receive_number}}</b> - Products</h4>
                    </div>
                    <div class="modal-body">
                        <!-- <h4>{{receive_number}}</h4> -->

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Category</td>
                                        <td>Product</td>
                                        <td>Color</td>
                                        <td>Quantity</td>
                                        <td>Unit Price(PKR)</td>
                                        <td>Net Price(PKR)</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="product in products">
                                        <td>{{product.product_color.product.product_category.name}}</td>
                                        <td>{{product.product_color.product.name}}</td>
                                        <td>{{product.product_color.color}}</td>
                                        <td style="text-align:right;">{{product.product_qty}}</td>
                                        <td style="text-align:right;">{{product.product_color.price | currency('')}}</td>
                                        <td style="text-align:right;">{{product.product_qty * product.product_color.price | currency('')}}</td>
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
             alert_image_url:'../img/xsys_info.png',
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

            this.get_all_orders();
            this.get_all_products();
            this.get_current_warehouse();

        },
        watch:{

        },
        methods:{
          showDetailedMessage(message){
            this.detailedMessage = message;
            $('#div_detailed_message').modal("show");
          },
            get_all_orders(){
                axios.get('./order/received_order_status').then((response)=>{
                    for(var i=0; i<response.data.length; i++){
                        if(response.data[i].main_warehouse_receive!=null){
                            if(response.data[i].main_warehouse_receive.is_received==0){
                                this.all_receive_orders.push(response.data[i]);
                            }
                        }
                        else{
                            this.all_receive_orders.push(response.data[i]);
                        }
                    }

                });
            },
            get_all_products(){
                axios.get('./allProducts').then(response=>{
                    this.products=response.data.data;
                });
            },
            get_current_warehouse(){
                axios.get('./currentWarehouse').then(response=>{
                    this.warehouse=response.data;
                    this.newItems.warehouse_id=response.data.id;
                    this.newWarehouseReceive.warehouse_id=response.data.id;
                });
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
                  this.showDetailedMessage("Consignment received successfully");
                  this.all_receive_orders=[];
                  this.get_all_orders();
                }else {
                  this.showDetailedMessage("Error receiving consignment");
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

