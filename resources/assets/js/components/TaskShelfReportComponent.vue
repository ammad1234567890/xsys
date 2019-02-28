<style lang="scss">
    #DataTable tr td{
        padding:10px;
    }
    #DataTable tr th{
        font-size:15px;
        padding:10px;
    }
</style>
<template>
    <div class="row">
        <div class="row">
            <div class="col-md-6">

                <h4>Sales Officer</h4>
                <hr/>
                <table width="100%">
                    <tr>
                        <td>Task No:</td>
                        <td><b>{{TaskDetails.task_no}}</b> - {{TaskDetails.task_status.name}}</td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td>{{TaskDetails.sales_officer.name}}</td>
                    </tr>
                    <tr>
                        <td>Phone Number:</td>
                        <td>{{TaskDetails.sales_officer.phoneNumber}}</td>
                    </tr>

                    <tr>
                        <td>CNIC:</td>
                        <td>{{TaskDetails.sales_officer.CNIC}}</td>
                    </tr>

                    <tr>
                        <td>Email Address:</td>
                        <td>{{TaskDetails.sales_officer.email}}</td>
                    </tr>
                    <tr>
                        <td>Comments:</td>
                        <td>{{TaskDetails.comment}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h4>Outlet: </h4>
                <hr/>
                <table width="100%">
                    <tr>
                        <td>Outlet Name:</td>
                        <td>{{TaskDetails.retailer_outlet.name}}</td>
                    </tr>
                    <tr>
                        <td>City:</td>
                        <td>{{TaskDetails.retailer_outlet.city.name}}</td>
                    </tr>

                    <tr>
                        <td>Region:</td>
                        <td>{{TaskDetails.retailer_outlet.region.name}}</td>
                    </tr>

                    <tr>
                        <td>Address:</td>
                        <td>{{TaskDetails.retailer_outlet.address}}</td>
                    </tr>
                </table>
            </div>
        </div>


        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">On Shelf Items</h2>
            </div>



            <!-- RETAILER SHOW GRID -->
            <div class="panel-body">

                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <td>S.no</td>
                            <td>Model</td>
                            <td>Color</td>
                            <td>IMEI1</td>
                            <td>IMEI2</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(shelf, index) in onShelfImei">
                            <td>{{index+1}}</td>
                            <td>{{shelf.item.product_color.product.name}}</td>
                            <td>{{shelf.item.product_color.color}}</td>
                            <td>{{shelf.item.imei[0].imei1}}</td>
                            <td>{{shelf.item.imei[0].imei2}}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">Items Not in Shelf</h2>
            </div>



            <!-- RETAILER SHOW GRID -->
            <div class="panel-body">

                <table class="table table-bordered" width="100%">
                    <thead>
                    <tr>
                        <td>S.no</td>
                        <td>Model</td>
                        <td>Color</td>
                        <td>IMEI1</td>
                        <td>IMEI2</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(not_in_shelf, index) in forActivateImeis">
                        <td>{{index+1}}</td>
                        <td>{{not_in_shelf.item.product_color.product.name}}</td>
                        <td>{{not_in_shelf.item.product_color.color}}</td>
                        <td>{{not_in_shelf.item.imei[0].imei1}}</td>
                        <td>{{not_in_shelf.item.imei[0].imei2}}</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>
<script>
    import Datatable from './DatatableComponent.vue';
    import Pagination from './PaginationComponent.vue';
    import {constant} from '../constant.js';
    import vSelect from "vue-select";
    export default {
        components: {vSelect},
        components: {datatable: Datatable, pagination: Pagination},
        data(){
            return {
                onShelfImei:[],
                TaskDetails:[],
                forActivateImeis:[]

            }
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
        mounted() {
            axios.get(constant.base_url+'get_shelf_imeis_by_task/'+window.location.pathname.split('/')[4]).then((response)=>{
                this.onShelfImei=response.data;
            });

            axios.get(constant.base_url+'get_for_activate_imeis_by_task/'+window.location.pathname.split('/')[4]).then((response)=>{
                this.forActivateImeis=response.data;
            });



            axios.get(constant.base_url+'get_so_task/'+window.location.pathname.split('/')[4]).then((response)=>{
                this.TaskDetails=response.data[0];
            });
        },
        created(){

        },
        methods: {



        }
    }


</script>