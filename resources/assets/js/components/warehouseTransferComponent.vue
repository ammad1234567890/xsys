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
                                <select class="textbox" name="SubWarehouse" v-model="newTransfer.subWarehouse" required>
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
                                  <th>Stock Quantity</th>
                                  <th>Transfer Quantity</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="(stock,index) in showDetails">
                                  <td><input type="checkbox"  name=""></td>
                                  <td>{{index + 1}}</td>                                 
                                  <td>{{stock.product_color.product.name}}</td>
                                  <td>{{stock.product_color.color}}</td>
                                  <td>{{stock.product_qty}}</td>
                                  <td><input type="number" name="" min="0" v-bind:max="stock.product_qty"></td>
                                  
                                </tr>
                              </tbody>
                            </table>
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
                currentWarehouseId:'',
                currentWarehouse:'',
                productDetails:'',
                productColor:'',
                warehouses:[],
                showDetails:'',
                newTransfer:{
                    subWarehouse:'',
                    //products:[{ product:'', colors:[{name:'',price:'',discount:''}]}],
                    details:[],
                },
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('./currentWarehouse').then(response=>{
            this.currentWarehouse=response.data.name;
            this.currentWarehouseId=response.data.id;            
            //console.log(response.data);
                // axios.get('./currentWarehouseData/'+this.currentWarehouseId).then(response=>{
                //     this.productDetails=response.data;
                //     this.productColor=this.productDetails.product_color;
                //     console.log(this.productDetails);
                //     let idArray=[];
                //     for(var i=0;i<this.productDetails.length;i++){
                //         idArray.push(this.productDetails[i].productColor.product.id);
                //     }  
                //});

            });  

            axios.get('./allWarehouse').then(response=>{
                this.warehouses=response.data;
            });
            

           axios.get('./allStock').then(response=>{            
            this.showDetails=response.data;
            this.newTransfer.details=response.data;
            console.log(response.data);
          });
        },
        methods:{
            //     isNumber: function (evt) {
            //     var theEvent = evt || window.event;
            //     theEvent.returnValue = false;
            // }
            
        }
    }
</script>
