<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Warehouse Stock</div>

                    <div class="panel-body">
                        <table class="table table-border">
                        	<thead>
                        		<tr>
                        			<th>S.No</th>
                        			<th>Warehouse</th>
                        			<th>Product Name</th>
                        			<th>Product Color</th>
                        			<th>Quantity</th>
                        		</tr>                        	
                        	</thead>
                        	<tbody>
                        		<tr v-for="(stock,index) in allStock">
                        			<td>{{index + 1}}</td>
                        			<td>{{stock.warehouse.name}}</td>
                        			<td>{{stock.product_color.product.name}}</td>
                        			<td>{{stock.product_color.color}}</td>
                        			<td>{{stock.product_qty}}</td>
                        		</tr>
                        	</tbody>
                        </table>
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
    			allStock:[]
    		}
    	},
        mounted() {
            console.log('Component mounted.')
        },
        created(){
        	axios.get('./allStock').then(response=>{
        		this.allStock=response.data;
        	})
        }
    }
</script>
