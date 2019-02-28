<template>
    <div>
        <div class="width_container">
            <img :src="ddl_logo_path" width="150">
            <div class="header">
                <div class="heading ">
                    <div><label><b>Transfer Invoice No</b> :</label> {{ti_details.win_no}}</div>
                    <div><label><b>From Warehouse</b> :</label> {{ti_details.warehouse_from.name}}</div>
                    <div><label><b>To Warehouse</b> :</label> {{ti_details.warehouse_to.name}}</div>
                    <div><label><b>Date</b> :</label> {{ti_details.created_at | moment}}</div>
                </div>
                <div class="heading floatright title">
                    <label><strong>TRANSFER INVOICE</strong> </label>
                </div>
            </div>
            <div class="heading floatleft ">
                <div class="panel-b">
                    <div class="m-l-12"><h5>FROM WAREHOUSE</h5></div>
                </div>
            </div>
            <div class="heading floatright m-l-50">
                <div class="panel-g">
                    <div class="m-l-12"><h5 class="m-t-30">TO WAREHOUSE</h5></div>
                </div>
            </div>
            <div class="heading floatleft m-t_-30">
                <table style=" ">
                    <tr>
                        <td>Name:</td>
                        <td>{{ti_details.warehouse_from.name}}</td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td>{{ti_details.warehouse_from.phone_no}}</td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td>{{ti_details.warehouse_from.address}}</td>
                    </tr>
                </table>
            </div>
            <div class="heading floatright m-t_-30">
                <table>
                    <tr>
                        <td>Name:</td>
                        <td>{{ti_details.warehouse_to.name}}</td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td>{{ti_details.warehouse_to.phone_no}}</td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td>{{ti_details.warehouse_to.address}}</td>
                    </tr>

                </table>
            </div><br>



            <div class="order">
                <table id="order">
                    <thead>
                    <tr class="border">
                        <th width="4%" class="border">S.No</th>
                        <th width="12%" class="border ">SKU</th>
                        <th width="20%" class="border ">Model Name</th>
                        <th width="13%" class="border">Color</th>
                        <th width="13%" class="border">Unit Cost (PKR)</th>
                        <th width="10%" class="border">Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(products, index) in ti_details.transfer_products" class="border">
                        <td>{{index+1}}</td>
                        <td>{{products.product_color.sku}}</td>
                        <td>{{products.product.name}}</td>
                        <td>{{products.product_color.color}}</td>
                        <td>{{products.price}}</td>
                        <td>{{products.quantity}}</td>
                    </tr>
                    <tr class="border">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total Cost: {{this.total_cost | currency('')}}</td>
                        <td>Total Qty: {{this.total_quantity}}</td>
                    </tr>
                    <tr class="border">

                    </tr>
                    <tr class="border">

                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="term"><label>Terms & Conditions Applied</label><br>
            </div>
            <div class="qrcode">
                <div id="qrcode" style="width:100px; height:100px; margin-top:15px;"></div>
            </div>
            <div class="" style="float:right;margin-top:135px">
                ________________________________<br>
                <center>signature</center>
            </div>
        </div>
    </div>
</template>

<script>
    import {constant} from '../constant.js';
    export default {
        data() {
            return {
                ddl_logo_path: '',
                ti_details:[],
                total_quantity:0,
                total_cost:0

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
            this.ddl_logo_path=constant.base_url+'img/ddl_logo.png';
            console.log('Component mounted.')
        },
        created: function () {
            this.init();
        },
        methods: {
            init: function () {

                this.get_details();
            },
            get_details: function () {
                axios.get(constant.base_url+'get_issue_note_details/' + window.location.pathname.split('/')[4]).then((response)=> {
                    this.ti_details=response.data[0];
                    for(var i=0; i<this.ti_details['transfer_products'].length; i++){
                        this.total_quantity+=this.ti_details['transfer_products'][i].quantity;
                        this.total_cost+=parseInt(this.ti_details['transfer_products'][i].price);
                    }

                    setTimeout("window.print()",23);
                    setTimeout("self.close()", 23);
                });
            }
        }
    }
</script>
<style>
    * {
        font-family: calibri;
    }
    .m-p-0{
        margin:0px;
        padding:0px
    }
    .width_container {
        width: 1050px;
    }

    .header {
        height: 40px;
        margin-top: 30px;
    }

    .heading {
        width: 500px;
    }

    .floatright {
        float: right;
    }

    .floatleft {
        float: left;
    }

    .m-l-50 {
        margin-left: 50px;
    }

    .panel-g {
        background-color: rgb(0, 176, 80);
        color: white;
        font-size: 28px;
    }

    .panel-b {
        color: white;
        font-size: 28px;
        background-color: #999;
    }

    #order, th, td {
        border-collapse: collapse;
    }

    .border {
        border: 1px solid #e5e5e5;
    }

    #order th, td {
        padding: 5px;
    }

    #order th {
        text-align: left;
    }

    .cellpadding th, td {
        padding: 2px;
    }

    .title {
        text-align: right;
        font-size: 40px;
        margin-top: -40px;
    }

    .m-l-12 {
        margin-left: 12px;
    }

    .m-t-30 {
        margin-top: 30px;
    }

    .m-t_-30 {
        margin-top: -30px;
    }

    .order {
        clear: both;
        margin-top: 240px;
    }

    .term {
        clear: both;
        margin-top: 40px
    }

    .qrcode {
        margin-top: 30px;
        width: 100px;
        float: left;
        margin-bottom: 100px;
    }

    .t-a-r {
        text-align: right;
    }

    .t-a-c {
        text-align: center;
    }
</style>