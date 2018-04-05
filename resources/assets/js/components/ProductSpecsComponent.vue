<template>
    <div>
        <div class="row">
            <div class="card headcolor">
                <div class="card-header">
                    <h3 class="card-title pad-bot">
                        <h4 class="heading-inline" style="text-transform: uppercase; "> Our Products</h4> </h3>
                </div>
                <hr/>
            </div>

            <div class="row">
                <div class="col-md-3" v-for="(product, index) in allProducts">
                    <div class="image" v-for="(product_color,index) in product.product_color" v-if="index<1" style="height:200px; width: 100%;">
                        <img :src="'../public/product_img/'+product_color.product_images[0].image" height="100%" width="100%" style="text-align:center;"/>
                    </div>
                    <div v-else>

                    </div>
                    <div class="heading" style="text-align:center;">
                        <h3>{{product.name}}</h3>
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
            return {
                allProducts:[],
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            axios.get('./allProducts').then(response=>{
                this.allProducts=response.data.data;
                this.path=response.data.path;
                console.log(this.allProducts);
            });
        },
        methods: {

        }

   