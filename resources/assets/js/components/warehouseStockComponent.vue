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
                    <div class="panel-heading">
                        <h2 class="panel-title">Stock Detail</h2>
                    </div>

                    <div class="panel-body">
                      <div class="row well">
                        <form>
                          <div class="form-group col-md-5">
                            <label for="warehouse">Warehouse</label>
                            <v-select label="name" v-model="searchedWarehouse" :options="allWarehouses"></v-select>
                          </div>
                          <div class="form-group col-md-5">
                            <label for="Report Type">Report Type</label>
                            <v-select label="reportType" v-model="selectedReportType" :options="reportTypes"></v-select>
                          </div>
                          <button class="btn btn-default col-md-1" @click="showReport">Show Report</button>
                        </form>
                      </div>
                        <table v-if="showSummary==true" id="warehousestocktable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
import vSelect from "vue-select"
    export default {
        components: {vSelect},
    	data(){
    		return{
          showSummary:false,
    			allStock:[],
          allWarehouses:[],
          searchedWarehouse:null,
          reportTypes:[
            {'reportType':'Summary'},
            {'reportType':'Detail'}
          ],
          selectedReportType:''
    		}
    	},
        mounted() {
            console.log('Component mounted.')
        },
        created(){
        	axios.get('./allStock').then(response=>{
        		this.allStock=response.data;
        	}),
          axios.get('./allWarehouse').then(response=>{
            this.allWarehouses=response.data;
          });

        },
        methods:{
          showReport(e){
            loadDatatable(false);
            e.preventDefault();
              this.showSummary=false;
              console.log(this.searchedWarehouse);
              if(this.selectedReportType.reportType=="Summary" && this.searchedWarehouse==null){
                this.showSummary=true;
                loadDatatable(true);
              }
          }
        }
    }
    var showed=false;
    function loadDatatable(show){

      if(show==true){
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
            showed=true;
        },3000);
    }else{
      if(showed==true){
      $('#warehousestocktable').DataTable().fnDestroy();;
      }
    }
  }
</script>
