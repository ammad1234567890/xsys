<template>

<div class="row" style="margin-top: 24px;">
    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h5 style="margin-top: 6px; font-variant: small-caps;">Ledger - Search</h5></div>
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
                    <div class="form-group col-md-2" style="margin-top: 34px;">

                        <input v-if="editing==false" type="submit" @click="searchLedger" class="btn btn-tumblr" value="Search">
                    </div>
                </form>

            </div>
        </div>

        
        <!-- RETAILER SHOW GRID -->
            <div class="panel panel-info" v-if="search_enabled">
                <div class="panel-heading"><h5 style="margin-top: 6px; font-variant: small-caps; color: #000;">{{searchData.retailerName}} Ledger - Details<span class="pull-right">From-To: {{searchData.fdate | moment}} - {{searchData.tdate | moment}}</span></h5>
                </div>
                <div class="panel-body">
                    <table id="ledger-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <!--<th>SNO</th>-->
                                <th>Date</th>
                                <th>Narration</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                    <!--    <tr>

                            <td style="font-weight: bold;" colspan="5" align="right">
                                Opening Balance: {{open_outstanding | currency('')}}
                            </td>

                        </tr> -->
                            <tr v-for="(ledger,index) in ledgerData">
                                <!--<td>{{index +1}}</td>-->
                                <td>{{ledger.TransDate | moment}}</td>
                                <td>{{ledger.description}}</td>
                                <td align="right">{{ledger.Credit | currency('')}}</td>
                                <td align="right">{{ledger.Collection | currency('')}}</td>
                                <td align="right">{{ledger.Outstanding | currency('')}}</td>
                            </tr>
    				<!-- 	 <tr>
                            <td style="font-weight: bold;" colspan="5" align="right">                       
                            </td>
                        </tr> -->
                     <!-- <tr>
                            <td style="font-weight: bold;" colspan="5" align="right">
                                Closing Balance: {{last_outstanding | currency('')}}
                            </td>

                        </tr>	--> 			
                        </tbody>	
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <strong>Opening Balance: <span class="pull-right" style="margin-right: 10px;">{{open_outstanding | currency('')}}</span></strong>
                                </td>
                            </tr>			
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
                open_outstanding:'',
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
            axios.get('./outlet/get_all_outlets').then((response) => {
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
                this.open_outstanding=this.ledgerData[0].Outstanding;
                //alert(this.last_outstanding);
                this.search_enabled=1;
                mydatatable();
            },
            change_retailer(){
                this.searchData.retailer_id=this.allRetailers[this.searchData.retailer_index].id;
            }

           },

     //   }
    }

    function mydatatable(){
        setTimeout(function(){
            $('#ledger-table').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search here",
            }
            });
        },3000); 
    }

</script>
