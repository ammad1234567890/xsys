<template>
<div>
    <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">Create New Payment Type</h2>
            </div>
        <div class="panel-body">
            <div class="alert alert-success"  v-if="message">
              <strong>{{message}}</strong>
            </div>
            
              <form @submit="createPaymentType">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="PaymentType">Payment Type</label>
                          <input name="PaymentType" type="text" class="form-control" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="payment_data.type">
                          <span class="text-danger" v-show="errors.has('PaymentType')">
                            {{errors.first('PaymentType')}}
                          </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <input v-if="editing==false" type="submit" class="btn btn-tumblr" value="Create Payment Method">
                          <button v-if="editing==true" @click="saveEditing" class="btn btn-tumblr">Save Editing</button>
                          <button v-if="editing==false" @click="showStaffType" class="btn btn-github" data-toggle="collapse" data-target="#paymentType">Show Payment Methods</button>
                          <button v-if="editing==true" @click="cancelEditing" class="btn btn-pinterest">Cancel Editing</button>
                        </div>
                    </div>
              </form>
        </div>              
        <div id="paymentType" class="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Payment Type List</h2>
            </div>
            <div class="panel-body">
                <table class="table table-bordered col-md-12">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Payment Type</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(payment_method,index) in all_payment_methods">
                        <td>{{index +1 }}</td>
                        <td>{{payment_method.type}}</td>
                        <td><button class="btn btn-info btn-sm" @click="edit(index,payment_method.id)">Edit</button></td>
                      </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
         data(){
           return{
               message:'',
             editIndex:'',
             editing:false,
             all_payment_methods:[],
             payment_data:{
               id:'',
               type:''
             },
           }
         },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            this.get_all_paymentMethods();
        },
        methods:{
            createPaymentType(e){
            e.preventDefault();
            axios.post('./add_payment',this.payment_data).then(response=>{
              if(response.data==201){
                //console.log(response.data.data);
                  this.payment_data.type='';
                this.get_all_paymentMethods();
                this.message="Added Successfully!";
              }else{
                alert('Fail to create Payment Type');
                console.log(response.data.data);
              }
            })
          },
            get_all_paymentMethods(){
                axios.get('./get_payment_types').then(response=>{
                    //console.log(response.data);
                    this.all_payment_methods=response.data;
                })
            },
          edit(index,id){
            this.editIndex=index;
            this.editing=true;
            this.staffTypeData={
              id:this.allStaffType[index].id,
              staffType:this.allStaffType[index].type
            }
          },
          saveEditing(e){
            e.preventDefault();
            axios.post('./editStaffType',this.staffTypeData).then(response=>{
               if(response.data.return == 0){
                 this.allStaffType[this.editIndex].name=this.staffTypeData.staffType;
                 this.staffTypeData={
                   staffType:''
                 };
                 this.editing=false;
                 this.editIndex='';
               }else{
                 alert('Fail to Edit Staff Type');
                 console.log(response.data.data);
               }
            });
          },
          showStaffType(e){
            e.preventDefault();
          },
          cancelEditing(e){
            e.preventDefault();
            this.staffTypeData={
              staffType:''
            };
            this.editing=false;
            this.editIndex='';
          }
        }//End of Methods
    }//End Of Script
</script>
