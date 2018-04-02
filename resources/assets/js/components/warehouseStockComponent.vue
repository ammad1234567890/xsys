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
                                 <select class="textbox" name="warehouse" required v-model="searchedWarehouse">
                                  <option value="">Select Warehouse</option>
                                  <option v-for="warehouse in allWarehouses" v-bind:value="warehouse">{{warehouse.name}}</option>
                                </select>
                                <!-- <v-select label="name" v-model="searchedWarehouse" :options="allWarehouses"></v-select> -->
                              </div>
                            </div>
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="Report Type">Report Type</label>
                                <select class="textbox" name="warehouse" required v-model="selectedReportType">
                                  <option value="">Report Type</option>
                                  <option v-for="reportType in reportTypes" v-bind:value="reportType">{{reportType.reportType}}</option>
                                </select>
                                <!-- <v-select label="reportType" v-model="selectedReportType" :options="reportTypes"></v-select> -->
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
                        </table> <table v-if="showFull==true" id="detailTable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
          //selectedWarehouse:true,
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
            e.preventDefault();
            loadDatatable(false,'',true);
            loadDatatable(false,'detail',true);            
              this.showSummary=false;
              this.showFull=false;
              //this.selectedWarehouse=true;
              //console.log(this.searchedWarehouse);
            if(this.selectedReportType.reportType=="Summary" && this.searchedWarehouse==null){
                //this.selectedWarehouse=true;
                console.log("Val "+this.selectedWarehouse);
                this.showDetails=this.allStock;
                this.showSummary=true;
                loadDatatable(true,'',true);
            }else if (this.selectedReportType.reportType=="Summary" && this.searchedWarehouse!=null) {
            // loadDatatable(false);
            //this.selectedWarehouse=false;
             axios.get('./warehouseStockSearch/'+this.searchedWarehouse.id).then(response=>{
              this.showDetails=response.data;
              this.showSummary=true;
              loadDatatable(true,'',false);
             })
              //  this.showDetails=result;

            }else if(this.selectedReportType.reportType=="Detail" && this.searchedWarehouse!=null){
              axios.get('./searchStockDetails/'+this.searchedWarehouse.id).then(response=>{
                this.detailRepot=response.data;
                this.showFull=true;
                 console.log(response.data);
                 loadDatatable(true,'detail',true);
              }) 
            }
          }
        }
    }
    var showed=false;  
    function loadDatatable(show,type,visible){  
      var id;
      if(type=="detail"){
        id="#detailTable";
      }else{
        id="#warehousestocktable";
      }
      if(show==true){
            console.log(show);
            setTimeout(function(){              
            var table=$(id).DataTable({
                "order": [[ 0,"desc" ]],
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
            if(visible==true){
              table.column( 1 ).visible( true );
            }else{
              table.column( 1 ).visible( false );
            }
            
          },3000);
            showed=true;

    }else{
      if(showed==true){
      $(id).DataTable().destroy();
     // table.destroy();  

      }
    }
  }
</script>
