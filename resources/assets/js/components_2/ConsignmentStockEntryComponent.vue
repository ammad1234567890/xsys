<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10">

              <!-- Alert Dialog with user action required -->
                <div class="modal  fade" id="div_detailed_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                
                        <div class="modal-body">
                        
                        <div class="row">
                        <div class="col-md-2 paddingtop5">
                            <img :src="alert_image_url" />
                        </div>
                        <div class="col-md-8 paddingtop5">


                        <p class="  text-center " style=" padding-top:12px;">{{detailedMessage}}</p>       
                        </div>
                        <div class="col-md-2">
                        
                        <button type="button" class="  close close_btn_settings" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        </div>
                        </div>
                    <!-- <div class="modal-footer  " style="text-align:center; margin-top:0;">
                        <button type="button" class="btn btn-primary ">  Login Account</button>
                        <button type="button" class="btn btn-primary"  data-dismiss="modal">Cancel</button>
                        </div> -->
                    </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Consignment Inspection</div>

                    <div class="panel-body">
                        <form>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Order No</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="textbox" placeholder="Order No" v-model="order_no" required readonly>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2">
                                    <label>Receive No</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="textbox" placeholder="Receive No" v-model="receive_no" required readonly>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Warehouse</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="textbox" placeholder="Warehouse Name" v-model="received_warehouse_name" required readonly>
                                </div>
                                <div class="col-md-1"></div>
                            </div>

                        </form>
                        <div>
                            <!-- <h1>TESTING</h1> -->
                            <table id="warehousestocktable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="col-md-1">Select</th>
                                    <th>S.No</th>
                                    <th>Model</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(stock,index) in main_warehouse_receive_products">
                                    <td><input type="checkbox" v-model="stock.isTrue" @change="change_checkbox(index, stock.product_color_id, currentWarehouseId, main_receive_id, stock.product_qty,stock.product_color_name, stock.product_name, stock.product_id)" name=""></td>
                                    <td>{{index + 1}}</td>
                                    <td>{{stock.product_name}}</td>
                                    <td>{{stock.product_color_name}}</td>
                                    <td>
                                        <input type="number" v-model="stock.product_qty" name="" min="0" v-bind:max="stock.product_qty" readonly>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <h5 v-if="current_scanning_product!=''"><b>{{current_scanning_product}}</b> <span style="float:right;"><b>Items Left for Scan:{{current_product_qty_left}}</b></span></h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" placeholder="Add Imei's" v-model="imei_text" class="textbox"/>
                                </div>
                                <div class="col-md-6">
                                    <Label>Manual: </Label>
                                    <input type="checkbox" v-model="manual_enabled"/>
                                    <button class="btn btn-success" v-on:click="add_manual($event)" :disabled="manual_enabled==0">Submit</button>
                                </div>
                            </div>

                            <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr>
                                        <td>S.no</td>
                                        <td>Model/Color</td>

                                        <td>Imei</td>
                                    </tr>
                                </thead>
                                <tbody v-for="(i, index_one) in items">
                                    <tr v-for="(j, index) in i.imei">
                                        <td>{{index+1}}</td>
                                        <td v-if="index==0" :rowspan="i.imei.length" style="vertical-align: top; font-weight:bold;">{{i.productName}}, {{i.productColorName}}</td>
                                        <td v-if="error_in_imei==j" style="background:red;">{{j}} <button style="color:blue; background:transparent; border:0px;" v-on:click="RemoveImei(index_one, index)">Remove</button></td>
                                        <td v-else>{{j}} <button style="color:blue; background:transparent; border:0px;" v-on:click="RemoveImei(index_one, index)">Remove</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <button style="margin-top:10px;" v-on:click="submit_imeis()" class="btn btn-primary" :disabled="submit_button_disabled==1">{{submit_button_text}}</button>

                    </div>



                </div>

            </div>
        </div>
    </div>
