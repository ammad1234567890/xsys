<template>
<div>
    <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">Create New Currency</h2>
            </div>
        <div class="panel-body">
            <div class="alert alert-success"  v-if="message">
              <strong>{{message}}</strong>
            </div>
            <form @submit="createCurrency">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="Currency">Currency</label>
                      <input name="Currency" type="text" class="form-control" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="currency_data.name">
                      <span class="text-danger" v-show="errors.has('Currency')">
                        {{errors.first('Currency')}}
                      </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="ISO">ISO</label>
                      <input name="ISO" type="text" class="form-control" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="currency_data.iso">
                      <span class="text-danger" v-show="errors.has('ISO')">
                        {{errors.first('ISO')}}
                      </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                      <label for="rate">Exhange Rate</label>
                      <input name="rate" type="text" class="form-control" v-validate="'required|regex:^[0-9]+$'" v-model="currency_data.exchange_rate">
                      <span class="text-danger" v-show="errors.has('rate')">
                        {{errors.first('rate')}}
                      </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <input v-if="editing==false" type="submit" class="btn btn-tumblr" value="Add Currency">
                      <button v-if="editing==true" @click="saveEditing" class="btn btn-tumblr">Save Editing</button>
                      <button v-if="editing==false" @click="showCities" class="btn btn-github" data-toggle="collapse" data-target="#currencies">Show Currencies</button>
                      <button v-if="editing==true" @click="cancelEditing" class="btn btn-pinterest">Cancel Editing</button>
                    </div>
                </div>                
            </form>
        </div>

        <div id="currencies" class="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Currency List</h2>
            </div>
            <div class="panel-body">
                <table class="table table-bordered col-md-12">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Currency</th>
                        <th>ISO</th>
                        <th>Exhange Rate</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(currency,index) in allCurrency">
                        <td>{{index +1 }}</td>
                        <td>{{currency.name}}</td>
                        <td>{{currency.iso}}</td>
                        <td>{{currency.exchange_rate}}</td>
                        <td><button class="btn btn-info btn-sm" @click="edit(index,currency.id)">Edit</button></td>
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
             allCurrency:[],
             currency_data:{
               id:'',
               name:'',
               iso:'',
               exchange_rate:''
             },
           }
         },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            this.get_currencies();
        },
        methods:{
            createCurrency(e){
            e.preventDefault();
            axios.post('./add_currency',this.currency_data).then(response=>{
              if(response.data==201){
                  this.get_currencies();
                      this.currency_data.name='';
                      this.currency_data.iso='';
                      this.currency_data.exchange_rate='';
                  this.message="Added Successfully!";
              }else{
                alert('Fail to create Currency');
                console.log(response.data);
              }
            })
          },
            get_currencies:function(){
                axios.get('./get_currencies').then(response=>{
                    this.allCurrency=response.data;
                })
            },
          edit(index,id){
            this.editIndex=index;
            this.editing=true;
            this.cityData={
              id:this.allCities[index].id,
              city:this.allCities[index].name
            }
          },
          saveEditing(e){
            e.preventDefault();
            axios.post('../editCity',this.cityData).then(response=>{
               if(response.data.return == 0){
                 this.allCities[this.editIndex].name=this.cityData.city;
                 this.cityData={
                   city:''
                 };
                 this.editing=false;
                 this.editIndex='';
               }else{
                 alert('Fail to Edit Currency');
                 console.log(response.data.data);
               }
            });
          },
          showCities(e){
            e.preventDefault();
          },
          cancelEditing(e){
            e.preventDefault();
            this.cityData={
              city:''
            };
            this.editing=false;
            this.editIndex='';
          }
        }//End of Methods
    }//End Of Script
</script>
