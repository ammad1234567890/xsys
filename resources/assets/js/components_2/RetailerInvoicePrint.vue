<template>
    <div>
        <div class="width_container">
            <img :src="ddl_logo_path" width="150">
            <div class="header">
                <div class="heading ">
                    <div><label><b>Invoice No</b> :</label> {{invoice_no}}</div>
                    <div><label><b>Order No</b> :</label> {{order_no}}</div>
                    <div><label><b>Date</b> :</label> {{ date}}</div>
                    <div><label><b>Aging Date</b> :</label> {{aging}}</div>
                </div>
                <div class="heading floatright title">
                    <label><strong>INVOICE</strong> </label>
                </div>
            </div>
            <div class="heading floatleft ">
                <div class="panel-b">
                    <div class="m-l-12"><h5>Company Details</h5></div>
                </div>
            </div>
            <div class="heading floatright m-l-50">
                <div class="panel-g">
                    <div class="m-l-12"><h5 class="m-t-30">Bill To</h5></div>
                </div>
            </div>
            <div class="heading floatleft m-t_-30">
                <table style=" ">
                    <tr>
                        <td>Company:</td>
                        <td>Deploy Distribution & Logistics</td>
                    </tr>
                    <tr>
                        <td>Phone No:</td>
                        <td>{{warehouse_phone}}</td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td>{{warehouse_address}}</td>
                    </tr>
                </table>
            </div>
            <div class="heading floatright m-t_-30">
                <table>
                    <tr>
                        <td>Dealer:</td>
                        <td>{{retailer_no}}</td>
                    </tr>
                    <tr>
                        <td>Outlet Name:</td>
                        <td>{{outlet_name}}</td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td>{{outlet_address}}</td>
                    </tr>
                    <tr>
                        <td>Phone No:</td>
                        <td>{{outlet_mobile_no}}</td>
                    </tr>
                    <tr style="display: none;">
                        <td>Payment type:</td>
                        <td></td>
                    </tr>
                    <tr >
                        <td colspan="2"><hr class="m-p-0"></td>
                    </tr>
                    <tr>
                        <td>Current Balance:</td>
                        <td>Rs. {{previous_balance | currency('')}}</td>
                    </tr>
                    <tr>
                        <td>Aging Balance:</td>
                        <td>Rs. {{aging_amount | currency('')}}</td>
                    </tr>
                </table>
            </div><br>
            <div class="order">
                <table id="order">
                    <thead>
                    <tr class="border">
                        <th width="4%" class="border">S.No</th>
                        <th width="20%" class="border ">Model No</th>
                        <th width="13%" class="border">Color</th>
                        <th width="13%" class="border">Unit Cost (PKR)</th>
                        <th width="5%" class="border">Qty</th>
                        <th width="10%" class="border">Discount %</th>
                        <th width="13%" class="border">Sub Total (PKR)</th>
                        <th width="10%" class="border">Discount</th>
                        <th width="13%" class="border">Total (PKR)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(details, index) in data">
                        <td class="border">{{++index}}</td>
                        <td class="border">{{details.product_name}}</td>
                        <td class="border">{{details.color}}</td>
                        <td class="border t-a-r">{{details.product_price}}</td>
                        <td class="border t-a-c">{{details.product_qty}}</td>
                        <td class="border t-a-c">{{details.discount}}%</td>
                        <td class="border t-a-r">{{details.product_price*details.product_qty | currency('')}}</td>
                        <td class="border t-a-r">{{details.product_price*details.product_qty-details.invoice_product_total_amount | currency('')}}</td>
                        <td class="border t-a-r">{{details.invoice_product_total_amount | currency('')}}</td>
                    </tr>
                    <tr class="border">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="border t-a-r">Sub Total</td>
                        <td class="border t-a-r">{{subtotal | currency('')}}</td>
                    </tr>
                    <tr class="border">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="border t-a-r">Discount</td>
                        <td class="border t-a-r">{{subtotal-total_amount | currency('')}}</td>
                    </tr>
                    <tr class="border">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="border t-a-r"><b>Total</b></td>
                        <td class="border t-a-r"><b>{{total_amount | currency('')}}</b></td>
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
                data: [],
                date: '',
                outlet_name: '',
                outlet_address: '',
                aging: '',
                subtotal: 0,
                discount: 0,
                outlet_mobile_no: '',
                order_no: '',
                previous_balance: '',
                retailer_id: '',
                aging_amount:'',
                total_amount:0,
                invoice_no:'',
                warehouse_phone:null,
                warehouse_address:null,
                retailer_no:null,

            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created: function () {
            this.init();
        },
        methods: {
            init: function () {
				this.ddl_logo_path=constant.base_url+'img/ddl_logo.png';
                this.get_all_orders();
            },
            get_all_orders: function () {
                axios.get('../../invoice/generate_invoice/' + window.location.pathname.split('/')[5]).then((response)=> {
                     this.data = response.data.data;
                     this.date = moment(response.data.data[0].created_at).format('DD-MM-YYYY');
                     this.aging = moment(response.data.data[0].created_at).add(response.data.data[0].credit_duration, 'days').format('DD-MM-YYYY');
                     this.order_no = response.data.data[0].order_no;
                     this.invoice_no=response.data.data[0].invoice_no;
                     this.outlet_name = response.data.data[0].outlet_name;
                     this.outlet_address = response.data.data[0].address;
                     this.outlet_mobile_no = response.data.data[0].phone_no;
                     this.retailer_no=response.data.data[0].retailer_no;
                     this.warehouse_address=response.data.warehouse_details.address;
                     this.warehouse_phone=response.data.warehouse_details.phone_no;
                     this.total_amount=response.data.data[0].invoice_total_amount;
                     this.aging_amount=response.data.balance.aging.aging;
                     this.previous_balance=response.data.balance.outstanding.Outstanding;
                     for (var i = 0; i < this.data.length; i++) {
                        this.subtotal += this.data[i].product_price*this.data[i].product_qty;
                     }
                     var qrcode = new QRCode(document.getElementById("qrcode"), {
                         width: 100,
                         height: 100
                     });
                qrcode.makeCode("Invoice No:"+this.invoice_no + " Name:" + response.data.warehouse_details.name);
                  setTimeout("window.print()",1);
                  setTimeout("self.close()", 1);
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