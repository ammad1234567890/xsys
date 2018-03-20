<template>

<div class="row">

            <div class="card headcolor">
                <div class="card-header">
                      <h3 class="card-title pad-bot"><i class="material-icons">chrome_reader_mode</i> <small>LEDGER</small> </h3>
                </div>
            </div>
    
    <div class="col-md-12">
        <div class="panel panel-default">
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
                        <date-picker name="fdate" v-model="searchData.fdate" type="date" format="dd-MM-yyyy" placeholder="dd-mm-yyyy" lang="en" required></date-picker>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="ToDate">To Date</label>

                        <date-picker name="tdate" v-model="searchData.tdate" type="date" format="dd-MM-yyyy" placeholder="dd-mm-yyyy" lang="en" required></date-picker>
                    </div>
                    <input v-if="editing==false" type="submit" @click="searchLedger" class="btn btn-tumblr" value="Search">
                </form>

            </div>
        </div>
    </div>

    <div class="col-md-12 panel panel-default">
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
                        <th>Collection</th>
                        <th>Outstanding</th>

                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(ledger,index) in ledgerData">
                        <td>{{index +1}}</td>
                        <td>{{ledger.TransDate | moment}}</td>
                        <td>{{ledger.description}}</td>
                        <td>{{ledger.Collection | currency('')}}</td>
                        <td>{{ledger.Credit | currency('')}}</td>

                    </tr>
                    <tr>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td style="font-weight: bold;">
                            Total Outstanding: {{last_outstanding | currency('')}}
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- View Details Modal END -->
    </div>
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
                last_outstanding:'',
                searchData:{
                    retailer_id: '',
                    fdate: '',
                    tdate: '',
                    retailerName:'',
                    retailer_index:''
                },
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

                this.last_outstanding=this.ledgerData[this.ledgerData.length - 1].Outstanding;
                //alert(this.last_outstanding);
                this.search_enabled=1;
            },
            change_retailer(){
                this.searchData.retailer_id=this.allRetailers[this.searchData.retailer_index].id;

            }

           },

     //   }
    }
</script>
