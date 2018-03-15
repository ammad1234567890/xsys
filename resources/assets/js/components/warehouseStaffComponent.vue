<template>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Warehouse Staff</div>
                    <div class="panel-body">
                      <form @submit="createWarehouseStaff">
                        <div class="form-group col-md-6">
                          <label for="warehouse">Warehouse</label>
                            <v-select label="name" v-model="newStaff.warehouse" :options="warehouses" @search="search"></v-select>
                        </div>
                        <div class="form-group col-md-6" @click="setColum('id')">
                          <label for="ID">Staff ID</label>
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
                          <button type="Submit" class="col-md-6 btn btn-default">Submit</button>
                        </div>
                      </form>
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
              }
  }
}
</script>
