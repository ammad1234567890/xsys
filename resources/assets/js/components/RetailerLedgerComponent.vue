<template>


    <div class="col-md-12 panel panel-default">
        <div class="panel panel-info">
            <div class="panel-heading"><h3 style="margin-top: 6px; font-variant: small-caps; font-weight:bold;">Ledger - Search</h3></div>
            <div class="panel-body">


                <form @submit="searchLedger">
                    <div class="form-group col-md-4">
                        <label for="select Retailer">Retailer</label>
                        <select name="select_retailer" class="form-control" v-model="searchData.retailer_index" @change="change_retailer()">
                            <option value="" selected>Select Retailer</option>
                            <option v-for="(retailer, index) in allRetailers" v-bind:value="index">{{retailer.name}}</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="FromDate">From Date</label>
                        <input type="date" name="fdate" class="form-control" placeholder="From Date"  v-model="searchData.fdate" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="ToDate">To Date</label>
                        <input type="date" name="tdate" class="form-control" placeholder="To Date"   v-model="searchData.tdate" required>

                    </div>
                    <input v-if="editing==false" type="submit" @click="searchLedger" class="btn btn-default" value="Search">
                </form>

            </div>
        </div>

        <!-- RETAILER SHOW GRID -->
        <div class="panel panel-info" v-if="search_enabled">
            <div class="panel-heading"><h3 style="margin-top: 6px; font-variant: small-caps; font-weight:bold;">{{searchData.retailerName}} Ledger - Details</h3></div>

            <div class="panel-body">
                <table id="outlet_table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>SNO</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Credit</th>
                        <th>Collection</th>
                        <th>Outstanding</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(ledger,index) in ledgerData">
                        <td>{{index +1}}</td>
                        <td>{{ledger.TransDate}}</td>
                        <td>{{ledger.description}}</td>
                        <td>{{formatPrice(ledger.Credit)}}</td>
                        <td>{{formatPrice(ledger.Collection)}}</td>
                        <td>{{formatPrice(ledger.Outstanding)}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- View Details Modal END -->
    </div>

    </template>



<script>
    export default {

        data(){
            return {
                search_enabled:0,
                editIndex: '',
                editing: false,
                allRetailers: [],
                ledgerData:[],
                searchData:{
                    retailer_id: '',
                    fdate: '',
                    tdate: '',
                    retailerName:'',
                    retailer_index:''
                },
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            axios.get('./retailer/get_retailers').then((response) => {
                this.allRetailers= response.data;
            });
//            axios.get('./ledgerData').then((response) => {
//                this.ledgerData= response.data;
//                console.log(this.ledgerData);
//            });

        },
        methods:{
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            searchLedger(e){
                e.preventDefault();
                this.searchData.retailerName=this.allRetailers[this.searchData.retailer_index].name;
                axios.post('./ledgerData',this.searchData).then(response=>{
                       this.ledgerData = response.data;
                });
                this.search_enabled=1;
            },
            change_retailer(){
                this.searchData.retailer_id=this.allRetailers[this.searchData.retailer_index].id;

            }

           },

     //   }
    }
</script>
