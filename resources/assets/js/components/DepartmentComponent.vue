<template>
    <div class="col-md-4 panel panel-default">
      <div class="panel-body">
      <form @submit="createDepartment">
        <div class="form-group">
          <label for="Department">Department</label>
          <input name="department" type="text" class="form-control" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="departmentData.department">
          <span class="text-danger" v-show="errors.has('department')">
            {{errors.first('department')}}
          </span>
        </div>
        <div class="form-group">
          <input v-if="editing==false" type="submit" class="btn btn-default col-md-6" value="Create Department">
          <button v-if="editing==true" @click="saveEditing" class="btn btn-default col-md-6">Save Editing</button>
          <button v-if="editing==false" @click="showDepartments" class="btn btn-default col-md-6" data-toggle="collapse" data-target="#department">Departments</button>
          <button v-if="editing==true" @click="cancelEditing" class="btn btn-default col-md-6">Cancel Editing</button>
        </div>
      </form>
      <div id="department" class="collapse panel panel-default col-md-12">
        <table class="table table-bordered col-md-12">
            <thead>
              <tr>
                <th>S.No</th>
                <th>Departments</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(department,index) in allDepartments">
                <td>{{index +1 }}</td>
                <td>{{department.name}}</td>
                <td><button class="btn btn-default" @click="edit(index,department.id)">Edit</button></td>
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
             allDepartments:[],
             departmentData:{
               id:'',
               department:''
             },
           }
         },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('/allDepartments').then(response=>{
              //console.log(response.data);
              this.allDepartments=response.data;
            })
        },
        methods:{
          createDepartment(e){
            e.preventDefault();
            axios.post('/createDepartment',this.departmentData).then(response=>{
              if(response.data.return==0){
                //console.log(response.data.data);
                this.allDepartments.push(response.data.data);
                this.departmentData={
                  department:''
                }
              }else{
                alert('Fail to create Department');
                console.log(response.data.data);
              }
            })
          },
          edit(index,id){
            this.editIndex=index;
            this.editing=true;
            this.departmentData={
              id:this.allDepartments[index].id,
              department:this.allDepartments[index].name
            }
          },
          saveEditing(e){
            e.preventDefault();
            axios.post('/editDepartment',this.departmentData).then(response=>{
               if(response.data.return == 0){
                 this.allDepartments[this.editIndex].name=this.departmentData.department;
                 this.departmentData={
                   department:''
                 };
                 this.editing=false;
                 this.editIndex='';
               }else{
                 alert('Fail to Edit Department');
                 console.log(response.data.data);
               }
            });
          },
          showDepartments(e){
            e.preventDefault();
          },
          cancelEditing(e){
            e.preventDefault();
            this.departmentData={
              department:''
            };
            this.editing=false;
            this.editIndex='';
          }
        }//End of Methods
    }//End Of Script
</script>
