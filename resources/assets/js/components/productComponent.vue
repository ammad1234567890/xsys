<template>
    <div>
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                            <h2 class="panel-title">Create Product</h2>
                        </div>
                <div id="d" class="panel-body" v-bind:class="{in:edit}">
                    <form @submit="createProduct">
                        <div>
                            <div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="productName">Title<span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="productName" v-validate="'required|regex:^[a-zA-Z0-9 ._]+$'" class="textbox" v-model="newProduct.name" placeholder="Model Name" required>
                                        <span class="text-danger" v-show="errors.has('productName')">
                                      {{errors.first('productName')}}
                                    </span>
                                    </div>
                                    <div class="col-md-1"></div>

                                    <div class="col-md-2">
                                        <label for="productCategory">Category<span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="textbox" required name="Category" v-model="newProduct.productCategory" v-validate="'required'" >
                                            <option value="">Select Category</option>
                                            <option v-for="category in categories" v-bind:value="category.id">{{category.name}}</option>
                                        </select>
                                        <span class="text-danger" v-show="errors.has('Category')">
                                      {{errors.first('Category')}}
                                    </span>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="releaseDate">Est. Release Date<span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <date-picker name="releaseDate" v-validate="'required'" style="width:100%;" v-model="releaseDate" type="date" format="dd-MM-yyyy" placeholder="dd-mm-yyyy" lang="en" required></date-picker>
                                        <!-- <input type="date"  name="releaseDate" v-validate="'required'" class=" form-control" placeholder="Release Date" v-model="newProduct.releaseDate" required > -->
                                                                          
                                        <span class="text-danger" v-show="errors.has('Release Date')">
                                      {{errors.first('Release Date')}}
                                        </span>
                                    </div>
                                </div>
                                <hr/>



                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse-network"><b>Network:</b></a>
                                            </h4>
                                        </div>
                                        <div id="collapse-network" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-2">Technology</div>
                                                    <div class="col-md-3"><input type="text" class="textbox" v-model="newProduct.technology_name" name="technology"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">2G Bands</div>
                                                    <div class="col-md-3"><input type="text" class="textbox" v-model="newProduct.two_G_name" name="technology"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">3G Bands</div>
                                                    <div class="col-md-3"><input type="text" class="textbox" v-model="newProduct.three_G_name" name="technology"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">4G Bands</div>
                                                    <div class="col-md-3"><input type="text" class="textbox" v-model="newProduct.four_G_name" name="technology"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">GPRS</div>
                                                    <div class="col-md-3"><input type="text" class="textbox" v-model="newProduct.gprs_name" name="technology"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Edge</div>
                                                    <div class="col-md-3"><input type="text" class="textbox" v-model="newProduct.edge_name" name="technology"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse-body"><b>Body:</b></a>
                                            </h4>
                                        </div>
                                        <div id="collapse-body" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-2">Dimension</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Weight</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">Build</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">SIM</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse-camera"><b>Camera:</b></a>
                                            </h4>
                                        </div>
                                        <div id="collapse-camera" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-2">Primary</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Secondary</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">Video</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Features</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse-Platform"><b>Platform:</b></a>
                                            </h4>
                                        </div>
                                        <div id="collapse-Platform" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-2">OS</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Chipset</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">CPU</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">GPU</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse-Memory"><b>Memory:</b></a>
                                            </h4>
                                        </div>
                                        <div id="collapse-Memory" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-2">Card Slot</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Internal</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse-Comms"><b>Comms:</b></a>
                                            </h4>
                                        </div>
                                        <div id="collapse-Comms" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-2">WLAN</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Bluetooth</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">GPS</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">NFC</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">Radio</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">USB</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse-Battery"><b>Battery:</b></a>
                                            </h4>
                                        </div>
                                        <div id="collapse-Battery" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-2">Type</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Talk Type</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">Music Play</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse-Features"><b>Features:</b></a>
                                            </h4>
                                        </div>
                                        <div id="collapse-Features" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-2">Sensors</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Messaging</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">Browser</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse-Display"><b>Display:</b></a>
                                            </h4>
                                        </div>
                                        <div id="collapse-Display" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-2">Type</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Size</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">Resolution</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Multi-Touch</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">Protection</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" href="#collapse-Sound"><b>Sound:</b></a>
                                            </h4>
                                        </div>
                                        <div id="collapse-Sound" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-2">Alert Types</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">Loud Speaker</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">3.5mm Jack</div>
                                                    <div class="col-md-3"><input type="text" class="textbox"></div>
                                                    <div class="col-md-1"></div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-1"></div>

                                    <div class="col-md-5">
                                        <button class="btn btn-info pull-right" @click="addColorForm">Add Product Color</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-for="(find, index) in newProduct.finds" class="well well-sm" style="    margin-top: 20px;"> <!--Product Color Form-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-3">
                                        <label for="colorName">Color<span style="color:red;">*</span></label>
                                        <input type="text" v-validate="'required|regex:^[a-zA-Z ._]+$'" name="colorName" v-model="find.color" class="form-control" placeholder="Color" required>
                                        <span class="text-danger" v-show="errors.has('colorName')">
                                              {{errors.first('colorName')}}
                                            </span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="price">Price(PKR)<span style="color:red;">*</span></label>
                                        
                                        <input type="number" name="Price" v-validate="'required|regex:^[0-9]+$|min_value:1'" v-model="find.price" class="form-control" placeholder="Price" required>
                                        <span class="text-danger" v-show="errors.has('Price')">
                                              {{errors.first('Price')}}
                                            </span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="discount">Discount(%)<span style="color:red;">*</span></label>
                                        <input type="number" name="Discount" v-validate="'required||regex:^[0-9]+$|min_value:0'" class="form-control" v-model="find.discount" placeholder="Discount" required>
                                        <span class="text-danger" v-show="errors.has('Discount')">
                                              {{errors.first('Discount')}}
                                            </span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label >Select image(s)<span style="color:red;">*</span></label>
                                                <input type="file" class="form-control" ref="fileupload" @change="imageChange(index)">
                                    </div>
                                    <div class="form-group col-md-2" style="margin-top: 35px;">
                                        <button class="btn btn-danger col-md-12" @click="removeColorForm(index)">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="edit==true">
                                <div class="col-md-12">
                                    <div v-for="(image, i) in find.product_images">
                                        <img v-if="localImage==false" v-bind:src="'./product_img/'+image.image" class="col-md-1 img-thumbnail" height="auto" @click="deleteImage(index,i)" />
                                        <img v-if="localImage==true" v-bind:src="image" class="col-md-1 img-thumbnail" height="auto" @click="deleteImage(index,i)" />
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="edit==false">
                                <div class="col-md-12">
                                    <div v-for="(image, i) in find.product_images">
                                        <img v-bind:src="image" class="col-md-1 img-thumbnail" height="auto" @click="deleteImage(index,i)" style="margin-left: 14px;"/>
                                    </div>
                                </div>
                            </div>

                        </div> <!--Product Color Form-->
                        <div class="form-group row">
                            <div style="    margin-left: 15px;">
                                <button v-if="edit==false" type="submit" class="btn btn-default">Submit</button>
                                <button v-if="edit==true" class="btn btn-tumblr"  @click="saveEditing">Save</button>
                                <button v-if="edit==true" class="btn btn-Danger"  @click="cancelEditing">Cancel</button>
                            </div>
                        </div>
                    </form>

                    <!-- <pre>{{ $data | json }}</pre> -->
                </div>
            </div>
            <!-- end of panel -->
            <!-- <div class="panel panel-default">
                <div class="panel-heading">
                     <h2 class="panel-title">Products</h2>
                </div>
                <div class="panel-body">
                    <table id="cateprotable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                        <tr>
                            <th>Model</th>
                            <th>Category</th>
                            <th>Est.Release Date</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(product, index) in allProducts">
                            <td>{{product.name}}</td>
                            <td>{{product.product_category.name}}</td>
                            <td>{{product.release_date | moment}}</td>
                            <td>
                                <button class="btn btn-github btn-xs" v-on:click="showDetails(index)" data-toggle="modal" data-target="#myModal">Details</button>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" v-on:click="editProduct(index)">Edit</a></li>
                                        <li><a href="#" v-on:click="deleteProduct(product.id,index)">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div> -->

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
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="productName">Product Name</label>
                                    <input type="text" readonly class="form-control" v-bind:value="details.productName">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="productCategory">Product Category</label>
                                    <input type="text" readonly class="form-control" v-bind:value="details.productCategory">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ReleaseDate">Release Date</label>
                                    <input type="text" readonly class="form-control" v-bind:value="details.releaseDate | moment">
                                </div>
                            </div>
                        </div>

                        <div v-for="(find, index) in details.finds" class="well well-sm"> <!--Product Color Form-->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <label for="colorName">Color Name</label>
                                        <input type="text" v-bind:value="find.color" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="price">Price</label>
                                        <vue-numeric currency="Rs" class="form-control" separator="," v-bind:value="find.price" readonly></vue-numeric>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="discount">Discount(%)</label>
                                        <input type="text" name="Discount" class="form-control" v-bind:value="find.discount+'%'" readonly>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div v-for="(image, index) in find.product_images">
                                        <img v-bind:src="'./product_img/'+image.image" class="col-md-3 img-thumbnail" height="auto" />
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
                technology_name:'',
                two_G_name:'',
                three_G_name:'',
                four_G_name:'',
                gprs:'',
                edge:'',
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
                    alert(response.data);
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
            $('#cateprotable').DataTable({
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

        // Value constants
    var units = ['','one','two','three','four','five','six','seven','eight','nine'];
    var tenToTwenties = ['ten','eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen'];
    var tens = ['','','twenty','thirty','forty','fifty','sixty','seventy','eighty','ninety'];

    // Unit constants
    var million = " million ";
    var thousand = " thousand ";
    var hundred = " hundred ";
    var zero = "zero";

    function convert_millions(num){
        if (num>=1000000){
            return convert_millions(Math.floor(num/1000000))+ million +convert_thousands(num%1000000);
        }
        else {
            return convert_thousands(num);
        }
    }

    function convert_thousands(num){
        if (num>=1000){
            return convert_hundreds(Math.floor(num/1000))+ thousand +convert_hundreds(num%1000);
        }
        else{
            return convert_hundreds(num);
        }
    }

    function convert_hundreds(num){
        if (num>99){
            return units[Math.floor(num/100)]+ hundred +convert_tens(num%100);
        }
        else{
            return convert_tens(num);
        }
    }

    function convert_tens(num){
        if (num<10) return units[num];
        else if (num>=10 && num<20) return tenToTwenties[num-10];
        else return tens[Math.floor(num/10)]+" "+units[num%10];   
    }

    //only call this function for cnversion
    function get_amount_in_words(num){
        if (num==0) return zero;
        else return convert_millions(num);
    }


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
</style>
