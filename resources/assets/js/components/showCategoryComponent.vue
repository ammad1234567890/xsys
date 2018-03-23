<template>
            <div class="row">
                <div class="col-md-12">
                    <div v-if="editing==1" class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Create Category</h2>
                        </div>

                        <div class="panel-body">
                            <form v-on:submit="CreateCategory">
                                <div class="form-group col-md-6">
                                    <label for="categoryName">Title</label>
                                    <input type="text" v-validate="'required|regex:^[a-zA-Z ._]+$'" v-model="newCategory.name" class="form-control" name="categoryName" required>
                                    <span class="text-danger" v-show="errors.has('categoryName')">
                              {{errors.first('categoryName')}}
                            </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-md-3">
                                        <span class="btn btn-round btn-file">
                                            <span class="fileinput-new">Browse</span>
                                            <input type="file" v-validate="'required|mimes:image/jpeg,image/png'" class="form-control" name="categoryImage" ref="fileupload" @change="imageChange">
                                        </span>
                                    </div>
                                    <div class="col-md-8">
                                        <pre v-if="fileName==''" class="pre-top-margin">Select Image</pre>
                                        <pre v-if="fileName!=''" class="pre-top-margin">{{fileName}}</pre>
                                        <span class="text-danger" v-show="errors.has('categoryImage')">
                                        {{errors.first('categoryImage')}}
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="categoryName">Description</label>
                                    <textarea class="form-control" v-model="newCategory.description">

                            </textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="submit" value="Submit" v-if="editing==0" class="btn btn-tumblr" />
                                    <button  class="btn btn-tumblr" v-on:click="saveEditing" v-if="editing==1">Save Editing</button>
                                    <button  class="btn btn-default" v-on:click="cancelEding" v-if="editing==1">Cancel Editing</button>
                                </div>
                            </form>
                        </div>
                    </div>



                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title">Categories</h2>
                        </div>
                        <div class="panel-body">
                          <div class="material-datatables">
                            <table id="categoriestable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%" >
                                <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th class="col-md-3 text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(category,index) in allCategories">
                                    <td>{{index+1}}</td>
                                    <td>{{category.name}}</td>
                                    <td>{{category.description}}</td>
                                    <td>
                                        <div>
                                            <ul>
                                                <a class="btn btn-tumblr btn-xs" href="#" v-on:click="edit(index)"> Edit</a> 
                                                <a class="btn btn-danger btn-xs" href="#" v-on:click="deleteCategory(category.id,index)"> Delete</a>
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
    export default {
        data(){
          return{
            editing:0,
            fileName:'',
            editIndex:null,
            path:'',
            allCategories:[],
            newCategory:{
                id:'',
                name:'',
                image:'',
                OldImage:'',
                description:''
            }
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('../public/categories').then(response=>{
                this.allCategories=response.data;
                console.log(this.allCategories);
            });
            axios.get('../public/path').then(response=>{
              this.path=response.data;
              console.log(this.path);
            })

        },
        methods:{
          imageChange(e){

            console.log(e.target.files[0])
            var fileReader = new FileReader();

            fileReader.readAsDataURL(e.target.files[0])
            this.fileName=e.target.files[0].name;
            fileReader.onload = (e) => {
              this.newCategory.image = e.target.result

            }
            console.log(this.newCategory);
          },

          CreateCategory:function(e){
            e.preventDefault();
              axios.post('../public/createCategory',this.newCategory).then(response=>{
                if(response.data.replay===0){
                  this.allCategories.unshift({
                        created_at:response.data.data.created_at,
                        created_by:response.data.data.created_by,
                        description:response.data.data.description,
                        id:response.data.data.id,
                        image:response.data.data.image,
                        name:response.data.data.name,
                        updated_at:response.data.data.updated_at,
                  });
                    console.log(response.data);
                    this.newCategory={
                      id:'',
                      name:'',
                      image:'',
                      OldImage:'',
                      description:''
                    }
                    const input = this.$refs.fileupload;
                    input.type = 'text';
                    input.type = 'file';
                    alert("New Category Created");
                    window.location.reload();
                }
                else{
                  alert(response.data.data);
                }
              })
          },
          edit:function(index){
            this.editIndex=index;
            this.editing=1;
            this.newCategory={
              id:this.allCategories[index].id,
              name:this.allCategories[index].name,
              image:this.allCategories[index].image,
              OldImage:this.allCategories[index].image,
              description:this.allCategories[index].description
            }
          },
          saveEditing:function(e){
            e.preventDefault();
            axios.post('../public/editCategory',this.newCategory).then(response=>{
              console.log(response.data);
              if(response.data.replay==0){
                console.log(response.data.data);
                var index=this.editIndex;
                this.allCategories[index].id=this.newCategory.id;
                this.allCategories[index].name=this.newCategory.name;
                this.allCategories[index].image=this.newCategory.image;
                this.allCategories[index].description=this.newCategory.description;
              }else if(response.data.replay==1){
                alert(response.data.data);
              }else{
                alert('Faile to update');
                console.log(response.data.data);
              }
              this.newCategory={
                id:'',
                name:'',
                image:'',
                OldImage:'',
                description:''
              }
              const input = this.$refs.fileupload;
              input.type = 'text';
              input.type = 'file';
              this.editIndex=null;
              this.editing=0;
            })
          },
          cancelEding:function(e){
            e.preventDefault();
            this.newCategory={
              id:'',
              name:'',
              image:'',
              OldImage:'',
              description:''
            }
            const input = this.$refs.fileupload;
            input.type = 'text';
            input.type = 'file';
            this.editIndex=null;
            this.editing=0;
          },

          deleteCategory:function(id,index){
               axios.get('../public/deleteCategory/'+id).then(response=>{
                  if(response.data==0){
                    this.allCategories.splice(index,1);
                  }else{
                    alert("Fail to delete");
                  }
                })
          }
        }
    }

    $(document).ready(function() {
       setTimeout(function(){
            $('#categoriestable').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search here",
            }
            });
        },5000);

       
    });

</script>



