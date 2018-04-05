<template>
  <div>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h2 class="panel-title">Create New Locality</h2>
        </div>
      <div class="panel-body">
          <form @submit="createRegion">
            <div class="row">
              <div class="col-md-2">
                      <label for="City" >Locality</label>
              </div>
              <div class="col-md-3">
                    <select name="city" class="textbox" v-model="regionData.cityId"  v-validate="'required'">
                      <option>Select City</option>
                      <option  v-for="city in cities" v-bind:value="city.id">{{city.name}}</option>
                    </select>
                    <span class="text-danger" v-show="errors.has('city')">
                      {{errors.first('city')}}
                    </span>
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-2">
                      <label for="City" >Locality</label>
              </div>
              <div class="col-md-3">
                    <input name="region" type="text" class="textbox" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="regionData.region">
                    <span class="text-danger" v-show="errors.has('region')">
                      {{errors.first('region')}}
                    </span>
              </div>
              <div class="col-md-1"></div>
          </div>
          <div class="row">
                <div class="col-md-6">
                      <input v-if="editing==false" type="submit" class="btn btn-tumblr" value="Create Locality">
                      <button v-if="editing==true" @click="saveEditing" class="btn btn-tumblr">Save Editing</button>
                      <button v-if="editing==false" @click="showRegions" class="btn btn-github" data-toggle="collapse" data-target="#regions">Show Locality</button>
                      <button v-if="editing==true" @click="cancelEditing" class="btn btn-pinterest">Cancel Editing</button>
                </div>
              </div>
            </form>
          </div>
        <div id="regions" class="collapse">
          <hr>
            <div class="panel-heading">
                <h2 class="panel-title">Locality List</h2>
            </div>
            <div class="panel-body">
                <table class="table table-bordered col-md-12">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>City</th>
                        <th>Regions</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(region,index) in allRegions">
                        <td>{{index +1 }}</td>
                        <td>{{region.city.name}}</td>
                        <td>{{region.name}}</td>
                        <td><button class="btn btn-info btn-sm" @click="edit(index,region.id)" title="Edit"><i class="fa fa-edit"></i></button></td>
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
             cities:[],
             allRegions:[],
             regionData:{
               id:'',
               region:'',
               cityId:''
             },
           }
         },
        mounted() {
            console.log('Component mounted.')
             axios.get('./allCities').then(response=>{
              this.cities=response.data;
              console.log(this.cities);
            })
        },
        created(){
            axios.get('./allRegions').then(response=>{
              this.allRegions=response.data;
              console.log(this.allRegions);
            })


        },
        methods:{
          createRegion(e){
            e.preventDefault();
            axios.post('./createRegion',this.regionData).then(response=>{
              if(response.data.return==0){
                this.allRegions.push(response.data.data);
                this.regionData={
                  region:'',
                  cityId:''
                }
                console.log(response.data.data);
              }else{
                alert('Fail to create Region');
                console.log(response.data.data);
              }
            })
          },
          edit(index,id){
            this.editIndex=index;
            this.editing=true;
            this.regionData={
              id:this.allRegions[index].id,
              region:this.allRegions[index].name,
              cityId:this.allRegions[index].city.name
            }
          },
          saveEditing(e){
            e.preventDefault();
            axios.post('./editRegion',this.regionData).then(response=>{
               if(response.data.return == 0){
                 this.allRegions[this.editIndex].name=this.regionData.region;
                 this.allRegions[this.editIndex].response.data.data.city;
                 this.regionData={
                   region:'',
                   cityId:''
                 };
                 this.editing=false;
                 this.editIndex='';
               }else{
                 alert('Fail to Edit Region');
                 console.log(response.data.data);
               }
            });
          },
          showRegions(e){
            e.preventDefault();
          },
          cancelEditing(e){
            e.preventDefault();
            this.regionData={
              region:'',
              cityId:''
            };
            this.editing=false;
            this.editIndex='';
          }
        }//End of Methods
    }//End Of Script
</script>
