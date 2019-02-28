<template>
    <div class="row" style="margin-top: 24px;">
        <div class="panel panel-info" v-if="enable_search==0">
            <div class="panel-heading">
                <h2 class="panel-title">Select Outlet for Ledger</h2>
            </div>



            <!-- RETAILER SHOW GRID -->
            <div class="panel-body">

                <div class="projects">
                    <div class="tableFilters">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="control">
                                    <div class="select">
                                        <Label>Records:</Label>
                                        <select v-model="tableData.length" @change="getProjects()">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">

                                <input class="textbox" type="text" v-model="tableData.search" placeholder="Search..."
                                       @input="getProjects()">
                            </div>
                        </div>
                    </div>
                    <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                        <tbody>
                        <tr v-for="(outlets, index) in outletsData" :key="outlets.id">
                            <td>{{outlets.name}}</td>
                            <td :title="outlets.business_person_name">{{outlets.retailer.retailer_no}}</td>
                            <td>{{outlets.business_person_name}}</td>
                            <td>{{outlets.phone_no}}</td>
                            <td>{{outlets.city.name}}</td>
                            <td :title=outlets.region.name>{{outlets.region.name.slice(0,30)}}...</td>
                            <td :title=outlets.address>{{outlets.address.slice(0,30)}}...</td>


                            <td>

                                <div class="btn-group ">
                                    <button class="btn btn-primary btn-xs" @click="show_ledger(outlets.id, outlets.name, outlets.city.name, outlets.address, outlets.phone_no, outlets.region.name)">Show Ledger</button>

                                </div>
                            </td>





                        </tr>
                        </tbody>
                    </datatable>
                    <pagination :pagination="pagination"
                                @prev="getProjects(pagination.prevPageUrl)"
                                @next="getProjects(pagination.nextPageUrl)">
                    </pagination>
                </div>

            </div>
        </div>
        <div class="col-md-12" v-if="enable_search==1">
            <div class="panel panel-info">
                <div class="panel-heading"><h5 style="margin-top: 6px; font-variant: small-caps;"><i class="fa fa-arrow-circle-left" @click="outlet_enabled()"></i> Ledger - Search</h5></div>
                <div class="panel-body">
                    <form @submit="searchLedger">
                        <div class="form-group col-md-4">
                            <label for="select Retailer">Retailer</label>
                            <!--<select name="select_retailer" class="form-control" v-model="searchData.retailer_index" @change="change_retailer()">
                                <option value="" selected>Select Retailer</option>
                                <option v-for="(retailer, index) in allRetailers" v-bind:value="index">{{retailer.name}}</option>
                            </select>-->
                            <input type="text" class="textbox" v-model="searchData.retailerName" readonly/>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="select Retailer">City</label>
                            <!--<select name="select_retailer" class="form-control" v-model="searchData.retailer_index" @change="change_retailer()">
                                <option value="" selected>Select Retailer</option>
                                <option v-for="(retailer, index) in allRetailers" v-bind:value="index">{{retailer.name}}</option>
                            </select>-->
                            <input type="text" class="textbox" v-model="city" readonly/>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="select Retailer">Region</label>
                            <!--<select name="select_retailer" class="form-control" v-model="searchData.retailer_index" @change="change_retailer()">
                                <option value="" selected>Select Retailer</option>
                                <option v-for="(retailer, index) in allRetailers" v-bind:value="index">{{retailer.name}}</option>
                            </select>-->
                            <input type="text" class="textbox" v-model="region" readonly/>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="select Retailer">Address</label>
                            <!--<select name="select_retailer" class="form-control" v-model="searchData.retailer_index" @change="change_retailer()">
                                <option value="" selected>Select Retailer</option>
                                <option v-for="(retailer, index) in allRetailers" v-bind:value="index">{{retailer.name}}</option>
                            </select>-->
                            <input type="text" class="textbox" v-model="address" readonly/>
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
                    <div><b style="font-size:20px;">Dealer Details</b></div>
                    <div><b>Outlet Name: </b>{{searchData.retailerName}}</div>
                    <div><b>Dealer Code: </b>{{retailer_no}}</div>
                    <div><b>Contact No:</b> {{contact_no}}</div>
                    <div><b>City:</b> {{city}}</div>
                    <div><b>Address:</b> {{address}}</div>

                </div>
                <br/>
                <div style="float:right;margin-top:50px;font-size: 12px;display: none;margin-bottom: 25px;" class="print_details">
                    <div><b style="font-size:20px;">Ledger Details</b><br/>From: {{searchData.fdate | moment}} To {{searchData.tdate | moment}}</div>
                </div>
                <div class="panel panel-info" v-if="search_enabled" style="">
                    <div class="panel-heading print_disable"><h5 style="margin-top: 6px; "><b>{{searchData.retailerName}}</b> <span>Ledger</span> - Details <span class="pull-right"> From: {{searchData.fdate | moment}} To {{searchData.tdate | moment}}</span></h5>
                    </div>
                    <div class="panel-body" style="clear:both;">
                        <table id="ledger-table" class="table table-bordered" border="1px solid #999" width="100%" style="font-size:12px;font-family: Calibri;border-collapse: collapse">
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
                            <tr>
                                <td style="font-weight: bold;" colspan="5" align="right">
                                    Closing Balance: {{last_outstanding | currency('')}}
                                </td>
                            </tr>
                            </tbody>
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
    import Datatable from './DatatableComponent.vue';
    import Pagination from './PaginationComponent.vue';
    import {constant} from '../constant.js';
    import vSelect from "vue-select";
    export default {
        components: {vSelect},
        components: {datatable: Datatable, pagination: Pagination},
        data(){
            let sortOrders = {};
            let columns = [
                {width: '20%', label: 'Outlet', name: 'Outlet' },
                {width: '10%', label: 'Dealer Code', name: 'Dealer Code'},
                {width: '10%', label: 'Name', name: 'Name'},
                {width: '10%', label: 'Contact No', name: 'Contact No'},
                {width: '10%', label: 'City', name: 'City'},
                {width: '15%', label: 'Locality', name: 'Locality'},
                {width: '20%', label: 'Address', name: 'Address'},
                {width: '25%', label: 'Action', name: 'Action'},
            ];
            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });
            return {
                enable_search:0,
                outletsData:[],
                projects:[],
                columns: columns,
                sortKey: 'Dealer Code',
                sortOrders: sortOrders,
                tableData: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc',
                },
                pagination: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: ''
                },
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
                city:'',
                address:'',
                contact_no:'',
                region:'',
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
            this.getProjects();
        },
        methods:{
            outlet_enabled(){
                this.searchData.fdate='';
                this.searchData.tdate='';

                this.search_enabled=0;
                this.enable_search=0;
            },
            show_ledger($id, retailer_outlet_name, city, address, contact_no, region){
                this.searchData.retailer_id=$id;
                this.searchData.retailerName=retailer_outlet_name;
                this.city=city;
                this.address=address;
                this.contact_no=contact_no;
                this.region=region;
                this.enable_search=1;
                //alert($id);
            },
            getProjects(url = constant.base_url+'get_all_outlets_dataTable') {
                this.tableData.draw++;
                axios.get(url, {params: this.tableData})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData.draw == data.draw) {
                            this.outletsData = data.data.data;
                            console.log(this.outletsData);
                            this.configPagination(data.data);
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            configPagination(data) {
                this.pagination.lastPage = data.last_page;
                this.pagination.currentPage = data.current_page;
                this.pagination.total = data.total;
                this.pagination.lastPageUrl = data.last_page_url;
                this.pagination.nextPageUrl = data.next_page_url;
                this.pagination.prevPageUrl = data.prev_page_url;
                this.pagination.from = data.from;
                this.pagination.to = data.to;
            },
            sortBy(key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.getProjects();
            },
            getIndex(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            searchLedger(e){
                e.preventDefault();
                this.search_enabled=0;
               // this.searchData.retailerName=this.allRetailers[this.searchData.retailer_index].name;
                this.last_outstanding=0;
                this.open_outstanding=0;
                axios.post('./ledgerData',this.searchData).then(response=>{
                    $('#btn_print').show();
                    this.ledgerData = response.data;
                    this.last_outstanding=response.data[response.data.length - 1].Outstanding;
                    //this.open_outstanding=response.data[0].Outstanding;
                   // this.open_outstanding=0;
                });

                axios.post('./get_past_closing_balance',this.searchData).then(response=>{
                    this.open_outstanding=response.data[response.data.length - 1].Outstanding;
                    // this.open_outstanding=0;
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
                //alert(this.allRetailers[this.searchData.retailer_index].id);
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
