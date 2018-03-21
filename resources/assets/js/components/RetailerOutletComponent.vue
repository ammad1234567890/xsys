<template>

        <div class="row">
            <div class="card headcolor">
                <div class="card-header">
                        <h3 class="card-title pad-bot"><i class="material-icons">description</i> <small>RETAILER </small> </h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Create Retailer Account</h2>
                    </div>

                    <div class="panel-body">
                        <div class="alert alert-success"  v-if="message">
                            <strong>{{message}}</strong>
                        </div>
                        <form @submit.prevent="add_outlet">
                            <div class="form-section">
                                <div>
                                    <h4 class="form-section-heading" style="border-bottom:1px solid black; display: inline-block;">RETAILER DETAILS</h4>
                                </div>
                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text" class="form-control" v-model="outlet.fullname" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group">
                                            <label>CNIC No</label>
                                            <input type="text" class="form-control" v-model="outlet.cnic" v-mask="'99999-9999999-9'" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-3"  v-if="!outlet.uploadImage" style="bottom: -26px;">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-xs" style="width:100%;">Select Retailer Image<input type="file" class="form-control" v-on:change="retailer_image_file_preview" ref="imageInput" name="image" autocomplete="off" required></button>
                                        </div>
                                    </div>
                                    <div class="col-md-6" v-else>
                                        <img :src="outlet.uploadImage" class="img img-responsive form-control" style="    width: 100px; height: 90px;" />
                                        <button @click="removeRetailerImage" class="btn btn-pinterest btn-xs"  style="width: 100px;"><i class="fa fa-times"></i> </button>
                                    </div>
                                    <div class="col-md-6 col-sm-3">
                                        <div class="form-group">
                                            <label>Mobile No</label>
                                            <input type="text" class="form-control" v-model="outlet.phone_no" v-mask="'9999-9999999'" autocomplete="off" required>
                                        </div>
                                    </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-section">
                                <div>
                                    <h4 class="form-section-heading" style="border-bottom:1px solid black; display: inline-block;">OUTLET DETAILS</h4>
                                </div>
                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <label>Outlet Name</label>
                                        <input type="text" class="form-control" v-model="outlet.outlet_name" autocomplete="off" required>
                                    </div>
                                </div>


                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <label>Outlet Phone No</label>
                                        <input type="text" class="form-control" v-mask="'9999-9999999'" v-model="outlet.outlet_phone" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-section">
                                <div>
                                    <h4 class="form-section-heading" style="border-bottom:1px solid black; display: inline-block;">BUSINESS PERSON DETAILS</h4>
                                </div>
                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" v-model="outlet.bussiness_person_name" autocomplete="off" name="person_name"  required>
                                    </div>
                                </div>


                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <label>CNIC</label>
                                        <input type="text" class="form-control" v-mask="'99999-9999999-9'" v-model="outlet.bussiness_person_cnic" autocomplete="off" name="person_cnic" minlength="15" maxlength="15" required>
                                    </div>
                                </div>


                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <label>Phone No</label>
                                        <input type="text" class="form-control" v-mask="'9999-9999999'" v-model="outlet.bussiness_person_phone" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-section">
                                <div>
                                    <h4 class="form-section-heading" style="border-bottom:1px solid black; display: inline-block;">LOCATION DETAILS</h4>
                                </div>

                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <select class="form-control" name="city_id" v-model="outlet.city_id" required>
                                            <option value="">Select City</option>
                                            <option v-for="cities in citiesData"  v-bind:value="cities.id">{{cities.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <select class="form-control" name="region_id" v-model="outlet.region_id" required>
                                            <option value="">Select Locality</option>
                                            <option v-for="region in regionsData"   v-bind:value="region.id">{{region.name}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" autocomplete="off" v-model="outlet.address" name="outlet_address" required/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <label>Longitude(OPTIONAL)</label>
                                        <input type="text" class="form-control" autocomplete="off" v-model="outlet.longitude" name="outlet_longitude"/>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <label>Latitude(OPTIONAL)</label>
                                        <input type="text" class="form-control" autocomplete="off" v-model="outlet.latitude" name="outlet_latitude"/>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-section">
                                <div>
                                    <h4 class="form-section-heading" style="border-bottom:1px solid black; display: inline-block;">FINANCIAL DETAILS</h4>
                                </div>

                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <label>Secuity Amount</label>
                                        <!-- <input type="text" class="form-control" autocomplete="off" v-model="outlet.security_check_amount" name="security_check" required/> -->
                                        <vue-numeric currency="Rs" class="form-control" separator="," v-model="outlet.security_check_amount"></vue-numeric>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <label>Credit Limit</label>
                                        <!-- <input type="number" class="form-control" autocomplete="off" v-model="outlet.credit_limit" name="credit_limit" required/> -->
                                        <vue-numeric currency="Rs" class="form-control" separator="," v-model="outlet.credit_limit"></vue-numeric>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-3">
                                    <div class="form-group">
                                        <label>Credit Duration</label>
                                        <input type="number" class="form-control" autocomplete="off" v-model="outlet.credit_duration" name="credit_duration" required/>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-6 col-sm-3"  v-if="!outlet.copy_image" style="bottom: -26px;">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-xs" style="width:100%;">Select Cheque Image<input type="file" class="form-control" v-on:change="file_preview" ref="imageInput" name="security_check_image" autocomplete="off" required></button>
                                        </div>
                                    </div>

                                    <div class="col-md-6" v-else>
                                        <img :src="outlet.copy_image" class="img img-responsive" style="width: 100px; height: 90px;" />
                                        <button @click="removeCopyImage" class="btn btn-pinterest btn-xs" style="width: 100px;"><i class="fa fa-times"></i> </button>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-3 pull-right" v-if="edit_enable==0">
                                    <button type="submit" class="btn btn-tumblr" :disabled="btndisabled">{{submit_btn_text}}</button>
                                </div>
                                <div class="col-md-5 pull-right" v-else>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-tumblr" v-on:click="update_outlet"><i class="fa fa-check"></i> {{submit_btn_text}}</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" v-on:click="close_edit_mode" class="btn btn-pinterest buttondesign"><i class="fa fa-times"></i> Close Editable Mode</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- RETAILER SHOW GRID -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Outlet - Details</h2>
                    </div>

                    <div class="panel-body">
                        <table id="outlet_table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Outlet Name</th>
								<th>Dealer Code</th>
                                <th>Phone Number</th>
                                <th>City</th>
                                <th>Locality</th>
                                <th>Address</th>
                                <th>Retailer Name</th>
                                <th>Bussiness Person</th>
                                <th class="col-md-3">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="(outlets,index) in outletsData">
                                <td>{{outlets.name}}</td>
								 <td>{{outlets.retailer.retailer_no}}</td>
                                <td>{{outlets.phone_no}}</td>
                                <td>{{outlets.city.name}}</td>
                                <td>{{outlets.region.name}}</td>
                                <td>{{outlets.address}}</td>
                                <td>{{outlets.retailer.name}}</td>
                                <td>{{outlets.business_person_name}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" v-on:click="enable_edit_mode(index)">Edit</a></li>

                                            <li><a href="#" v-on:click="delete_outlet(outlets.id)">Delete</a></li>

                                        </ul>
                                        -
                                        <button class="btn btn-github btn-xs" type="button" v-on:click="view_outlet_details(index)">View Details</button>
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
                                    <h4 class="form-section-heading">Retailer</h4>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img :src="outlet_view.retailer_image" height="65px" width="100%"/>
                                        </div>
                                        <div class="col-md-10">
                                            <table class="table table-hovered">
                                                <tr>
                                                    <td>Name</td>
                                                    <td>{{outlet_view.retailer_name}} ({{outlet_view.retailer_no}})</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone</td>
                                                    <td>{{outlet_view.retailer_phone}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Cnic</td>
                                                    <td>{{outlet_view.retailer_cnic}}</td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-section padding10px">
                                    <h4 class="form-section-heading">Outlet</h4>
                                    <br/>

                                    <table class="table table-hovered">
                                        <tr>
                                            <td>Name</td>
                                            <td>{{outlet_view.outlet_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>{{outlet_view.outlet_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Contact Person Name</td>
                                            <td>{{outlet_view.bussiness_person_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Contact Person Phone</td>
                                            <td>{{outlet_view.bussiness_person_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Contact Person CNIC</td>
                                            <td>{{outlet_view.bussiness_person_cnic}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-section padding10px">
                                    <h4 class="form-section-heading">Location</h4>
                                    <br/>
                                    <table class="table table-hovered">
                                        <tr>
                                            <td>Address</td>
                                            <td>{{outlet_view.address}}</td>
                                        </tr>
                                        <tr>
                                            <td>Locality</td>
                                            <td>{{outlet_view.region_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td>{{outlet_view.city_name}}</td>
                                        </tr>


                                        <tr>
                                            <td>Latitude</td>
                                            <td v-if="outlet_view.latitude!=null">{{outlet_view.latitude}}</td>
                                            <td v-else> --- </td>
                                        </tr>
                                        <tr>
                                            <td>Longitude</td>
                                            <td v-if="outlet_view.longitude!=null">{{outlet_view.longitude}}</td>
                                            <td v-else> --- </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-section padding10px">
                                    <h4 class="form-section-heading">Financial Status</h4>
                                    <br/>
                                    <table class="table table-hovered">
                                        <tr>
                                            <td>Security Check Amount</td>
                                            <td>{{outlet_view.security_check_amount | currency('Rs')}}</td>

                                        </tr>
                                        <tr>
                                            <td>Credit Limit</td>
                                            <td>{{outlet_view.credit_limit | currency('Rs')}}</td>
                                        </tr>
                                        <tr>
                                            <td>Credit Duration</td>
                                            <td>{{outlet_view.credit_duration}}</td>
                                        </tr>

                                        <tr>
                                            <td>Security Cheque Image</td>
                                            <td><a :href="'./deposit_check_img/'+outlet_view.copy_image" target="_blank">Link</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-github" data-dismiss="modal" aria-label="Close">Close</button>
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
                submit_btn_text:'Create Account',
                message:'',
                outlet:{
                    id:'',
                    fullname:'',
                    cnic:'',
                    phone_no:'',
                    uploadImage:'',

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
					retailer_no:'',
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

                regionsData:[],
                outletsData:[],
                citiesData:[],

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
                this.get_regions();
                this.get_all_outlets();
            },
            removeCopyImage:function(e){
                e.preventDefault();
                this.outlet.copy_image="";
            },
            removeRetailerImage:function(e){
                e.preventDefault();
                this.outlet.uploadImage="";
            },
            retailer_image_file_preview(e){
                console.log(e.target.files[0])
                var fileReader = new FileReader();

                fileReader.readAsDataURL(e.target.files[0])

                fileReader.onload = (e) => {
                    this.outlet.uploadImage= e.target.result
                }

                console.log(this.outlet);
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
            add_outlet:function(){
                axios.post('./outlet/create_outlet',this.outlet).then(response=>{
                    alert(response.data);
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

                        this.outlet.uploadImage='';
                        this.outlet.fullname='';
                        this.outlet.cnic='';
                        this.outlet.phone_no='';
                        this.message="New Retailer has been created!";
                        $("html, body").animate({
                            scrollTop: 0
                        }, 600);
                        demo.swal({title:this.message});
                        demo.showSwal('success-message');

                    }
                    else if(response.data==406){
                        this.get_all_outlets();
                        this.message="Account has already exist!";
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
                        $("html, body").animate({
                            scrollTop: 0
                        }, 600);
                        demo.showSwal('success-message');
                        demo.swal({title:this.message});
                    }
                    else{
                        alert(response.data);
                    }
                });
            },
            get_all_outlets:function(){
                axios.get('./outlet/get_all_outlets').then(response=>{
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
					this.outlet_view.retailer_no=this.outletsData[index].retailer.retailer_no;
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
                    this.outlet_view.retailer_image='./retailers_img/'+this.outletsData[index].retailer.image;

                    this.outlet_view.city_name=this.outletsData[index].city.name;
                    this.outlet_view.region_name=this.outletsData[index].region.name;
            },
            //Function for Deactivating the Outlet, It Required only outlet_id.
            delete_outlet(outlet_id){
                this.outlet.id=outlet_id;
                axios.post('./outlet/delete_outlet',this.outlet).then(response=>{
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
                this.outlet.copy_image="./deposit_check_img/"+this.outletsData[index].security_deposit_image;
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
            },
            get_cities:function(){
                axios.get('./allCities').then(response=>{
                    this.citiesData=response.data;
                });
            },
            get_regions:function(){
                axios.get('./allRegions').then(response=>{
                    this.regionsData=response.data;
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

