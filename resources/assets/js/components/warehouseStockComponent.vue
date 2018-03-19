<template>
    <div>
        <div class="row">
            <div class="card headcolor">
                <div class="card-header">
                      <h3 class="card-title pad-bot"><i class="material-icons">store</i> <small>WAREHOUSE STOCK </small> </h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Stock Detail</div>

                    <div class="panel-body">
                        <table id="warehousestocktable" class="table table-striped table-bordered table-hover">
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

    $(document).ready(function() {
        setTimeout(function(){
            $('#warehousestocktable').DataTable({
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
        },3000);
    });
</script>
