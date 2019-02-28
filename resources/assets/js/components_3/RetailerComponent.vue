<template>

<div class="row">
    <div class="col-md-12">

        <h2 style="margin-top: 6px; font-variant: small-caps; font-weight:bold;">Retailer Accounts</h2>
        <div class="panel panel-info">
            <div class="panel-heading">Add New Retailer Outlet</div>

            <div class="panel-body">
                <div class="alert alert-success"  v-if="message && success_msg==1">
                    <strong>{{message}}</strong>
                </div>
                <div class="alert alert-danger"    v-if="message && success_msg==0">
                    <strong>{{message}}</strong>
                </div>
                <form @submit.prevent="add_retailer">
                    <div class="row">

                        <div class="col-md-6 col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Retailer Name</label>
                                <input type="text" class="form-control" v-model="retailer.fullname" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Retailer Outlet</label>
                                <input type="text" class="form-control" v-model="retailer.cnic" v-mask="'99999-9999999-9'" autocomplete="off" required>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-3"  v-if="!retailer.uploadImage">
                            <div class="form-group label-floating">
                                <label class="control-label">Retailer Image</label>
                                <input type="file" class="form-control" v-on:change="file_preview" ref="imageInput" name="image" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-4" v-else>
                            <img :src="retailer.uploadImage" class="img img-responsive form-control" />
                            <button @click="removeRetailerImage" class="image_close_btn"><i class="fa fa-times"></i> </button>
                        </div>

                        <div class="col-md-6 col-sm-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Retailer Phone#</label>
                                <input type="text" class="form-control" v-model="retailer.phone_no" v-mask="'9999-9999999'" autocomplete="off" required>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>

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

