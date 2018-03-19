<template>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Create New Outlets</div>

                    <div class="panel-body">
                        <div class="alert alert-success"  v-if="message">
                            <strong>{{message}}</strong>
                        </div>
                        <form @submit.prevent="add_outlet">
                            <div class="form-section">
                                <h4 class="form-section-heading">RETAILER DETAILS</h4>


                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Full Name</label>
                                            <input type="text" class="form-control" v-model="retailer.fullname" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">CNIC No</label>
                                            <input type="text" class="form-control" v-model="retailer.cnic" v-mask="'99999-9999999-9'" autocomplete="off" required>
                                        </div>
                                    </div>



                                    <div class="col-md-6 col-sm-3"  v-if="!retailer.uploadImage">
                                        <div class="form-group label-floating">
                                            <button class="btn btn-primary btn-xs" style="width:100%;">Select Image<input type="file" class="form-control" v-on:change="file_preview" ref="imageInput" name="image" autocomplete="off" required></button>
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else>
                                        <img :src="retailer.uploadImage" class="img img-responsive form-control" />
                                        <button @click="removeRetailerImage" class="image_close_btn"><i class="fa fa-times"></i> </button>
                                    </div>

                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Mobile No</label>
                                            <input type="text" class="form-control" v-model="retailer.phone_no" v-mask="'9999-9999999'" autocomplete="off" required>
                                        </div>
                                    </div>

                                <div class="clearfix"></div>
                            </div>
                            <div class="form-section">
                                <h4 class="form-section-heading">OUTLET DETAILS</h4>
                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Outlet Name</label>
                                        <input type="text" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>


                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Outlet Phone No</label>
                                        <input type="text" class="form-control" v-mask="'9999-9999999'" v-model="outlet.outlet_phone" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-section">
                                <h4 class="form-section-heading">BUSINESS PERSON DETAILS</h4>
                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Full Name</label>
                                        <input type="text" class="form-control" v-model="outlet.bussiness_person_name" autocomplete="off" name="person_name"  required>
                                    </div>
                                </div>


                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">CNIC</label>
                                        <input type="text" class="form-control" v-mask="'99999-9999999-9'" v-model="outlet.bussiness_person_cnic" autocomplete="off" name="person_cnic" minlength="15" maxlength="15" required>
                                    </div>
                                </div>


                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Phone No</label>
                                        <input type="text" class="form-control" v-mask="'9999-9999999'" v-model="outlet.bussiness_person_phone" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <br/>
                            <div class="form-section">
                                <h4 class="form-section-heading">LOCATION DETAILS</h4>
                                <br/>
                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Select City</label>
                                        <input type="text" class="form-control" v-model="outlet.bussiness_person_name" autocomplete="off" name="person_name"  required>
                                        <select class="form-control" name="city_id" v-model="outlet.city_id" @change="change_city(outlet.city_id)" required>
                                            <option value="">Select City</option>
                                            <option v-for="cities in citiesData"  v-bind:value="cities.id">{{cities.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Select City</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div v-if="add_city_mode==0">
                                                <div class="col-md-10">
                                                    <select class="textbox" name="city_id" v-model="outlet.city_id" @change="change_city(outlet.city_id)" required>
                                                        <option value="">Select City</option>
                                                        <option v-for="cities in citiesData"  v-bind:value="cities.id">{{cities.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <i class="fa fa-plus-circle" v-on:click="enable_city_mode" style="font-size: 27px;"></i>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div class="col-md-10">
                                                    <input type="text" class="textbox" v-model="city.name" id="city_textbox" placeholder="Enter Name of the City" >
                                                </div>
                                                <div class="col-md-2">
                                                    <i class="fa fa-times-circle" v-on:click="disable_city_mode" style="font-size: 27px; position: absolute; right: 45px;"></i>
                                                    <i class="fa fa-check-circle" v-on:click="add_city" style="font-size: 27px;"></i>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Select Locality</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div v-if="add_region_mode==0">
                                                <div class="col-md-10">
                                                    <select class="textbox" name="city_id" v-model="outlet.region_id"  @change="change_region(outlet.region_id)" required>
                                                        <option value="">Select Locality</option>
                                                        <option v-for="region in regionsData"   v-bind:value="region.id">{{region.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <i class="fa fa-plus-circle" v-on:click="enable_region_mode" style="font-size: 27px;"></i>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div class="col-md-10">
                                                    <input type="text" class="textbox" v-model="region.name" id="region_textbox" placeholder="Enter Name of the Locality">
                                                </div>
                                                <div class="col-md-2">
                                                    <i class="fa fa-times-circle" v-on:click="disable_region_mode" style="font-size: 27px; position: absolute; right: 45px;"></i>
                                                    <i class="fa fa-check-circle" v-on:click="add_region" style="font-size: 27px;"></i>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Address</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="textbox" autocomplete="off" v-model="outlet.address" name="outlet_address" required/>
                                    </div>


                                    <div class="col-md-2">
                                        <label>Longitude</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="textbox" autocomplete="off" v-model="outlet.longitude" placeholder="(Optional)" name="outlet_longitude"/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Latitude</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="textbox" autocomplete="off"  v-model="outlet.latitude" placeholder="(Optional)" name="outlet_latitude"/>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="form-section">
                                <h4 class="form-section-heading">FINANCIAL DETAILS</h4>
                                <br/>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Secuity Amount</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="textbox"  v-model="outlet.security_check_amount" autocomplete="off" name="security_check"/>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Credit Duration</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="textbox" v-model="outlet.credit_duration"  autocomplete="off" name="credit_duration"/>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Credit Limit</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="textbox" v-model="outlet.credit_limit"  autocomplete="off" name="credit_limit"/>
                                    </div>



                                    <div class="col-md-2">
                                        <label>Attach Check Copy</label>
                                    </div>

                                    <div class="col-md-4" v-if="!outlet.copy_image">
                                        <input type="file" class="textbox" v-on:change="file_preview" ref="imageInput" name="security_check_image" autocomplete="off" required/>
                                    </div>
                                    <div class="col-md-4" v-else>
                                        <img :src="outlet.copy_image" class="img img-responsive" />
                                        <button @click="removeCopyImage" class="image_close_btn"><i class="fa fa-times"></i> </button>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-3 pull-right" v-if="edit_enable==0">
                                    <button type="submit" class="btn buttondesign" :disabled="btndisabled">{{submit_btn_text}}</button>
                                </div>
                                <div class="col-md-5 pull-right" v-else>
                                    <div class="col-md-6">
                                        <button type="button" class="btn buttondesign" v-on:click="update_outlet"><i class="fa fa-check"></i> {{submit_btn_text}}</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" v-on:click="close_edit_mode" class="btn btn-danger buttondesign"><i class="fa fa-times"></i> Close Editable Mode</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- RETAILER SHOW GRID -->
                <div class="panel panel-info">
                    <div class="panel-heading">Outlet - Details</div>

                    <div class="panel-body">
                        <table id="outlet_table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Oulet Name</th>
                                <th>Phone Number</th>
                                <th>City</th>
                                <th>Locality</th>
                                <th>Address</th>
                                <th>Retailer Name</th>
                                <th>Bussiness Person</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(outlets,index) in outletsData">
                                <td>{{outlets.name}}</td>
                                <td>{{outlets.phone_no}}</td>
                                <td>{{outlets.city.name}}</td>
                                <td>{{outlets.region.name}}</td>
                                <td>{{outlets.address}}</td>
                                <td>{{outlets.retailer.name}}</td>
                                <td>{{outlets.business_person_name}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Action
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><button class="btn btn-primary form-control"  v-on:click="enable_edit_mode(index)">Edit</button></li>

                                            <li><button class="btn btn-danger form-control" style="margin-top: 5px;" v-on:click="delete_outlet(outlets.id)">Delete</button></li>

                                        </ul>
                                        -
                                        <button class="btn btn-default dropdown-toggle" type="button" v-on:click="view_outlet_details(index)">View Details</button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- View Details Modal Start-->
                <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="outlet_info_modal" aria-labelledby="bs-add-Model-modal-md">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Outlet Details</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-section padding10px">
                                    <h4 class="form-section-heading">RETAILER DETAILS</h4>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img :src="outlet_view.retailer_image" height="65px" width="100%"/>
                                        </div>
                                        <div class="col-md-10">
                                            <table class="table table-hovered">
                                                <tr>
                                                    <td>Retailer Name</td>
                                                    <td>{{outlet_view.retailer_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Retailer Phone</td>
                                                    <td>{{outlet_view.retailer_phone}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Retailer Cnic</td>
                                                    <td>{{outlet_view.retailer_cnic}}</td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-section padding10px">
                                    <h4 class="form-section-heading">OUTLET DETAILS</h4>
                                    <br/>

                                    <table class="table table-hovered">
                                        <tr>
                                            <td>Outlet Name</td>
                                            <td>{{outlet_view.outlet_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Outlet Phone</td>
                                            <td>{{outlet_view.outlet_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Bussiness Person Name</td>
                                            <td>{{outlet_view.bussiness_person_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Bussiness Person Phone</td>
                                            <td>{{outlet_view.bussiness_person_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Bussiness Person CNIC</td>
                                            <td>{{outlet_view.bussiness_person_cnic}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-section padding10px">
                                    <h4 class="form-section-heading">OUTLET LOCATION DETAILS</h4>
                                    <br/>
                                    <table class="table table-hovered">
                                        <tr>
                                            <td>City</td>
                                            <td>{{outlet_view.city_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Region</td>
                                            <td>{{outlet_view.region_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Latitude</td>
                                            <td>{{outlet_view.longitude}}</td>
                                        </tr>
                                        <tr>
                                            <td>Longitude</td>
                                            <td>{{outlet_view.latitude}}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>{{outlet_view.address}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-section padding10px">
                                    <h4 class="form-section-heading">OUTLET FINANCIAL DETAILS</h4>
                                    <br/>
                                    <table class="table table-hovered">
                                        <tr>
                                            <td>Security Check Amount</td>
                                            <td>{{outlet_view.security_check_amount}}</td>
                                        </tr>
                                        <tr>
                                            <td>Credit Limit</td>
                                            <td>{{outlet_view.credit_limit}}</td>
                                        </tr>
                                        <tr>
                                            <td>Credit Duration</td>
                                            <td>{{outlet_view.credit_duration}}</td>
                                        </tr>
                                        <tr>
                                            <td>Credit Remaining</td>
                                            <td>{{outlet_view.latitude}}</td>
                                        </tr>
                                        <tr>
                                            <td>Aging Amount</td>
                                            <td>{{outlet_view.address}}</td>
                                        </tr>
                                        <tr>
                                            <td>Security Check Image</td>
                                            <td><a :href="'../deposit_check_img/'+outlet_view.copy_image" target="_blank">Link</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- View Details Modal END -->


            </div>
        </div>



</template>




<script>

    import Vue from 'vue';
    import VeeValidate from 'vee-validate';
    var base_url = window.location.origin;

    const config = {
        errorBagName: 'errors', // change if property conflicts
        fieldsBagName: 'fields',
        delay: 0,
        locale: 'en',
        dictionary: null,
        strict: true,
        classes: false,
        classNames: {
            touched: 'touched', // the control has been blurred
            untouched: 'untouched', // the control hasn't been blurred
            valid: 'valid', // model is valid
            invalid: 'invalid', // model is invalid
            pristine: 'pristine', // control has not been interacted with
            dirty: 'dirty' // control has been interacted with
        },
        events: 'input|blur',
        inject: true,
        validity: false,
        aria: true,
        i18n: null, // the vue-i18n plugin instance,
        i18nRootKey: 'validations' // the nested key under which the validation messsages will be located
    };

    Vue.use(VeeValidate, config);
    export default {
        data(){
            return{
                add_city_mode:0,
                add_region_mode:0,
                btndisabled:false,
                edit_enable:0,
                editIndex:null,
                submit_btn_text:'Create Outlet',
                message:'',
                outlet:{
                    id:'',
                    retailer_id:'',
                    outlet_name:'',
                    outlet_phone:'',
                    bussiness_person_name:'',
                    bussiness_person_cnic:'',
                    bussiness_person_phone:'',

                    city_id:'',
                    region_id:'',
                    address:'',
                    longitude:'',
                    latitude:'',

                    security_check_amount:'',
                    copy_image:'',
                    credit_limit:'',
                    credit_duration:''
                },
                outlet_view:{
                    id:'',
                    retailer_id:'',
                    outlet_name:'',
                    outlet_phone:'',
                    bussiness_person_name:'',
                    bussiness_person_cnic:'',
                    bussiness_person_phone:'',

                    city_id:'',
                    region_id:'',
                    address:'',
                    longitude:'',
                    latitude:'',

                    security_check_amount:'',
                    copy_image:'',
                    credit_limit:'',
                    credit_duration:'',

                    retailer_name:'',
                    retailer_cnic:'',
                    retailer_phone:'',
                    retailer_image:'',

                    city_name:'',
                    region_name:''
                },
                retailer:{
                    id:'',
                    fullname:'',
                    cnic:'',
                    phone_no:'',
                    uploadImage:'',
                    aging_amount:'',
                },
                city:{
                    id:'',
                    name:''
                },
                region:{
                    id:'',
                    name:''
                },
                citiesData:[],
                regionsData:[],
                retailersData:[],
                outletsData:[]
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created:function(){
            this.init();
        },
        methods: {
            init: function(){
                this.get_cities();
                this.get_region();
                this.get_retailers();
                this.get_all_outlets();

            },
            removeCopyImage:function(e){
                e.preventDefault();
                this.outlet.copy_image="";
            },
            file_preview(e){
                console.log(e.target.files[0])
                var fileReader = new FileReader();

                fileReader.readAsDataURL(e.target.files[0])

                fileReader.onload = (e) => {
                    this.outlet.copy_image= e.target.result;
                    if(this.edit_enable==1){
                        axios.post('../outlet/change_outlet_image',this.outlet).then(response=>{
                            if(response.data==201){
                                this.message="New Image has been Uploaded";
                            }
                        });
                    }
                    else{
                        alert(response.data);
                    }
                }

                console.log(this.outlet);


            },
            change_retailer:function(retailer_id){
                this.outlet.retailer_id=retailer_id;
            },
            change_city:function(city_id){
                this.outlet.city_id=city_id;
            },
            change_region:function(region_id){
                this.outlet.region_id=region_id;
            },
            enable_city_mode:function(){
                this.add_city_mode=1;
            },
            disable_city_mode:function(){
                this.add_city_mode=0;
            },
            enable_region_mode:function(){
                this.add_region_mode=1;
            },
            disable_region_mode:function(){
                this.add_region_mode=0;
            },
            add_city:function(){
                if(this.city.name!=""){
                    axios.post('../add_city',this.city).then(response=>{
                        if(response.data==201){
                            this.add_city_mode=0;
                            this.city.name="";
                            this.get_cities();
                        }
                    });
                }
                else{
                    $('#city_textbox').css('border-color','red');
                }
            },
            add_region:function () {
                if(this.region.name!=""){
                    axios.post('../add_region',this.region).then(response=>{
                        if(response.data==201){
                            this.add_region_mode=0;
                            this.region.name="";
                            this.get_region();
                        }
                    });
                }
                else{
                    $('#region_textbox').css('border-color','red');
                }
            },
            get_cities:function(){
                axios.get('../get_cities').then(response=>{
                    this.citiesData= response.data;
                });
            },
            get_region:function(){
                axios.get('../get_regions').then(response=>{
                    this.regionsData= response.data;
                });
            },
            get_retailers:function(){
                axios.get('get_retailers').then(response=>{
                    this.retailersData= response.data;
                });
            },
            add_outlet:function(){
                axios.post('../outlet/create_outlet',this.outlet).then(response=>{
                    if(response.data==201){
                        this.get_all_outlets();
                        this.outlet.id='';
                        this.outlet.retailer_id='';
                        this.outlet.outlet_name='';
                        this.outlet.outlet_phone='';
                        this.outlet.bussiness_person_name='';
                        this.outlet.bussiness_person_cnic='';
                        this.outlet.bussiness_person_phone='';

                        this.outlet.city_id='';
                        this.outlet.region_id='';
                        this.outlet.address='';
                        this.outlet.longitude='';
                        this.outlet.latitude='';

                        this.outlet.security_check_amount='';
                        this.outlet.copy_image='';
                        this.outlet.credit_limit='';
                        this.outlet.credit_duration='';

                        this.message="New Outlet has been created!";
                        $(this).scrollTop(0);
                    }
                    else{
                        alert(response.data);
                    }
                });
            },
            get_all_outlets:function(){
                axios.get('../outlet/get_all_outlets').then(response=>{
                    this.outletsData=response.data;
                });
            },
            view_outlet_details:function(index){
                $('#outlet_info_modal').modal('show');
                    this.outlet_view.id=this.outletsData[index].id;
                    this.outlet_view.retailer_id=this.outletsData[index].retailer_id;
                    this.outlet_view.outlet_name=this.outletsData[index].name;
                    this.outlet_view.outlet_phone=this.outletsData[index].phone_no;
                    this.outlet_view.bussiness_person_name=this.outletsData[index].business_person_name;
                    this.outlet_view.bussiness_person_cnic=this.outletsData[index].business_person_cnic;
                    this.outlet_view.bussiness_person_phone=this.outletsData[index].mobile_no;

                    this.outlet_view.city_id=this.outletsData[index].city_id;;
                    this.outlet_view.region_id=this.outletsData[index].region_id;;
                    this.outlet_view.address=this.outletsData[index].address;
                    this.outlet_view.longitude=this.outletsData[index].longitude;
                    this.outlet_view.latitude=this.outletsData[index].latitude;

                    this.outlet_view.security_check_amount=this.outletsData[index].security_deposit_amount;
                    this.outlet_view.copy_image=this.outletsData[index].security_deposit_image;
                    this.outlet_view.credit_limit=this.outletsData[index].credit_limit;
                    this.outlet_view.credit_duration=this.outletsData[index].credit_duration;

                    this.outlet_view.retailer_name=this.outletsData[index].retailer.name;
                    this.outlet_view.retailer_phone=this.outletsData[index].retailer.phone_no;
                    this.outlet_view.retailer_cnic=this.outletsData[index].retailer.cnic;
                    this.outlet_view.retailer_image='../retailers_img/'+this.outletsData[index].retailer.image;

                    this.outlet_view.city_name=this.outletsData[index].city.name;
                    this.outlet_view.region_name=this.outletsData[index].region.name;
            },
            //Function for Deactivating the Outlet, It Required only outlet_id.
            delete_outlet(outlet_id){
                this.outlet.id=outlet_id;
                axios.post('../outlet/delete_outlet',this.outlet).then(response=>{
                    if(response.data==201){
                        this.message="Outlet has been Deleted";
                        this.get_all_outlets();
                    }
                    else{
                        alert(response.data);
                        this.btndisabled=false;
                    }
                });
            },
            enable_edit_mode:function(index){
                this.outlet.id=this.outletsData[index].id;
                this.outlet.retailer_id=this.outletsData[index].retailer_id;
                this.outlet.outlet_name=this.outletsData[index].name;
                this.outlet.outlet_phone=this.outletsData[index].phone_no;
                this.outlet.bussiness_person_name=this.outletsData[index].business_person_name;
                this.outlet.bussiness_person_cnic=this.outletsData[index].business_person_cnic;
                this.outlet.bussiness_person_phone=this.outletsData[index].mobile_no;

                this.outlet.city_id=this.outletsData[index].city_id;;
                this.outlet.region_id=this.outletsData[index].region_id;;
                this.outlet.address=this.outletsData[index].address;
                this.outlet.longitude=this.outletsData[index].longitude;
                this.outlet.latitude=this.outletsData[index].latitude;

                this.outlet.security_check_amount=this.outletsData[index].security_deposit_amount;
                this.outlet.copy_image="../deposit_check_img/"+this.outletsData[index].security_deposit_image;
                this.outlet.credit_limit=this.outletsData[index].credit_limit;
                this.outlet.credit_duration=this.outletsData[index].credit_duration;
                this.edit_enable=1;
                this.submit_btn_text="Update Outlet";
            },
            close_edit_mode:function(){
                this.edit_enable=0;
                this.submit_btn_text="Create Outlet";
                this.outlet.id='';
                this.outlet.retailer_id='';
                this.outlet.outlet_name='';
                this.outlet.outlet_phone='';
                this.outlet.bussiness_person_name='';
                this.outlet.bussiness_person_cnic='';
                this.outlet.bussiness_person_phone='';

                this.outlet.city_id='';
                this.outlet.region_id='';
                this.outlet.address='';
                this.outlet.longitude='';
                this.outlet.latitude='';

                this.outlet.security_check_amount='';
                this.outlet.copy_image='';
                this.outlet.credit_limit='';
                this.outlet.credit_duration='';
            },
            update_outlet:function(){
                axios.post('../outlet/update_outlet',this.outlet).then(response=>{
                    if(response.data==201){
                        this.get_all_outlets();
                        this.message="Outlet has been updated!";
                        this.edit_enable=0;
                        this.submit_btn_text="Create Outlet";
                        this.outlet.id='';
                        this.outlet.retailer_id='';
                        this.outlet.outlet_name='';
                        this.outlet.outlet_phone='';
                        this.outlet.bussiness_person_name='';
                        this.outlet.bussiness_person_cnic='';
                        this.outlet.bussiness_person_phone='';

                        this.outlet.city_id='';
                        this.outlet.region_id='';
                        this.outlet.address='';
                        this.outlet.longitude='';
                        this.outlet.latitude='';

                        this.outlet.security_check_amount='';
                        this.outlet.copy_image='';
                        this.outlet.credit_limit='';
                        this.outlet.credit_duration='';
                    }
                    else{
                        alert(response.data);
                        this.btndisabled=false;
                    }

                });
            }
        }
    }

    $(document).ready(function(){
        setTimeout(function(){
            $('#outlet_table').DataTable();
        },8000);
    });







</script>
<style>
    #form-section{
        border:1px solid black;
    }
</style>

