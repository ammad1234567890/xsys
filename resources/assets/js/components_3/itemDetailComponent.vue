<template>
    <div >
        <div class="row">
            <div>
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Find IMEI asdasdadad
                            </div>
                        </div>

                        <div class="panel-body">

                                
                                <div class="col-md-4">
                                    <input type="text" class="textbox" v-model="imei" placeholder="Enter IMEI" required="">
                                </div>
                                <div class="col-md-5">
                                    <button class="btn btn-primary" @click="getDetails">Search</button>
                                </div>

                            <!-- <div v-if="itemDetails==''">Imei not Matched</div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="itemDetails!=''" class="col-md-12 well"  style="margin-top: 20px;" v-cloak>

                <div class="col-md-3">
                    <h3 class="col-md-12 text-center">{{itemDetails.item.product_color.product.name}}</h3>
                    <img v-bind:src="'./product_img/'+itemDetails.item.product_color.product_images[0].image" class=" img-thumbnail" height="auto" />
                    <!-- <h1 class="col-md-12 text-center">{{itemDetails.item.product_color.product.name}}</h1> -->
                </div>

                <div class="col-md-9">
                    <table class="table table-borderd table-hover">
                        <thead>
                            <tr>
                                <th><b>Details</b></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-md-4"><b>Model Name:</b> </td>
                                <td>{{itemDetails.item.product_color.product.name}}</td>
                            </tr>
                            <tr>
                                <td><b>Color: </b> </td>
                                <td>{{itemDetails.item.product_color.color}}</td>
                            </tr>
                            <tr>
                                <td><b>Imei 1:</b> </td>
                                <td>{{itemDetails.imei1}}</td>
                            </tr>
                            <tr>
                                <td><b>Imei 2:</b> </td>
                                <td>{{itemDetails.imei2}}</td>
                            </tr>
                            <tr>
                                <td><b>Release Date:</b> </td>
                                <td>{{itemDetails.item.product_color.product.release_date |moment()}}</td>
                            </tr>
                            <tr>
                                <td><b>Discount:</b> </td>
                                <td>{{itemDetails.item.product_color.discount}}%</td>
                            </tr>
                            <tr>
                                <td><b>Price:</b> </td>
                                <td>{{itemDetails.item.product_color.price|currency('Rs')}}</td>
                            </tr>
                            <tr>
                                <td><b>Order No:</b> </td>
                                <td>{{itemDetails.item.receive.order.manufacture_order_no}}</td>
                            </tr>
                            <tr>
                                <td><b>Receiving No:</b> </td>
                                <td>{{itemDetails.item.receive.receive_no}}</td>
                            </tr>
                            <tr>
                                <td><b>Receiving Date:</b> </td>
                                <td>{{itemDetails.item.receive.created_at |moment()}}</td>
                            </tr>
                            <tr>
                                <td><b>Warehouse Receive:</b> </td>
                                <td>{{itemDetails.item.receive.main_warehouse_receive.warehouse.name}}</td>
                                <td>
                                    {{itemDetails.item.mainWarehouseReceiveItem}}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Warehouse Receive Date:</b> </td>
                                <td>{{itemDetails.item.receive.main_warehouse_receive.created_at|moment()}}</td>
                            </tr>
                            <tr>
                                <td><b>Stock Status</b> </td>
                                <td v-if="itemDetails.item.warehouse_issue_item!=null" style="color:red;">Sold out</td>
                                <td v-else style="color:green;">In-stock</td>

                            </tr>
                            <tr>
                                <td><b>Sold Date</b> </td>
                                <td v-if="itemDetails.item.warehouse_issue_item!=null">{{itemDetails.item.warehouse_issue_item.created_at |moment()}}</td>
                                <td v-else style="color:green;">-</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <ul>
                        <li><b>Model Name:</b> <span class="col-md-offset-1">{{itemDetails.item.product_color.product.name}}</span></li>
                        <li><b>Color: </b> <span class="col-md-offset-1">{{itemDetails.item.product_color.color}}</span></li>
                        <li><b>Imei 1:</b> <span class="col-md-offset-1">{{itemDetails.imei1}}</span></li>
                        <li><b>Imei 2:</b> <span class="col-md-offset-1">{{itemDetails.imei2}}</span></li>
                        <li><b>Release Date:</b><span class="col-md-offset-1">{{itemDetails.item.product_color.product.release_date |moment()}}</span></li>
                        <li><b>Discount:</b><span class="col-md-offset-1">{{itemDetails.item.product_color.discount}}%</span></li>
                        <li><b>Price:</b> <span class="col-md-offset-1">{{itemDetails.item.product_color.price|currency('Rs')}}</span></li>
                    
                        <li><b>Order No:</b><span class="col-md-offset-1">{{itemDetails.item.receive.order.manufacture_order_no}}</span></li>
                        
                        <li><b>Order Date:</b><span class="col-md-offset-1">{{itemDetails.item.receive.order.created_at |moment()}}</span></li>
                        <li><b>Receiving No:</b><span class="col-md-offset-1">{{itemDetails.item.receive.receive_no}}</span></li>
                        <li><b>Receiving Date:</b><span class="col-md-offset-1">{{itemDetails.item.receive.created_at |moment()}}</span></li>
                        <li><b>Main Warehouse Receive:</b><span class="col-md-offset-1">{{itemDetails.item.receive.main_warehouse_receive.warehouse.name}}</span></li>
                        <li><b>Main Warehouse Receive Date:</b><span class="col-md-offset-1">{{itemDetails.item.receive.main_warehouse_receive.created_at|moment()}}</span></li>
                        <li><b>Warehouse Issue Date:</b><span v-if="itemDetails.item.warehouse_issue_item!=null" class="col-md-offset-1">{{itemDetails.item.warehouse_issue_item.created_at |moment()}}</span>
                            <span class="col-md-offset-1" v-else style="color:green;">In-stock</span>
                        </li>
                    </ul> -->
                  
                </div>


                <!-- <div class="col-md-12" >
                    <h1 class="col-md-3 text-center">{{itemDetails.item.product_color.product.name}}</h1>
                </div> -->

                
                <!-- <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h3 v-if="itemDetails!=''">{{itemDetails.item.product_color.product.name}}</h3>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                           <div v-if="itemDetails!=''">{{itemDetails.item.product_color.product.name}}</div> 
                        </div>
                        
                        <div class="col-md-12">
                
                            <img v-if="itemDetails!=''" v-bind:src="'./product_img/'+itemDetails.item.product_color.product_images[0].image" class="col-md-3 img-thumbnail" height="auto"  style="    margin-left: 5px;"/>
                           
                        </div>
                        
                    </div>
                </div> -->
            </div>

            <!-- <div v-else class="col-md-12" style="margin-top: 20px;">
                <h4 style="color:red; text-align:center;" >Imei not Matched</h4>
            </div> -->
        </div>
    </div>
</template>

<script>
    
    export default {
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            }
        },
        data(){
            return{
                imei:'',
                itemDetails:'',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            
        },
        methods:{
            getDetails(){
                this.itemDetails='';
                if(this.imei==''){
                    alert("Please Scan any Imei for the Details!");
                }
                else{
                    axios.get('./itemDetails/'+this.imei).then(response=>{
                        if(response.data==404){
                            alert("Invalid Imei");
                            this.itemDetails='';
                        }
                        else{
                            this.itemDetails=response.data;
                            alert(this.itemDetails);
                            console.log("Created at: " + this.itemDetails.created_at);
                            if(this.itemDetails.created_at == '' || this.itemDetails.created_at == null){
                                alert("IMEI not found");
                            }
                            //console.log(this.itemDetails.item.product_color.product_images[0].image);
                            alert(this.itemDetails);
                        }

                    })
                }

            }
        }
    }
</script>


<style>
ul{
    list-style-type: none;
}

[v-cloak] > * { display:none; }
[v-cloak]::before { 
  content: " ";
  display: block;
  width: 16px;
  height: 16px;
  background-image: url('data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==');
}

</style>