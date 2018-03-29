<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"></div>

                    <div class="panel-body">
                        <input type="text" v-model="imei">
                        <button @click="getDetails">Get Details</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                imei:'',
                itemDetail:'',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            
        },
        methods:{
            getDetails(){
                axios.get('./itemDetails/'+this.imei).then(response=>{
                    console.log(response.data);
                })
            }
        }
    }
</script>