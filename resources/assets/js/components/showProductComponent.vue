<template>
    <div>
    <div class="row">
        <div class="col-md-12">
            <div v-if="edit" class="panel panel-info">
                <div class="panel-heading">
                            <h2 class="panel-title">Edit Product</h2>
                        </div>
                <div id="d" class="panel-body" v-bind:class="{in:edit}">
                    <form @submit="createProduct">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="productName">Title</label>
                                    <input type="text" name="productName" v-validate="'required|regex:^[a-zA-Z ._]+$'" class="form-control" v-model="newProduct.name" placeholder="Product Name" required>
                                    <span class="text-danger" v-show="errors.has('productName')">
                                  {{errors.first('productName')}}
                                </span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="productCategory">Category</label>
                                    <select class="form-control" required name="Category" v-model="newProduct.productCategory" v-validate="'required'" >
                                        <option value="">Select Category</option>
                                        <option v-for="category in categories" v-bind:value="category.id">{{category.name}}</option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('Category')">
                                  {{errors.first('Category')}}
                                </span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="releaseDate">Estimated Release  Date</label>
                                    <date-picker name="releaseDate" v-validate="'required'" style="width:100%;" v-model="releaseDate" type="date" format="dd-MM-yyyy" placeholder="dd-mm-yyyy" lang="en" required></date-picker>
                                    <!-- <input type="date"  name="releaseDate" v-validate="'required'" class=" form-control" placeholder="Release Date" v-model="newProduct.releaseDate" required > -->
                                                                      
                                    <span class="text-danger" v-show="errors.has('Release Date')">
                                  {{errors.first('Release Date')}}
                                </span>
                                </div>
                                <div class="form-group col-md-12">
                                    <button class="btn btn-info" @click="addColorForm">Add Product Color</button>
                                </div>
                            </div>
                        </div>
                        <div v-for="(find, index) in newProduct.finds" class="well well-sm"> <!--Product Color Form-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-3">
                                        <label for="colorName">Color</label>
                                        <input type="text" v-validate="'required|regex:^[a-zA-Z ._]+$'" name="colorName" v-model="find.color" class="form-control" placeholder="Color" required>
                                        <span class="text-danger" v-show="errors.has('colorName')">
                                              {{errors.first('colorName')}}
                                            </span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="price">Price (Rs) </label>
                                        <input type="number" name="Price" v-validate="'required|regex:^[0-9]+$|min_value:1'" v-model="find.price" class="form-control" placeholder="Price" required>
                                        <span class="text-danger" v-show="errors.has('Price')">
                                              {{errors.first('Price')}}
                                            </span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="discount">Discount(%)</label>
                                        <input type="number" name="Discount" v-validate="'required||regex:^[0-9]+$|min_value:0'" class="form-control" v-model="find.discount" placeholder="Discount" required>
                                        <span class="text-danger" v-show="errors.has('Discount')">
                                              {{errors.first('Discount')}}
                                            </span>
                                    </div>
                                    <div class="form-group col-md-3" style="margin-top: 8px;">
                                        <span class="btn btn-round btn-file">
                                            <span class="fileinput-new">Select image(s)</span>
                                                <input type="file" class="form-control" ref="fileupload" @change="imageChange(index)">
                                            </span>
                                    </div>
                                    <div class="form-group col-md-2" style="margin-top: 35px;">
                                        <button class="btn btn-danger col-md-12" @click="removeColorForm(index)">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="edit==true">
                                <div class="col-md-12">
                                    <div v-for="(image, i) in find.product_images">
                                        <img v-if="localImage==false" v-bind:src="'./product_img/'+image.image" class="col-md-1 img-thumbnail" height="auto" @click="deleteImage(index,i)"  style="margin-left: 14px;"/>
                                        <img v-if="localImage==true" v-bind:src="image" class="col-md-1 img-thumbnail" height="auto" @click="deleteImage(index,i)" />
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="edit==false">
                                <div class="col-md-12">
                                    <div v-for="(image, i) in find.product_images">
                                        <img v-bind:src="image" class="col-md-1 img-thumbnail" height="auto" @click="deleteImage(index,i)" />
                                    </div>
                                </div>
                            </div>

                        </div> <!--Product Color Form-->
                        <div class="form-group row" style="    margin-left: 0px;">
                                <button v-if="edit==false" type="submit" class="btn btn-tumblr">Submit</button>
                                <button v-if="edit==true" class="btn btn-tumblr"  @click="saveEditing">Save</button>
                                <button v-if="edit==true" class="btn btn-danger"  @click="cancelEditing">Cancel </button>
                        </div>
                    </form>

                    <!-- <pre>{{ $data | json }}</pre> -->
                </div>
            </div>
            <!-- end of panel -->
            <div class="panel panel-info">
                <div class="panel-heading">
                     <h2 class="panel-title">Products Detail</h2>
                </div>
                <div class="panel-body">
                    <table id="pro" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th>Model</th>
                            <th>Category</th>
                            <th>Est.Release Date</th>
                            <th class="col-md-1">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(product, index) in allProducts">
                            <td>{{product.name}}</td>
                            <td>{{product.product_category.name}}</td>
                            <td>{{product.release_date | moment}}</td>
                            <td>
                                <button class="btn btn-success btn-xs" v-on:click="showDetails(index)" data-toggle="modal" data-target="#myModal" title="View Detail"><i class="fa fa-eye"></i></button>
                                <button class="btn btn-info btn-xs" v-on:click="editProduct(index)"><i class="fa fa-edit" title="Edit"></i></button>

                            </td>
                            <!-- <td>
                                <div class="dropdown">
                                    <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" v-on:click="editProduct(index)">Edit</a></li>
                                        <li><a href="#" v-on:click="deleteProduct(product.id,index)">Delete</a></li>
                                    </ul>
                                </div>
                            </td> -->
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Model -->
        <div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Product Details</h4>
                    </div>
                    <div class="modal-body">

                            <div class="row">
                                    <div class="col-md-1">
                                        <label for="productName"><strong>Model:</strong></label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{details.productName}}</label>
                                        <!-- <input type="text" readonly class="textbox" v-bind:value="details.productName"> -->
                                    </div>

                                    <div class="col-md-2">
                                        <label for="productCategory"><strong>Category:</strong></label>
                                    </div>
                                    <div class="col-md-2 m-p-0">
                                        <label >{{details.productCategory}}</label>
                                        <!-- <input type="text" readonly class="textbox" v-bind:value="details.productCategory"> -->
                                    </div>

                                    <div class="col-md-3">
                                        <label for="ReleaseDate"><strong>Release Date:</strong></label>
                                    </div>

                                    <div class="col-md-2 m-p-0">
                                        <label>{{details.releaseDate | moment}}</label>
                                        <!-- <input type="text" readonly class="textbox" v-bind:value="details.releaseDate | moment"> -->
                                    </div>
                            </div>

                            <div v-for="(find, index) in details.finds" class="well well-sm" style="    margin-top: 5px;"> <!--Product Color Form-->
                                <div class="row">
                                        <div class="col-md-3">
                                            <label for="colorName"><strong>Color Name:</strong></label>
                                        </div>
                                        <div class="col-md-2 m-p-0">
                                            <label >{{find.color}}</label>
                                            <!-- <input type="text" v-bind:value="find.color" class="textbox" readonly> -->
                                        </div>

                                        <div class="col-md-1">
                                            <label for="price"><strong>Price:</strong></label>
                                        </div>     
                                        <div class="col-md-3">      
                                            <label>{{find.price | currency('Rs')}}</label>  
                                            <!-- <vue-numeric currency="Rs" class="textbox" separator="," v-bind:value="find.price" readonly style="text-align:right;"></vue-numeric> -->
                                        </div>
                               
                                        <div class="col-md-2">
                                            <label for="discount"><strong>Discount(%):</strong></label>
                                        </div>
                                        <div class="col-md-1">
                                            <label>{{find.discount+'%'}}</label>
                                           <!--  <input type="text" name="Discount" class="textbox" v-bind:value="find.discount+'%'" readonly> -->
                                        </div>

                                </div>

                                <div class="row">

                                        <div class="col-md-12">
                                            <div v-for="(image, index) in find.product_images">
                                                <img v-bind:src="'./product_img/'+image.image" class="col-md-3 img-thumbnail" height="auto"  style="    margin-left: 5px;"/>
                                            </div>
                                        </div>
                                </div>

                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-github" data-dismiss="modal">Close</button>
                    </div>
                </div>



            </div>
        </div>
        <!-- Model -->

    </div>

    </div>
