<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 ">
                <div class="panel panel-default" id="imei_grid">
                    <div class="panel-heading">Sale Return</div>
                    <div class="panel-body">
                        <div class="col-md-1">IMEI</div>
                        <div class="col-md-8"><input v-model="imei" type="text" class="form-control" autofocus/></div>
                        <div class="col-md-12">
                            <table class="table">
                                <tbody>
                                <tr v-for="(imei, index) in removeDuplicates(imei_list)">
                                    <td width="12px">{{index + 1}}</td>
                                    <td>{{imei}}</td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-xs" @click="removeIMEI(index)" title="Delete">
                                            <i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <button @click="submit()">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default dis-none">
                    <div class="panel-body">
                        <table class="table table-hovered">
                            <thead>
                            <tr>
                                <td>Model</td>
                                <td>Color</td>
                                <td>Price</td>
                                <td>IMEI1</td>
                                <td>IMEI2</td>
                                <td>Outlet Name</td>
                                <td>Address</td>
                                <td>Order No</td>
                                <td>Invoice No</td>
                                <td>Sale Officer</td>
                                <td>Date</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(details, index) in product_details.data" v-if="details.outlet_id==outlet_id">
                                <td>{{details.product_name}}</td>
                                <td>{{details.color}}</td>
                                <td>{{details.product_unit_price}}</td>
                                <td>{{details.imei1}}</td>
                                <td>{{details.imei2}}</td>
                                <td>{{details.outlet_name}} ({{details.outlet_id}})</td>
                                <td>{{details.outlet_address}}</td>
                                <td>{{details.order_no}}</td>
                                <td>{{details.invoice_no}}</td>
                                <td>{{details.staff_name}}</td>
                                <td>{{details.invoice_date}}</td>
                            </tr>
                            <tr class="red" v-for="(details, index) in product_details.data"
                                v-if="details.outlet_id!=outlet_id">
                                <td>{{details.product_name}}</td>
                                <td>{{details.color}}</td>
                                <td>{{details.product_unit_price}}</td>
                                <td>{{details.imei1}}</td>
                                <td>{{details.imei2}}</td>
                                <td>{{details.outlet_name}} ({{details.outlet_id}})</td>
                                <td>{{details.outlet_address}}</td>
                                <td>{{details.order_no}}</td>
                                <td>{{details.invoice_no}}</td>
                                <td>{{details.staff_name}}</td>
                                <td>{{details.invoice_date}}</td>
                                <td>
                                    <button @click="remove_imei_detail(index)"><b>X</b></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <button @click="sale_return()" id="return_btn" class="pull-right">Return</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                imei: '',
                imei_list: [],
                product_details: [],
                outlet_id: '',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        watch: {
            imei: function () {
                if (this.imei.length >= 15) {
                    if (this.imei != '') {
                        this.imei_list.push(this.imei);
                        this.imei = '';
                    }
                }
            }
        },
        methods: {
            removeIMEI(index) {
                event.preventDefault();
                this.imei_list.splice(index, 1);
            },
            remove_imei_detail(index) {
                event.preventDefault();
                this.product_details.data.splice(index, 1);
            },
            submit: function () {
                $('#imei_grid').hide();

                this.outlet_id = window.location.pathname.split('/')[4];
                axios.post('../sale_return_verification', {'imei_list': this.imei_list}).then((response) => {
                    this.imei = '';
                    this.imei_list = [];
                    this.product_details = response.data;
                    if (response.data.status == true) {
                        $(".dis-none").removeClass("dis-none");
                    } else {
                        alert("Invalid IMEI")
                        location.reload();
                    }
                    console.log(response.data);
                });
            },
            removeDuplicates: function (arr) {
                let unique_array = []
                for (let i = 0; i < arr.length; i++) {
                    if (unique_array.indexOf(arr[i]) == -1) {
                        unique_array.push(arr[i])
                    }
                }
                return unique_array
            },
            sale_return: function () {
                var count = 0;
                for (var i = 0; i < this.product_details.data.length; i++) {
                    if (this.product_details.data[i].outlet_id != this.outlet_id) {
                        count++;
                    }
                }
                if (count == 0 && this.product_details.data.length!=0) {
                    $('#return_btn').hide();
                    axios.post('../sale_return', {'products': this.product_details}).then((response) => {
                        if (response.data.status == true) {
                            alert("Sale Return Successful");
                            location.reload();
                        }
                    });
                } else {
                    alert("Remove Invalid IMEI");
                }
            }
        }
    }
</script>
<style>
    .red {
        color: red;
    }

    .dis-none {
        display: none;
    }
</style>
