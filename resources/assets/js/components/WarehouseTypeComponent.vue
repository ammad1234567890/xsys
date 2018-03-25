<template>
<div>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h2 class="panel-title">Create New City</h2>
        </div>

        <div class="panel-body">
            <form @submit="createWarehouseType">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="WarehouseType">Warehouse Type</label>
                      <input name="warehouseType" type="text" class="form-control" v-validate="'required|regex:^[a-zA-Z ._-]+$'" v-model="warehouseTypeData.warehouseType">
                      <span class="text-danger" v-show="errors.has('warehouseType')">
                        {{errors.first('warehouseType')}}
                      </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <input v-if="editing==false" type="submit" class="btn btn-tumblr" value="Create Warehouse Type">
                      <button v-if="editing==true" @click="saveEditing" class="btn btn-tumblr">Save Editing</button>
                      <button v-if="editing==false" @click="showWarehouseType" class="btn btn-github" data-toggle="collapse" data-target="#warehouseType">Show Warehouse Type</button>
                      <button v-if="editing==true" @click="cancelEditing" class="btn btn-pinterest">Cancel Editing</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="warehouseType" class="collapse">
            <div class="panel-heading">
                <h2 class="panel-title">Warehouse Type List</h2>
            </div>
            <div class="panel-body">
                <table class="table table-bordered col-md-12">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Warehouse Type</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(warehouseType,index) in allWarehouseType">
                        <td>{{index +1 }}</td>
                        <td>{{warehouseType.type}}</td>
                        <td><button class="btn btn-info btn-sm" @click="edit(index,warehouseType.id)">Edit</button></td>
                      </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
         data(){
           return{
             editIndex:'',
             editing:false,
             allWarehouseType:[],
             warehouseTypeData:{
               id:'',
               warehouseType:''
             },
           }
         },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('./allWarehouseType').then(response=>{
              //console.log(response.data);
              this.allWarehouseType=response.data;
            })
        },
        methods:{
          createWarehouseType(e){
            e.preventDefault();
            this.$validator.validateAll().then( (result) => {
               if (result) {
                 axios.post('./createWarehouseType',this.warehouseTypeData).then(response=>{
                   if(response.data.return==0){
                     //console.log(response.data.data);
                     this.allWarehouseType.push(response.data.data);
                     this.warehouseTypeData={
                       warehouseType:''
                     }
                   }else{
                     alert('Fail to create Warehouse Type');
                     console.log(response.data.data);
                   }
                 })
               } else{
                 alert("Validation Error");
               }
             })
          },
          edit(index,id){
            this.editIndex=index;
            this.editing=true;
            this.warehouseTypeData={
              id:this.allWarehouseType[index].id,
              warehouseType:this.allWarehouseType[index].type
            }
          },
          saveEditing(e){
            e.preventDefault();
            this.$validator.validateAll().then( (result) => {
               if (result) {
                 axios.post('./editWarehouseType',this.warehouseTypeData).then(response=>{
                    if(response.data.return == 0){
                      this.allWarehouseType[this.editIndex].name=this.warehouseTypeData.warehouseType;
                      this.warehouseTypeData={
                        warehouseType:''
                      };
                      this.editing=false;
                      this.editIndex='';
                    }else{
                      alert('Fail to Edit Warehouse Type');
                      console.log(response.data.data);
                    }
                 });
               }else{
                  alert("Validation Error");
               }
             })

          },
          showWarehouseType(e){
            e.preventDefault();
          },
          cancelEditing(e){
            e.preventDefault();
            this.warehouseTypeData={
              warehouseType:''
            };
            this.editing=false;
            this.editIndex='';
          }
        }//End of Methods
    }//End Of Script
</script>
