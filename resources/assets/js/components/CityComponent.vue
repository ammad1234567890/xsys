<template>
    <div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">Create New City</h2>
            </div>
            <div class="panel-body">
                <form @submit="createCity">
                    <div class="row">
                      <div class="col-md-2">
                            <label for="City" >City</label>
                      </div>
                      <div class="col-md-3">
                            <input name="city" type="text" class="textbox" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="cityData.city">
                            <span class="text-danger" v-show="errors.has('city')">
                              {{errors.first('city')}}
                            </span>
                      </div>
                      <div class="col-md-1"></div>

                      <div class="col-md-6">
                                <input v-if="editing==false" type="submit" class="btn btn-tumblr" value="Create City">
                                <button v-if="editing==true" @click="saveEditing" class="btn btn-tumblr">Save Editing</button>
                                <button v-if="editing==false" @click="showCities" class="btn btn-github" data-toggle="collapse" data-target="#cities">Show Cities</button>
                                <button v-if="editing==true" @click="cancelEditing" class="btn btn-pinterest">Cancel Editing</button>
                      </div>
                    </div>                      
                </form>
            </div>

            <div id="cities" class="collapse">
              <hr>
                <div class="panel-heading">
                    <h2 class="panel-title">City List</h2>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
                            <td><button class="btn btn-info btn-sm" @click="edit(index,city.id)" title="Edit"><i class="fa fa-edit"></i></button></td>
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
