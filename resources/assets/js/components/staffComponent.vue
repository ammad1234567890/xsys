<template>
  <div>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                  <a href="#d" data-toggle="collapse">
                    <div class="panel-heading">Create Staff</div>
                  </a>
                    <div id="d" class="panel-body collapse" v-bind:class="{in:edit}">
                      <form v-on:submit="createStaff">
                        <div class="form-group col-md-6">
                          <label for="name">Name</label>
                          <input type="text" v-validate="'required|regex:^[a-zA-Z ._]+$'" v-model="newStaff.name" class="form-control" name="StaffName" placeholder="Full Name" required>
                          <span class="text-danger" v-show="errors.has('StaffName')">
                            {{errors.first('StaffName')}}
                          </span>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="CNIC">CNIC</label>
                          <input type="text" v-validate="'required|regex:^[0-9 -]+$|digits:13'" v-model="newStaff.CNIC" v-mask="'99999-9999999-9'" class="form-control" name="cnic" placeholder="CNIC without - /" required>
                          <span class="text-danger" v-show="errors.has('cnic')">
                            {{errors.first('cnic')}}
                          </span>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="address">Address</label>
                          <input type="text" v-validate="'required'" v-model="newStaff.address" class="form-control" name="address" placeholder="Complete Address" required>
                          <span class="text-danger" v-show="errors.has('address')">
                            {{errors.first('address')}}
                          </span>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="phoneNumber">Phone Number</label>
                          <input type="text" v-validate="'required|regex:^[0-9 -]+$|digits:11'" v-mask="'9999-9999999'" v-model="newStaff.phoneNumber" class="form-control" name="phoneNumber" placeholder="Phone Number" required>
                          <span class="text-danger" v-show="errors.has('phoneNumber')">
                            {{errors.first('phoneNumber')}}
                          </span>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="city">Select City</label>
                          <!-- <select class="form-control" name="city" v-validate="'required'" v-model="newStaff.city">
                            <option value="">Select City</option>
                            <option v-for="city in cities" v-bind:value="city.id">{{city.name}}</option>
                          </select> -->
                          <v-select label="name" v-model="newStaff.city" :options="cities"></v-select>
                          <span class="text-danger" v-show="errors.has('city')">
                            {{errors.first('city')}}
                          </span>
                        </div>
                         <div class="form-group col-md-6">
                          <label for="region">Select Locality</label>
                          <!-- <select class="form-control" name="region" v-validate="'required'" v-model="newStaff.region">
                            <option value="">Select Region</option>
                            <option v-for="region in regions" v-bind:value="region.id">{{region.name}}</option>
                          </select> -->
                          <v-select label="name" v-model="newStaff.region" :options="regions"></v-select>
                          <span class="text-danger" v-show="errors.has('region')">
                            {{errors.first('region')}}
                          </span>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="email">E-Mail</label>
                          <input type="email" v-validate="'required|email'" data-vv-value-path="innerValue" :has-error="errors.has('email')" v-model="newStaff.email" class="form-control" name="email" placeholder="E-Mail" required>
                          <span class="text-danger" v-show="errors.has('email')">
                            {{errors.first('email')}}
                          </span>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="Department">Select Department</label>
                          <select class="form-control" name="department" v-validate="'required'" v-model="newStaff.department_id">
                            <option value="">Select Department</option>
                            <option v-for="department in departments" v-bind:value="department.id">{{department.name}}</option>
                          </select>
                          <span class="text-danger" v-show="errors.has('department')">
                            {{errors.first('department')}}
                          </span>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="staffType">Select Staff Type</label>
                          <select class="form-control" name="staffType" v-validate="'required'" v-model="newStaff.staff_type_id">
                            <option value="">Select Staff Type</option>
                            <option v-for="staffType in staffTypes" v-bind:value="staffType.id">{{staffType.type}}</option>
                          </select>
                          <span class="text-danger" v-show="errors.has('staffType')">
                            {{errors.first('staffType')}}
                          </span>
                        </div>
                       <div class="form-group col-md-6">
                          <label for="designation">Designation</label>
                          <select class="form-control" name="designation" v-validate="'required'" v-model="newStaff.designation_id">
                            <option value="">Select Designation</option>
                            <option v-for="designation in designations" v-bind:value="designation.id">{{designation.designation}}</option>
                          </select>
                          <span class="text-danger" v-show="errors.has('designation')">
                            {{errors.first('designation')}}
                          </span>
                        </div>
                        <div class="form-group col-md-12">
                          <input v-if="edit==false" type="submit" value="Submit" class="btn btn-default col-md-4">
                          <button v-if="edit" class="btn btn-default col-md-6" @click="saveEditing">Save Editing</button>
                          <button v-if="edit" class="btn btn-default col-md-6" @click="cancelEding">Cancel Editing</button>
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
              <div class="panel-heading">Create Staff</div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Name</th>
                      <th>E-Mail</th>
                      <th>CNIC</th>
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
                    <tr v-for="(staff, index) in allStaff">
                      <td>{{index +1}}</td>
                      <td>{{staff.name}}</td>
                      <td>{{staff.email}}</td>
                      <td>{{staff.CNIC}}</td>
                      <td>{{staff.phoneNumber}}</td>
                      <td>{{staff.address}}</td>
                      <td>{{staff.city.name}}</td>
                      <td>{{staff.region.name}}</td>
                      <td>{{staff.department.name}}</td>
                      <td>{{staff.staff_type.type}}</td>
                      <td>{{staff.designation.designation}}</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Action
                            <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                            <li><a href="#" v-on:click="editStaff(index)">Edit</a></li>
                            <li><a href="#" v-on:click="deleteStaff(index,staff.id)">Delete</a></li>
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
</script>
