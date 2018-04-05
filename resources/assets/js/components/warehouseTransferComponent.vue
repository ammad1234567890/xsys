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
                                <tr v-for="(stock,index) in newTransfer.details">
                                  <td><input type="checkbox" v-model="stock.isTrue"  name=""></td>
                                  <td>{{index + 1}}</td>                                 
                                  <td>{{stock.productColor.product.name}}</td>
                                  <td>{{stock.productColor.color}}</td>
                                  <td>{{stock.productQuantity}}</td>
                                  <td><input type="number" v-model="stock.transferQty" name="" min="0" v-bind:max="stock.productQuantity"></td>
                                  
                                </tr>
                              </tbody>
                            </table>
                            </div>
                            <button @click="transfer">Transfer</button>
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
            });  

            axios.get('./allWarehouse').then(response=>{
                this.warehouses=response.data;
            });
            

           axios.get('./allStock').then(response=>{            
            this.showDetails=response.data;
            console.log(response.data);
            console.log(response.data);
            for(var i=0;i<response.data.length;i++){
                this.newTransfer.details.push({isTrue:false,warehouseId:response.data[i].id,productColor:response.data[i].product_color,productColorId:response.data[i].product_color_id,productQuantity:response.data[i].product_qty,transferQty:0});
            }
            
            console.log(this.newTransfer.details);
          });
        },
        methods:{
            transfer(e){
                e.preventDefault();
                console.log(this.newTransfer);
                axios.post('./transferReq',this.newTransfer).then(response=>{
                    console.log(response.data);
                });
            }            
        }
    }
</script>
