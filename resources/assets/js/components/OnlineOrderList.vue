<template>
    <div>
        <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h5>Order List</h5>
                </div>
                <!-- RETAILER SHOW GRID -->
                <div class="panel-body">
                    <table id="order_table" class="table table-striped table-bordered ">
                        <thead>
                        <tr>
                            <th>Order No</th>
                            <th>Name</th>
                            <th>Phone No</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(value) in orders">
                            <td>{{value.order_no}}</td>
                            <td>{{value.fullname}}</td>
                            <td>{{value.phone}}</td>
                            <td>{{value.email}}</td>
                            <td>{{value.created_at | moment()}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" v-on:click="detials(value.id)">Details
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--model view start-->
        <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog" id="order_details"
             aria-labelledby="bs-add-Model-modal-md">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <div class="row">
                            <div style="margin-left: 10px;">
                                <h4 class="modal-title">Order Details</h4>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered ">
                                    <tbody>
                                    <tr>
                                        <td>Order No</td>
                                        <td>{{user.order_no}}</td>
                                        <td>Name</td>
                                        <td>{{user.fullname}}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td>{{user.phone}}</td>
                                        <td>Email</td>
                                        <td>{{user.email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td>{{user.address}}</td>
                                        <td>Date</td>
                                        <td>{{user.created_at | moment()}}</td>
                                    </tr>
                                    <tr>
                                        <td>Order Status</td>
                                        <td><select class="form-control" v-model="status" id="status_option">
                                            <option value="1">Pending</option>
                                            <option value="2">Cancel</option>
                                            <option value="3">Completed</option>
                                        </select>
                                            <br>
                                            <button type="button" class="btn btn-primary" id="status_btn"
                                                    @click="status_update(user.id)">Update
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered ">
                                    <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Product Color</th>
                                        <th>Price</th>
                                        <th>QTY</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(value) in order_details">
                                        <td>{{value.name}}</td>
                                        <td>{{value.color}}</td>
                                        <td>{{value.price}}</td>
                                        <td>{{value.qty}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right"><b>Total</b></td>
                                        <td><b>{{total}}</b></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--model view end -->

    </div>
</template>

<script>
    import vSelect from "vue-select"
    import {constant} from '../constant.js';

    export default {
        components: {vSelect},
        data() {
            return {
                orders: [],
                order_details: [],
                user: [],
                total: 0,
                status: '',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created: function () {
            this.get_orders();
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            },
        },
        methods: {
            get_orders: function () {
                axios.get('onlineorders').then((response) => {
                    this.orders = response.data.data;
                });
            },
            detials: function (id) {
                this.total = 0;
                axios.get('order_details/' + id).then((response) => {
                    this.order_details = response.data.data;
                    this.user = response.data.data[0];
                    this.status = response.data.data[0].status;
                    if (this.status == 3) {
                        $("#status_option").attr("disabled", "disabled");
                        $('#status_btn').hide();
                    }
                    else{
                        $("#status_option").attr("disabled", false);
                        $('#status_btn').show();
                    }
                    for (var i = 0; i < response.data.data.length; i++) {
                        this.total += parseInt(response.data.data[i].price * response.data.data[i].qty);
                    }
                    $('#order_details').modal('show');
                });
            },
            status_update: function (id) {
                var token = $("input[name*='_token']").val();
                axios.post('status_update', {
                    'status_id': this.status,
                    'order_id': id,
                    '_token': token
                }).then((response) => {
                    //console.log(response.data);
                    if(this.status==3){
                        $("#status_option").attr("disabled", "disabled");
                        $('#status_btn').hide();
                    }
                    alert('Status Update');
                });
            },
        }

    }

        setTimeout(function(){  $('#order_table').DataTable();}, 1000);

</script>
