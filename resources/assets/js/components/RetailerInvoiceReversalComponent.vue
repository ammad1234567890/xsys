<template>
    <div>
        <form @submit.prevent="add_invoice">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6"><img
                                    src="http://172.16.1.253:82/xsys_new_version/public/img/ddl_logo.png" width="150">
                            </div>
                            <br><br><br>
                            <div class="col-md-6">
                            <div class="col-md-12"><label><b>Invoice No</b> :</label> <input type="text" :value="all_orders.invoice_no" class="bordernone" readonly /></div>
                            <div class="col-md-12"><label><b>Order NO</b> :</label> <input type="text" :value="order_no" class="bordernone" id="order_no" readonly /></div>
                            <div class="col-md-12 "><label><b>Date</b> :</label> {{ all_orders.created_at | moment }}</div>
                            </div>
                            <div class="col-md-6 text-right"><label><span
                                    class="h3"><strong>INVOICE Reversal</strong></span></label></div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12 m-p-0">
                                <div class="col-md-6">
                                    <div class="panel panel-info">
                                        <div class="panel-heading m-p-0" style="color:white;background-color:#999;">
                                            <label style="margin-top:13px;margin-left:12px;"><h5>Company Details</h5>
                                            </label></div>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="panel panel-info">
                                        <div class="panel-heading m-p-0"
                                             style="background-color:rgb(0,176,80);color:white;">
                                            <label style="margin-top:13px;margin-left:12px;"><h5>Bill To</h5></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6 m-p-0" style="font-size:12px;">
                                    <div class="col-md-12"><label><b>Company</b> :</label> Deploy Distribution &
                                        Logistics
                                    </div>
                                    <div class="col-md-12"><label><b>Company Tel</b> :</label> 021-35899116-7</div>
                                    <div class="col-md-12"><label><b>Address</b> :</label> Office No 1410, 14th Floor, Al.Najibi Plaza Zaibunnisa Street, Saddar, Karachi</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12"><label><b>Outlet Name</b> : {{ retailer_outlet.name}}</label></div>
                                    <div class="col-md-12"><label><b>Outlet Address</b> : {{ retailer_outlet.address}}</label>
                                    </div>
                                    <div class="col-md-12 hidden"><label><b>Payment type</b> : </label>
                                        <input type="text" :value="all_orders.payment_type_id" id="payment_type_id"/>
                                    </div>
                                    <div class="col-md-12"><label><b>Previous Balance</b> :
                                        Rs.{{previous_balance>0?previous_balance:0 | currency('')}}</label></div>
                                    <div class="col-md-12"><label><b>Aging Date</b> : {{ duedate }} </label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="margin-bottom: 0px">
                                    <thead>
                                    <tr>
                                        <th width="4%">S.No</th>
                                        <th width="21%">Model Name</th>
                                        <th width="21%">Colour</th>
                                        <th width="10%">Unit Cost (PKR)</th>
                                        <th width="7%">Quantity</th>
                                        <th width="7%">Discount</th>
                                        <th width="10%">Amount (PKR)</th>
                                        <th width="10%">Discount</th>
                                        <th width="10%">Total Amount (PKR)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(order, index) in all_orders.invoice__products" v-bind:id="'row'+index">
                                        <td><input type="text" class="bordernone " :value="s_no+index"
                                                   style="width: 20px;"/>
                                            <input type="text" class="bordernone hidden"
                                                   v-bind:data-id="`order_id_`+index" :value="order.id"
                                                   style="width: 20px;"/>
                                        </td>
                                        <td>{{order.product_color.product.name}}</td>
                                        <td><input type="text" class="width70px bordernone hidden"
                                                   v-bind:data-id="`color`+index"
                                                   :value="order.product_color_id"/>
                                            {{order.product_color.color}}
                                        </td>
                                        <td>
                                            <input type="text" class="hidden" :value="order.product_color.price"
                                                   v-bind:data-id="`unit`+index" readonly/>
                                            <input type="text" class="bordernone text-right pull-right" style="width:100px"
                                                   :value="order.product_color.price | currency('')"
                                                   v-bind:data-id="`unit_view`+index" readonly/>
                                        </td>
                                        <td class="text-center">
                                            <input type="number" min="1" v-bind:data-id="`qty`+index"
                                                   class="width60px bordernone text-center"
                                                   :value="order.product_qty"
                                                   @click="qty(order.id,$event.target.value,order.product_color.price)"
                                                   @keypress="isNumber(this.event),qty(order.id,$event.target.value,order.product_color.price)"
                                                   :max="order.product_qty" readonly/>
                                        </td>
                                        <td class="text-center"><input type="text" v-bind:data-id="`discount_amount`+order.id"
                                                   :value="order.product_color.discount"
                                                   v-on:keyup="discount($event.target.value,order.id)"
                                                   class=" width60px bordernone hidden " maxlength="5" readonly/>

                                            <input type="text" :value="order.product_color.discount+'%'"
                                                   class=" width60px bordernone text-center" readonly/>
                                        </td>
                                        <td>
                                            <input type="text" value="15" min="1" class="hidden"
                                                   :value="order.product_color.price*order.product_qty"
                                                   readonly
                                                   v-bind:id="`amount`+order.id" v-bind:data-id="`amount`+index">
                                            <input type="text" value="15" min="1"
                                                   class="amount bordernone text-right pull-right"
                                                   :value="order.product_color.price*order.product_qty | currency('')"
                                                   readonly
                                                   v-bind:id="`amount_view`+order.id"
                                                   v-bind:data-id="`amount_view`+index" >
                                        </td>
                                        <td>
                                            <input type="text" v-bind:id="`discountamount`+order.id"
                                                   :value="order.product_color.price*order.product_qty /100 * order.product_color.discount"
                                                   v-bind:data-id="`discountamount`+index" readonly class="hidden"/>
                                            <input type="text" v-bind:id="`discountamount_view`+order.id"
                                                   v-bind:data-id="`discountamount_view`+index" readonly
                                                   :value="order.product_color.price*order.product_qty /100 * order.product_color.discount | currency('')"
                                                   class="amount bordernone text-right pull-right"/>
                                        </td>
                                        <td>
                                            <input type="text" v-bind:id="`finalprice`+order.id"
                                                   :value="(order.product_color.price*order.product_qty) - (order.product_color.price*order.product_qty /100 * order.product_color.discount)"
                                                   v-bind:data-id="`count`+index" readonly class="hidden"/>
                                            <input type="text" v-bind:id="`finalprice_view`+order.id"
                                                   :value="(order.product_color.price*order.product_qty) - (order.product_color.price*order.product_qty /100 * order.product_color.discount) | currency('')"
                                                   v-bind:data-id="`count_view`+index" readonly
                                                   class="amount bordernone text-right pull-right"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=7></td>
                                        <td  class="text-right">Sub Total</td>
                                        <td class="text-right">  <input type="text" class="hidden" id="subamount"
                                                                        :value="subamount" readonly>
                                            <input type="text" class="bordernone text-right " id="subamount_view"
                                                     readonly></td>
                                    </tr>
                                    <tr>
                                        <td  colspan=7></td>
                                        <td  class="text-right">Discount</td>
                                        <td  class="text-right"> <input type="text" class="hidden" id="discount_amount"
                                                                        :value="discountamount" readonly>
                                            <input type="text" class="bordernone text-right " id="discount_amount_view"
                                                    readonly></td>
                                    </tr>
                                    <tr>
                                        <td width="80%" colspan=7></td>
                                        <td width="10%" class="text-right"><b>Total</b></td>
                                        <td width="10%" class="text-right"> <b>      <input type="text" class="hidden" id="finalamount"
                                                                                            :value="totalamount" readonly>
                                            <input type="text" class="bordernone text-right " id="finalamount_view"
                                                       readonly> </b></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 "><label>Remarks</label>
                            <textarea class="form-control" id="decs" rows="4"></textarea>
                        </div>
                        <div class="col-md-7 "><label>Terms & Condition</label><br>
                            <label>Payment Terms: 21st of the month following invoice date</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><br>
                            <button type="submit" id="btn_invoice" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Reverse Invoice
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
                retailer_id: '',

                current_date: '',
                duedate: '',
                subamount: 0,
                invoice: '',
                order_id: '',
                payment_type_id: '',
                finalamount: '',
                discountamount: '',
                desc: '',
                retailer_name: '',
                outlet_name: '',
                outlet_address: '',

                colorid: [],
                unitcost: [],
                quantity: [],
                amount: [],
                discount_type_id: [],
                productamount: [],
                product_id: [],
                extra: [],
                countrow: 0,
                qty_db: [],
                remaining_qty: [],
                order_id_pattern: '',
                previous_balance: '',
                order_no: '',
                s_no: 1,
                retailer_outlet:[],
                created_date:'',
            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        created: function () {
            this.init();

        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            },
            date_time: function (date) {
                return moment(date).format('DD-MM-YYYY h:m a');
            }
        },
        methods: {
            init: function () {
                this.get_all_orders();
            },
            get_all_orders: function () {
                axios.get('../../invoice/invoice_reverse/' + window.location.pathname.split('/')[5]).then((response) => {
                    this.created_date=response.data.created_at;                   
                    this.all_payment_type = response.data.payment_type;
                    this.retailer_outlet=response.data.retailer_order.retailer_outlet;
                    this.all_orders = response.data;
                    this.order_no=this.all_orders.retailer_order.order_no;
                    this.order_id = this.all_orders.retailer_order.id;
                    this.totalamount=this.all_orders.total_amount;
                    this.retailer_id = this.all_orders.retailer_order.retailer_outlet.id;
                    this.duedate = moment(this.all_orders.created_at).add(this.retailer_outlet.credit_duration, 'days').format('DD-MM-YYYY');
                    this.order_id_pattern += moment().format('YY');
                    this.order_id_pattern += this.all_orders.retailer_order.retailer_outlet.city.name.substr(0, 1) + this.all_orders.retailer_order.retailer_outlet.region.name.substr(0, 1);
                    for(var i=0;i<this.all_orders.invoice__products.length;i++){
                        this.subamount+=this.all_orders.invoice__products[i].product_color.price*this.all_orders.invoice__products[i].product_qty;
                        this.countrow++;
                    }
                    this.discountamount=this.subamount-this.totalamount;
                    $("#subamount_view").val("Rs. " + accounting.formatMoney(this.subamount, {
                        symbol: "",
                        format: "%v %s"
                    }));
                    $("#discount_amount_view").val("Rs. " + accounting.formatMoney(this.discountamount, {
                        symbol: "",
                        format: "%v %s"
                    }));
                    $("#finalamount_view").val("Rs. " + accounting.formatMoney(this.totalamount, {
                        symbol: "",
                        format: "%v %s"
                    }));
                    this.retailer_balance();
                });
            },
            retailer_balance: function () {
                var retailer = {'retailer_id': this.retailer_id};
                axios.post('../../RetailerTotalOutstanding', retailer).then((response) => {
                    this.previous_balance = response.data[0].Outstanding;
                });
            },
            remove: function (id) {
                $("[data-id='count" + id + "']").val(0);
                $("[data-id='discountamount" + id + "']").val(0);
                $("[data-id='amount" + id + "']").val(0);
                this.totalamount_method();
                $("#row" + id).hide();
            },
            type_discount: function (id, value) {
                $("[data-id='discount_amount" + id + "']").val("");
                $("#finalprice" + id).val($("#amount" + id).val());
                this.totalamount_method();
                $("#extra" + id).val("");
            }, totalamount_method: function () {
                var cont = null;
                var contsub = null;
                var contdiscount = null;
                for (var i = 0; i < this.countrow; i++) {
                    var attid = "[data-id='count" + i + "']";
                    cont += parseFloat($(attid).val());
                    var attidsub = "[data-id='amount" + i + "']";
                    contsub += parseFloat($(attidsub).val());
                    var discount = "[data-id='discountamount" + i + "']";
                    contdiscount += parseFloat($(discount).val());
                }
                $('#discount_amount').val(contdiscount);
                $('#finalamount').val(cont);
                $('#subamount').val(contsub);
                $('#subamount_view').val("Rs. " + accounting.formatMoney(contsub, {symbol: "", format: "%v %s"}));
                $('#discount_amount_view').val("Rs. " + accounting.formatMoney(contdiscount, {
                    symbol: "",
                    format: "%v %s"
                }));
                $('#finalamount_view').val("Rs. " + accounting.formatMoney(cont, {symbol: "", format: "%v %s"}));
            },
            discount: function (discount, orderid) {
                var price = $("#amount" + orderid).val();
                var discount_id = $("#discount_id" + orderid).val();

                if (discount_id == 2) {
                    $("#finalprice" + orderid).val(price - discount > 0 ? price - discount : 0);
                }
                if (discount_id == 1) {
                    var percent = price / 100 * discount;
                    $("#finalprice" + orderid).val(price > percent ? price - percent : 0);
                }
                this.totalamount_method()
            },
            qty: function (id, qty, unit) {
                $("#amount" + id).val(unit * qty);
                var discount_amount = $("[data-id='discount_amount" + id + "']").val();
                $("#discountamount" + id).val((unit * qty) - (unit * qty - unit * qty / 100 * discount_amount));
                $("#finalprice" + id).val(unit * qty - unit * qty / 100 * discount_amount);
                $("#amount_view" + id).val(accounting.formatMoney(unit * qty, {symbol: "", format: "%v %s"}));
                $("#discountamount_view" + id).val(accounting.formatMoney((unit * qty) - (unit * qty - unit * qty / 100 * discount_amount), {
                    symbol: "",
                    format: "%v %s"
                }));
                $("#finalprice_view" + id).val(accounting.formatMoney(unit * qty - unit * qty / 100 * discount_amount, {
                    symbol: "",
                    format: "%v %s"
                }));
                this.totalamount_method();
                $("#discount_id" + id).val([]);
            },
            isNumber: function (evt) {
                var theEvent = evt || window.event;
                theEvent.returnValue = false;
            },
            add_invoice: function (e) {
                $("#btn_invoice").hide();
                this.payment_type_id = $("#payment_type_id").val();
                this.finalamount = $("#finalamount").val();
                this.finalamount = Math.round($("#finalamount").val());
                var count = 0;
                for (var i = 0; i < this.countrow; i++) {
                    if ($("[data-id='amount" + i + "']").val() != 0) {
                        this.product_id[count] = $("[data-id='order_id_" + i + "']").val();
                        this.colorid[count] = $("[data-id='color" + i + "']").val();
                        this.unitcost[count] = $("[data-id='unit" + i + "']").val();
                        this.quantity[count] = $("[data-id='qty" + i + "']").val();
                        this.amount[count] = $("[data-id='amount" + i + "']").val();
                        this.discount_type_id[count] = $("[data-id='discount_type_id" + i + "']").val();
                        this.productamount[count] = $("[data-id='count" + i + "']").val();
                        this.extra[count] = $("[data-id='extra" + i + "']").val();
                        this.qty_db[count] = $("[data-id='qty_db" + i + "']").val();
                        count++;
                    }
                }
                this.invoice = {
                    'order_id': this.order_id, 'payment_type_id': this.payment_type_id,
                    'invoice_type_id': '1', 'total_amount': this.finalamount, 'decs': this.decs,
                    'colorid': this.colorid, 'unitcost': this.unitcost, 'quantity': this.quantity,
                    'amount': this.amount, 'product_id': this.product_id, 'qty_db': this.qty_db,
                    'productamount': this.productamount, 'extra': '', 'retailer_id': this.retailer_id,
                    'order_id_pattern': this.order_id_pattern,'order_no':this.order_no,'invoice_id':window.location.pathname.split('/')[5],
                    'warehouseissue':this.all_orders.warehouse_issue[0].is_issued,'created_date':this.created_date
                };
                axios.post('../../invoice/add_reversal', this.invoice).then((response) => {
                    //console.log(response.data);
                   if (response.data == 201) {
                        location.assign("../../invoice/list");
                    }
                    if (response.data == 401) {
                        alert('Invoice reversal cannot be done after sale return');
                    }
                    //alert(response.data);
                });
            },
        }
    }
</script>


