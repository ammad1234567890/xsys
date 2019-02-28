<template>
    <div>
        <div v-if="!created" class="row">
            <div class="col-md-12">

              <!-- Alert Dialog with user action required -->
                <div class="modal  fade" id="div_detailed_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">

                        <div class="modal-body">

                        <div class="row">
                        <div class="col-md-2 paddingtop5">
                        <img src="img/xsys_info.png" />
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
                        <h2 class="panel-title">Sale Invoice</h2>
                    </div>

                    <div class="panel-body">
                        <form @submit="createIssue">
                          <div class="row">
                              <div class="col-md-2">
                                <label for="Name">Select Invoice No</label>
                              </div>
                              <div class="col-md-4">
                                  <v-select label="invoice_no" :filterable="false" v-model="warehouseissue" :options="issueRequests"></v-select>
                              </div>
                              <div class="col-md-1"></div>
                              <div class="col-md-5"><button class="btn btn-primary" v-on:click="get_invoice_details($event)">Get Invoice Details</button></div>
                              <!--

                              <div class="col-md-2">
                                    <label for="">IMEI</label>
                              </div>
                              <div class="col-md-3">
                                    <input type="text" v-model="imei" class="textbox">
                              </div>
                              <div class="col-md-1"></div> -->
                          </div>

                            <div class="row" v-if="invoice_detail_enabled==1">
                                <div class="col-md-12">
                                    <div class="invoice_details">
                                        <h5><b>Invoice No:</b> {{selected_invoice_No}}</h5>
                                        <h5><b>Outlet Name:</b> {{selected_outlet_name}}</h5>
                                        <h5><b>Total Amount:</b> {{selected_total_Amount | currency('Rs')}}</h5>
                                        <h5><b>Invoice Created Date:</b> {{selected_created_at | moment}}</h5>

                                    </div>
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th class="col-md-1">S.No</th>

                                                <th>Model</th>
                                                <th class="col-md-1">Color</th>
                                                <th>Quantity</th>
                                                <th>Unit. price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(product, index) in products">
                                                <td><input type="checkbox" v-model="product.isTrue" @change="change_checkbox(currentWarehouseId, product.product_id, product.product_color_id, index, product.product_name, product.product_color_name)" name=""></td>
                                                <td>{{index + 1}}</td>
                                                <td>{{product.product_name}}</td>
                                                <td>{{product.product_color_name}}</td>
                                                <td style="text-align:right;">{{product.product_qty}}</td>
                                                <td style="text-align:right;">{{product.per_item_price | currency('Rs')}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="text" v-model="imei" placeholder="Enter Imeis" class="textbox">
                                            </div>
                                            <div class="col-md-6">
                                                <Label>Manual: </Label>
                                                <input type="checkbox" v-model="manual_enabled"/>
                                                <button class="btn btn-success" v-on:click="add_manual($event)" :disabled="manual_enabled==0">Submit</button>
                                            </div>
                                        </div>


                                </div>
                                <div class="col-md-12" style="margin-top: 20px;">

                                    <div class="row" style="margin-top:10px;">
                                        <div class="col-md-6">
                                            <h4>Available Imei(s)</h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="col-md-1">S.No</th>
                                                    <th>IMEI</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(selected_products, index) in all_selected_products">
                                                    <td v-if="selected_products.is_selected" style="background:green; color:#fff;">{{index + 1}}</td>
                                                    <td v-else>{{index+1}}</td>
                                                    <td v-if="selected_products.is_selected" style="background:green; color:#fff;">{{selected_products.imei1}}</td>
                                                    <td v-else>{{selected_products.imei1}}</td>

                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">

                                            <h4>Selected Imei(s)</h4>
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th class="col-md-1">S.No</th>
                                                    <th>IMEI</th>
                                                    <th>Model</th>
                                                    <th class="col-md-1">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(imei, index) in newIssueItems.imei">
                                                    <td>{{index + 1}}</td>
                                                    <td>{{imei.imei}}</td>
                                                    <th>{{imei.model_name}}</th>
                                                    <td class="text-center"><button class="btn btn-danger btn-xs" @click="removeIMEI(index)" title="Delete"><i class="fa fa-times"></i></button></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                                <div class="col-md-4">
                                    <input type="submit" class="btn btn-default" value="Submit">

                                </div>
                                        </div>
                                    </div>

                                </div>
                               
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="created" class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Details</div>

                    <div class="panel-body">
                      <table class="table table-border">
                        <thead>
                          <tr>
                            <th>S.No</th>
                            <th>IMEI 1</th>
                            <th>IMEI 2</th>
                            <th>Product Name</th>
                            <th>Product Color</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item,index) in createdData.warehouse_issue_item">
                            <td>{{index + 1}}</td>
                            <td>{{item.item.imei[0].imei1}}</td>
                            <td>{{item.item.imei[0].imei2}}</td>
                            <td>{{item.item.product_color.product.name}}</td>
                            <td>{{item.item.product_color.color}}</td>
                          </tr>
                        </tbody>
                      </table>
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
            selected_model:'',
            recent_selected_index:'',
            selected_qty:0,
            all_selected_products:[],
            currentWarehouseId:'',
            currentWarehouse:'',
            manual_enabled:false,
            invoice_detail_enabled:0,
          issueRequests:[],
          detailedMessage:'',
          warehouseissue:'',

           selected_invoice_No:'',
           selected_total_Amount:'',
           selected_created_at:'',
            selected_outlet_name:'',
            products:[],

          imei:'',
          createdData:'',
          created:false,
          newIssueItems:{
            warehouseIssue_id:'',
            invoice_id:'',
            imei:[],
          }
        }
      },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
          axios.get('./warehouseIssueRequest').then(response=>{
            this.issueRequests=response.data;
            console.log("DATA"+response.data);
          })


            axios.get('./currentWarehouse').then(response=>{
                this.currentWarehouse=response.data.name;
                this.currentWarehouseId=response.data.id;

            });
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            },

            getdate: function (date) {
                return moment(date).format('DD');
            },

            getmonth: function (date) {
                return moment(date).format('MM');
            },
        },
        watch: {
            warehouseissue: function () {
                if (this.warehouseIssue != '') {
                    this.newIssueItems.invoice_id = this.warehouseissue.invoice_id;
                    this.newIssueItems.warehouseIssue_id = this.warehouseissue.id;
                    //console.log(this.warehouseissue.invoice_id);

                }
            },
            imei: function () {
                if (this.manual_enabled == false) {
                    if (this.imei.length >= 15) {
                        if (this.imei != '') {
                            var isanytrue = 0;
                            for (var i = 0; i < this.products.length; i++) {
                                //alert(this.newTransfer.details[i].isTrue);
                                if (this.products[i].isTrue) {
                                    isanytrue = 1;
                                    break;
                                }
                            }

                            var isFound = 0;
                            var isrepeated = 0;
                            var item_id = 0;
                            if (isanytrue == 1) {
                                if (this.newIssueItems.imei.length < this.selected_qty) {
                                    for (var i = 0; i < this.all_selected_products.length; i++) {
                                        if (this.all_selected_products[i].imei1 == this.imei) {
                                            isFound = 1;
                                            item_id = this.all_selected_products[i].item_id;
                                            for (var j = 0; j < this.newIssueItems.imei.length; j++) {
                                                if (this.imei == this.newIssueItems.imei[j].imei) {
                                                    isrepeated = 1;
                                                    break;
                                                }
                                            }
                                        }
                                    }

                                    if (isFound == 1 && isrepeated == 0) {
                                        this.newIssueItems.imei.push({
                                            imei_for: this.recent_selected_index,
                                            imei: this.imei,
                                            item_id: item_id,
                                            model_name:this.selected_model,
                                        });

                                        this.imei = '';
                                        isFound = 1;

                                    }
                                    else if (isFound == 1 && isrepeated == 1) {
                                        alert('This Imei is already Scanned');
                                        this.imei = '';
                                    }
                                    else if (isFound == 0) {
                                        alert('Incorrect Imei');
                                        this.imei = '';
                                    }
                                }
                                else{
                                    alert('Product Limit Exceed');
                                    this.imei='';
                                }



                                //console.log(this.newItems.imei);
                            }
                            else{
                                alert('Please Select any Product');
                                this.imei='';
                            }
                        }
                    }
                }
            }
        },
        methods:{
          showDetailedMessage(message){
            this.detailedMessage = message;
            $('#div_detailed_message').modal("show");
          },
          removeIMEI(index){
            event.preventDefault();
            this.newIssueItems.imei.splice(index,1);
          },
          createIssue(e){
            e.preventDefault();
            console.log(this.newIssueItems);
            axios.post('./createIssue',this.newIssueItems).then(response=>{
              if(response.data.replay==0){
                this.created=true,
                this.createdData=response.data.data,
                console.log(response.data);
                this.newIssueItems={
                  warehouseIssue_id:'',
                  invoice_id:'',
                  imei:[],
                },
                this.warehouseissue=''
              }else if (response.data.replay==2) {
                alert(response.data.data);
              }else{
                console.log(response.data);
                this.showDetailedMessage(response.data);
              }
            })
          },
            get_invoice_details:function(e){
                e.preventDefault();
                if(this.newIssueItems.invoice_id!=''){
                    this.products=[];
                    axios.get('./getProducts/'+this.warehouseissue.invoice_id).then(response=>{
                        //this.products=response.data.invoice_product;
                        this.selected_invoice_No=response.data.invoice_no;
                        this.selected_total_Amount=response.data.total_amount;
                        this.selected_created_at=response.data.created_at;
                        this.selected_outlet_name=response.data.order.retailer_outlet.name;


                        for(var i=0; i<response.data.invoice_product.length; i++){
                            this.products.push({
                                isTrue:false,
                                invoice_id:response.data.invoice_product[i].invoice_id,
                                product_color_id:response.data.invoice_product[i].product_color.id,
                                product_id:response.data.invoice_product[i].product_color.product.id,
                                product_color_name:response.data.invoice_product[i].product_color.color,
                                product_name:response.data.invoice_product[i].product_color.product.name,
                                product_qty:response.data.invoice_product[i].product_qty,
                                per_item_price:response.data.invoice_product[i].product_color.price,
                            });
                        }

                        //console.log(this.products);
                    })
                    this.invoice_detail_enabled=1;
                }
                else{
                    this.showDetailedMessage("Please select invoice");
                    this.invoice_detail_enabled=0;
                }

            },
            add_manual:function(e){
                e.preventDefault();
                if (this.imei != '') {
                    var isanytrue = 0;
                    for (var i = 0; i < this.products.length; i++) {
                        //alert(this.newTransfer.details[i].isTrue);
                        if (this.products[i].isTrue) {
                            isanytrue = 1;
                            break;
                        }
                    }

                    var isFound = 0;
                    var isrepeated = 0;
                    var item_id = 0;
                    if (isanytrue == 1) {
                        if (this.newIssueItems.imei.length < this.selected_qty) {
                            for (var i = 0; i < this.all_selected_products.length; i++) {
                                if (this.all_selected_products[i].imei1 == this.imei) {
                                    isFound = 1;
                                    item_id = this.all_selected_products[i].item_id;
                                    for (var j = 0; j < this.newIssueItems.imei.length; j++) {
                                        if (this.imei == this.newIssueItems.imei[j].imei) {
                                            isrepeated = 1;
                                            break;
                                        }
                                    }
                                }
                            }

                            if (isFound == 1 && isrepeated == 0) {
                                this.newIssueItems.imei.push({
                                    imei_for: this.recent_selected_index,
                                    imei: this.imei,
                                    item_id: item_id,
                                    model_name:this.selected_model,
                                });

                                this.imei = '';
                                isFound = 1;

                            }
                            else if (isFound == 1 && isrepeated == 1) {
                                alert('This Imei is already Scanned');
                                this.imei = '';
                            }
                            else if (isFound == 0) {
                                alert('Incorrect Imei');
                                this.imei = '';
                            }
                        }
                        else{
                            alert('Product Limit Exceed');
                            this.imei='';
                        }



                        //console.log(this.newItems.imei);
                    }
                    else{
                        alert('Please Select any Product');
                        this.imei='';
                    }
                }
            },
            change_checkbox(warehouse_id, product_id, product_color_id, index, product_name, product_color){

                //for(var i=0; i< this.newTransfer.details.length; i++){
                //    if(this.newTransfer.details[i].isTrue){
                //        this.selected_qty= parseInt(this.selected_qty)+parseInt(this.newTransfer.details[i].transferQty);
                //    }
                // }
                //alert(this.selected_qty);

                if(this.products[index].isTrue){
                    if(this.selected_qty==this.newIssueItems.imei.length) {
                        this.all_selected_products = [];
                        this.selected_qty += this.products[index].product_qty;
                        //alert(this.selected_qty);
                        this.recent_selected_index = index;
                        this.selected_model= product_name+'('+product_color+')';


                        axios.post('./get_specific_warehouse_items',{warehouse_id: warehouse_id,product_id: product_id,product_color_id: product_color_id}).then(response=>{
                            //this.all_selected_products=response.data;
                            for(var i=0; i<response.data.length; i++){
                                this.all_selected_products.push({imei1:response.data[i].imei1, is_selected:0, item_id:response.data[i].item_id});
                            }
                        });
                    }
                    else{
                        alert("First Scan the items of currently selected product!");
                        this.products[index].isTrue=false;
                    }
                }
                else{
                    var result=confirm("Are you sure, You want to uncheck? It'll lose all the scanned imei's of this product!");
                    if(result){
                        this.selected_qty-=this.products[index].product_qty;

                        for(var i=this.newIssueItems.imei.length-1; i>=0; i--){
                            if(this.newIssueItems.imei[i].imei_for==index){
                                //this.newTransfer.items.splice(i, 1);
                                this.removeIMEI(i, this.newIssueItems.imei[i].imei);

                            }
                        }

                        //this.all_selected_products=[];
                    }
                    else{
                        this.products[index].isTrue=true;

                    }
                }


            },
            removeIMEI(index, selected_imei){
                event.preventDefault();

                this.newIssueItems.imei.splice(index,1);

            },


        }
//this.$validator.validateAll().then( (result) => {}
    }
</script>

<style>
  .v-select .dropdown-toggle .clear{
  bottom: 6px;
  }
  .v-select .dropdown-toggle{
  border-radius:0px;
  }

  .invoice_details{
  padding: 10px;
  margin-top:10px;
  border-top: 2px solid #bce8f1;
  }
</style>

