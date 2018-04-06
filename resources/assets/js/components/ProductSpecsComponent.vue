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
                    <div class="mobile-look-container">
                        <div v-for="(product_color,index) in product.product_color">
                            <div class="product-image" v-if="index<1 && product_color.product_images[0].image!=null">
                                <img :src="'../public/product_img/'+product_color.product_images[0].image" class="img img-responsive"/>
                            </div>
                        </div>
                        <div v-if="product.product_color==''">
                            <div class="product-image">
                                <img :src="'../public/product_img/mobile_placeholder.png'" class="img img-responsive" width="100%"/>
                            </div>

                        </div>

                        <div class="product-heading">
                            <h4>{{product.name}}</h4>
                            <p class="colors"><b>Colors:</b>
                                <span v-for="(product_color,index) in product.product_color">
                                        {{product_color.color}},
                                </span>
                                <span v-if="product.product_color==''">
                                        Not Available
                                </span>
                            </p>
                            <p class="released_date"><b>Released Date:</b> {{product.release_date | moment}}</p>
                            <a :href="'specification/'+product.id"><button class="btn btn-primary specs-btn">View Specifications</button></a>
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
            return {
                allProducts:[],
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            },

            getdate: function (date) {
                return moment(date).format('DD');
            },

            getmonth: function (date) {
                return moment(date).format('MM');
            },
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

    }
</script>