</template>
<script>
    import vSelect from "vue-select"
    export default {
        components: {vSelect},
        data() {
            return {
                submit_button_text:"Submit",
                submit_button_disabled:0,
                manual_enabled:false,
                alert_image_url:'../img/xsys_alert.png',
                detailedMessage:'',
                selected_product_available_imei:[],
                error_in_imei:'',
                current_product_qty_left:'',
                current_scanning_product:'',
                current_selected_index:'',
                received_warehouse_name:'',
                order_no:'',
                receive_no:'',
                currentWarehouseId:'',
                main_warehouse_receive_products:[],
                items:[],
                main_receive_id:0,
                selected_qty:0,
                imei_text:'',

            }
        },
        watch:{
            imei_text:function(){
                    var is_repeated=0;
                if (this.manual_enabled == false) {
                    if(this.imei_text.length>=15){
                        if(this.current_product_qty_left==0){
                            this.showDetailedMessage("Kindly Select any product to scan the imei's");
                            this.imei_text='';
                        }
                        else{
                            for(var i=0; i<this.items.length; i++){
                                for(var j=0; j<this.items[i].imei.length; j++){
                                    if(this.items[i].imei[j]==this.imei_text){
                                        is_repeated=1;
                                        break;
                                    }
                                }
                            }
                            var is_valid=0;
                            for(var i=0; i<this.selected_product_available_imei.length; i++){
                                //alert(this.selected_product_available_imei[i].imei1);
                                if(this.imei_text==this.selected_product_available_imei[i].imei1){
                                    if (is_repeated == 0) {
                                        for(var i=0; i<this.items.length; i++) {
                                            if (this.items[i].select_from_index == this.current_selected_index) {
                                                this.items[i].imei.push(this.imei_text);
                                                break;
                                            }
                                        }
                                    }

                                    is_valid=1;
                                    break;
                                }
                            }

                            if(is_valid==0){
                                this.showDetailedMessage("Invalid IMEI");
                            }
                            else if(is_repeated==1){
                                this.showDetailedMessage("IMEI scanned already");
                            }
                            this.imei_text='';
                            this.get_remaining_qty_of_selected_product(this.current_selected_index);
                        }

                    }
                }


            }
        },
        filters:{

        },
        created(){

            this.get_main_warehouse_receive();

        },
        methods:{
            showDetailedMessage(message){
                this.detailedMessage = message;
                $('#div_detailed_message').modal("show");
            },
            get_main_warehouse_receive(){
                axios.get('../get_main_warehouse_receive_data/'+window.location.pathname.split('/')[4]).then((response)=>{
                    this.received_warehouse_name=response.data[0].warehouse.name;
                    this.receive_no=response.data[0].receive.receive_no;
                    this.order_no=response.data[0].receive.order.manufacture_order_no;
                    this.currentWarehouseId=response.data[0].warehouse.id;
                    this.main_receive_id=response.data[0].id;
                    for(var i=0; i<response.data[0].receive.receive_products.length; i++){
                        this.main_warehouse_receive_products.push(
                            {
                                isTrue:false,
                                product_id:response.data[0].receive.receive_products[i].product_color.product.id,
                                product_name:response.data[0].receive.receive_products[i].product_color.product.name,
                                product_color_id:response.data[0].receive.receive_products[i].product_color_id,
                                product_color_name:response.data[0].receive.receive_products[i].product_color.color,
                                product_qty:response.data[0].receive.receive_products[i].product_qty,
                            }
                        );
                    }
                });
            },
            change_checkbox(index, product_color_id, warehouse_id, main_receive_id, quantity, productColorName, productName, product_id){

                //alert(warehouse_id);

                if(this.main_warehouse_receive_products[index].isTrue){
                    if(this.current_product_qty_left==0){
                        //Add the final item quantity
                        this.selected_qty+=this.main_warehouse_receive_products[index].product_qty;
                        this.selected_product_available_imei=[];

                        axios.post('../get_all_avaiable_imeis',{product_id: product_id}).then(response=> {
                            this.selected_product_available_imei=response.data;
                        });



                        //Push the data in items which is currently selected
                        this.items.push({
                            productColorName:productColorName,
                            productName:productName,
                            productColor:product_color_id,
                            main_receive:main_receive_id,
                            warehouse_id:warehouse_id,
                            quantity:quantity,
                            imei:[],
                            select_from_index:index,
                        });

                        //Set the CUrrently Selected Product Name
                        this.current_scanning_product="Product Selected: "+this.main_warehouse_receive_products[index].product_name+'-'+this.main_warehouse_receive_products[index].product_color_name;

                        this.get_remaining_qty_of_selected_product(index);

                    }
                    else{
                        this.showDetailedMessage("Complete scanning for the currently selected product first");
                        this.main_warehouse_receive_products[index].isTrue=false;
                    }
                }
                else{
                    var result=confirm("Are you sure you want to uncheck this product? It'll remove all the scanned items from this product");
                    if(result==1){
                        this.selected_qty-=this.main_warehouse_receive_products[index].product_qty;
                        this.main_warehouse_receive_products[index].isTrue=false;
                        this.current_scanning_product='';
                        this.current_product_qty_left='';
                        this.selected_product_available_imei=[];


                        for(var i=this.items.length-1; i>=0; i--){
                            if(this.items[i].select_from_index==index){
                                this.items.splice(i, 1);
                                break;
                            }
                        }
                    }
                    else{
                        this.main_warehouse_receive_products[index].isTrue=true;
                    }
                }
            },
            get_remaining_qty_of_selected_product:function(index){
                //Get the Remainning Quantity of selected Product
                this.current_product_qty_left=0;
                for(var i=0; i<this.items.length; i++){
                    if(this.items[i].select_from_index==index){
                        this.current_product_qty_left+=(this.items[i].quantity)-(this.items[i].imei.length);
                    }
                }
                this.current_selected_index=index;
            },
            RemoveImei:function(item_index, imei_index){
                this.items[item_index].imei.splice(imei_index, 1);
                this.get_remaining_qty_of_selected_product(item_index);
            },
            submit_imeis:function(){
                var is_any_left=0;
                for(var i=0; i<this.main_warehouse_receive_products.length; i++){
                    if(this.main_warehouse_receive_products[i].isTrue==false){
                        is_any_left=1;
                        break;
                    }
                }
                var total_scanned_qty=0;
                for(var i=0; i<this.items.length; i++){
                    total_scanned_qty+=this.items[i].imei.length;
                }



                if((is_any_left==0 && (total_scanned_qty==this.selected_qty))){
                    this.submit_button_text="Please Wait...";
                    axios.post('../receive_consignment_items',{my_items:this.items}).then(response=>{
                        //alert(response.data);
                        if(response.data==201) {
                            this.alert_image_url="../img/xsys_info.png";
                            this.showDetailedMessage("Consignment inspection done successfully");
                            this.submit_button_text="Submit";
                            window.location = "../mainWarehouseReceive";
                        }
                        else{
                            alert(response.data.data);
                            this.error_in_imei=response.data.imei;
                            this.submit_button_text="Submit";
                        }
                    });
                }
                else{
                    alert("Please Scan the items of all the products!");
                }

            },
            add_manual:function(e){
                e.preventDefault();
                if(this.imei_text!=''){
                    if(this.current_product_qty_left==0){
                        this.showDetailedMessage("Kindly Select any product to scan the imei's");
                        this.imei_text='';
                    }
                    else{
                        var is_repeated=0;
                        for(var i=0; i<this.items.length; i++){
                            for(var j=0; j<this.items[i].imei.length; j++){
                                if(this.items[i].imei[j]==this.imei_text){
                                    is_repeated=1;
                                    break;
                                }
                            }
                        }
                        var is_valid=0;
                        for(var i=0; i<this.selected_product_available_imei.length; i++){
                            //alert(this.selected_product_available_imei[i].imei1);
                            if(this.imei_text==this.selected_product_available_imei[i].imei1){
                                if (is_repeated == 0) {
                                    for(var i=0; i<this.items.length; i++) {
                                        if (this.items[i].select_from_index == this.current_selected_index) {
                                            this.items[i].imei.push(this.imei_text);
                                            break;
                                        }
                                    }
                                }

                                is_valid=1;
                                break;
                            }
                        }

                        if(is_valid==0){
                            this.showDetailedMessage("Invalid IMEI");
                        }
                        else if(is_repeated==1){
                            this.showDetailedMessage("IMEI scanned already");
                        }
                        this.imei_text='';
                        this.get_remaining_qty_of_selected_product(this.current_selected_index);
                    }

                }
            }
        }
    }
</script>