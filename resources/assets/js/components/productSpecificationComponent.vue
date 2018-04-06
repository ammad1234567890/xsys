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
                    <h3 class="col-md-12 text-center">Xcell</h3>
                    <!--<img v-bind:src="'./category_img/'+productDetails.product_category.image" class=" img-thumbnail" height="auto" /> -->
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
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Model Name:</b> </td>
                            <td>{{specification.name}}</td>
                        </tr>
                        <tr>
                            <td><b>Release Date:</b> </td>
                            <td>{{specification.released_date}}</td>
                        </tr>
                        <tr>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>Discount</th>
                            <th>Price</th>
                            <th>Warehouse</th>
                            <th>Address</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
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
                this.specification=response.data.data[0];
            });
        },
        methods: {

        }

    }
