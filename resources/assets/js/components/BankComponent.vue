<template>
    <!--<div class="col-md-4 panel panel-default">-->
        <div class="col-md-12 panel panel-default">
        <h3 style="margin-top: 6px; font-variant: small-caps; font-weight:bold;">Add Bank</h3>
        <hr/>
            <form @submit="createBank">
               <div class="form-group">
                   <label for="Bank">Bank Name</label>
                  <input name="bank_name" type="text" class="form-control"  v-model="bankData.bank_name">
                    <!--<span class="text-danger" v-show="errors.has('bank_name')">-->
            <!--{{errors.first('city')}}-->
          <!--</span>-->
                </div>
                <div class="form-group">
                    <label for="Bank">Bank Phone No</label>
                    <input name="bank_phone_no" type="text" class="form-control"  v-model="bankData.bank_phone_no">
                    <!--<span class="text-danger" v-show="errors.has('bank_name')">-->
                    <!--{{errors.first('city')}}-->
                    <!--</span>-->
                </div>
                <div class="form-group">
                    <select class="form-control" name="city" v-validate="'required'" v-model="bankData.city_id">
                        <option value="">Select City</option>
                        <option v-for="city in cities" v-bind:value="city.id">{{city.name}}</option>
                    </select>
                    <!--<span class="text-danger" v-show="errors.has('city')">-->
                            <!--{{errors.first('city')}}-->
                          <!--</span>-->
                </div>
                <div class="form-group">
                    <!--<button v-if="editing==true" @click="saveEditing" class="btn btn-default col-md-6">Save Editing</button>-->
                    <!--<button v-if="editing==false" @click="showCities" class="btn btn-default col-md-6" data-toggle="collapse" data-target="#cities">Bank</button>-->
                    <!--<button v-if="editing==true" @click="cancelEditing" class="btn btn-default col-md-6">Cancel Editing</button>-->
                </div>
                <input v-if="editing==false" type="submit" @click="createBank" class="btn btn-default" value="Create Bank">
            </form>
        </BR>

            <h3 style="margin-top: 6px; font-variant: small-caps; font-weight:bold;">Bank Details</h3>
            <hr/>
            <div id="Bank" class="collapse panel panel-default col-md-12">
                <table class="table table-bordered col-md-12">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Bank Names</th>
                        <th>Bank Phone No</th>
                        <th>Bank City</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(bank,index) in allBanks">
                        <td>{{index +1 }}</td>
                        <td>{{bank.bank_name}}</td>
                        <td>{{bank.bank_phone_no}}</td>
                        <td>{{bank.name}}</td>
                        <td><button class="btn btn-default" @click="edit(index,city.id)">Edit</button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
    </div>
</template>

<script>
    export default {

        data(){
            return{
                editIndex:'',
                editing:false,
                allBanks:[],
                cities:[],
                bankData:{
                    bank_name:'',
                    bank_phone_no:'',
                    city_id:''
                },
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('./allBanks').then(response=>{
                this.allBanks=response.data;
            });
            axios.get('./generalData').then(response=>{
                this.cities=response.data.city;
            });
        },
        methods:{
            createBank(e){
                e.preventDefault();
                axios.post('./createBank',this.bankData).then(response=>{
                    if(response.data.return==0){
                        this.allBanks.push(response.data.data);
                        this.bankData={
                            bank_name:'',
                            bank_phone_no:'',
                            city_id:''
                        }
                    }else{
                        alert('Fail to create city');
                        console.log(response.data.data);
                    }
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
                        alert('Fail to Edit City');
                        console.log(response.data.data);
                    }
                });
            },
        }
    }
</script>
