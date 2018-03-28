<template>
    <div class="row">
    <!--<div class="col-md-4 panel panel-default">-->
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">Add New Bank</h2>
            </div>
            <div class="panel-body">
                <form @submit="createBank">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Bank Name<span style="color:red;">*</span></label>
                        </div>
                        <div class="col-md-3">
                              <input name="bank_name" type="text" class="textbox"  v-model="bankData.bank_name">
                                <span class="text-danger" v-show="errors.has('bank_name')">
                                    {{errors.first('bank_name')}}
                                </span>
                        </div>
                        <div class="col-md-1"></div>

                        <div class="col-md-2">
                            <label for="Bank" class="control-label">Phone No<span style="color:red;">*</span></label>
                        </div>
                        <div class="col-md-3">
                            <input name="bank_phone_no" type="text" class="textbox"  v-model="bankData.bank_phone_no">
                            <span class="text-danger" v-show="errors.has('bank_phone_no')">
                                {{errors.first('bank_phone_no')}}
                            </span>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <label for="Bank" class="control-label">City<span style="color:red;">*</span></label>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <select class="textbox" name="city" v-validate="'required'" v-model="bankData.city_id">
                                    <option value="">Select City</option>
                                    <option v-for="city in cities" v-bind:value="city.id">{{city.name}}</option>
                                </select>
                                <span class="text-danger" v-show="errors.has('city')">
                                        {{errors.first('city')}}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-1"></div>

                        <div class="col-md-6">
                            <!--<button v-if="editing==true" @click="saveEditing" class="btn btn-default col-md-6">Save Editing</button>-->
                            <!--<button v-if="editing==false" @click="showCities" class="btn btn-default col-md-6" data-toggle="collapse" data-target="#cities">Bank</button>-->
                            <!--<button v-if="editing==true" @click="cancelEditing" class="btn btn-default col-md-6">Cancel Editing</button>-->
                        <input v-if="editing==false" type="submit" @click="createBank" class="btn btn-tumblr pull-right" value="Create Bank" style="margin-right: 86px;">
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">Bank Details</h2>
            </div>
            <div class="panel-body">
                 <table id="bank_detail_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                    <tr>
                        <th class="col-md-1">S.No</th>
                        <th>Bank Names</th>
                        <th>Bank Phone No</th>
                        <th>Bank City</th>
                        <th class="col-md-1">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(bank,index) in allBanks">
                        <td>{{index +1 }}</td>
                        <td>{{bank.bank_name}}</td>
                        <td>{{bank.bank_uan}}</td>
                        <td>{{bank.name}}</td>
                        <td class="text-center"><button class="btn btn-info btn-xs" @click="edit(index,city.id)" title="Edit"><i class="fa fa-edit"></i></button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
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

    $(document).ready(function() {
        setTimeout(function(){
            $('#bank_detail_table').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search Here",
            }
            });
        },3000);
    });
</script>
