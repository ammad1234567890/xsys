<template>
    <div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">Product Detail</div> 
                    </div>

                    <div class="panel-body">
                        <div class="col-md-1">
                            <label>Model</label>
                        </div>
                        <div class="col-md-5">
                                <select class="textbox" name="selectProduct" required v-model="productId">
                                  <option value="">Select Product</option>
                                  <option v-for="product in products" v-bind:value="product.id">{{product.name}}</option>
                                </select>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary" @click="getDetails">Get Detail</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="productDetails!=''" class="col-md-12 well"  style="margin-top: 20px;" v-cloak>

               <div class="col-md-3">
                   <h3 class="col-md-12 text-center">{{productDetails.name}}</h3>
                   <img v-bind:src="'./category_img/'+productDetails.product_category.image" class=" img-thumbnail" height="auto" />
                   <!-- <h1 class="col-md-12 text-center">{{productDetails.name}}</h1> -->
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
                               <td class=""><b>Category:</b> </td>
                               <td>{{productDetails.product_category.name}}</td>
                           </tr>
                           <tr>
                               <td><b>Model Name:</b> </td>
                               <td>{{productDetails.name}}</td>
                           </tr>
                           <tr>
                               <td><b>Release Date:</b> </td>
                               <td>{{productDetails.release_date|moment()}}</td>
                           </tr>
                           <tr>
                               <th>Color</th>
                               <th>Quantity</th>
                               <th>Discount</th>
                               <th>Price</th>
                               <th>Warehouse</th>
                               <th>Address</th>
                           </tr>
                           <tr>
                              <td><p v-for="productColor in productDetails.product_color">{{productColor.color}}</p></td>
                              <td><p v-for="productColor in productDetails.product_color">
                                  <span v-for="quantity in productColor.warehouse_stock">{{quantity.product_qty}} <span style="color:green;">In stock</span></span>
                                  </p>
                              </td>
                              <td><p v-for="productDiscount in productDetails.product_color">{{productDiscount.discount}}% </p></td>
                              <td><p v-for="productPrice in productDetails.product_color">{{productPrice.price |currency('Rs')}} </p></td>
                              <td><p v-for="productColor in productDetails.product_color">
                                     <span v-for="warehousestock in productColor.warehouse_stock">
                                             <span>{{warehousestock.warehouse.name}}</span>
                                     </span>
                                 </p>
                              </td>
                              <td><p v-for="productColor in productDetails.product_color">
                                     <span v-for="warehousestock in productColor.warehouse_stock">
                                             <span>{{warehousestock.warehouse.address}}</span>
                                     </span>
                                 </p>
                              </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

               <!--  <div class="col-md-12">
                   <table class="table table-borderd">
                       <thead>
                           <tr>
                               <th>Category</th>
                               <th>Model</th>
                               <th>Color</th>
                               <th>Release Date</th>
                               <th>Discount</th>
                               <th>Price</th>
                               <th>Quantity</th>
                               <th>Warehouse</th>
                               <th>Address</th>
                           </tr>
                       </thead>
                       <tbody>
                           <tr>
                               <td>{{productDetails.product_category.name}}</td>
                               <td>{{productDetails.name}}</td>
                               <td><p v-for="productColor in productDetails.product_color">{{productColor.color}}</p></td>
                               <td>{{productDetails.release_date|moment()}}</td>
                               <td><p v-for="productDiscount in productDetails.product_color">{{productDiscount.discount}}%, </p></td>
                               <td><p v-for="productPrice in productDetails.product_color">{{productPrice.price}}, </p></td>
                               <td><p v-for="productColor in productDetails.product_color">
                               <span v-for="quantity in productColor.warehouse_stock">{{quantity.product_qty}},</span>
                                </p>
                               </td>
                               <td><p v-for="productColor in productDetails.product_color">
                                       <span v-for="warehousestock in productColor.warehouse_stock">
                                               <span>{{warehousestock.warehouse.name}}</span>
                                       </span>
                                   </p>
                               </td>
                               <td><p v-for="productColor in productDetails.product_color">
                                       <span v-for="warehousestock in productColor.warehouse_stock">
                                               <span>{{warehousestock.warehouse.address}}</span>
                                       </span>
                                   </p>
                               </td>
                           </tr>
                       </tbody>
                   </table>
               
                 
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
                productId:'',
                products:[],
                productDetails:'',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('./allProducts').then(response=>{
                this.products=response.data.data;
                console.log(this.products);
            })
        },
        methods:{
            getDetails(){
                axios.get('./productDetails/'+this.productId).then(response=>{
                    this.productDetails=response.data;
                    console.log(response.data);
                })
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

p {
    padding: 0;
    margin: 0;
}

</style>