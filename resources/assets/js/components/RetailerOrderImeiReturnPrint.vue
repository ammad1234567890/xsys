<template>
    <div>
        <div class="width_container"  style="margin-top: 40px;">
            <img :src="ddl_logo_path" width="150">
            <br>Deploy Distribution Logistics
            <div class="header">
                <div class="heading " >
                    <div><label><b>Invoice No</b> :</label> {{invoice}}</div>
                </div>
                <div class="heading " style="font-size:26px;">
                    <label><strong>Return IMEI Details</strong> </label>
                </div>
                <div class="heading " style="float:right;margin-top:-100px;">
                    <div><label><b>Dealer Code</b> :</label> {{retailer_no}}</div>
                    <div><label><b>Outlet</b> :</label> {{outlet_name}}</div>
                    <div><label><b>Address</b> :</label> {{address}}</div>
                    <div><label><b>City</b> :</label> {{name_city}}</div>
                    <div><label><b>Locality</b> :</label> {{region}}</div>
                </div>
            </div>
            <div class="order">
                <div  v-for="(details) in product_details"><hr>
                    <div v-for="(details_value) in details">
                        <div v-for="(list) in details_value.list">
                            <b>{{details_value.product_name}}</b>   ({{list.color}})<br>
                            <span v-for="(imei,key,index) in list.imeis">
                                <span class="border grid"> {{imei.imei1}}</span> <span  v-if="index==5"> {{index=0==''?'':''}}<br></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="m-t-30"><b>Total Unit: {{total_unit}}</b></div>
            </div>
            <div class="term hidden"><label>Terms & Condition</label><br>
                <label>Payment Terms: 21st of the month following invoice date</label>
            </div>
            <div class="qrcode">
                <div id="qrcode" style="width:100px; height:100px; margin-top:15px;"></div>
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

                invoice: '',
                outlet_name:'',
                address:'',
                retailer_no:'',
                name_city:'',
                region:'',
                product_details: [],
                total_unit: null,


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
                this.get_all_orders_imei();
                this.ddl_logo_path=constant.base_url+'img/ddl_logo.png';
            },
            get_all_orders_imei: function () {
                axios.get('../../../../order/imei/return/details/' + window.location.pathname.split('/')[7]).then((response) => {
                   // console.log(response.data);
                    if(response.data.status==true) {
                        this.product_details = response.data['data']['products'];
                        this.invoice = response.data['data']['outlet_details']['invoice_no'];
                        this.outlet_name = response.data['data']['outlet_details']['outlet_name'];
                        this.address = response.data['data']['outlet_details']['address'];
                        this.retailer_no = response.data['data']['outlet_details']['retailer_no'];
                        this.name_city = response.data['data']['outlet_details']['city_name'];
                        this.region = response.data['data']['outlet_details']['region_name'];
                        this.total_unit = response.data['total'];
                        setTimeout("window.print()",1);
                        setTimeout("self.close()", 1);
                    }
                    else{
                        alert("No Sale Return");
                    }
            });
            }
        }
    }
</script>
<style>
    * {
        font-family: calibri;
    }

    .m-p-0 {
        margin: 0px;
        padding: 0px
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
    .hidden{
        display:none;
    }
    .grid{
        line-height: 3;
        padding-top:5px;
        padding-bottom:5px;
        padding-left:15px;
        padding-right:15px;
    }
</style>