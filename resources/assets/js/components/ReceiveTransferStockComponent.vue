<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Receive Stock</div>

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-2">
                                <label>Transfer Invoice No</label>
                            </div>
                            <div class="col-md-3">
                                <select class="textbox" v-model="selected_transfer_invoice_no">
                                    <option v-for="(ti, index) in transfer_invoices" v-bind:value="ti.id">
                                            {{ti.win_no}}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" v-on:click="get_ti_details">Get Details</button>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12" v-if="transfer_details_enabled==1">
                <div class="panel panel-default">
                    <div class="panel-heading">Details</div>

                    <div class="panel-body">
                        <table width="100%" class="col-md-6">
                            <tr>
                                <th>Transfer Invoice No:</th>
                                <td>{{win_no}}</td>
                            </tr>
                            <tr>
                                <th>From Warehouse:</th>
                                <td>{{from_warehouse_name}}</td>
                            </tr>
                            <tr>
                                <th>Created Date:</th>
                                <td>{{created_date | moment}}</td>
                            </tr>
                        </table>


                            <table class="table table-bordered" style="width:100%">
                                <thead style="padding:10px; background: lightblue;">
                                    <th style="padding:5px;">S.no</th>
                                    <th style="padding:5px;">Model</th>
                                    <th style="padding:5px;">Color</th>
                                    <th style="padding:5px;">Quantity</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(products, index) in transfer_product_details">
                                        <td>{{index+1}}</td>
                                        <td>{{products.product.name}}</td>
                                        <td>{{products.product_color.color}}</td>
                                        <td>{{products.quantity}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-primary" @click="receive_stock()">Receive Stock</button>

                    </div>
                </div>
            </div>


        </div>
    </div>
</template>

<script>
    import {constant} from '../constant.js';
    import vSelect from "vue-select"
    export default {
        components: {vSelect},
        data(){
            return{
                transfer_details_enabled:0,
                selected_transfer_invoice_no:'',
                transfer_invoices:[],
                transfer_invoice_details:[],
                transfer_product_details:[],
                win_no:'',
                from_warehouse_name:'',
                created_date:''
            }
        },
        mounted() {
            axios.get(constant.base_url+'get_transfer_receiving').then((response)=>{
                this.transfer_invoices=response.data;
               // console.log(this.transfer_invoices);
            });
        },
        created(){

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
        watch: {


        },
        methods:{
            get_ti_details(){
                this.transfer_details_enabled=0;
                axios.get(constant.base_url+'get_issue_note_details/'+this.selected_transfer_invoice_no).then((response)=>{
                    this.transfer_invoice_details=response.data[0];
                    this.created_date=this.transfer_invoice_details.created_at;
                    this.from_warehouse_name=this.transfer_invoice_details.warehouse_from.name;
                    this.win_no=this.transfer_invoice_details.win_no;
                    this.transfer_product_details=response.data[0].transfer_products;
                    console.log(this.transfer_invoice_details);

                    this.transfer_details_enabled=1;
                });
            },
            receive_stock(){
                if(this.selected_transfer_invoice_no!=''){
                    var result= confirm("Are you sure, You want to Receive "+ this.win_no);
                    if(result){
                        axios.post(constant.base_url+'receive_stock_to_warehouse',{'win_no': this.selected_transfer_invoice_no}).then((response)=>{
                            if(response.data==201){
                                alert("Stock has been Received Successfully");
                                location.reload();
                            }
                        });
                    }
                }
                else{
                    alert("Please Select the Transfer Invoice");
                }


            }
        }
    }

</script>
