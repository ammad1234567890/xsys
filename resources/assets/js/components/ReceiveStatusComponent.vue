<template>
<div>
    <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">Create New Receive Status</h2>
            </div>
            <div class="panel-body">
                <div class="alert alert-success"  v-if="message">
                    <strong>{{message}}</strong>
                </div>
                <form @submit="receiveStatusSubmit">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ReceiveStatusName">Receive Status</label>
                            <input name="ReceiveStatusName" type="text" class="form-control" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="receive_status.name">
                            <span class="text-danger" v-show="errors.has('ReceiveStatusName')">
                            {{errors.first('ReceiveStatusName')}}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input v-if="editing==false" type="submit" class="btn btn-tumblr" value="Create Status">
                            <button v-if="editing==true" @click="saveEditing" class="btn btn-tumblr">Save Editing</button>
                            <button v-if="editing==false" @click="showStaffType" class="btn btn-github" data-toggle="collapse" data-target="#ReceiveStatus">Show Receive Status</button>
                            <button v-if="editing==true" @click="cancelEditing" class="btn btn-pinterest">Cancel Editing</button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="ReceiveStatus" class="collapse">
                <div class="panel-heading">
                    <h2 class="panel-title">Receive Status List</h2>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered col-md-12">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(receive_status,index) in all_receive_status">
                            <td>{{index +1 }}</td>
                            <td>{{receive_status.status}}</td>
                            <td><button class="btn btn-info btn-sm" @click="edit(index,receive_status.id)">Edit</button></td>
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
                all_receive_status:[],
                receive_status:{
                    id:'',
                    name:'',
                },
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            this.get_all_receive_status();
        },
        methods:{
            receiveStatusSubmit(e){
                e.preventDefault();
                axios.post('./order/add_status',this.receive_status).then(response=>{
                    if(response.data==201){
                        //console.log(response.data.data);
                        this.receive_status.name='';
                        this.get_all_receive_status();
                        this.message="Added Successfully!";
                    }else{
                        alert('Fail to create Recieve Status');
                        console.log(response.data.data);
                    }
                })
            },
            get_all_receive_status(){
                axios.get('./order/get_status').then(response=>{
                    //console.log(response.data);
                    this.all_receive_status=response.data;
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
