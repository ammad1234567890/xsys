<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Consignment Inspection</div>

                    <div class="panel-body">

                            <div class="row">
                                <div class="col-md-2">
                                    <label>Warehouse</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="textbox" placeholder="Warehouse Name" v-model="received_warehouse_name" readonly>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Scan Items</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="textbox" placeholder="Imei Number" v-model="imei_no">
                                </div>
                                <div class="col-md-4">

                                    <span>Manual <input type="checkbox" v-model="enabled_manual"/> </span>
                                    <button class="btn btn-primary" @click="enter_imei()" :disabled="enabled_manual==false">Enter</button>
                                </div>
                                <div class="col-md-1"></div>
                            </div>

                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Scanned Imeis List</div>

                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" border="1">
                            <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Imei</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(imei, index) in imeis">
                                    <td>{{index+1}}</td>
                                    <td>{{imei.imei}} <span v-if="imei.is_error==1" style="color:red;">{{imei.error_text}}</span></td>
                                    <td><button @click="remove_imei(index, imei.imei)"><i class="fa fa-times"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                        <div style="margin-left:20px; margin-bottom:10px;">
                            <!--<button  class="btn btn-primary">Submit Items</button>-->

                            <button @click="submit_imeis" type="button" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">Submit Items</button>
                        </div>
                </div>


            </div>
        </div>
    </div>
</template>

<script>
    import {constant} from '../constant.js';
    import vSelect from "vue-select"
    export default {
        components: {vSelect},
        data(){
            return{
                received_warehouse_name:'',
                receive_warehouse_id:'',
                enabled_manual:false,
                imei_no:'',
                imeis:[],
                max_scan_limit: 500
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('./currentWarehouse').then(response=>{
                this.received_warehouse_name=response.data.name;
                this.receive_warehouse_id=response.data.id;
            });

        },

        watch: {

            imei_no: function () {
                if(this.enabled_manual==false) {

                        if (this.imei_no.length >= 15) {
                            if((this.imeis.length)>=this.max_scan_limit){
                                alert("You cannot scan more than "+this.max_scan_limit+" Items");
                            }
                            else{
                                var is_repeated=0;
                                for(var i=0; i<this.imeis.length; i++){
                                    if(this.imei_no==this.imeis[i].imei){
                                        is_repeated=1;
                                    }
                                }

                                if(is_repeated==0){
                                    this.imeis.push({is_error:0, imei:this.imei_no, error_text:''});
                                    this.imei_no='';
                                }
                                else{
                                    alert("This Imei has already Scanned!");
                                    this.imei_no='';
                                }
                            }
                        }
                    }
                }
        },
        methods:{
            remove_imei(index, imei){
                var confirm_Result= confirm("Are you sure to remove this item "+imei+"?");
                if(confirm_Result){
                    this.imeis.splice(index, 1);
                }

            },
            enter_imei(){
                if(this.imei_no!=""){
                    if((this.imeis.length)>=this.max_scan_limit){
                        alert("You cannot scan more than "+this.max_scan_limit+" Items");
                    }
                    else{
                        var is_repeated=0;
                        for(var i=0; i<this.imeis.length; i++){
                            if(this.imei_no==this.imeis[i].imei){
                                is_repeated=1;
                            }
                        }

                        if(is_repeated==0){
                            this.imeis.push({is_error:0, imei:this.imei_no, error_text:''});
                            this.imei_no='';
                        }
                        else{
                            alert("This Imei has already Scanned!");
                            this.imei_no='';
                        }
                    }
                }
                else{
                    alert("Please Enter Imei Number!");
                }

            },
            submit_imeis(){
                if(this.imeis.length!=0){
                    if(this.imeis.length<=this.max_scan_limit){
                        var confirm_result=confirm("Are you sure? You want to submit the Items?");
                        if(confirm_result){
                            $('#load').button('loading');
                            axios.post(constant.base_url+'submit_consignment_imeis', {'imeis':this.imeis, 'warehouse_id': this.receive_warehouse_id}).then((response)=>{
                                $('#load').button('reset');
                                if(response.data.error_found==1){
                                    for(var i=0; i<this.imeis.length; i++){
                                        for(var j=0; j< response.data.details.length; j++){
                                            if(this.imeis[i].imei == response.data.details[j].imei){
                                                this.imeis[i].is_error=1;
                                                this.imeis[i].error_text= response.data.details[j].error_text;
                                            }
                                        }
                                    }
                                }
                                else if(response.data.error_found==0){
                                    alert("Items has been Received Succesfully!");
                                    location.reload();
                                }
                            });
                        }
                    }
                    else{
                        alert("You can only submit "+this.max_scan_limit+" at a time!");
                    }
                }
                else{
                    alert("Please Scan the Items!");
                }

            }
        }
    }
    var showed=false;
    function loadDatatable(show,type,visible){
        var id;
        if(type=="detail"){
            id="#detailTable";
        }else{
            id="#warehousestocktable";
        }
        if(show==true){
            console.log(show);
            setTimeout(function(){
                var table=$(id).DataTable({
                    "order": [[ 0,"desc" ]],
                    "pagingType": "full_numbers",
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    responsive: false,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search records",
                    }
                });
                if(visible==true){
                    table.column( 1 ).visible( true );
                }else{
                    table.column( 1 ).visible( false );
                }

            },3000);
            showed=true;

        }else{
            if(showed==true){
                $(id).DataTable().destroy();
                // table.destroy();

            }
        }
    }
</script>
