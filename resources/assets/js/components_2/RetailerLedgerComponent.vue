<template>

<div class="row" style="margin-top: 24px;">

    <div class="col-md-12">
        <div class="panel panel-info">
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
        <button title="Print" id="btn_print" @click="print_ledger" class="btn btn-github btn-xs pull-right "  style="display: none;"><i class="fa fa-print"></i></button>

        <!-- RETAILER SHOW GRID -->
        <div id="printLedger">
            <div class="print_details" style="float:left;font-size: 12px;display: none">
            <div ><img :src="ddl_logo_path"   width="150" style=""></div>
            <div style="">Deploy Distribution & Logistics (PVT) Ltd.</div>
            <div>Ledger - Details  From: {{searchData.fdate | moment}} To {{searchData.tdate | moment}}</div>
        </div>
<div style="float:right;margin-top:50px;font-size: 12px;display: none" class="print_details">
            <div>Outlet Name: {{searchData.retailerName}}</div>
            <div>Dealer Code: {{retailer_no}}</div>
</div>
            <div class="panel panel-info" v-if="search_enabled" style="">
                <div class="panel-heading print_disable"><h5 style="margin-top: 6px; "><b>{{searchData.retailerName}}</b> Ledger - Details <span class="pull-right"> From: {{searchData.fdate | moment}} To {{searchData.tdate | moment}}</span></h5>
                </div>
                <div class="panel-body" style="clear:both;">
                    <table id="ledger-table" class="table table-bordered" border="1px solid #999"  style="font-size:12px;font-family: Calibri;border-collapse: collapse">
                        <thead>
                            <tr>
                                <!--<th>SNO</th>-->
                                <th width="15%">Date</th>
                                <th width="40%">Narration</th>
                                <th width="15%">Debit(PKR)</th>
                                <th width="15%">Credit(PKR)</th>
                                <th width="15%">Balance(PKR)</th>
                            </tr>
                        </thead>
                        <tbody>
                    <tr>

                            <td style="font-weight: bold;" colspan="5" align="right">
                                Opening Balance: {{open_outstanding | currency('')}}
                            </td>

                        </tr>
                            <tr v-for="(ledger,index) in ledgerData">
                                <!--<td>{{index +1}}</td>-->
                                <td><center>{{ledger.TransDate | moment}}</center></td>
                                <td>{{ledger.description}}</td>
                                <td align="right">{{ledger.Credit | currency('')}}</td>
                                <td align="right">{{ledger.Collection | currency('')}}</td>
                                <td align="right">{{ledger.Outstanding | currency('')}}</td>
                            </tr>
    				<!-- 	 <tr>
                            <td style="font-weight: bold;" colspan="5" align="right">
                            </td>
                        </tr> -->
                     <tr>
                            <td style="font-weight: bold;" colspan="5" align="right">
                                Closing Balance: {{last_outstanding | currency('')}}
                            </td>

                        </tr>
                        </tbody>
                      <!--      <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <strong>Opening Balance: <span class="pull-right" style="margin-right: 10px;">{{open_outstanding | currency('')}}</span></strong>
                                </td>
                            </tr>	-->
                    </table>

                </div>
                <div  style="font-size: 9px">{{current_date}}</div>
            </div>
        <!-- View Details Modal END -->

        </div>
    </div>
</div>

    </template>



<script>
    import {constant} from '../constant.js';
    export default {

        data(){
            return {
                ddl_logo_path: '',
                search_enabled:0,
                editIndex: '',
                editing: false,
                allRetailers: [],
                ledgerData:[],
                last_outstanding:'',
                open_outstanding:'',
                current_date: moment().format('DD-MM-YYYY h:s a'),
                retailer_no:'',
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
            this.ddl_logo_path=constant.base_url+'img/ddl_logo.png';
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
                this.search_enabled=0;
                this.searchData.retailerName=this.allRetailers[this.searchData.retailer_index].name;
                this.last_outstanding=0;
                this.open_outstanding=0;
                axios.post('./ledgerData',this.searchData).then(response=>{
                        $('#btn_print').show();
                       this.ledgerData = response.data;
                    this.last_outstanding=response.data[response.data.length - 1].Outstanding;
                    //this.open_outstanding=response.data[0].Outstanding;
                    this.open_outstanding=0;
                });
                axios.get('./retailer_info/'+this.searchData.retailer_id).then(response=>{
            this.retailer_no=response.data[0].retailer_no;
            });
                console.log(this.searchData.retailer_id);
                //alert(this.last_outstanding);
                this.search_enabled=1;
               // mydatatable();
            },
            change_retailer(){
                this.searchData.retailer_id=this.allRetailers[this.searchData.retailer_index].id;
            },
            printData:function()
    {
        $('.print_details').show();
        $('.print_disable').hide();
        var divToPrint=document.getElementById("printLedger");
        var newWin= window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        $('.print_details').hide();
        $('.print_disable').show();
       newWin.close();
    },
        print_ledger:function(){
           this.printData();
        },
        },
     //   }
    }

/*    function mydatatable(){
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
    } */

</script>
