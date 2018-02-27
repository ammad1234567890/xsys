<template>

            <div class="col-md-12">
                <h2 style="margin-top: 6px; font-variant: small-caps; font-weight:bold;">Category Management</h2>
                <hr/>
                <div class="panel panel-default">

                    <div class="panel-heading">Create Category</div>

                    <div class="panel-body">
                        <form v-on:submit="CreateCategory">
                          <div class="form-group col-md-6">
                            <label for="categoryName">Category Name</label>
                            <input type="text" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="newCategory.name" class="form-control" name="categoryName" placeholder="Category Name" required>
                            <span class="text-danger" v-show="errors.has('categoryName')">
                              {{errors.first('categoryName')}}
                            </span>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="categoryImage">Category image</label>
                            <input type="file" v-validate="'required|mimes:image/jpeg,image/png'" class="form-control" name="categoryImage" ref="fileupload" @change="imageChange">
                            <span class="text-danger" v-show="errors.has('categoryImage')">
                              {{errors.first('categoryImage')}}
                            </span>
                          </div>
                          <div class="form-group col-md-12">
                            <label for="categoryName">Description</label>
                            <textarea class="form-control" v-model="newCategory.description">

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



                  <div class="panel panel-default">
                      <div class="panel-heading">Categories</div>
                      <div class="panel-body">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>S.No</th>
                              <th>Category Name</th>
                              <th>Description</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              <tr v-for="(category,index) in allCategories">
                                <td>{{index+1}}</td>
                                <td>{{category.name}}</td>
                                <td>{{category.description}}</td>
                                <td>
                                  <div class="dropdown">
                                  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Action
                                  <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                      <li><a href="#" v-on:click="edit(index)">Edit</a></li>
                                      <li><a href="#" v-on:click="deleteCategory(category.id,index)">Delete</a></li>
                                  </ul>
                                </div>
                               </td>
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
            editing:0,
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
</script>
