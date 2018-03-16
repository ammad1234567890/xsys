<template>
    <div >
      <div class="row">
          <div class="card headcolor">
              <div class="card-header">
                      <h3 class="card-title pad-bot"><i class="material-icons">store</i> <small>WAREHOUSE ISSUE </small> </h3>
              </div>
          </div>
      </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Warehouse Issue</div>

                    <div class="panel-body">
                        <form @submit="createIssue">
                          <div class="form-group col-md-12">
                            <label for="Name">Invoice ID</label>
                              <v-select label="invoice_id" :filterable="false" v-model="warehouseissue" :options="issueRequests"></v-select>
                          </div>
                          <div class="form-group col-md-12">
                                <label for="">IMEI</label>
                                <input type="text" v-model="imei" class="form-control">
                          </div>
                          <div class="col-md-12">
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
                         <!--  <div class="form-group col-md-6">
                            <label for="Name">Invoice ID</label>
                              <!-- <v-select label="product_color.color" :filterable="false" :options="products"></v-select> -->
                              <!-- <select class="form-control" >
                                  <option></option>
                                  <option v-for="p in products">{{p.product_color.color}}| {{ p.product_color.product.name}}</option>
                              </select>
                          </div> --> 
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
          //invoice:'',
          issueRequests:[],
          warehouseissue:'',
          products:[],
          imei:'',
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
            console.log(response.data);
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
              if(response.data==0){
                this.newIssueItems={
                  warehouseIssue_id:'',
                  invoice_id:'',
                  imei:[],
                },
                this.warehouseissue=''
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
