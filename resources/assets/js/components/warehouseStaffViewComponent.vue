<template>
      <div>    
        <!-- <div class="row">
            <div class="card headcolor">
                <div class="card-header">
                        <h3 class="card-title pad-bot"><i class="material-icons">store</i> <small>WAREHOUSE STAFF</small> </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Allocate Staff </h2>
                    </div>
                    <div class="panel-body">
                      <form @submit="createWarehouseStaff">
                        <div class="form-group col-md-6">
                          <label for="warehouse">Warehouse</label>
                            <v-select label="name" v-model="newStaff.warehouse" :options="warehouses" @search="search"></v-select>
                        </div>
                        <div class="form-group col-md-6" @click="setColum('id')">
                          <label for="ID">Emp ID</label>
                           <v-select label="id" :filterable="false" v-model="newStaff.staff" :options="searchedStaff" @search="searchStaff" ></v-select>
                        </div>
                        <div class="form-group col-md-6" @click="setColum('name')">
                          <label for="Name">Name</label>
                            <v-select label="name" v-model="newStaff.staff" :options="searchedStaff" @search="searchStaff" ></v-select>
                        </div>
                        <div class="form-group col-md-6" @click="setColum('phoneNumber')">
                          <label for="phoneNumber">Phone Number</label>
                            <v-select label="phoneNumber" v-model="newStaff.staff" :options="searchedStaff" @search="searchStaff"></v-select>
                        </div>
                        <div class="form-group col-md-6" @click="setColum('email')">
                          <label for="email">Email</label>
                            <v-select label="email" v-model="newStaff.staff" :options="searchedStaff" @search="searchStaff"></v-select>
                        </div>
                        <div class="form-group col-md-6" @click="setColum('CNIC')">
                          <label for="CNIC">CNIC</label>
                            <v-select label="CNIC" v-model="newStaff.staff" :options="searchedStaff" @search="searchStaff"></v-select>
                        </div>
                        <div class="form-group col-md-6">
                          <button type="Submit" class="btn btn-tumblr">Submit</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row" style="margin-top: 24px;">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                      <h2 class="panel-title">Warehouse Staff</h2>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="form-group col-md-2">
                          <label class="labelmarginsearch" for="warehouse">Search Warehouse</label>
                        </div>
                        <div class="form-group col-md-8">
                          <v-select label="name" v-model="searchedWarehouse" :options="warehousesforStaff" @search="searchforStaff"></v-select>
                        </div>
                          
                        <div class="form-group col-md-2">
                            <button class="btn btn-tumblr searchmargin" v-on:click="fetchStaff">Show Staff</button>
                        </div>
                      </div>
                        <div class="table-responsive">
                          <table id="staffsearch-table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                              <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Cnic</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Locality</th>
                                <th>Deparment</th>
                                <th>Staff Type</th>
                                <th>Designation</th>
                                <!-- <th>Action</th> -->
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="(staff, index) in warehouseStaff">
                                <td>{{index+1}}</td>
                                <td>{{staff.staff.name}}</td>
                                <td>{{staff.staff.email}}</td>
                                <td>{{staff.staff.CNIC}}</td>
                                <td>{{staff.staff.phoneNumber}}</td>
                                <td>{{staff.staff.address}}</td>
                                <td>{{staff.staff.city.name}}</td>
                                <td>{{staff.staff.region.name}}</td>
                                <td>{{staff.staff.department.name}}</td>
                                <td>{{staff.staff.staff_type.type}}</td>
                                <td>{{staff.staff.designation.designation}}</td>
                                <!-- <td><button class="btn btn-danger btn-xs" v-on:click="removeStaff(index,staff.staff.id)">Remove</button>
                                </td> -->
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
import vSelect from "vue-select"
    export default {
        components: {vSelect},
      data(){
        return{
            warehouses:[],
            warehousesforStaff:[],
            warehouseStaff:[],
            searchedWarehouse:'',
            searchedStaff:[],
            searchColum:'',
            newStaff:{
              warehouse:'',
              staff:'',
            },      
        }
      },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
              fetchStaff(){
                    console.log(this.searchedWarehouse.id);

                    if(this.searchedWarehouse!=''){
                        axios.get('./warehouseSearchStaff/'+this.searchedWarehouse.id).then(response=>{
                          this.warehouseStaff=response.data;
                          loadDatatable();
                          console.log(this.warehouseStaff);
                        })
                    }
                  },
              search(search) {
                  this.warehouses=[];
                  axios.get('./allWarehouse').then(response=>{
                    //this.warehouses.push(response.data);
                    this.warehouses=response.data;
                  });
                  //console.log(this.warehouses);
                  //console.log(search);
                  //this.warehouses.push({'name':'ali','id':1});

              },
              searchforStaff(search) {
                  this.warehouses=[];
                  axios.get('./allWarehouse').then(response=>{
                    //this.warehouses.push(response.data);
                    this.warehousesforStaff=response.data;
                  });
                  //console.log(this.warehouses);
                  //console.log(search);
                  //this.warehouses.push({'name':'ali','id':1});

              },
              searchStaff(search,event){
                axios.get('./searchStaff/'+this.searchColum+'/'+search).then(response=>{
                    console.log(response.data);
                    this.searchedStaff=response.data;
                });
                //console.log("Search: "+search);
                // console.log(event.currentTarget.getAttribute('data_id'));
              },
              setColum(name){
                this.searchColum=name;
              },
              createWarehouseStaff(){
                axios.post('./createWarehouseStaff',this.newStaff).then(response=>{
                    console.log(response.data);
                });
              },
              createWarehouseStaff(e){
                e.preventDefault();
                // console.log('Submit');
                axios.post('./createWarehouseStaff',this.newStaff).then(response=>{
                  //console.log(response.data);
                    if(response.data==0){
                      alert("Warehouse Staff Created");
                      this.newStaff={
                        warehouse:'',
                        staff:'',
                      }
                    }else{
                      alert("Fail to create warehouse");
                    }
                });
              },
              removeStaff(index,id){
                axios.get('./removeStaff/'+id).then(response=>{
                  if(response.data==0){
                    console.log(response.data);
                    this.warehouseStaff.splice(index,1);
                  }else{
                    alert("Fail to Remove");
                  }
                })
              }
  }
}

function loadDatatable(){
  $("#staffsearch-table").dataTable().fnDestroy()
  setTimeout(function(){
  $('#staffsearch-table').DataTable({
        /*"pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records",
        }*/

        dom: 'Bfrtip',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            stateSave: true,
            buttons: [
                'colvis',
            ]
    });
  },5000);
}
            

</script>
