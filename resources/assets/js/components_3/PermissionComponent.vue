<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title">Create New Permission</h2>
                    </div>

                    <div class="panel-body">
                        <form>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="roleName">Name</label>
                                </div>
                                <!-- <select v-model="newUserRole.user" class="form-control" name="" required>
                                  <option v-for="user in Users"  v-bind:value="user.id">{{user.name}}</option>
                                </select> -->
                                <div class="col-md-3">
                                    <input type="text" name="name" class="textbox" v-model="permission" placeholder="Permission Name" required>
                                </div>
                                <div class="col-md-1"></div>

                                <div class="col-md-2">
                                    <label for="permission">Description</label>
                                </div>
                                <div class="col-md-3">
                                    <textarea class="textbox" v-model="description" placeholder="Permission Description"></textarea>
                                </div>
                                <div class="col-md-1"></div>

                                <div class="col-md-2">
                                    <label for="permission">Page URL</label>
                                </div>
                                <div class="col-md-3">
                                    <input class="textbox" v-model="url" placeholder="Permission Page URL">
                                </div>
                                <div class="col-md-1"></div>


                            </div>
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <button @click="create_permission($event)" class="btn btn-primary">Save</button>
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
                        <h2 class="panel-title">Permission List</h2>
                    </div>
                    <div class="panel-body">
                        <table id="example" class="display table table-bordered" >
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Permission</th>
                                    <th>Description</th>
                                    <th>Url</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(permis, index) in all_permission">
                                <td>{{index + 1}}</td>
                                <td>
                                    <span  v-if="permis.edit_enabled==false">
                                        <span v-if="permis.permission.length<=24">
                                            {{permis.permission}}
                                        </span>
                                        <span :title="permis.permission" v-else>
                                            {{permis.permission.substr(0, 24)+'...'}}
                                        </span>
                                    </span>
                                    <span v-else>
                                        <input type="text" class="textbox" v-model="permis.edit_permission" />
                                    </span>

                                </td>
                                <td>
                                    <span  v-if="permis.edit_enabled==false">
                                        <span v-if="permis.description.length<=24">
                                            {{permis.description}}
                                        </span>
                                        <span :title="permis.description" v-else>
                                            {{permis.description.substr(0, 24)+'...'}}
                                        </span>
                                    </span>
                                    <span v-else>
                                        <input type="text" class="textbox" v-model="permis.edit_description" />
                                    </span>
                                </td>
                                <td>
                                     <span  v-if="permis.edit_enabled==false">
                                        <span v-if="permis.url.length<=24">
                                            {{permis.url}}
                                        </span>
                                        <span :title="permis.url" v-else>
                                            {{permis.url.substr(0, 24)+'...'}}
                                        </span>
                                    </span>
                                    <span v-else>
                                        <input type="text" class="textbox" v-model="permis.edit_url" />
                                    </span>
                                </td>
                                <td>
                                    <button v-if="permis.edit_enabled==true" v-on:click="save_editing($event, index)" class="btn btn-success">Save</button>
                                    <button v-if="permis.edit_enabled==true" v-on:click="cancel_editing($event, index)" class="btn btn-danger">Cancel</button>

                                    <button v-if="permis.edit_enabled==false" v-on:click="edit_permission($event, index)" class="btn btn-primary">Edit</button>
                                    <button v-if="permis.edit_enabled==false" v-on:click="delete_permission(permis.id,$event)" class="btn btn-danger">Delete</button></td>
                            </tr>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>S.No</th>
                                <th>Permission</th>
                                <th>Description</th>
                                <th>Url</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    export default {
        data(){
            return{
                permission:'',
                description:'',
                url:'',
                all_permission:[],

                edit_enabled:0
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            this.get_all_perimissions();
        },
        methods:{
            get_all_perimissions:function(){
                this.all_permission=[];
                axios.get("./permissions").then((response)=>{
                    for(var i=0; i<response.data.length; i++){
                        this.all_permission.push({
                            edit_enabled:false,
                            id:response.data[i].id,
                            permission:response.data[i].permission,
                            description:response.data[i].description,
                            url:response.data[i].url,
                            edit_permission:response.data[i].permission,
                            edit_description:response.data[i].description,
                            edit_url:response.data[i].url,
                        });
                    }
                });
            },
            create_permission:function(e){
                e.preventDefault();
                axios.post("./create_permission",{'permission': this.permission, description: this.description, url: this.url}).then((response)=>{
                    if(response.data==201){
                        alert("New Permission has been created successfully!");
                        location.reload();
                    }
                    else{
                        alert("Server Request Failed!");
                    }
                });
            },
            delete_permission:function(id, e){
                e.preventDefault();
                var result=confirm("Are you sure, You want to Delete Permission?");

                if(result){
                     axios.post('./delete_permission', {permission_id: id}).then((response)=>{
                         if(response.data==201){
                             alert("Permission has been Deleted!");
                             this.get_all_perimissions();
                         }

                    });
                }

            },
            edit_permission:function(e, index){
                e.preventDefault();
                this.all_permission[index].edit_enabled=true;
            },
            cancel_editing:function(e, index){
                e.preventDefault();
                this.all_permission[index].edit_permission= this.all_permission[index].permission;
                this.all_permission[index].edit_description= this.all_permission[index].description;
                this.all_permission[index].edit_url= this.all_permission[index].url;
                this.all_permission[index].edit_enabled=false;
            },
            save_editing:function(e, index){
                e.preventDefault();
                var result=confirm("Are you sure, You want to Update the Permission?");

                if(result){
                    var update_data={
                        'id': this.all_permission[index].id,
                        'permission': this.all_permission[index].edit_permission,
                        'description': this.all_permission[index].edit_description,
                        'url': this.all_permission[index].edit_url
                    }

                    axios.post('./edit_permission', update_data).then((response)=>{
                        if(response.data==201){
                            alert("Permission has been Updated!");
                            this.all_permission[index].edit_enabled=false;
                            this.get_all_perimissions();
                        }
                    });
                }
            }

        }
        //End of Methods
    }
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        setTimeout(function(){ mydatatable(); }, 3000);
    } );

    function mydatatable(){
        $('#example tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

        // DataTable
        var table = $('#example').DataTable();

        // Apply the search
        table.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    }
</script>