</template>


<script>



    export default {
        filters: {
          moment: function (date) {
            return moment(date).format('DD-MM-YYYY');
          }
        },
        data(){
          return{
            categories:[],
            allProducts:[],
            edit:false,
            localImage:false,
            editIndex:'',
            path:'',
            releaseDate:'',
            details:{
              productName:'',
              productCategory:'',
              releaseDate:'',
              finds:[]
            },
            newProduct:{
                id:'',
                name:'',
                productCategory:'',
                releaseDate:'',
                finds: [],
            }
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('./categories').then(response=>{
                this.categories=response.data;
                //console.log(response.data);
            });

            axios.get('./allProducts').then(response=>{
              this.allProducts=response.data.data;
              this.path=response.data.path;
              console.log(this.allProducts);

            });
        },
        watch:{
            releaseDate:function(){
                this.newProduct.releaseDate=moment(this.releaseDate).format('YYYY-MM-DD');
            console.log(this.newProduct.releaseDate);
            },
        },
        methods:{
            imageChange(index){
                event.preventDefault();
                //console.log(event.target.files[0])
                this.localImage=true;
                var fileReader = new FileReader();

                fileReader.readAsDataURL(event.target.files[0])

                fileReader.onload = (event) => {
                //  this.newProduct.finds[index].images.push(event.target.result);
                  if(this.edit==false){
                    this.newProduct.finds[index].product_images.push(event.target.result);
                  }else{
                    this.newProduct.finds[index].product_images.push(event.target.result);
                  }
                }
                //console.log(this.images);
            },
            deleteImage(index,i){
              if(this.edit==false){
                this.newProduct.finds[index].images.splice(i,1);
              }else{
                this.newProduct.finds[index].product_images.splice(i,1);
              }
              //alert(index+" "+i);
            },
            showDetails:function(index){
                this.details={
                  productName:this.allProducts[index].name,
                  productCategory:this.allProducts[index].product_category.name,
                  releaseDate:this.allProducts[index].release_date,
                  finds:this.allProducts[index].product_color
                }
            },
            addColorForm: function (e) {
                e.preventDefault();
                //this.newProduct.finds.push({ color: '' , price: '', discount: '', images:[]});
                this.newProduct.finds.push({ color: '' , price: '', discount: '', product_images:[]});
            },

            removeColorForm:function(index){
                event.preventDefault();
                this.newProduct.finds.splice(index,1);
            },

            createProduct:function(e){
                e.preventDefault();
                axios.post('./createProduct',this.newProduct).then(response=>{
                    if(response.data.replay==0){
                      console.log(response.data.data[0]);
                      this.allProducts.unshift(response.data.data[0]);
                       this.newProduct={
                         id:'',
                         name:'',
                         productCategory:'',
                         releaseDate:'',
                         finds: [],
                       };
                       const input = this.$refs.fileupload;
                       input.type = 'text';
                       input.type = 'file';
                       alert("Product Created Successfully");
                       window.location.reload();
                    }else{
                      alert('Fail to Create Product');
                      console.log(response.data.replay);
                    }
                })
            },
            editProduct:function(index){
              this.localImage=false;
              this.edit=true;
              this.editIndex=index;
              this.newProduct={
                id:this.allProducts[index].id,
                name:this.allProducts[index].name,
                productCategory:this.allProducts[index].product_category.id,
                releaseDate:this.allProducts[index].release_date,
                finds:this.allProducts[index].product_color
              }
            },
            saveEditing:function(){
              event.preventDefault();
              axios.post('./updateProduct',this.newProduct).then(response=>{
                if(response.data.return==0){
                  console.log(response.data.data[0]);
                  console.log(this.allProducts[this.editIndex]);
                  this.allProducts[this.editIndex]=response.data.data[0];
                  this.edit=false;
                  this.editIndex='';
                  this.newProduct={
                    id:'',
                    name:'',
                    productCategory:'',
                    releaseDate:'',
                    finds: [],
                  };
                }else{
                  alert('Fail to edit');
                  console.log(response.data.data);
                }

              })
            },
            cancelEditing:function(){
              event.preventDefault();
              this.edit=false;
              this.editIndex='';
              this.newProduct={
                id:'',
                name:'',
                productCategory:'',
                releaseDate:'',
                finds: [],
              };
            },
            deleteProduct:function(id,index){
              //alert("Running");
              axios.get('./deleteProduct/'+id).then(response=>{
                console.log(response.data);
                if(response.data==0){
                    this.allProducts.splice(index,1);
                }else{
                  alert('Fail to delete');
                }
              });
            }

        }
    }    
    $(document).ready(function() {

        setTimeout(function(){
            $('#pro').DataTable({
                "order": [[ 0,"desc" ]],
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
<style scoped>
.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
    top: 1px;
    left: 1px;
  z-index: 2;
  text-align: center;
}
.img{
  z-index: 1;
}

.cont:hover .image {
  opacity: 0.3;
}

.cont:hover .middle {
  opacity: 1;
}
.m-p-0{
    margin: 0px; padding: 0px;
}
</style>
