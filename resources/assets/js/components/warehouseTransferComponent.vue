<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Warehouse Transfer</div>

                    <div class="panel-body">
                        <form>

                            <div class="col-md-2">
                                <label for="Warehouse">Warehouse<span style="color:red;">*</span></label>
                             </div>
                            <div class="col-md-3">
                                <input type="text" class="textbox" v-model="currentWarehouse" placeholder="Model Name" required readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="SubWarehouse">Sub-Warehouse<span style="color:red;">*</span></label>
                            </div>
                            <div class="col-md-3">
                                <select class="textbox" name="SubWarehouse" v-model="newTransfer.subWarehouse" required disabled="true">
                                    <option value="">Select Warehouse</option>
                                    <option v-for="warehouse in warehouses" v-bind:value="warehouse.id">{{warehouse.name}}</option>
                                </select>
                                <span class="text-danger" v-show="errors.has('SubWarehouse')">
                                    {{errors.first('SubWarehouse')}}
                                </span>
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
                                  <th>Stock History</th>
                                  <th>Transfer Quantity</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="(stock,index) in newTransfer.details">
                                  <td><input type="checkbox" v-model="stock.isTrue" @change="change_checkbox(stock.warehouseId, stock.productId, stock.productColorId, index)" name=""></td>
                                  <td>{{index + 1}}</td>
                                  <td>{{stock.productName}}</td>
                                  <td>{{stock.productColor}}</td>
                                  <td><a v-bind:href="'../stock_item_history/'+currentWarehouseId+'/'+stock.productColorId" target="_blank">{{stock.productName}}, {{stock.productColor}}</a></td>
                                  <td>
                                      <input type="number" v-model="stock.transferQty" name="" min="0" v-bind:max="stock.productQuantity" readonly>
                                  </td>

                                </tr>
                              </tbody>
                            </table>

                             <input type="text"  v-model="imei" placeholder="Add Imei's" class="textbox"/>
                             

                             <div class="row" style="margin-top:10px;">
                                 <div class="col-md-6">
                                     <h4>Available Imei(s)</h4>
                                     <table class="table table-bordered">
                                         <thead>
                                         <tr>
                                             <th class="col-md-1">S.No</th>
                                             <th>IMEI</th>
                                         </tr>
                                         </thead>
                                         <tbody>
                                         <tr v-for="(selected_products, index) in all_selected_products">
                                                <td v-if="selected_products.is_selected" style="background:green; color:#fff;">{{index + 1}}</td>
                                                <td v-else>{{index+1}}</td>
                                                <td v-if="selected_products.is_selected" style="background:green; color:#fff;">{{selected_products.imei1}}</td>
                                                <td v-else>{{selected_products.imei1}}</td>
                                                
                                         </tr>
                                         </tbody>
                                     </table>
                                 </div>
                                 <div class="col-md-6">
                                     
                                     <h4>Selected Imei(s)</h4>
                                     <table class="table table-bordered">
                                         <thead>
                                         <tr>
                                             <th class="col-md-1">S.No</th>
                                             <th>IMEI</th>
                                             <th>Action</th>
                                         </tr>
                                         </thead>
                                         <tbody>
                                         <tr v-for="(transfer_items, index) in newTransfer.items">
                                             <td>{{index+1}}</td>
                                             <td>{{transfer_items.imei}}</td>
                                             <td><button @click="removeIMEI(index, transfer_items.imei)">Remove</button></td>
                                         </tr>
                                         </tbody>
                                     </table>
                                     <button style="margin-top:10px;" @click="transfer" class="btn btn-primary"  :disabled="btndisabled">{{this.submit_button_text}}</button>
                                 </div>
                                 
                             </div>

                            </div>

                            

                    </div>



                </div>

            </div>
        </div>
    </div>
</template>

