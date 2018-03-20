<template>
    <div class="col-md-4 panel panel-default">
      <div class="panel-body">
      <form @submit="createStaffType">
        <div class="form-group">
          <label for="StaffType">Staff Type</label>
          <input name="staffType" type="text" class="form-control" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="staffTypeData.staffType">
          <span class="text-danger" v-show="errors.has('staffType')">
            {{errors.first('staffType')}}
          </span>
        </div>
        <div class="form-group">
          <input v-if="editing==false" type="submit" class="btn btn-default col-md-6" value="Create Staff Type">
          <button v-if="editing==true" @click="saveEditing" class="btn btn-default col-md-6">Save Editing</button>
          <button v-if="editing==false" @click="showStaffType" class="btn btn-default col-md-6" data-toggle="collapse" data-target="#staffType">Staff Type</button>
          <button v-if="editing==true" @click="cancelEditing" class="btn btn-default col-md-6">Cancel Editing</button>
        </div>
      </form>
      <div id="staffType" class="collapse panel panel-default col-md-12">
        <table class="table table-bordered col-md-12">
            <thead>
              <tr>
                <th>S.No</th>
                <th>Staff Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(staffType,index) in allStaffType">
                <td>{{index +1 }}</td>
                <td>{{staffType.type}}</td>
                <td><button class="btn btn-default" @click="edit(index,staffType.id)">Edit</button></td>
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
             allStaffType:[],
             staffTypeData:{
               id:'',
               staffType:''
             },
           }
         },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('./allStaffType').then(response=>{
              //console.log(response.data);
              this.allStaffType=response.data;
            })
        },
        methods:{
          createStaffType(e){
            e.preventDefault();
            axios.post('./createStaffType',this.staffTypeData).then(response=>{
              if(response.data.return==0){
                //console.log(response.data.data);
                this.allStaffType.push(response.data.data);
                this.staffTypeData={
                  staffType:''
                }
              }else{
                alert('Fail to create Staff Type');
                console.log(response.data.data);
              }
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

                 this.allStaffType[this.editIndex].type=this.staffTypeData.staffType;
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
