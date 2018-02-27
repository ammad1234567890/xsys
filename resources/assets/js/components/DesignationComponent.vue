<template>
    <div class="col-md-4 panel panel-default">
      <div class="panel-body">
      <form @submit="createDesignation">
        <div class="form-group">
          <label for="designation">Designation</label>
          <input name="designation" type="text" class="form-control" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="designationData.designation">
          <span class="text-danger" v-show="errors.has('designation')">
            {{errors.first('designation')}}
          </span>
        </div>
        <div class="form-group">
          <input v-if="editing==false" type="submit" class="btn btn-default col-md-6" value="Create Designation">
          <button v-if="editing==true" @click="saveEditing" class="btn btn-default col-md-6">Save Editing</button>
          <button v-if="editing==false" @click="showDesignations" class="btn btn-default col-md-6" data-toggle="collapse" data-target="#designation">Designations</button>
          <button v-if="editing==true" @click="cancelEditing" class="btn btn-default col-md-6">Cancel Editing</button>
        </div>
      </form>
      <div id="designation" class="collapse panel panel-default col-md-12">
        <table class="table table-bordered col-md-12">
            <thead>
              <tr>
                <th>S.No</th>
                <th>Designations</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(designation,index) in allDesignations">
                <td>{{index +1 }}</td>
                <td>{{designation.designation}}</td>
                <td><button class="btn btn-default" @click="edit(index,designation.id)">Edit</button></td>
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
             allDesignations:[],
             designationData:{
               id:'',
               designation:''
             },
           }
         },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('/allDesignations').then(response=>{
              //console.log(response.data);
              this.allDesignations=response.data;
            })
        },
        methods:{
          createDesignation(e){
            e.preventDefault();
            axios.post('/createDesignation',this.designationData).then(response=>{
              if(response.data.return==0){
                //console.log(response.data.data);
                this.allDesignations.push(response.data.data);
                this.designationData={
                  designation:''
                }
              }else{
                alert('Fail to create Designation');
                console.log(response.data.data);
              }
            })
          },
          edit(index,id){
            this.editIndex=index;
            this.editing=true;
            this.designationData={
              id:this.allDesignations[index].id,
              designation:this.allDesignations[index].designation
            }
          },
          saveEditing(e){
            e.preventDefault();
            axios.post('/editDesignation',this.DesignationData).then(response=>{
               if(response.data.return == 0){
                 this.allDesignations[this.editIndex].designation=this.designationData.designation;
                 this.designationData={
                   designation:''
                 };
                 this.editing=false;
                 this.editIndex='';
               }else{
                 alert('Fail to Edit Designation');
                 console.log(response.data.data);
               }
            });
          },
          showDesignations(e){
            e.preventDefault();
          },
          cancelEditing(e){
            e.preventDefault();
            this.designationData={
              designation:''
            };
            this.editing=false;
            this.editIndex='';
          }
        }//End of Methods
    }//End Of Script
</script>
