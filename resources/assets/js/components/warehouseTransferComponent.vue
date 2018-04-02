<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Warehouse Trnsfer</div>

                    <div class="panel-body">
                        <form>
                            <div>
                                <input type="text" class="textbox" v-model="currentWarehouse">
                            </div>
                            <div>
                                                                
                            </div>
                        </form>
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
                productColor:''
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
                axios.get('./currentWarehouseData/'+this.currentWarehouseId).then(response=>{
                    this.productDetails=response.data;
                    this.productColor=this.productDetails.product_color;
                    console.log(this.productDetails);
                    let idArray=[];
                    for(var i=0;i<this.productDetails.length;i++){
                        idArray.push(this.productDetails[i].productColor.product.id);
                    }  
                });

            });         
        
        },
        methods:{
            
        }
    }
</script>
