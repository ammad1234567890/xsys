<template>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Change Stock Type</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <label for="Warehouse">Change From<span style="color:red;">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <select class="textbox" v-model="change_from">
                                    <option value="0">-- Select Stock Type --</option>
                                    <option v-for="s_type in stock_types" v-if="s_type.id!=change_to" v-bind:value="s_type.id">{{s_type.type}}</option>
                                </select>
                            </div>


                            <div class="col-md-2">
                                <label for="Warehouse">Change To<span style="color:red;">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <select class="textbox" v-model="change_to">
                                    <option value="0">-- Select Stock Type --</option>
                                    <option v-for="s_type in stock_types" v-if="s_type.id!=change_from" v-bind:value="s_type.id">{{s_type.type}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-2">
                                <label for="Warehouse">Remarks<span style="color:red;">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <textarea class="textbox" v-model="remarks">

                                </textarea>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <button class="btn btn-primary" @click="enter_imeis()">Enter Imei's</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" v-if="enter_imei_enabled==1">
            <div class="panel panel-default">
                <div class="panel-heading">{{change_from_name}} to {{change_to_name}}</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="textbox" v-model="imei_no" placeholder="Enter Imei's"/>
                        </div>
                        <div class="col-md-6">
                            <span>Manual <input type="checkbox" v-model="enabled_manual"/> </span>
                            <button class="btn btn-primary" @click="enter_imei()" :disabled="enabled_manual==false">Enter</button>
                        </div>

                        <div class="col-md-12">
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
                                        <td><button @click="remove_imei(index)"><i class="fa fa-times"></i></button></td>

                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="col-md-12">
                            <button @click="submit_imeis">Submit</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                currentWarehouse:'',
                currentWarehouseId:'',
                imei_no:'',
                change_from:0,
                change_to:0,
                change_from_name:'',
                change_to_name:'',
                remarks:'',
                enter_imei_enabled:0,
                enabled_manual:false,
                stock_types:[
                    {
                        'id':1,
                        'type': 'Major'
                    },
                    {
                        'id':2,
                        'type': 'Mini',
                    },
                    {
                        'id':3,
                        'type': 'Damage',
                    }
                ],
                imeis:[]
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created: function () {
            this.init();
        },
        watch: {
            imei_no: function () {
                if(this.enabled_manual==false) {
                    if (this.imei_no.length >= 15) {
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
        },
        methods:{
            init:function(){
                axios.get('../currentWarehouse').then(response=>{
                    this.currentWarehouse=response.data.name;
                    this.currentWarehouseId=response.data.id;
                });
            },
            enter_imeis(){
                if(this.change_to==0 || this.change_from==0){
                    this.enter_imei_enabled=0;
                    alert("Please select the Stock types!");
                }
                else{
                    if(this.remarks==''){
                        alert("Please type Remarks!");
                    }
                    else{
                        for(var i=0; i<this.stock_types.length; i++){
                            if(this.stock_types[i].id==this.change_to){
                                this.change_to_name=this.stock_types[i].type;
                            }
                            if(this.stock_types[i].id==this.change_from){
                                this.change_from_name=this.stock_types[i].type;
                            }
                        }
                        this.enter_imei_enabled=1;
                    }
                }

            },
            enter_imei(){
                if(this.imei_no!=""){
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
                else{
                    alert("Please Enter Imei Number!");
                }

            },
            remove_imei(index){
                this.imeis.splice(index, 1);
            },
            submit_imeis:function(){
                if(this.imeis.length==0){
                    alert("Kindly Scan the imei's!");
                }
                else{
                    var submit_data={
                        imeis: this.imeis,
                        change_from: this.change_from,
                        change_to: this.change_to,
                        warehouse_id: this.currentWarehouseId,
                        remarks:this.remarks
                    }
                    axios.post("../warehouse/update_stock_type",submit_data).then((response)=>{
                        if(response.data==201){
                            alert("Stock successfully tranfer to "+this.change_to_name+" Stock");
                            location.reload();
                        }
                        else{
                            for(var i=0; i<this.imeis.length; i++){
                                for(var j=0; j<response.data.length; j++){

                                    if(response.data[j].imei==this.imeis[i].imei){
                                        this.imeis[i].is_error=1;
                                        this.imeis[i].error_text=response.data[j].error_text;
                                    }
                                    //alert(response.data[i].error_text);
                                }
                            }

                        }
                    });

                }
            }
        }
    }
</script>