<script>
    
    export default {
        
        data(){
            return{
                btndisabled:false,
                submit_button_text:'Transfer Stock',
                add_imei_enable:0,
                currentWarehouseId:'',
                currentWarehouse:'',
                productDetails:'',
                recent_selected_index:'',
                productColor:'',
                warehouses:[],
                all_selected_products:[],
                imei:'',
                showDetails:'',
                selected_qty:0,
                newTransfer:{
                    subWarehouse:'',
                    winID:'',
                    //products:[{ product:'', colors:[{name:'',price:'',discount:''}]}],
                    details:[],
                    //all_product_imei:[],
                    items:[],
                },
            }
        },
        mounted() {
            console.log('Component mounted.44')
        },
        created(){
            //alert(window.location.pathname.split('/')[4]);
            if(localStorage.my_imeis){
             

                    var my_imeis_array=JSON.parse(localStorage.my_imeis);
                    for(var i=0; i<my_imeis_array.length; i++){
                        
                        this.newTransfer.items.push({imei_for:my_imeis_array[i].imei_for,imei: my_imeis_array[i].imei, item_id: my_imeis_array[i].item_id});
                        
                    }

            axios.get('../get_issue_note_details/'+ window.location.pathname.split('/')[4]).then(response=>{
               this.newTransfer.subWarehouse=response.data[0].warehouse_to.id;
               this.newTransfer.winID=response.data[0].id;
                for(var i=0; i<response.data[0].transfer_products.length; i++){
                    this.newTransfer.details.push(
                        {isTrue:false,
                            warehouseId:response.data[0].warehouse_from.id,
                            productColor:response.data[0].transfer_products[i].product_color.color,
                            productColorId:response.data[0].transfer_products[i].product_color_id,
                            productQuantity:parseInt(response.data[0].transfer_products[i].quantity),
                            transferQty:parseInt(response.data[0].transfer_products[i].quantity),
                            productPrice:parseInt(response.data[0].transfer_products[i].price),
                            productId:response.data[0].transfer_products[i].product_id,
                            productName:response.data[0].transfer_products[i].product.name
                        });
                }
               // alert(this.newTransfer.details);
                
               var my_imeis_array=JSON.parse(localStorage.my_imeis);
               var imei_array_last_selected_product=my_imeis_array.length-1;

               var stored_index=my_imeis_array[imei_array_last_selected_product].imei_for;
               //alert(stored_index);
                axios.post('../get_specific_warehouse_items',{warehouse_id: this.newTransfer.details[stored_index].warehouseId,product_id: this.newTransfer.details[stored_index].productId,product_color_id: this.newTransfer.details[stored_index].productColorId}).then(response=>{
                    //this.all_selected_products=response.data;
                    //this.newTransfer.details[stored_index].isTrue=true;
                    for(var i=0; i<response.data.length; i++){
                        this.all_selected_products.push({imei1:response.data[i].imei1, is_selected:0, item_id:response.data[i].item_id});
                        
                    }
                    for(var i=0; i<my_imeis_array.length; i++){
                            for(var j=0; j<this.all_selected_products.length; j++){
                                if(this.all_selected_products[j].imei1==parseInt(my_imeis_array[i].imei)){
                                this.all_selected_products[j].is_selected=1;
                                }
                            }
                    }
                });
                var imei_for_is_difference=-1;

                for(var i=0; i<my_imeis_array.length; i++){
                   // this.check_to_item_select(my_imeis_array[i].imei);
                    
                    if(my_imeis_array[i].imei_for!=imei_for_is_difference){
                        this.newTransfer.details[my_imeis_array[i].imei_for].isTrue=true;
                        this.selected_qty+=parseInt(this.newTransfer.details[my_imeis_array[i].imei_for].transferQty);
                       
                    }
                    imei_for_is_difference=my_imeis_array[i].imei_for;
                }

                //alert(this.selected_qty);
                
            });
                    
            }
            else{
                axios.get('../get_issue_note_details/'+ window.location.pathname.split('/')[4]).then(response=>{
               this.newTransfer.subWarehouse=response.data[0].warehouse_to.id;
               this.newTransfer.winID=response.data[0].id;
                for(var i=0; i<response.data[0].transfer_products.length; i++){
                    this.newTransfer.details.push(
                        {isTrue:false,
                            warehouseId:response.data[0].warehouse_from.id,
                            productColor:response.data[0].transfer_products[i].product_color.color,
                            productColorId:response.data[0].transfer_products[i].product_color_id,
                            productQuantity:parseInt(response.data[0].transfer_products[i].quantity),
                            transferQty:parseInt(response.data[0].transfer_products[i].quantity),
                            productPrice:parseInt(response.data[0].transfer_products[i].price),
                            productId:response.data[0].transfer_products[i].product_id,
                            productName:response.data[0].transfer_products[i].product.name
                        });
                }
               // alert(this.newTransfer.details);
            });

            //alert(this.newTransfer.details);




            }
            axios.get('../currentWarehouse').then(response=>{
                this.currentWarehouse=response.data.name;
                this.currentWarehouseId=response.data.id;
            });

            axios.get('../allWarehouse').then(response=>{
                this.warehouses=response.data;
            });


                     // axios.get('../warehouseStockDetail').then(response=>{
          //  this.showDetails=response.data;

          //  for(var i=0;i<response.data.length;i++){
          //      this.newTransfer.details.push({isTrue:false,warehouseId:response.data[i].warehouse_id,productColor:response.data[i].product_color,productColorId:response.data[i].product_color_id,productQuantity:response.data[i].product_qty,transferQty:0,productPrice:response.data[i].product_color.price,transferQty:0, productId:response.data[i].product_color.product.id});
          //  }
          // });
        },
        watch: {
            imei: function () {

                if(this.imei.length>=15){
                    var isanytrue=0;
                    for(var i=0; i<this.newTransfer.details.length; i++){
                        //alert(this.newTransfer.details[i].isTrue);
                        if(this.newTransfer.details[i].isTrue){
                            isanytrue=1;
                            break;
                        }
                    }


                    if(this.imei!=''){
                        var isFound=0;
                        var isrepeated=0;
                        var item_id=0;
                        if(isanytrue==1){

                            if(this.newTransfer.items.length<this.selected_qty){
                                for(var i=0; i<this.all_selected_products.length; i++) {
                                    if(this.all_selected_products[i].imei1==this.imei){
                                        isFound=1;
                                        item_id=this.all_selected_products[i].item_id;
                                        for(var j=0; j<this.newTransfer.items.length; j++){
                                            if(this.imei==this.newTransfer.items[j].imei){
                                                isrepeated=1;
                                                break;
                                            }
                                        }
                                    }
                                }
                                //alert(isrepeated);
                                if(isFound==1 && isrepeated==0){
                                    //alert(item_id);
                                    this.newTransfer.items.push({imei_for:this.recent_selected_index ,imei: this.imei, item_id: item_id});
                                   // localStorage.setItem('imei',this.imei);
                                   this.check_to_item_select(this.imei);
                                    this.add_imei_in_local();
                                    this.imei='';
                                    isFound=1;
                                    
                                }
                                else if(isFound==1 && isrepeated==1){
                                    alert('This Imei is already Scanned');
                                    this.imei='';
                                }
                                else if(isFound==0){
                                    alert('Incorrect Imei');
                                    this.imei='';
                                }
                            }
                            else{
                                alert('Product Limit Exceed');
                                this.imei='';
                            }
                        }
                        else{

                            alert('Please Select any Product');
                            this.imei='';
                        }
                    }
                }


            }
        },
        methods:{
            
            add_imei_in_local:function(){
                var myJson=[];
                for(var i=0; i<this.newTransfer.items.length; i++){
                    myJson.push({'imei_for':this.newTransfer.items[i].imei_for,'imei':this.newTransfer.items[i].imei, 'item_id':this.newTransfer.items[i].item_id});
                }
                //  alert(myJson);
                localStorage.my_imeis=JSON.stringify(myJson);
                
            },
            transfer(e){
                
                e.preventDefault();
                
                var total_transfer_qty=0;
                for(var i=0; i<this.newTransfer.details.length; i++){
                   total_transfer_qty=total_transfer_qty+parseInt(this.newTransfer.details[i].transferQty);
                   //alert(total_transfer_qty);
                }
                //alert(total_transfer_qty);
                
                if(this.newTransfer.items==""){
                    alert("Scan Items are Not Found");
                }
                else if(this.newTransfer.items.length!=total_transfer_qty){
                    alert("Some Items are left for scan!");
                }
                else{
                   // console.log(this.newTransfer);
                   var confirm_result=confirm("Are you sure, You want to submit?");
                   if(confirm_result){
                       this.btndisabled=true;
                       this.submit_button_text="Please Wait ...";
                        axios.post('../transferReq',this.newTransfer).then(response=>{
                        if(response.data.replay==0){
                            
                            alert("Successfully Transfered");
                            this.btndisabled=false;
                            this.submit_button_text="Transfer Stock";
                            localStorage.removeItem('my_imeis');
                            window.location = "../transfer_requests";
                        }
                        else{
                            alert("Error to Transfer, Refresh the page, Data will not be lost");
                            this.btndisabled=false;
                            this.submit_button_text="Transfer Stock";
                        }

                    });
                    //alert("Now it's all perfect go & move it!");
                   }
                } 

            },
            AddImei(){
                this.add_imei_enable=1;
            },
            removeIMEI(index, selected_imei){
                event.preventDefault();
                
                this.newTransfer.items.splice(index,1);
                this.check_to_item_unselect(selected_imei);
                this.add_imei_in_local();
                
            },
            change_checkbox(warehouse_id, product_id, product_color_id, index){
                
                //for(var i=0; i< this.newTransfer.details.length; i++){
                //    if(this.newTransfer.details[i].isTrue){
                //        this.selected_qty= parseInt(this.selected_qty)+parseInt(this.newTransfer.details[i].transferQty);
                //    }
               // }
                //alert(this.selected_qty);
                    if(this.newTransfer.details[index].isTrue){
                        if(this.selected_qty==this.newTransfer.items.length){
                            this.all_selected_products=[];
                            this.selected_qty+=parseInt(this.newTransfer.details[index].transferQty);
                            //alert(this.selected_qty);
                            this.recent_selected_index=index;
                            axios.post('../get_specific_warehouse_items',{warehouse_id: warehouse_id,product_id: product_id,product_color_id: product_color_id}).then(response=>{
                                //this.all_selected_products=response.data;
                                for(var i=0; i<response.data.length; i++){
                                    this.all_selected_products.push({imei1:response.data[i].imei1, is_selected:0, item_id:response.data[i].item_id});
                                }
                            });
                        }
                        else{
                            alert("First Scan the items of currently selected product!");
                            this.newTransfer.details[index].isTrue=false;
                        }
                        
                    }
                    else{
                        var result=confirm("Are you sure, You want to uncheck? It'll lose all the scanned imei's of this product!");
                        if(result){
                            this.selected_qty-=parseInt(this.newTransfer.details[index].transferQty);
                            
                                for(var i=this.newTransfer.items.length-1; i>=0; i--){

                                if(this.newTransfer.items[i].imei_for==index){
                                    //this.newTransfer.items.splice(i, 1);
                                    this.removeIMEI(i, this.newTransfer.items[i].imei);

                                }
                            }
                              
                            //this.all_selected_products=[];
                        } 
                        else{
                            this.newTransfer.details[index].isTrue=true;

                        }
                    }
            },
            check_to_item_select($imei){
                //alert($imei);
                for(var i=0; i<this.all_selected_products.length; i++){
                        if(this.all_selected_products[i].imei1==$imei){
                            this.all_selected_products[i].is_selected=1;
                        }
                }
            },
            check_to_item_unselect($imei){
                for(var i=0; i<this.all_selected_products.length; i++){
                        if(this.all_selected_products[i].imei1==$imei){
                            this.all_selected_products[i].is_selected=0;
                        }
                }
            },
            
            
           
        }
    }

</script>

