<template>
    <div class="col-md-4 panel panel-default">
      <div class="panel-body">
      <form @submit="createCity">
        <div class="form-group">
          <label for="City">City</label>
          <input name="city" type="text" class="form-control" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="cityData.city">
          <span class="text-danger" v-show="errors.has('city')">
            {{errors.first('city')}}
          </span>
        </div>
        <div class="form-group">
          <input v-if="editing==false" type="submit" class="btn btn-default col-md-6" value="Create City">
          <button v-if="editing==true" @click="saveEditing" class="btn btn-default col-md-6">Save Editing</button>
          <button v-if="editing==false" @click="showCities" class="btn btn-default col-md-6" data-toggle="collapse" data-target="#cities">Cities</button>
          <button v-if="editing==true" @click="cancelEditing" class="btn btn-default col-md-6">Cancel Editing</button>
        </div>
      </form>
      <div id="cities" class="collapse panel panel-default col-md-12">
        <table class="table table-bordered col-md-12">
            <thead>
              <tr>
                <th>S.No</th>
                <th>Cities</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(city,index) in allCities">
                <td>{{index +1 }}</td>
                <td>{{city.name}}</td>
                <td><button class="btn btn-default" @click="edit(index,city.id)">Edit</button></td>
              </tr>
            </tbody>
        </table>
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
             allCities:[],
             cityData:{
               id:'',
               city:''
             },
           }
         },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('./allCities').then(response=>{
              this.allCities=response.data;
            })
        },
        methods:{
          createCity(e){
            e.preventDefault();
            axios.post('./createCity',this.cityData).then(response=>{
              if(response.data.return==0){
                this.allCities.push(response.data.data);
                this.cityData={
                  city:''
                }
              }else{
                alert('Fail to create city');
                console.log(response.data.data);
              }
            })
          },
          edit(index,id){
            this.editIndex=index;
            this.editing=true;
            this.cityData={
              id:this.allCities[index].id,
              city:this.allCities[index].name
            }
          },
          saveEditing(e){
            e.preventDefault();
            axios.post('../editCity',this.cityData).then(response=>{
               if(response.data.return == 0){
                 this.allCities[this.editIndex].name=this.cityData.city;
                 this.cityData={
                   city:''
                 };
                 this.editing=false;
                 this.editIndex='';
               }else{
                 alert('Fail to Edit City');
                 console.log(response.data.data);
               }
            });
          },
          showCities(e){
            e.preventDefault();
          },
          cancelEditing(e){
            e.preventDefault();
            this.cityData={
              city:''
            };
            this.editing=false;
            this.editIndex='';
          }
        }//End of Methods
    }//End Of Script
</script>
