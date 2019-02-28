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
        <div v-if="create_task_enabled==0">
            <button class="btn btn-primary" @click="enable_new_task"><i class="fa fa-plus"></i> Create New Sales Officer Task</button>

            <div class="panel panel-info" style="margin-top:20px;">
                <div class="panel-heading">
                    <h2 class="panel-title">Tasks List</h2>
                </div>
                <div class="panel-body">
                    <div class="projects">
                        <div class="tableFilters">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="control">
                                        <div class="select">
                                            <Label>Records:</Label>
                                            <select v-model="tableData2.length" @change="getProjects()">
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <input class="textbox" type="text" v-model="tableData2.search" placeholder="Search..."
                                           @input="get_all_tasks()">
                                </div>
                            </div>
                        </div>
                        <datatable :columns="columns2" :sortKey="sortKey2" :sortOrders="sortOrders2" @sort="sortBy2">
                            <tbody>
                                <tr v-for="(task, index) in all_tasks" :key="task.id">
                                    <td>{{task.task_no}}</td>
                                    <td>{{task.sales_officer.name}}</td>
                                    <td>{{task.retailer_outlet.name}}</td>
                                    <td>{{task.retailer_outlet.city.name}}</td>
                                    <td :title="task.retailer_outlet.region.name">{{task.retailer_outlet.region.name.substring(0,10)}}...</td>
                                    <td :title="task.retailer_outlet.address">{{task.retailer_outlet.address.substring(0,15)}}...</td>
                                    <td>
                                        <span v-if="task.task_status.id==1" style="color:red; font-weight:bold;">{{task.task_status.name}}</span>
                                        <span v-if="task.task_status.id==2" style="color:orange; font-weight:bold;">{{task.task_status.name}}</span>
                                        <span v-if="task.task_status.id==3" style="color:green; font-weight:bold;">{{task.task_status.name}}</span>
                                    </td>
                                    <td>{{task.created_at | moment}}</td>
                                    <td>
                                        <span v-if="task.task_status.id==1">Not Started Yet</span>
                                        <button v-if="task.task_status.id==2" @click="SetToComplete(task.id)">Completed</button>
                                        <a v-if="task.task_status.id==3" :href="base_url+'TaskReport/'+task.id" target="_blank">Check Report</a>
                                    </td>
                                </tr>
                            </tbody>
                        </datatable>
                        <pagination :pagination="pagination2"
                                    @prev="get_all_tasks(pagination2.prevPageUrl)"
                                    @next="get_all_tasks(pagination2.nextPageUrl)">
                        </pagination>
                    </div>
                </div>
            </div>
        </div>



        <div class="panel panel-info" v-if="create_task_enabled==1 && select_outlet_enabled==0">
            <div class="panel-heading">
                <h2 class="panel-title"><i class="fa fa-arrow-circle-left" @click="task_enabled()"></i> Add New Sales Officer Task</h2>
            </div>
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
                            <tr v-for="(so, index) in soData" :key="so.id">
                                <td>{{so.name}}</td>
                                <td>{{so.phoneNumber}}</td>
                                <td>{{so.email}}</td>
                                <td>{{so.CNIC}}</td>
                                <td><button @click="get_so_outlet(so.id, so.name, so.phoneNumber, so.CNIC, so.email)">Assign New task</button></td>
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

        <div class="panel panel-info" v-if="select_outlet_enabled==1">
            <div class="panel-heading">
                <h2 class="panel-title"><i class="fa fa-arrow-circle-left" @click="so_enabled()"></i> Create New Task</h2>
            </div>
            <div class="panel-body">

                <table width="50%">
                    <tr>
                        <td><b>SO Name:</b></td>
                        <td>{{selected_so_name}}</td>
                    </tr>
                    <tr>
                        <td><b>Phone:</b></td>
                        <td>{{selected_so_phone}}</td>
                    </tr>
                    <tr>
                        <td><b>CNIC:</b></td>
                        <td>{{selected_so_cnic}}</td>
                    </tr>
                    <tr>
                        <td><b>Email Address:</b></td>
                        <td>{{selected_so_email}}</td>
                    </tr>
                </table>
                <table class="table table-bordered" width="100%" border="1"  style="width:100%" id="DataTable">
                    <tr>
                        <th>Select</th>
                        <th>Outlet Name</th>
                        <th>Phone Number</th>
                        <th>City</th>
                        <th>Region</th>
                        <th>Address</th>
                    </tr>
                    <tr v-for="(outlets, index) in so_outlets">
                        <td><input type="checkbox" v-model="outlets.istrue"/> </td>
                        <td>{{outlets.outlet_name}}</td>
                        <td>{{outlets.phone}}</td>
                        <td>{{outlets.city}}</td>
                        <td>{{outlets.region}}</td>
                        <td>{{outlets.address}}</td>
                    </tr>
                </table>
                <button @click="add_new_task()" class="btn btn-primary">Add New Task</button>
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
                {width: '20%', label: 'Name', name: 'Name' },
                {width: '10%', label: 'Phone Number', name: 'Phone Number'},
                {width: '10%', label: 'Email Address', name: 'Email Address'},
                {width: '10%', label: 'CNIC', name: 'CNIC'},
                {width: '10%', label: 'Action', name: 'Action'},
            ];
            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });


            let sortOrders2 = {};
            let columns2 = [
                {width: '10%', label: 'Task#', name: 'Task#' },
                {width: '10%', label: 'Sales Officer', name: 'Sales Officer'},
                {width: '10%', label: 'Outlet Name', name: 'Outlet Name'},
                {width: '10%', label: 'City', name: 'City'},
                {width: '10%', label: 'Locality', name: 'Locality'},
                {width: '10%', label: 'Address', name: 'Address'},
                {width: '10%', label: 'Task Status', name: 'Task Status'},
                {width: '10%', label: 'Created Date', name: 'Created Date'},
                {width: '10%', label: 'Action', name: 'Action'},

            ];
            columns2.forEach((column2) => {
                sortOrders2[column2.name] = -1;
            });
            return {
                soData:[],
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


                columns2: columns2,
                sortKey2: 'Dealer Code',
                sortOrders2: sortOrders2,
                tableData2: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc',
                },
                pagination2: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: ''
                },

                base_url:constant.base_url,
                so_outlets:[],
                create_task_enabled:0,
                select_outlet_enabled:0,
                selected_so_name:'',
                selected_so_phone:'',
                selected_so_cnic:'',
                selected_so_email:'',
                selected_so_id:'',
                selected_outlet_arr:[],
                all_tasks:[]
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
            this.getProjects();
            this.get_all_tasks();
        },
        methods: {
            getProjects(url = constant.base_url+'get_sales_officers_outlet') {
                this.tableData.draw++;
                axios.get(url, {params: this.tableData})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData.draw == data.draw) {
                            this.soData = data.data.data;
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
            get_so_outlet($so_id, so_name, so_phone, so_cnic, so_email){
                this.selected_so_name=so_name;
                this.selected_so_phone=so_phone;
                this.selected_so_cnic=so_cnic;
                this.selected_so_email=so_email;
                this.selected_so_id=$so_id;
                axios.get(constant.base_url+"get_sales_officer_outlet/"+$so_id).then(response=>{

                    for(var i=0; i<(response.data.length-1); i++){
                        this.so_outlets.push({
                            istrue:false,
                            outlet_id:response.data[i].retailer_outlet.id,
                            outlet_name:response.data[i].retailer_outlet.name,
                            phone:response.data[i].retailer_outlet.phone_no,
                            city:response.data[i].retailer_outlet.city.name,
                            region:response.data[i].retailer_outlet.region.name,
                            address:response.data[i].retailer_outlet.address,
                        });
                    }

                    console.log(this.so_outlets);

                    //console.log(this.so_outlets);
                    this.select_outlet_enabled=1;
                });
            },
            enable_new_task(){
                this.create_task_enabled=1;
            },
            so_enabled(){
                this.select_outlet_enabled=0;
            },
            task_enabled(){
                this.create_task_enabled=0;
            },
            add_new_task(){
                this.selected_outlet_arr=[];
                for(var i=0; i<this.so_outlets.length; i++){
                    if(this.so_outlets[i].istrue==true){
                        this.selected_outlet_arr.push(this.so_outlets[i].outlet_id);
                    }
                }


                if(this.selected_outlet_arr.length==0){
                    alert("Please Select Any Outlet!");
                }
                else{
                    axios.post(constant.base_url+"create_survey_task",{'so_id': this.selected_so_id, 'outlets': this.selected_outlet_arr}).then(response=>{
                        if(response.data==201){
                            alert("New Task has been Successfully Created!");
                            location.reload();
                        }
                        else{
                            alert("Error");
                        }
                    });
                }


            },

            get_all_tasks(url = constant.base_url+'get_all_so_tasks') {
                this.tableData2.draw++;
                axios.get(url, {params: this.tableData2})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData2.draw == data.draw) {
                            this.all_tasks = data.data.data;
                            this.configPagination2(data.data);
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            configPagination2(data) {
                this.pagination2.lastPage = data.last_page;
                this.pagination2.currentPage = data.current_page;
                this.pagination2.total = data.total;
                this.pagination2.lastPageUrl = data.last_page_url;
                this.pagination2.nextPageUrl = data.next_page_url;
                this.pagination2.prevPageUrl = data.prev_page_url;
                this.pagination2.from = data.from;
                this.pagination2.to = data.to;
            },
            sortBy2(key) {
                this.sortKey2 = key;
                this.sortOrders2[key] = this.sortOrders2[key] * -1;
                this.tableData2.column = this.getIndex2(this.columns2, 'name', key);
                this.tableData2.dir = this.sortOrders2[key] === 1 ? 'asc' : 'desc';
                this.get_all_tasks();
            },
            getIndex2(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },
            SetToComplete($task_id){
                axios.post(constant.base_url+'changeToCompleteTask',{task_id: $task_id}).then((response)=>{
                    if(response.data==201){
                        alert("Task Completed");
                        this.get_all_tasks();
                    }
                });
            }


        }
    }


</script>