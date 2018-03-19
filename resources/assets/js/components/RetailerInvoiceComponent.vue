<template>
    <div>
        <form @submit.prevent="add_invoice">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12"><label><span class="h1">Xcell</span></label></div>
                            <br><br><br>
                            <div class="col-md-6"><label><b>Order</b> :</label> <input type="text" :value="order_id" class="bordernone"/></div>
                            <div class="col-md-6"><label><b>Date</b> :</label> {{ current_date }}</div>
                            <div class="col-md-6"><label><b>Due Date</b> : {{ duedate }}</label></div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-6"><label><b>Retailer Name</b> :</label>{{ retailer_name}}
                            </div>
                            <div class="col-md-6"><label><b>Outlet Name</b> :</label>
                                {{ outlet_name}}
                            </div>
                            <div class="col-md-6"><label><b>Outlet Address</b> : {{ outlet_address}}</label>
                            </div>
                            <div class="col-md-6"><label><b>Payment type</b> :</label>
                                <select id="payment_type_id">
                                    <option v-for="(type, index) in all_payment_type"  v-bind:value="type.id">{{type.type}}</option>
                                </select>
                            </div>
                            <div class="col-md-6"><label><b>Previous Balance</b> :</label></div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <th>Model NO</th>
                                        <th>Colour</th>
                                        <th>Unit Cost</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Discount Type</th>
                                        <th>Discount</th>
                                        <th>Extra</th>
                                        <th>Total Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(order, index) in all_orders.order_products">
                                        <td>{{order.id}}</td>
                                        <td>{{order.product_color.product.name}}</td>
                                        <td><input type="text" class="width70px bordernone hide"
                                                   v-bind:data-id="`color`+index"
                                                   :value="order.product_color_id" />
                                        {{order.product_color.color}}
                                        </td>
                                        <td>
                                            <input type="text" class="width60px bordernone" :value="order.unit_price"
                                                   v-bind:data-id="`unit`+index"/></td>
                                        <td>
                                            <input type="number" min="1" v-bind:data-id="`qty`+index"
                                                   class="width60px" :value="order.product_qty"
                                                   @click="qty(order.id,$event.target.value,order.unit_price)"
                                                   @keyup="qty(order.id,$event.target.value,order.unit_price)">
                                        </td>
                                        <td>
                                            <input type="text" value="15" min="1" class="width60px"
                                                   :value="order.unit_price*order.product_qty" readonly
                                                   v-bind:id="`amount`+order.id" v-bind:data-id="`amount`+index">
                                        </td>
                                        <td>
                                            <select class="size90" v-bind:data-id="`discount_type_id`+index" v-bind:id="`discount_id`+order.id"
                                                    v-on:change="type_discount(order.id,$event.target.value)">
                                                <option value=""></option>
                                                <option v-for="(type, index) in all_discount_type"  v-bind:value="type.id">{{type.discount_name}}</option>
                                            </select>
                                        </td>
                                        <td><input type="text"  v-bind:data-id="`discount_amount`+order.id"
                                                   v-on:keyup="discount($event.target.value,order.id)" class="size90" maxlength="5"/></td>
                                       <td><input type="text" class="size90" v-bind:data-id="`extra`+index" v-bind:id="`extra`+order.id" maxlength="3"/></td>
                                        <td><input type="text" v-bind:id="`finalprice`+order.id"
                                                   :value="order.total_price"
                                                   v-bind:data-id="`count`+index" readonly/></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 pull-right">
                            <button class="btn btn-primary hidden ">Add More</button>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-7">
                            <div class="col-md-8">
                                <label><span class="h3">Sub Total : </span></label></div>
                            <div class="col-md-4">
                                <span class="h3"> <input type="text" class="bordernone" id="subamount"
                                                         :value="subamount" readonly></span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-7">
                            <div class="col-md-8">
                                <label><span class="h3">Total : </span></label></div>
                            <div class="col-md-4">
                                <span class="h3"> <input type="text" class="bordernone" id="finalamount"
                                                         :value="totalamount" readonly></span></div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-11 "><label>Remarks</label>
                            <textarea class="form-control" id="decs">
                    </textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><br>
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Create
                                Invoice
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                message: '',
                all_orders: [],
                all_payment_type: [],
                all_discount_type: [],
                totalamount: 0,
                retailer_id:'',

                current_date: '',
                duedate: '',
                subamount: '',
                invoice: '',
                order_id: '',
                payment_type_id: '',
                finalamount: '',
                desc: '',
                retailer_name:'',
                outlet_name:'',
                outlet_address:'',

                colorid:[],
                unitcost:[],
                quantity: [],
                amount:[],
                discount_type_id:[],
                productamount:[],
                extra:[],


            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        created: function () {
            this.init();

        },
        methods: {
            init: function () {
                this.get_all_orders();
                this.retailer_balance();
            },
            get_all_orders: function () {
                axios.get('../../retailer_order/get_order/' + window.location.href.substr(-1, 1)).then((response) => {

                    this.all_payment_type=response.data.payment_type;
                    this.all_discount_type=response.data.discount_type;
                    this.all_orders = response.data.get_all_order;

                    this.order_id=this.all_orders.id;
                    this.retailer_name=this.all_orders.retailer.name;
                    this.outlet_name=this.all_orders.retailer_outlet.name;
                    this.outlet_address=this.all_orders.retailer_outlet.address;
                    this.retailer_id=this.all_orders.retailer.id;
                    //console.log(this.retailer_id)
                    this.current_date = moment().format('DD-MMM-YYYY h:m a');
                    this.duedate = moment().add(this.all_orders.retailer_outlet.credit_duration, 'days').format('DD-MMM-YYYY');
                    for (var i = 0; i < this.all_orders.order_products.length; i++) {
                        this.totalamount += this.all_orders.order_products[i].total_price;
                    }
                    this.subamount = this.totalamount;
                });
            },
            retailer_balance:function () {
            /*
                var retailer={'retailer_id':6};
                axios.post('../../RetailerLedgerData',retailer).then((response) => {
                    console.log(response.data);
                });
                */
            },
            type_discount: function (id, value) {

                $("[data-id='discount_amount" + id+ "']").val("");
                $("#finalprice" + id).val($("#amount" + id).val());
                this.totalamount_method();
                $("#extra" + id).val("");
            }, totalamount_method: function () {
                var cont = 0;
                var contsub = 0;
                for (var i = 0; i < this.all_orders.order_products.length; i++) {
                    var attid = "[data-id='count" + i + "']";
                    cont += parseInt($(attid).val());
                    var attidsub = "[data-id='amount" + i + "']";
                    contsub += parseInt($(attidsub).val());
                }
                $('#finalamount').val(cont);
                $('#subamount').val(contsub);
            },
            discount: function (discount, orderid) {
                var price = $("#amount" + orderid).val();
                var discount_id=$("#discount_id" + orderid).val();


                    if (discount_id == 2) {
                        $("#finalprice" + orderid).val(price - discount > 0 ? price - discount : 0);
                    }
                    if (discount_id == 1) {
                        //var a=125*100/200;
                        var percent = price / 100 * discount;
                        $("#finalprice" + orderid).val(price > percent ? price - percent : 0);
                    }


                this.totalamount_method()
            },
            qty: function (id, qty, unit) {
                $("#amount" + id).val(unit * qty);
                $("#finalprice" + id).val(unit * qty);
                this.totalamount_method();
                $("[data-id='discount_amount" + id+ "']").val("");
               $("#discount_id" + id).val([]);
                $("#extra" + id).val("");

            },
            add_invoice: function (e) {


                this.payment_type_id = $("#payment_type_id").val();
                this.finalamount = $("#finalamount").val();
                this.decs = $("#decs").val();

                for (var i = 0; i < this.all_orders.order_products.length; i++) {
                    this.colorid[i]=$("[data-id='color" + i + "']").val();
                    this.unitcost[i]=$("[data-id='unit" + i + "']").val();
                    this.quantity[i] = $("[data-id='qty" + i + "']").val();
                    this.amount[i]=$("[data-id='amount" + i + "']").val();
                    this.discount_type_id[i]=$("[data-id='discount_type_id" + i + "']").val();
                    this.productamount[i]=$("[data-id='count" + i + "']").val();
                    this.extra[i]=$("[data-id='extra" + i + "']").val();

                }
                /*
                console.log(this.colorid);
                console.log(this.unitcost);
                console.log(this.quantity);
                console.log(this.amount);
                console.log(this.discount_type_id);
                console.log(this.productamount);
*/


                this.invoice = {
                    'order_id': this.order_id, 'payment_type_id': this.payment_type_id,
                    'invoice_type_id': '1', 'total_amount': this.finalamount, 'decs': this.decs,
                    'colorid':this.colorid,'unitcost':this.unitcost,'quantity':this.quantity,
                    'amount':this.amount,'discount_type_id':this.discount_type_id,
                    'productamount':this.productamount,'extra':this.extra,'retailer_id':this.retailer_id
                };
               // console.log(this.invoice);
                axios.post('../../invoice/store', this.invoice).then((response) => {
                    console.log(response.data);
                });
            },
        }
    }
</script>


