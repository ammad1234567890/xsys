<template>
    <div>
        <div class="width_container">
            <img src="http://172.16.1.253:82/xsys_new_version/public/img/ddl_logo.png" width="150">
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
                        <td>021-35899116-7</td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td>46-C Jami Commercial</td>
                    </tr>
                </table>
            </div>
            <div class="heading floatright m-t_-30">
                <table>
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
                    <tr v-for="(details, index) in data.invoice__products">
                        <td class="border">{{++index}}</td>
                        <td class="border">{{details.product_color.product.name}}</td>
                        <td class="border">{{details.product_color.color}}</td>
                        <td class="border t-a-r">{{details.product_price}}</td>
                        <td class="border t-a-c">{{details.product_qty}}</td>
                        <td class="border t-a-c">{{details.product_color.discount}}%</td>
                        <td class="border t-a-r">{{details.product_price*details.product_qty | currency('')}}</td>
                        <td class="border t-a-r">{{(details.product_price*details.product_qty)-(details.total_amount) |
                            currency('')}}
                        </td>
                        <td class="border t-a-r">{{details.total_amount | currency('')}}</td>
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
                        <td class="border t-a-r">{{discount | currency('')}}</td>
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
            <div class="term"><label>Terms & Condition</label><br>
                <label>Payment Terms: 21st of the month following invoice date</label>
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
    export default {
        data() {
            return {
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
                this.get_all_orders();
            },
            get_all_orders: function () {
                axios.get('../../invoice/generate_invoice/' + window.location.pathname.split('/')[5]).then((response)=> {
                    this.data = response.data.invoice_details;
                this.date = moment(response.data.created_at).format('DD-MM-YYYY');
                this.aging = moment(response.data.created_at).add(response.data.invoice_details.retailer_order.retailer_outlet.credit_duration, 'days').format('DD-MM-YYYY');
                this.outlet_name = response.data.invoice_details.retailer_order.retailer_outlet.name;
                this.outlet_address = response.data.invoice_details.retailer_order.retailer_outlet.address;
                this.outlet_mobile_no = response.data.invoice_details.retailer_order.retailer_outlet.mobile_no;
                this.order_no = response.data.invoice_details.retailer_order.order_no;
                this.retailer_id = response.data.invoice_details.retailer_order.outlet_id;
                for (var i = 0; i < this.data.invoice__products.length; i++) {
                    this.subtotal += this.data.invoice__products[i].product_price * this.data.invoice__products[i].product_qty;
                }
                this.discount = this.subtotal - this.data.total_amount[0];
                this.previous_balance=response.data.outstanding.Outstanding;
                this.aging_amount=response.data.aging.aging;
                this.total_amount=this.data.total_amount[0];
                this.invoice_no=this.data.invoice_no[0];
                var qrcode = new QRCode(document.getElementById("qrcode"), {
                    width: 100,
                    height: 100
                });
                qrcode.makeCode("Invoice No:"+response.data.invoice_details.invoice_no[0]+" ID:" + response.data.user.id + " Name:" + response.data.user.name);
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