<template>
    <div class="col-md-4 panel panel-default">
      <div class="panel-body">
      <form @submit="createRegion">
        <div class="form-group">
          <label for="Region">Locality</label>
          <input name="region" type="text" class="form-control" v-validate="'required|regex:^[a-zA-Z]+$'" v-model="regionData.region">
          <span class="text-danger" v-show="errors.has('region')">
            {{errors.first('region')}}
          </span>
        </div>
        <div class="form-group">
          <input v-if="editing==false" type="submit" class="btn btn-default col-md-6" value="Create Locality">
          <button v-if="editing==true" @click="saveEditing" class="btn btn-default col-md-6">Save Editing</button>
          <button v-if="editing==false" @click="showRegions" class="btn btn-default col-md-6" data-toggle="collapse" data-target="#regions">Locality</button>
          <button v-if="editing==true" @click="cancelEditing" class="btn btn-default col-md-6">Cancel Editing</button>
        </div>
      </form>
      <div id="regions" class="collapse panel panel-default col-md-12">
        <table class="table table-bordered col-md-12">
            <thead>
              <tr>
                <th>S.No</th>
                <th>Regions</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(region,index) in allRegions">
                <td>{{index +1 }}</td>
                <td>{{region.name}}</td>
                <td><button class="btn btn-default" @click="edit(index,region.id)">Edit</button></td>
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
             allRegions:[],
             regionData:{
               id:'',
               region:''
             },
           }
         },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('./allRegions').then(response=>{
              this.allRegions=response.data;
            })
        },
        methods:{
          createRegion(e){
            e.preventDefault();
            axios.post('./createRegion',this.regionData).then(response=>{
              if(response.data.return==0){
                this.allRegions.push(response.data.data);
                this.regionData={
                  region:''
                }
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
              region:this.allRegions[index].name
            }
          },
          saveEditing(e){
            e.preventDefault();
            axios.post('./editRegion',this.regionData).then(response=>{
               if(response.data.return == 0){
                 this.allRegions[this.editIndex].name=this.regionData.region;
                 this.regionData={
                   region:''
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
              region:''
            };
            this.editing=false;
            this.editIndex='';
          }
        }//End of Methods
    }//End Of Script
</script>
