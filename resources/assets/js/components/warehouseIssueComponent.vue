<template>
    <div>
      <div class="row">
          <div class="card headcolor">
              <div class="card-header">
                      <h3 class="card-title pad-bot"><i class="material-icons">store</i> <small>SALE INVOICE </small> </h3>
              </div>
          </div>
      </div>
        <div v-if="!created" class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h2 class="panel-title">Sale Invoice</h2>
                    </div>

                    <div class="panel-body">
                        <form @submit="createIssue">
                          <div class="row">
                              <div class="col-md-2">
                                <label for="Name">Invoice ID</label>
                              </div>
                              <div class="col-md-3">
                                  <v-select label="invoice_id" :filterable="false" v-model="warehouseissue" :options="issueRequests"></v-select>
                              </div>
                              <div class="col-md-1"></div>

                              <div class="col-md-2">
                                    <label for="">IMEI</label>
                              </div>
                              <div class="col-md-3">
                                    <input type="text" v-model="imei" class="textbox">
                              </div>
                              <div class="col-md-1"></div>
                          </div>

                          <div class="col-md-12" style="margin-top: 20px;">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>IMEI</th>
                                        <th>Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(imei, index) in newIssueItems.imei">
                                        <td>{{index + 1}}</td>
                                        <td>{{imei}}</td>
                                        <td><button class="btn btn-danger" @click="removeIMEI(index)">Remove</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="submit" class="btn btn-round btn-tumblr fixedbutton" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="created" class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Details</div>

                    <div class="panel-body">
                      <table class="table table-border">
                        <thead>
                          <tr>
                            <th>S.No</th>
                            <th>Item Id</th>
                            <th>IMEI 1</th>
                            <th>IMEI 2</th>
                            <th>Product Name</th>
                            <th>Product Color</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item,index) in createdData.warehouse_issue_item">
                            <td>{{index + 1}}</td>
                            <td>{{item.item_id}}</td>
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
          //invoice:'',
          issueRequests:[],
          warehouseissue:'',
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
        },
        watch:{
          warehouseissue:function(){
            if(this.warehouseIssue!=''){
              this.newIssueItems.invoice_id=this.warehouseissue.invoice_id;
              this.newIssueItems.warehouseIssue_id=this.warehouseissue.id;
              //console.log(this.warehouseissue.invoice_id);
              axios.get('./getProducts/'+this.warehouseissue.invoice_id).then(response=>{
                this.products=response.data.invoice_product;
                console.log(response.data);
              })
            }
          },
          imei:function(){
              if(this.imei!=''){
                this.newIssueItems.imei.push(this.imei);
                //this.newIssueItems.quantity +=1;
                this.imei='';
                //console.log(this.newItems.imei);
            }
          }
        },
        methods:{
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
                alert('Fail to insert');
              }
            })
          }
        }
//this.$validator.validateAll().then( (result) => {}
    }
</script>
