<template>
    <div>
        <div class="row">
            <div class="card headcolor">
                <div class="card-header">
                    <h3 class="card-title pad-bot">
                        <h4 class="heading-inline" style="text-transform: uppercase; "> Product Specification</h4> </h3>
                </div>
                <hr/>
            </div>
            <div class="col-md-12 well"  style="margin-top: 20px;" v-cloak>

                <div class="col-md-3">
                    <h3 class="col-md-12 text-center">{{specification.name}}</h3>
                    <div class="slider-for">
                        <span v-for="pro_images in product_images">
                            <img v-bind:src="'../product_img/'+pro_images" class=" img-thumbnail" height="auto" />
                        </span>
                    </div>

                    <div class="slider-nav">
                        <span v-for="pro_images in product_images">
                                <img v-bind:src="'../product_img/'+pro_images" class=" img-thumbnail" height="auto" />
                        </span>
                    </div>


                    <!-- <h1 class="col-md-12 text-center">{{productDetails.name}}</h1> -->
                </div>

                <div class="col-md-9">
                    <table class="table table-borderd table-hover">
                        <thead>
                        <tr>
                            <th><b>Details</b></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td class=""><b>Category:</b> </td>
                            <td>{{specification.product_category.name}}</td>
                        </tr>
                        <tr>
                            <td><b>Model Name:</b> </td>
                            <td>{{specification.name}}</td>
                        </tr>
                        <tr>
                            <td><b>Release Date:</b> </td>
                            <td>{{specification.release_date | moment}}</td>
                        </tr>
                        <tr>
                            <th>Color</th>
                            <th>Price</th>
                            <th>Discount</th>


                        </tr>
                        <tr v-for="product_colors in specification.product_color">
                            <td>{{product_colors.color}}</td>
                            <td>{{product_colors.price}}</td>
                            <td>{{product_colors.discount}}%</td>

                        </tr>

                        </tbody>
                    </table>
                    <h4 style="text-transform: uppercase;"><b>Specifications</b></h4>
                    <table width="100%" border="1px" class="table table-borderd table-hover">
                        <tbody v-for="spec in product_spec">
                        <tr>
                            <td :colspan="2" style="color:#000; font-weight:bold;">{{spec.specs_category_name}}</td>
                        </tr>
                        <tr v-for="sub_category in spec.sub_cat" v-if="sub_category.sub_cat_specs.detail_name!=null">
                            <td>{{sub_category.specs_sub_category_name}}</td>

                            <td>{{sub_category.sub_cat_specs.detail_name}}</td>

                        </tr>
                        </tbody>






                    </table>
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
                specification:[],
                product_spec:[],
                public_path:'',
                product_images:[],
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
            axios.get('../get_product_specification/'+ window.location.pathname.split('/')[4]).then(response=>{
                this.specification=response.data[0].data[0];
                this.product_spec=response.data[0].specs;
                this.public_path=response.data[0].path;



                    for (var i = 0; i < response.data[0].data[0].product_color.length; i++) {
                        for (var j = 0; j < response.data[0].data[0].product_color[i].product_images.length; j++) {
                            this.product_images.push(response.data[0].data[0].product_color[i].product_images[j].image);
                        }
                    }

            });
        },
        methods: {

        }

    }
    $(document).ready(function(){
        setTimeout(function(){
            $('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.slider-nav'
            });
            $('.slider-nav').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                asNavFor: '.slider-for',
                arrows: true,
                centerMode: true,
                focusOnSelect: true
            });
        },2000);
    });
</script>
