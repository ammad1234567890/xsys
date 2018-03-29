<template>
  <div>
    <div>
        <div v-if="edit" class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                      <a href="#d" data-toggle="collapse" style="color:#333333">
                          <h2 class="panel-title">Edit Enrolment</h2>
                      </a>
                    </div>
                    <div id="d" class="panel-body">
                      <form v-on:submit="createStaff">
                        <div class="row">
                            <div class="col-md-2">
                                    <label for="name">Name</label>
                            </div>
                            <div class="col-md-3">
                                    <input type="text" v-validate="'required|regex:^[a-zA-Z ._]+$'" v-model="newStaff.name" class="textbox" name="StaffName" placeholder="Full Name" required>
                                    <span class="text-danger" v-show="errors.has('StaffName')">
                                      {{errors.first('StaffName')}}
                                    </span>
                            </div>
                            <div class="col-md-1"></div>

                            <div class="col-md-2">
                                  <label for="CNIC">CNIC</label>
                            </div>
                            <div class="col-md-3">
                                  <input type="text" v-validate="'required|regex:^[0-9 -]+$'" v-model="newStaff.CNIC" v-mask="'99999-9999999-9'" class="textbox" name="cnic" placeholder="CNIC without - /" required>
                                  <span class="text-danger" v-show="errors.has('cnic')">
                                    {{errors.first('cnic')}}
                                  </span>
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                  <label for="address">Address</label>
                            </div>
                            <div class="col-md-3">
                                  <input type="text" v-validate="'required'" v-model="newStaff.address" class="textbox" name="address" placeholder="Complete Address" required>
                                  <span class="text-danger" v-show="errors.has('address')">
                                    {{errors.first('address')}}
                                  </span>
                            </div>
                            <div class="col-md-1"></div>

                            <div class="col-md-2">
                                  <label for="phoneNumber">Phone Number</label>
                            </div>
                            <div class="col-md-3">
                                  <input type="text" v-validate="'required|regex:^[0-9 -]+$'" v-mask="'9999-9999999'" v-model="newStaff.phoneNumber" class="textbox" name="phoneNumber" placeholder="Phone Number" required>
                                  <span class="text-danger" v-show="errors.has('phoneNumber')">
                                    {{errors.first('phoneNumber')}}
                                  </span>
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                  <label for="Department">Department</label>
                            </div>
                            <div class="col-md-3">
                                  <select class="textbox" name="department" v-validate="'required'" v-model="newStaff.department_id">
                                    <option value="">Department</option>
                                    <option v-for="department in departments" v-bind:value="department.id">{{department.name}}</option>
                                  </select>
                                  <span class="text-danger" v-show="errors.has('department')">
                                    {{errors.first('department')}}
                                  </span>
                            </div>
                            <div class="col-md-1"></div>

                            <div class="col-md-2">
                                  <label for="staffType">Staff Type</label>
                            </div>
                            <div class="col-md-3">
                                  <select class="textbox" name="staffType" v-validate="'required'" v-model="newStaff.staff_type_id">
                                    <option value="">Staff Type</option>
                                    <option v-for="staffType in staffTypes" v-bind:value="staffType.id">{{staffType.type}}</option>
                                  </select>
                                  <span class="text-danger" v-show="errors.has('staffType')">
                                    {{errors.first('staffType')}}
                                  </span>
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                  <label for="designation">Designation</label>
                            </div>

                            <div class="col-md-3">
                                  <select class="textbox" name="designation" v-validate="'required'" v-model="newStaff.designation_id">
                                    <option value="">Designation</option>
                                    <option v-for="designation in designations" v-bind:value="designation.id">{{designation.designation}}</option>
                                  </select>
                                  <span class="text-danger" v-show="errors.has('designation')">
                                    {{errors.first('designation')}}
                                  </span>
                            </div>
                            <div class="col-md-1"></div>

                            <div class="col-md-2">
                                  <label for="email">E-Mail</label>
                            </div>
                            <div class="col-md-3">
                                  <input type="email" v-validate="'required|email'" data-vv-value-path="innerValue" :has-error="errors.has('email')" v-model="newStaff.email" class="textbox" name="email" placeholder="E-Mail" required>
                                  <span class="text-danger" v-show="errors.has('email')">
                                    {{errors.first('email')}}
                                  </span>
                            </div>
                            <div class="col-md-1"></div>

                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                  <label for="city">City</label>
                            </div>
                                  <!-- <select class="textbox" name="city" v-validate="'required'" v-model="newStaff.city">
                                    <option value="">Select City</option>
                                    <option v-for="city in cities" v-bind:value="city.id">{{city.name}}</option>
                                  </select> -->
                            <div class="col-md-3">
                                  <v-select label="name" v-model="newStaff.city" :options="cities"></v-select>
                                  <span class="text-danger" v-show="errors.has('city')">
                                    {{errors.first('city')}}
                                  </span>
                            </div>
                            <div class="col-md-1"></div>
                            
                            <div class="col-md-2">
                                  <label for="region">Locality</label>
                            </div>
                                  <!-- <select class="textbox" name="region" v-validate="'required'" v-model="newStaff.region">
                                    <option value="">Select Region</option>
                                    <option v-for="region in regions" v-bind:value="region.id">{{region.name}}</option>
                                  </select> -->
                            <div class="col-md-3">
                                  <v-select label="name" v-model="newStaff.region" :options="regions"></v-select>
                                  <span class="text-danger" v-show="errors.has('region')">
                                    {{errors.first('region')}}
                                  </span>
                            </div>

                            <div class="col-md-1"></div>
                        </div>

                        <div class="row" style="    margin-top: 10px;">
                            <div class="col-md-12">
                                  <input v-if="edit==false" type="submit" value="Submit" class="btn btn-tumblr">
                                  <button v-if="edit" class="btn btn-default" @click="saveEditing">Save </button>
                                  <button v-if="edit" class="btn btn-danger" @click="cancelEding">Cancel </button>
                            </div>
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
                  <div class="panel-heading">
                      <h2 class="panel-title">All Staff</h2>
                  </div>
                  <div class="panel-body">
                    <div class="table-responsive">
                      <table id="staff" class="table table-striped table-bordered table-hover table-no" cellspacing="0">
                        <thead>
                        <tr>
                          <th style="width:8px !important;">S.No</th>
                          <th>Staff ID</th>
                          <th>Name</th>
                          <th>Department</th>
                          <th>Type</th>
                          <th>Designation</th>
                          <th>Phone</th>
                          <th>E-Mail</th>
                          <th>CNIC</th>
                          <th>Address</th>
                          <th>City</th>
                          <th>Locality</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(staff, index) in allStaff">
                          <td>{{index +1}}</td>
                          <td>{{staff.id}}</td>
                          <td>{{staff.name}}</td>
                          <td>{{staff.department.name}}</td>
                          <td>{{staff.staff_type.type}}</td>
                          <td>{{staff.designation.designation}}</td>
                          <td>{{staff.phoneNumber}}</td>
                          <td>{{staff.email}}</td>
                          <td>{{staff.CNIC}}</td>
                          <td>{{staff.address}}</td>
                          <td>{{staff.city.name}}</td>
                          <td>{{staff.region.name}}</td>
                          <td>
                            <a class="btn btn-primary btn-xs" href="#" v-on:click="editStaff(index)"><i class="fa fa-edit" title="Edit"></i></a>
                            <!-- <div class="dropdown">
                              <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
                                <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                <li><a href="#" v-on:click="editStaff(index)">Edit</a></li>
                                <li><a href="#" v-on:click="deleteStaff(index,staff.id)">Delete</a></li>
                              </ul>
                            </div> -->
                          </td>
                        </tr>
                        </tbody>
                      </table>
                    </div>

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
        data() {
          return{
            cities:[],
            regions:[],
            departments:[],
            staffTypes:[],
            designations:[],
            editIndex:'',
            edit:false,
            allStaff:[],
            newStaff:{
              id:'',
              name:'',
              email:'',
              CNIC:'',
              phoneNumber:'',
              address:'',
              city:'',
              region:'',
              department_id:'',
              staff_type_id:'',
              designation_id:'',
            }
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
              axios.get('./allStaff').then(response=>{
                this.allStaff=response.data;
              });
              axios.get('./generalData').then(response=>{
                  this.cities=response.data.city;
                  this.regions=response.data.region;
                  this.departments=response.data.department;
                  this.staffTypes=response.data.staffType;
                  this.designations=response.data.designation;
              });
        },
        methods:{
          createStaff:function(e){
            e.preventDefault();
            this.$validator.validateAll().then( (result) => {
               if (result) {
                 axios.post('./createStaff',this.newStaff).then(response=>{
                   console.log(response.data);
                   if(response.data.replay==0){
                     this.allStaff.unshift(response.data.data);
                     this.newStaff={
                       id:'',
                       name:'',
                       email:'',
                       CNIC:'',
                       address:'',
                       city_id:'',
                       region_id:'',
                       department_id:'',
                       staff_type_id:'',
                       designation_id:'',
                     }
                     alert("New Staff Create");
                     window.location.reload();
                   }else{
                     alert('Fail to create Staff');
                     console.log(response.data.data);
                   }
                 })
               }else{
                 alert('Validation Error');
               }

             }﻿)
          },
          editStaff(index){
            this.editIndex=index;
            this.edit=true;
            this.newStaff={
              id:this.allStaff[index].id,
              name:this.allStaff[index].name,
              email:this.allStaff[index].email,
              CNIC:this.allStaff[index].CNIC,
              address:this.allStaff[index].address,
              city_id:this.allStaff[index].city_id,
              region_id:this.allStaff[index].region_id,
              department_id:this.allStaff[index].department_id,
              staff_type_id:this.allStaff[index].staff_type_id,
              designation_id:this.allStaff[index].designation_id,
            }
          },
          saveEditing(e){
            e.preventDefault();
            this.$validator.validateAll().then( (result) => {
               if (result) {
                 axios.post('./editStaff',this.newStaff).then(response=>{
                   if(response.data.replay==0){
                     this.allStaff[this.editIndex]=response.data.data;
                     this.newStaff={
                       id:'',
                       name:'',
                       email:'',
                       CNIC:'',
                       address:'',
                       city_id:'',
                       region_id:'',
                       department_id:'',
                       staff_type_id:'',
                       designation_id:'',
                     }
                     this.editIndex='';
                     this.edit=false;
                   }else{
                     alert('Fail to edit Staff');
                     console.log(response.data.data);
                   }
                 })
               }
               else{
                    alert('Validate Error');
               }
             })
          },
          cancelEding(e){
            e.preventDefault();
            this.newStaff={
              id:'',
              name:'',
              email:'',
              CNIC:'',
              address:'',
              city_id:'',
              region_id:'',
              department_id:'',
              staff_type_id:'',
              designation_id:'',
            }
            this.editIndex='';
            this.edit=false;
          },
          deleteStaff(index,id){
            axios.get('./deleteStaff/'+id).then(response=>{
              if(resonse.data.replay==0){
                this.allStaff.splice(index,1);
              }else{
                alert('Fail to delete');
                console.log(response.data.data);
              }
            })
          }

        }
    }

    $(document).ready(function() {
        setTimeout(function(){
            $('#staff').DataTable({
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

            /*dom: 'Bfrtip',
            responsive: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search here",
            },
            stateSave: true,
            buttons: [
                'colvis',
            ]*/

            });
        },3000);
    });
</script>
