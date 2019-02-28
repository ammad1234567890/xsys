<template>
    <div class="row">
        <!--<div class="col-md-4 panel panel-default">-->
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">Change Account Password</h2>
            </div>
            <div class="panel-body">
                <form @submit="change_password($event)">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Current Password<span style="color:red;">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <input type="password" class="textbox" v-model="old_pass">
                            <span style="color:red; font-size:10px;" v-if="old_pass_error!=''">{{old_pass_error}}</span>
                        </div>
                        <div class="col-md-1"></div>


                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>New Password<span style="color:red;">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <input type="password" class="textbox" v-model="new_pass">
                            <span style="color:red; font-size:10px;" v-if="new_pass_error!=''">{{new_pass_error}}</span>
                        </div>

                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Re-Enter New Password<span style="color:red;">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <input type="password" class="textbox" v-model="reEnter_pass">
                            <span style="color:red; font-size:12px;" v-if="renter_pass_error!=''">{{renter_pass_error}}</span>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </form>
            </div>
        </div>



    </div>
</template>

<script>
    import {constant} from '../constant.js';
    export default {

        data(){
            return{
                old_pass:'',
                old_pass_error:'',
                new_pass:'',
                reEnter_pass:'',
                new_pass_error:'',
                renter_pass_error:''
            }
        },
        watch:{
            new_pass:function(){
                var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})");
                if(strongRegex.test(this.new_pass)){
                    this.new_pass_error=""
                }
                else{
                    this.new_pass_error="Password must be contain Lower Case Aplhabet, UpperCase Alphabet and numbers"
                }
            },
            renter_pass_error:function(){
                this.renter_pass_error=""
            },

        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){

        },
        methods:{
            change_password:function(e){
                e.preventDefault();
                this.old_pass_error="";
                if(this.new_pass_error==''){
                    if(this.old_pass!='' && this.new_pass!='' && this.reEnter_pass!=''){
                        if(this.new_pass==this.reEnter_pass){
                            axios.post(constant.base_url+'update_user_password',{'new_pass':this.new_pass, 'old_pass': this.old_pass}).then((response)=>{
                                if(response.data==0){
                                    this.old_pass_error="You have entered Incorrect password";
                                }
                                else{
                                    alert("Your Password has been Changed, Now you need to Re-Login your Account!");
                                    document.getElementById('logout-form').submit();
                                }
                            });
                        }
                        else{
                            alert("New Password doesn't Matched!");
                        }
                    }
                    else{
                        alert("Please Fill up all the fields!");
                    }
                }

            }
        }
    }


</script>
