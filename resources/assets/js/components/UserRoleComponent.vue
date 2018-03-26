<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                      <h2 class="panel-title">Assign Role</h2>
                    </div>

                    <div class="panel-body">
                        <form>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="roleName">Users</label>
                                </div>
                                    <!-- <select v-model="newUserRole.user" class="form-control" name="" required>
                                      <option v-for="user in Users"  v-bind:value="user.id">{{user.name}}</option>
                                    </select> -->
                                <div class="col-md-3">
                                    <input type="text" name="user" v-model="newUserRole.user" class="form-control" placeholder="User Name" required>
                                </div>
                                <div class="col-md-1"></div>
                            
                                <div class="col-md-2">
                                        <label for="permission">Role</label>
                                </div>
                                <div class="col-md-3">
                                        <v-select multiple label="role" v-model="newUserRole.roles" :options="Roles" required></v-select>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 20px;">
                                        <button  class="btn btn-primary" v-on:click="saveEditing" v-if="editing==1">Save Editing</button>
                                        <button  class="btn btn-danger" v-on:click="cancelEding" v-if="editing==1">Cancel Editing</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title">Assigned Roles</h2>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="col-md-1">S.No</th>
                                <th>User</th>
                                <th>Roles</th>
                                <th class="col-md-1">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(userRole, index) in UserRoles">
                                <td>{{index + 1}}</td>
                                <td>{{userRole.name}} (<strong>{{userRole.id}}</strong>)</td>
                                <td>
                                    <span class="btn btn-default" v-for="(role, index) in userRole.role" data-toggle="tooltip" v-bind:title="role.description"> {{ role.role }} </span>
                                </td>
                                <td class="text-center">
                                    <!-- <div class="dropdown">
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Action
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" v-on:click="edit(index)">Edit</a></li>
                                            <li><a href="#" v-on:click="deleteRole(role.id,index)">Delete</a></li>
                                        </ul>
                                    </div> -->
                                    <button class="btn btn-primary btn-xs" v-on:click="edit(index)" title="Edit"><i class="fa fa-edit"></i></button>
                                </td>
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
            editing:0,
            editIndex:null,
            Roles:[],
            Users:[],
            UserRoles:{},
            newUserRole:{
              id:'',
              user:'',
              roles: null,
            },
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
          axios.get('./users').then(response=>{
            this.Users=response.data;
          }),
          axios.get('./roles').then(response=>{
            this.Roles=response.data;
          }),
          axios.get('./userroles').then(response=>{
              this.UserRoles=response.data;
          })
        },
        methods:{
            // assignRole:function(e){
            //   e.preventDefault();
            //     axios.post('/assignrole',this.newUserRole).then(response=>{
            //       //console.log(this.newUserRole);
            //       if(response.data==0){
            //         this.newUserRole={
            //           id:'',
            //           user:'',
            //           roles: null,
            //           }
            //       }
            //       else{
            //         alert("Fail to create role");
            //         console.log(response.data);
            //       }
            //     })
            // },

            edit:function(index){
              this.editIndex=index;
              this.editing=1;
              console.log(this.UserRoles[index].name);
              this.newUserRole={
                  id:this.UserRoles[index].id,
                  user:this.UserRoles[index].name,
                  roles:this.UserRoles[index].role,
                }
            },

            saveEditing:function(e){
              e.preventDefault();
              axios.post('./edituserrole',this.newUserRole).then(response=>{
                if(response.data==0){
                  var index=this.editIndex;
                  this.UserRoles[index].name=this.newUserRole.user;
                  this.UserRoles[index].role=this.newUserRole.roles;
                  this.newUserRole={
                      id:'',
                      user:'',
                      roles: null,
                    }
                    this.editing=0;
                    this.editIndex=null;

                }else{
                  alert('Fail to Edit data');
                  console.log(response.data);
                }
              })
            },

            cancelEding:function(e){
              e.preventDefault();
              this.newUserRole={
                  id:'',
                  user:'',
                  roles: null,
                }
                this.editing=0;
                this.editIndex=null;
            },
            deleteRole:function(id,index){
                axios.get('./deleterole/'+id).then(response=>{
                  if(response.data==0){
                    this.rolePermission.splice(index,1);
                  }else{
                    alert("Fail to delete");
                  }
                })
            }
        }
    }
</script>
