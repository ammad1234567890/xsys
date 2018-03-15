<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Role</div>

                    <div class="panel-body">
                        <form v-on:submit="addPermission">
                            <div class="form-group col-md-6">
                                <label for="roleName">Role Name</label>
                                <input type="text" class="form-control" v-model="newRolePermission.roleName" name="roleName" placeholder="Role Name" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="permission">Permissions</label>
                                <v-select multiple label="permission" v-model="newRolePermission.selected" :options="permissions" required></v-select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="roleName">Role Description</label>
                                <textarea name="roleDescription" rows="2" v-model="newRolePermission.description" class="col-md-12 form-control">

                                </textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="submit" value="Submit" v-if="editing==0" class="btn btn-default" />
                                <button  class="btn btn-default" v-on:click="saveEditing" v-if="editing==1">Save Editing</button>
                                <button  class="btn btn-default" v-on:click="cancelEding" v-if="editing==1">Cancel Editing</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Role</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(role, index) in rolePermission">
                                <td>{{index + 1}}</td>
                                <td>{{role.role}}</td>
                                <td><span v-for="permission in role.permission" class="btn btn-default" data-toggle="tooltip" v-bind:title="permission.description" >{{permission.permission}} </span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Action
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" v-on:click="edit(index)">Edit</a></li>
                                            <li><a href="#" v-on:click="deleteRole(role.id,index)">Delete</a></li>
                                        </ul>
                                    </div>
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
            permissions:[],
            newRolePermission:{
              id:'',
              roleName:'',
              selected: null,
              description:''
            },
            rolePermission:{}
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
          axios.get('./permissions').then(response=>{
            this.permissions=response.data;
          }),
          axios.get('./role').then(response=>{
            this.rolePermission=response.data;
          })
        },
        methods:{
            addPermission:function(e){
              e.preventDefault();
                axios.post('./createrole',this.newRolePermission).then(response=>{
                  if(response.data==0){
                    this.newRolePermission={
                        id:'',
                        roleName:'',
                        selected: null,
                        description:''
                      }
                  }
                  else{
                    alert("Fail to create role");
                  }
                })
            },

            edit:function(id){
              this.editIndex=id;
              this.editing=1;
              this.newRolePermission={
                  id:this.rolePermission[id].id,
                  roleName:this.rolePermission[id].role,
                  selected:this.rolePermission[id].permission,
                  description:this.rolePermission[id].description
                }
            },

            saveEditing:function(e){
              e.preventDefault();
              axios.post('./editRole',this.newRolePermission).then(response=>{
                if(response.data==0){
                  var index=this.editIndex;
                  this.rolePermission[index].role=this.newRolePermission.roleName;
                  this.rolePermission[index].permission=this.newRolePermission.selected;
                  this.rolePermission[index].description=this.newRolePermission.description;
                  this.newRolePermission={
                      id:'',
                      roleName:'',
                      selected: null,
                      description:''
                    }
                    this.editing=0;
                    this.editIndex=null;

                }else{
                  alert('Fail to Edit data');
                }
              })
            },

            cancelEding:function(){
              this.newRolePermission={
                  id:'',
                  roleName:'',
                  selected: null,
                  description:''
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
