<template>
      <div>    
        <div class="row" style="margin-top: 24px;">
            <div class="col-md-12">
                <div class="alert alert-success" id="message_div" v-if="message">
                    <strong>{{message}}</strong>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title">Allocate Staff </h2>
                    </div>
                    <div class="panel-body">
                      <form @submit="createWarehouseStaff">
                        <div class="row">
                          <div class="col-md-2">
                            <label for="warehouse">Warehouse<span style="color:red;">*</span></label>
                          </div>
                          <div class="col-md-3">
                             <select class="textbox" name="warehouse" required v-model="newStaff.warehouse">
                              <option value="">Select Warehouse</option>
                              <option v-for="warehouse in warehouses" v-bind:value="warehouse">{{warehouse.name}}</option>
                            </select>
                              <!-- <v-select label="name" v-model="newStaff.warehouse" :options="warehouses" @search="search"></v-select> -->
                          </div>
                          <div class="col-md-1"></div>


                          <div class="col-md-2">
                            <label for="ID">Emp ID<span style="color:red;">*</span></label>
                          </div>
                          <div class="col-md-3" @click="setColum('id')">
                          <select class="textbox" name="staff_id" required v-model="newStaff.staff">
                              <option value="">Select Staff ID</option>
                              <option v-for="searchStaff in searchedStaff" v-bind:value="searchStaff">{{searchStaff.id}}</option>
                            </select>
                            <!--  <v-select label="id" :filterable="false" v-model="newStaff.staff" :options="searchedStaff" @search="searchStaff" ></v-select> -->
                          </div>
                          <div class="col-md-1"></div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <label for="Name">Name<span style="color:red;">*</span></label>
                          </div>
                          <div class="col-md-3" @click="setColum('name')">
                            <select class="textbox" name="staffName" required v-model="newStaff.staff">
                              <option value="">Name</option>
                              <option v-for="searchStaff in searchedStaff" v-bind:value="searchStaff">{{searchStaff.name}}</option>
                            </select>
                              <!-- <v-select label="name" v-model="newStaff.staff" :options="searchedStaff" @search="searchStaff" ></v-select> -->
                          </div>
                          <div class="col-md-1"></div>

                          <div class="col-md-2">
                            <label for="phoneNumber">Phone Number<span style="color:red;">*</span></label>
                          </div>
                          <div class="col-md-3" @click="setColum('phoneNumber')">
                            <select class="textbox" name="staffPhoneNumber" required v-model="newStaff.staff">
                              <option value="">Phone Number</option>
                              <option v-for="searchStaff in searchedStaff" v-bind:value="searchStaff">{{searchStaff.phoneNumber}}</option>
                            </select>
                              <!-- <v-select label="phoneNumber" v-model="newStaff.staff" :options="searchedStaff" @search="searchStaff"></v-select> -->
                          </div>
                          <div class="col-md-1"></div>
                        </div>

                        <div class="row">
                          <div class="col-md-2" >
                            <label for="email">Email<span style="color:red;">*</span></label>
                          </div>
                          <div class="col-md-3" @click="setColum('email')">
                            <select class="textbox" name="staffEmail" required v-model="newStaff.staff">
                              <option value="">Email</option>
                              <option v-for="searchStaff in searchedStaff" v-bind:value="searchStaff">{{searchStaff.email}}</option>
                            </select>
                              <!-- <v-select label="email" v-model="newStaff.staff" :options="searchedStaff" @search="searchStaff"></v-select> -->
                          </div>
                          <div class="col-md-1"></div>

                          <div class="col-md-2">
                            <label for="CNIC">CNIC<span style="color:red;">*</span></label>
                          </div>
                          <div class="col-md-3"  @click="setColum('CNIC')">
                            <select class="textbox" name="staffCNIC" required v-model="newStaff.staff">
                              <option value="">CNIC</option>
                              <option v-for="searchStaff in searchedStaff" v-bind:value="searchStaff">{{searchStaff.CNIC}}</option>
                            </select>
                            <!-- <v-select label="CNIC" v-model="newStaff.staff" :options="searchedStaff" @search="searchStaff"></v-select> -->
                          </div>
                          <div class="col-md-1"></div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <button type="Submit" class="btn btn-default">Submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
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
                                <th>Action</th>
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
                                <td><button class="btn btn-danger btn-xs" v-on:click="removeStaff(index,staff.staff.id)">Remove</button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                    </div>
              </div>
            </div>
          </div> -->
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
        created(){
          axios.get('./allWarehouse').then(response=>{
                    //this.warehouses.push(response.data);
                    this.warehouses=response.data;
                  });
           axios.get('./allStaff').then(response=>{
                    //console.log(response.data);
                    this.searchedStaff=response.data;
                });
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
                      this.message = this.newStaff.staff.name + " assigned successfully";
                      setTimeout(function() {
                            $('#message_div').fadeOut(1000);
                        }, 1000);
                        $("html, body").animate({
                            scrollTop: 0
                        }, 600);
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
