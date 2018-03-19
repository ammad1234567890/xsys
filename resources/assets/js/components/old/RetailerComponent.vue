<template>

<div class="row">
    <div class="col-md-12">

        <h2 style="margin-top: 6px; font-variant: small-caps; font-weight:bold;">Retailer Accounts</h2>
        <hr/>
        <div class="panel panel-info">
            <div class="panel-heading">Add New Retailer</div>

            <div class="panel-body">
                <div class="alert alert-success"  v-if="message && success_msg==1">
                    <strong>{{message}}</strong>
                </div>
                <div class="alert alert-danger"    v-if="message && success_msg==0">
                    <strong>{{message}}</strong>
                </div>
                <form @submit.prevent="add_retailer">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Full Name</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="textbox" v-model="retailer.fullname" name="fullname" autocomplete="off" required/>
                        </div>

                        <div class="col-md-2">
                            <label>CNIC</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="textbox" v-model="retailer.cnic" name="cnic" id="cnic" v-mask="'99999-9999999-9'" autocomplete="off" required/>
                        </div>
                    </div>




                    <div class="row">


                        <div class="col-md-2">
                            <label>Image</label>
                        </div>
                        <div class="col-md-4" v-if="!retailer.uploadImage">
                            <input type="file" class="textbox" v-on:change="file_preview" ref="imageInput" name="image" autocomplete="off" required/>
                        </div>
                        <div class="col-md-4" v-else>
                            <img :src="retailer.uploadImage" class="img img-responsive" />
                            <button @click="removeRetailerImage" class="image_close_btn"><i class="fa fa-times"></i> </button>
                        </div>


                        <div class="col-md-2">
                            <label>Phone Number</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="textbox phone_no" v-model="retailer.phone_no" v-mask="'9999-9999999'"  name="phone_no" required/>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3 pull-right" v-if="edit_enable==0">
                            <button type="submit" class="btn buttondesign" :disabled="btndisabled">{{submit_btn_text}}</button>
                        </div>
                        <div class="col-md-5 pull-right" v-else>
                            <div class="col-md-6">
                                <button type="button" v-on:click="edit_retailer" class="btn buttondesign"><i class="fa fa-check"></i> {{submit_btn_text}}</button>
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
            <div class="panel-heading">Retailer - Details</div>

            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>CNIC</th>
                        <th>Phone Number</th>
                        <th>Active Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(retailer,index) in retailerData">
                        <td>{{retailer.name}}</td>
                        <td>{{retailer.cnic}}</td>
                        <td>{{retailer.phone_no}}</td>
                        <td v-if="retailer.is_deleted==1"><i class="fa fa-times" style="text-align:center; display:block; font-size:25px; color:red;"></i> </td>
                        <td v-else><i class="fa fa-check" style="text-align:center; display:block; font-size:25px; color:green;"></i></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Action
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><button class="btn btn-primary form-control" v-on:click="edit(index)">Edit</button></li>

                                    <li v-if="retailer.is_deleted==0" style="margin-top: 5px;"><button class="btn btn-danger form-control" v-on:click="delete_retailer(retailer.id,index)">Delete</button></li>

                                </ul>
                                -
                                <button class="btn btn-default dropdown-toggle" type="button" v-on:click="view_retailer_details(index)">View Details</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- View Details Modal Start-->
        <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="retailer_info_modal" aria-labelledby="bs-add-Model-modal-md">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Retailer Information</h4>
                    </div>
                    <div class="modal-body">
                        <span style="position: absolute;right: 0px;top: 0px; background: green;color: #fff;padding-right: 10px; padding-left: 10px;" class="pull-right" v-if="retailer_view.is_deleted==0"><i class="fa fa-check"></i> Active Retailer</span>
                        <span style="position: absolute;right: 0px;top: 0px; background: red;color: #fff;padding-right: 10px; padding-left: 10px;" class="pull-right" v-else><i class="fa fa-times"></i> Non-Active Retailer</span>
                        <div class="clearfix"></div>
                        <br/>
                        <div class="row">

                            <div class="col-md-4">
                                <img :src="retailer_view.uploadImage" height="185px" width="100%"/>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-hovered">
                                    <tr>
                                        <td>
                                            <span style="font-weight:bold;">Full Name</span>
                                        </td>
                                        <td>
                                            {{retailer_view.fullname}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span style="font-weight:bold;">Phone Number</span>
                                        </td>
                                        <td>
                                            {{retailer_view.phone_no}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span style="font-weight:bold;">CNIC</span>
                                        </td>
                                        <td>
                                            {{retailer_view.cnic}}
                                        </td>
                                    </tr>
                                </table>
                            </div>
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
    //var base_url = window.location.origin;

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

                btndisabled:false,
                edit_enable:0,
                editIndex:null,
                submit_btn_text:'Add Retailer',
                success_msg:0,
                message:'',
                retailer:{
                    id:'',
                    fullname:'',
                    cnic:'',
                    phone_no:'',
                    uploadImage:'',
                    aging_amount:'',
                },
                retailer_view:{
                    id:'',
                    fullname:'',
                    cnic:'',
                    phone_no:'',
                    uploadImage:'',
                    is_deleted:0,
                },
                retailerData:[],
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
                this.getRetailerData();

            },
            view_retailer_details(index){
                $('#retailer_info_modal').modal('show');
                this.retailer_view={
                    id:this.retailerData[index].id,
                    fullname:this.retailerData[index].name,
                    cnic:this.retailerData[index].cnic,
                    phone_no:this.retailerData[index].phone_no,
                    uploadImage:'../public/retailers_img/'+this.retailerData[index].image,
                    is_deleted:this.retailerData[index].is_deleted,
                }
            },
            edit(index){
                this.editIndex=index;
                this.retailer={
                    id:this.retailerData[index].id,
                    fullname:this.retailerData[index].name,
                    cnic:this.retailerData[index].cnic,
                    phone_no:this.retailerData[index].phone_no,
                    uploadImage:'../public/retailers_img/'+this.retailerData[index].image,
                }
                this.edit_enable=1;
                this.submit_btn_text="Save Changes";
            },
            close_edit_mode(){
                this.edit_enable=0;
                this.submit_btn_text="Add Retailer";
                this.retailer={
                    id:'',
                    fullname:'',
                    cnic:'',
                    phone_no:'',
                    uploadImage:'',
                }
            },
            getRetailerData: function() {
                axios.get('retailer/get_retailers').then((response) => {
                    this.retailerData=response.data;
                });
            },
            removeRetailerImage(e){
                e.preventDefault();
                this.retailer.uploadImage='';
            },
            file_preview(e){
                console.log(e.target.files[0])
                var fileReader = new FileReader();

                fileReader.readAsDataURL(e.target.files[0])

                fileReader.onload = (e) => {
                    this.retailer.uploadImage= e.target.result
                }

                console.log(this.retailer);
            },
            delete_retailer:function(id, index){
                this.retailer.id=id;
                //alert(this.retailer.id);
                axios.post('retailer/delete_retailer',this.retailer).then(response=>{
                    if(response.data==201) {
                        this.message = "Retailer has been Deleted!";
                        this.getRetailerData();
                        this.retailer.id='';
                    }
                    else{
                        alert(response.data);
                    }
                });
            },
            edit_retailer:function(){
                axios.post('retailer/edit_retailer',this.retailer).then(response=>{
                    if(response.data==201){
                        this.message="Retailer Data has been Updated!";
                        this.getRetailerData();
                        this.retailer.id='';
                        this.retailer.fullname='';
                        this.retailer.cnic='';
                        this.retailer.phone_no='';
                        this.retailer.uploadImage='';
                        this.submit_btn_text='Add Retailer';
                        this.btndisabled=false;
                        this.edit_enable=0;
                        this.success_msg=1;
                    }
                    else if(response.data==406){
                        this.message="This retailer has already exist!";
                        this.submit_btn_text='Add Retailer';
                        this.btndisabled=false;
                        this.success_msg=0;
                    }
                    else{
                        alert(response.data);
                        this.btndisabled=false;
                    }
                });

            },
            add_retailer: function () {
                this.$validator.validateAll()
                this.submit_btn_text='Please Wait ...';
                this.btndisabled=true;
                if (!this.errors.any()) {
                    //alert(this.retailer.uploadImage);

                   axios.post('retailer/create_retailer',this.retailer).then(response=>{
                        if(response.data==201){
                            this.message="New Retailer has been Created!";
                            this.getRetailerData();
                                this.retailer.fullname='';
                                this.retailer.cnic='';
                                this.retailer.phone_no='';
                                this.retailer.uploadImage='';
                                this.submit_btn_text='Add Retailer';
                                this.btndisabled=false;
                                this.success_msg=1;
                        }
                        else if(response.data==406){
                            this.message="This retailer has already exist!";
                            this.submit_btn_text='Add Retailer';
                            this.btndisabled=false;
                            this.success_msg=0;
                        }
                        else{
                            alert(response.data);
                            this.btndisabled=false;
                            this.success_msg=0;
                        }
                    });

                }

            }
        }
    }

</script>

