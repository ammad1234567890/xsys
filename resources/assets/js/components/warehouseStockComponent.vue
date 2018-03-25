<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title">Stock Details</h2>
                    </div>

                    <div class="panel-body">
                      <div>
                        <form>
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="warehouse">Warehouse</label>
                                <v-select label="name" v-model="searchedWarehouse" :options="allWarehouses"></v-select>
                              </div>
                            </div>
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="Report Type">Report Type</label>
                                <v-select label="reportType" v-model="selectedReportType" :options="reportTypes"></v-select>
                              </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="    margin-top: 36px;">
                                    <button class="btn btn-tumblr" @click="showReport" style="    bottom: -8px;">Show Report</button>
                                </div>
                            </div>
                        </form>
                      </div>
                    </div>
                    <div class="panel-body">
                        <table v-if="showSummary==true" id="warehousestocktable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        	<thead>
                        		<tr>
                        			<th>S.No</th>
                        			<th>Warehouse</th>
                        			<th>Model</th>
                        			<th>Color</th>
                        			<th>Quantity</th>
                        		</tr>
                        	</thead>
                        	<tbody>
                        		<tr v-for="(stock,index) in showDetails">
                        			<td>{{index + 1}}</td>
                        			<td>{{stock.warehouse.name}}</td>
                        			<td>{{stock.product_color.product.name}}</td>
                        			<td>{{stock.product_color.color}}</td>
                        			<td>{{stock.product_qty}}</td>
                        		</tr>
                        	</tbody>
                        </table> <table v-if="showFull==true"  class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                          <thead>
                            <tr>
                              <th>S.No</th>
                              <th>imei1 </th>
                              <th>imei2</th>
                              <th>Model</th>
                              <th>Color</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(data,index) in detailRepot">
                              <td>{{index + 1}}</td>
                              <td>{{data.item.imei[0].imei1}}</td>
                              <td>{{data.item.imei[0].imei2}}</td>
                              <td>{{data.item.product_color.product.name}}</td>
                              <td>{{data.item.product_color.color}}</td>
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
          showFull:false,
    			allStock:[],
          allWarehouses:[],
          showDetails:[],
          detailRepot:[],
          searchedWarehouse:null,
          reportTypes:[
            {'reportType':'Summary'},
            {'reportType':'Detail'}
          ],
          selectedReportType:null,
    		}
    	},
        mounted() {
            console.log('Component mounted.')
        },
        created(){
        	axios.get('./allStock').then(response=>{
        		this.allStock=response.data;
            this.showDetails=this.allStock;
        	}),
          axios.get('./allWarehouse').then(response=>{
            console.log(response.data);
            this.allWarehouses=response.data;
          });

        },
        methods:{
          showReport(e){
           // loadDatatable(false);
            e.preventDefault();
              this.showSummary=false;
              this.showFull=false;
              //console.log(this.searchedWarehouse);
              if(this.selectedReportType.reportType=="Summary" && this.searchedWarehouse==null){
                this.showDetails=this.allStock;
                this.showSummary=true;
                loadDatatable(true);
            }else if (this.selectedReportType.reportType=="Summary" && this.searchedWarehouse!=null) {
             loadDatatable(false);
             axios.get('./warehouseStockSearch/'+this.searchedWarehouse.id).then(response=>{
              this.showDetails=response.data;
              this.showSummary=true;
             })
              //  this.showDetails=result;

            }else if(this.selectedReportType.reportType=="Detail" && this.searchedWarehouse!=null){
              axios.get('./searchStockDetails/'+this.searchedWarehouse.id).then(response=>{
                this.detailRepot=response.data;
                this.showFull=true;
                 console.log(response.data);
              }) 
            }
          }
        }
    }
    var showed=false;
    function loadDatatable(show){
      var table;
      if(show==true){
            console.log()
            table=$('#warehousestocktable').DataTable({
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

    }else{
      if(showed==true){
      //$('#warehousestocktable').DataTable().fnDestroy();
      table.destroy();  

      }
    }
  }
</script>
