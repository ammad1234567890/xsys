<template>
    <div>
      <div>
        <div class="row">
            <div class="card headcolor">
                <div class="card-header">
                        <h3 class="card-title pad-bot"><i class="material-icons">store</i> <small>WAREHOUSE </small> </h3>
                </div>
            </div>
        </div>
          <div class="row">
              <div class="col-md-12">
                  <div class="panel panel-default">
                    <a href="#d" data-toggle="collapse">
                      <div class="panel-heading">Create Warehouse</div>
                      </a>
                      <div id="d" class="panel-body collapse" v-bind:class="{in:edit}">
                        <form @submit="createWarehouse">
                          <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input name="Name" type="text" class="form-control" v-validate="'required|regex:^[a-zA-Z ._]+$'" v-model="newWarehouse.name">
                            <span class="text-danger" v-show="errors.has('city')">
                              {{errors.first('city')}}
                            </span>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="warehouseType">Warehouse Type</label>
                            <select class="form-control" name="WarehouseType" v-validate="'required'" required v-model="newWarehouse.warehouse_type_id">
                              <option value="">Select Warehouse Type</option>
                              <option v-for="type in allWarehouseTypes" v-bind:value="type.id">{{type.type}}</option>
                            </select>
                            <span class="text-danger" v-show="errors.has('WarehouseType')">
                              {{errors.first('WarehouseType')}}
                            </span>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="City">Warehouse City</label>
                            <!-- <select class="form-control" name="city" required v-model="newWarehouse.city">
                              <option value="">Select City</option>
                              <option v-for="city in cities" v-bind:value="city.id">{{city.name}}</option>
                            </select> -->
                            <v-select label="name" v-validate="'required'" v-model="newWarehouse.city" :options="cities" name="city"></v-select>
                            <span class="text-danger" v-show="errors.has('city')">
                              {{errors.first('city')}}
                            </span>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="region">Warehouse Locality</label>
                            <!-- <select class="form-control" name="region" required v-model="newWarehouse.region">
                              <option value="">Select Region</option>
                              <option v-for="region in regions" v-bind:value="region.id">{{region.name}}</option>
                            </select> -->
                            <v-select label="name" v-validate="'required'" name="region" v-model="newWarehouse.region" :options="regions"></v-select>
                            <span class="text-danger" v-show="errors.has('region')">
                              {{errors.first('region')}}
                            </span>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="region">Warehouse Latitude</label>
                            <input type="text" v-validate="'regex:^[0-9.]+$'" name="latitude" class="form-control" v-model="newWarehouse.latitude">
                            <span class="text-danger" v-show="errors.has('latitude')">
                              {{errors.first('latitude')}}
                            </span>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="region">Warehouse Longitude</label>
                            <input type="text" name="longitude" v-validate="'regex:^[0-9.]+$'" class="form-control" v-model="newWarehouse.longitude">
                            <span class="text-danger" v-show="errors.has('longitude')">
                              {{errors.first('longitude')}}
                            </span>
                          </div>
                          <div class="form-group col-md-12">
                            <label for="region">Warehouse Address</label>
                            <input type="text" name="address" v-validate="'required'" class="form-control" v-model="newWarehouse.address">
                            <span class="text-danger" v-show="errors.has('address')">
                              {{errors.first('address')}}
                            </span>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="manager">Warehouse Manager</label>
                            <!-- <select class="form-control" name="manager" required v-model="newWarehouse.warehouse_manager">
                              <option value="">Select Manager</option>
                              <option v-for="manager in managers" v-bind:value="manager.id">{{manager.name}}</option>
                            </select> -->
                            <v-select label="name" name="manager" v-validate="'required'" v-model="newWarehouse.warehouse_manager" :options="managers"></v-select>
                            <span class="text-danger" v-show="errors.has('manager')">
                              {{errors.first('manager')}}
                            </span>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="accountant">Warehouse Accountant</label>
                            <!-- <select class="form-control" name="accountant" required v-model="newWarehouse.warehouse_accountant">
                              <option value="">Select Accountant</option>
                              <option v-for="accountant in accountants" v-bind:value="accountant.id">{{accountant.name}}</option>
                            </select> -->
                            <v-select label="name" v-validate="'required'" name="accountant" v-model="newWarehouse.warehouse_accountant" :options="accountants"></v-select>
                            <span class="text-danger" v-show="errors.has('accountant')">
                              {{errors.first('accountant')}}
                            </span>
                          </div>
                          <div class="form-group col-md-12">
                            <input v-if="edit==false" type="submit" class="btn btn-tumblr" value="Submit">
                            <button v-if="edit==true" class="btn btn-tumblr" @click="saveEditing">Save Editing</button>
                            <button v-if="edit==true" class="btn btn-pinterest" @click="cancelEding">Cancel Editing</button>
                          </div>
                        </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-12">
              <div class="panel panel-default">
                  <div class="panel-heading">Warehouse List</div>
                  <div class="panel-body">
                    <table id="warehousetable" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Name</th>
                          <th>Type</th>
                          <th>City</th>
                          <th>Locality</th>
                          <th>Latitude</th>
                          <th>Longitude</th>
                          <th>Address</th>
                          <th>Manager</th>
                          <th>Accountant</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(warehouse,index) in allWarehouses">
                          <td>{{index + 1}}</td>
                          <td>{{warehouse.name}}</td>
                          <td>{{warehouse.warehouse_type.type}}</td>
                          <td>{{warehouse.city.name}}</td>
                          <td>{{warehouse.region.name}}</td>
                          <td>{{warehouse.latitude}}</td>
                          <td>{{warehouse.longitude}}</td>
                          <td>{{warehouse.address}}</td>
                          <td>{{warehouse.manager.name}}</td>
                          <td>{{warehouse.accountant.name}}</td>
                          <td>
                              <div class="dropdown">
                                <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
                                <span class="caret"></span></button>
                                  <ul class="dropdown-menu">
                                    <li><a href="#" v-on:click="editWarehouse(index)">Edit</a></li>
                                    <li><a href="#" v-on:click="deleteWarehouse(index,warehouse.id)">Delete</a></li>
                                  </ul>
                              </div>
                          </td>
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
            //allStaff:[],
            managers:[],
            editIndex:'',
            edit:false,
            accountants:[],
            allWarehouses:[],
            allWarehouseTypes:[],
            cities:[],
            regions:[],
            newWarehouse:{
              id:'',
              name:'',
              warehouse_type_id:'',
              city:'',
              region:'',
              latitude:'',
              longitude:'',
              address:'',
              warehouse_manager:'',
              warehouse_accountant:''
            }
          }
        },

        mounted() {
            console.log('Component mounted.')
        },
        created() {
           axios.get('./allWarehouse').then(response=>{
                this.allWarehouses=response.data;
                console.log(this.allWarehouses);
           });
            axios.get('./allWarehouseType').then(response=>{
                this.allWarehouseTypes=response.data;
            });
            axios.get('./generalData').then(response=>{
                this.cities=response.data.city;
                this.regions=response.data.region;
            });
            // axios.get('/allStaff').then(response=>{
            //   this.allStaff=response.data;
            // });
            axios.get('./manager').then(response=>{
              this.managers=response.data;
            });
            axios.get('./accountant').then(response=>{
              this.accountants=response.data;
            })
        },
        methods:{
          createWarehouse(e){
            e.preventDefault();
            this.$validator.validateAll().then( (result) => {
               if (result) {
                 axios.post('./createWarehouse',this.newWarehouse).then(response=>{
                     if(response.data.replay==0){
                       this.allWarehouses.unshift(response.data.data);
                       console.log(this.allWarehouses);
                       this.newWarehouse={
                         id:'',
                         name:'',
                         warehouse_type_id:'',
                         city:'',
                         region:'',
                         latitude:'',
                         longitude:'',
                         address:'',
                         warehouse_manager:'',
                         warehouse_accountant:''
                       };
                     }else{
                       alert('Fail to create Warehouse');
                       console.log(response.data.data);
                     }
                   });
               }else{
                 alert("Validation Errors");
               }
             })

          },
          editWarehouse(index){
            this.editIndex=index;
            this.edit=true;
            this.newWarehouse={
              id:this.allWarehouses[index].id,
              name:this.allWarehouses[index].name,
              warehouse_type_id:this.allWarehouses[index].warehouse_type_id,
              city:this.allWarehouses[index].city,
              region:this.allWarehouses[index].region,
              latitude:this.allWarehouses[index].latitude,
              longitude:this.allWarehouses[index].longitude,
              address:this.allWarehouses[index].address,
              warehouse_manager:this.allWarehouses[index].manager,
              warehouse_accountant:this.allWarehouses[index].accountant
            };
          },
          saveEditing(e){
            e.preventDefault();
            this.$validator.validateAll().then( (result) => {
               if (result) {
                 axios.post('./editWarehouse',this.newWarehouse).then(response=>{
                   if(response.data.replay==0){
                     this.allWarehouses[this.editIndex]=response.data.data;
                     this.editIndex='',
                     this.edit=false;
                     this.newWarehouse={
                       id:'',
                       name:'',
                       warehouse_type_id:'',
                       city:'',
                       region:'',
                       latitude:'',
                       longitude:'',
                       address:'',
                       warehouse_manager:'',
                       warehouse_accountant:''
                     };
                   }else{
                     alert("Fail to edit Warehouse");
                     console.log(response.data.data);
                   }
                 })
               }else{
                 alert('Validation Errors');
               }
             })
          },
          cancelEding(e){
            e.preventDefault();
            this.editIndex='',
            this.edit=false;
            this.newWarehouse={
              id:'',
              warehouse_type_id:'',
              name:'',
              city:'',
              region:'',
              latitude:'',
              longitude:'',
              address:'',
              warehouse_manager:'',
              warehouse_accountant:''
            };
          },
          /*
          deleteStaff(index,id){
            axios.get('/deleteStaff/'+id).then(response=>{
              if(resonse.data.replay==0){
                this.allStaff.splice(index,1);
              }else{
                alert('Fail to delete');
                console.log(response.data.data);
              }
            })
          }
          */
          deleteWarehouse(index,id){
            axios.get('./deleteWarehouse/'+id).then(response=>{
              if(response.data==0){
                this.allWarehouses.splice(index,1);
              }else{
                alert('Fail to delete');
              }
            })
          },
          getRegion(){
            console.log("Change");
          }
        }

    }

    $(document).ready(function() {
        setTimeout(function(){
            $('#warehousetable').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }
            });
        },5000);
    });
</script>
