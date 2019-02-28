<template>
    <div>
        <div class="width_container"  style="margin-top: 40px;">
            <img :src="ddl_logo_path" width="150">
            <br>Deploy Distribution Logistics
            <div class="header">
                <div class="heading " >
                    <div><label><b>Transfer Invoice No</b> :</label> {{ti_no}}</div>
                </div>
                <div class="heading " style="font-size:26px;">
                    <label><strong>IMEI Details</strong> </label>
                    <br/>
                </div>

            </div>
            <div class="order" style="margin-top:20px;">

                    <div v-for="(items, index) in item_details">
                        <span v-if="items.link_break==1" style="border:1px solid black; width: 100%; display: block;">{{items.product_name}} {{items.product_color}}<br/></span>

                        <span class="border grid" style="line-height: 2;">
                            {{items.product_name}}

                        </span>
                        <span class="border grid" style="line-height: 2;">
                            {{items.product_color}}
                        </span>
                        <span class="border grid" style="line-height: 2;">
                             {{items.imei1}}
                        </span>
                        <span class="border grid" style="line-height: 2;">
                            {{items.imei2}}
                        </span>






                    </div>

                    <p> <span class="border grid">
                        <b>Total Items: {{item_details.length}}</b>
                        </span></p>
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
                warehouse_issue: [],
                invoice: '',
                outlet_name:'',
                address:'',
                retailer_no:'',
                name_city:'',
                region:'',
                product_details: [],
                total_unit: null,

                imei_list:[],
                items:[],
                products:[],
                ti_no:"",
                index_br:0,


                item_details:[],

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
                axios.get(constant.base_url+'transfer_imei_print/' + window.location.pathname.split('/')[4]).then((response) => {
                    //alert(response.data);
                    this.ti_no=response.data[0].win_no;
                    //this.products=response.data[0].transfer_products;
                    //this.items=response.data[0].items;


                    //this.item_details=response.data[0];
                   // console.log('products'+this.products);
                   // console.log('items'+this.items);
                    //setTimeout("window.print()",1);
                    //setTimeout("self.close()", 1);
                    var current_id=0;
                    for(var i=0; i<response.data[0].items.length; i++){
                        //console.log(response.data[0].items[i].item.product_color.product.name);

                        var veri_id=response.data[0].items[i].item.product_color.id;

                        if(current_id==veri_id){
                            this.item_details.push({
                                'product_name':response.data[0].items[i].item.product_color.product.name,
                                'product_color':response.data[0].items[i].item.product_color.color,
                                'imei1':response.data[0].items[i].item.imei[0].imei1,
                                'imei2':response.data[0].items[i].item.imei[0].imei2,
                                'link_break':0,
                            });
                        }
                        else{
                            current_id=response.data[0].items[i].item.product_color.id;;
                            this.item_details.push({
                                'product_name':response.data[0].items[i].item.product_color.product.name,
                                'product_color':response.data[0].items[i].item.product_color.color,
                                'imei1':response.data[0].items[i].item.imei[0].imei1,
                                'imei2':response.data[0].items[i].item.imei[0].imei2,
                                'link_break':1,
                            });
                        }

                    }

                    //console.log(this.item_details);
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