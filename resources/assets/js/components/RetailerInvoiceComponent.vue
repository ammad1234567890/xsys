<template>
    <div>
        <div class="row"><div class="card headcolor"><div class="card-header"><h3 class="card-title pad-bot"><i class="material-icons"></i> <small>Create Invoice</small></h3></div></div></div>
        <form @submit.prevent="add_invoice">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12"><label><span class="h1">Xcell</span></label></div>
                            <br><br><br>
                            <div class="col-md-6"><label><b>Order NO</b> :</label> <input type="text" :value="order_no" class="bordernone"/></div>
                            <div class="col-md-3 col-md-offset-3 "><label ><b>Date</b> :</label> {{ current_date }}</div>
							<div class="col-md-6"></div>
                            <div class="col-md-3 col-md-offset-3"><label><b>Due Date</b> : {{ duedate }}</label></div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-6"><label><b>Outlet Name</b> :</label>
                                {{ outlet_name}}
                            </div>

                            <div class="col-md-3 col-md-offset-3"><label><b>Payment type</b> : </label>
                                <select id="payment_type_id">
                                    <option v-for="(type, index) in all_payment_type"  v-bind:value="type.id" :selected="type.id == 2">{{type.type}}</option>
                                </select>
                            </div>
                            <div class="col-md-6"><label><b>Outlet Address</b> : {{ outlet_address}}</label>
                            </div>
                            <div class="col-md-3 col-md-offset-3"><label><b>Previous Balance</b> : Rs.{{previous_balance>0?previous_balance:0 | currency('')}}</label></div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Model Name</th>
                                        <th>Colour</th>
                                        <th>Unit Cost (PKR)</th>
                                        <th>Quantity</th>
                                        <th>Discount</th>
                                        <th>Amount (PKR)</th>
                                        <th style="display:none;">Extra</th>
                                        <th>Total Amount (PKR)</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(order, index) in all_orders.order_products"  v-bind:id="'row'+index">
                                        <td><input type="text" class="bordernone " :value="s_no+index" style="width: 20px;"/>
                                            <input type="text" class="bordernone hidden" v-bind:data-id="`order_id_`+index" :value="order.id" style="width: 20px;"/>
                                        </td>
                                        <td>{{order.product_color.product.name}}</td>
                                        <td><input type="text" class="width70px bordernone hide"
                                                   v-bind:data-id="`color`+index"
                                                   :value="order.product_color_id" />
                                            {{order.product_color.color}}
                                        </td>
                                        <td>
                                            <input type="text" class="hidden" :value="order.unit_price"
                                                   v-bind:data-id="`unit`+index"/>
                                            <input type="text" class="width60px bordernone text-right pull-right" :value="order.unit_price | currency('')"
                                                   v-bind:data-id="`unit_view`+index"/>
                                        </td>
                                        <td>
                                            <input type="number" min="1" v-bind:data-id="`qty`+index" @keypress="isNumber(this)"
                                                   class="width60px bordernone" :value="order.remaining_qty==0?order.product_qty:order.remaining_qty"
                                                   @click="qty(order.id,$event.target.value,order.unit_price)"
                                                   @keyup="qty(order.id,$event.target.value,order.unit_price)" :max="order.remaining_qty==0?order.product_qty:order.remaining_qty"/>
                                            <input type="text" class="hidden " :value="order.remaining_qty==0?order.product_qty:order.remaining_qty" v-bind:data-id="`qty_db`+index"/>
                                        </td>
                                        <td><input type="text"  v-bind:data-id="`discount_amount`+order.id" :value="order.product_color.discount"
                                                   v-on:keyup="discount($event.target.value,order.id)" class=" width60px bordernone hidden" maxlength="5" readonly/>

                                            <input type="text"   :value="order.product_color.discount+'%'"
                                                    class=" width60px bordernone"  readonly/>

                                        </td>
                                        <td>
                                            <input type="text" value="15" min="1" class="hidden"
                                                   :value="order.unit_price*(order.remaining_qty==0?order.product_qty:order.remaining_qty)" readonly
                                                   v-bind:id="`amount`+order.id" v-bind:data-id="`amount`+index" >
                                            <input type="text" value="15" min="1" class="amount bordernone text-right pull-right"
                                                   :value="order.unit_price*(order.remaining_qty==0?order.product_qty:order.remaining_qty) | currency('')" readonly
                                                   v-bind:id="`amount_view`+order.id" v-bind:data-id="`amount_view`+index" >
                                        </td>
                                        <td style="display:none;"><input type="text" class="size90 " v-bind:data-id="`extra`+index" v-bind:id="`extra`+order.id" maxlength="3"/></td>
                                        <td>
                                            <input type="text" v-bind:id="`finalprice`+order.id"
                                                   :value="order.unit_price*(order.remaining_qty==0?order.product_qty:order.remaining_qty)-order.unit_price*(order.remaining_qty==0?order.product_qty:order.remaining_qty)/100*order.product_color.discount "
                                                   v-bind:data-id="`count`+index" readonly class="hidden"/>
                                            <input type="text" v-bind:id="`finalprice_view`+order.id"
                                                   :value="order.unit_price*(order.remaining_qty==0?order.product_qty:order.remaining_qty)-order.unit_price*(order.remaining_qty==0?order.product_qty:order.remaining_qty)/100*order.product_color.discount | currency('')"
                                                   v-bind:data-id="`count_view`+index" readonly class="amount bordernone text-right pull-right"/>
                                        </td>
                                        <td><button type="button" class="btn btn-primary pull-right" v-on:click="remove(index)">X</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-7">
                            <div class="col-md-4 text-right">
                                <label><span class="h4">Sub Total : </span></label></div>
                            <div class="col-md-6">
                                <span class="h4">
                                    <div class='col-md-9'>
                                    <input type="text" class="hidden" id="subamount"
                                           :value="subamount" readonly>
                                        <input type="text" class="bordernone text-right " id="subamount_view"
                                               readonly>
                                    </div>
                                </span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-7">
                            <div class="col-md-4 text-right">
                                <label><span class="h4">Total : </span></label></div>
                            <div class="col-md-6">
                                <span class="h4">
                                    <div class='col-md-9'>
                                    <input type="text" class="hidden" id="finalamount"
                                                         :value="totalamount" readonly>
                                            <input type="text" class="bordernone text-right " id="finalamount_view"
                                                    readonly>
                                    </div>
                                </span></div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-md-11 "><label>Remarks</label>
                            <textarea class="form-control" id="decs" rows="10"></textarea>
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
                subamount: 0,
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
                product_id:[],
                extra:[],
                countrow:0,
                qty_db:[],
                remaining_qty:[],
                order_id_pattern:'',
                previous_balance:'',
                order_no:'',
                s_no:1,




            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        created: function () {
            this.init();

        }
    ,
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
                //  console.log(window.location.href.substr(45));
                // console.log(window.location.href.substr(74));
                console.log(window.location.href.substr(62));
                axios.get('../../retailer_order/get_order/' + window.location.href.substr(62)).then((response) => {

                    this.all_payment_type=response.data.payment_type;
                    this.all_discount_type=response.data.discount_type;
                    this.all_orders = response.data.get_all_order;
                    this.order_id=this.all_orders.id;
                    this.retailer_name=this.all_orders.retailer.name;
                    this.outlet_name=this.all_orders.retailer_outlet.name;
                    this.outlet_address=this.all_orders.retailer_outlet.address;
                    this.retailer_id=this.all_orders.retailer_outlet.id;
                    this.order_no=this.all_orders.order_no;
                    this.order_id_pattern+=moment().format('YY');
                    this.order_id_pattern+=this.all_orders.retailer_outlet.city.name.substr(0,1)+this.all_orders.retailer_outlet.region.name.substr(0,1);
                  //  this.order_id_pattern+= this.order_id<10?'0000':this.order_id<=99?'000':this.order_id<=999?'00':this.order_id<=9999?'0':'';
                    //this.order_id_pattern+=this.order_id;
                    this.current_date = moment().format('DD-M-YYYY');
                    this.duedate = moment().add(this.all_orders.retailer_outlet.credit_duration, 'days').format('DD-M-YYYY');
                    var pro_qty=0;
                    for (var i = 0; i < this.all_orders.order_products.length; i++) {
                        this.countrow++;
                        pro_qty=this.all_orders.order_products[i].remaining_qty==0?this.all_orders.order_products[i].product_qty:this.all_orders.order_products[i].remaining_qty
                        //console.log(pro_qty);
                        this.subamount+= this.all_orders.order_products[i].unit_price*pro_qty
                        //console.log(this.subamount);
                        this.totalamount+= this.all_orders.order_products[i].unit_price*pro_qty - this.all_orders.order_products[i].unit_price*pro_qty/100*this.all_orders.order_products[i].product_color.discount;
                        //console.log( this.subamount);
                    }
                    $("#subamount_view").val("Rs. "+accounting.formatMoney(this.subamount,{symbol: "",  format: "%v %s" }));
                    $("#finalamount_view").val("Rs. "+accounting.formatMoney(this.totalamount,{symbol: "",  format: "%v %s" }));
                    this.retailer_balance();

                     //console.log(this.order_id_pattern);
                });

            },
            retailer_balance:function () {
//console.log(this.retailer_id)
                var retailer={'retailer_id':this.retailer_id};
                axios.post('../../RetailerTotalOutstanding',retailer).then((response) => {
                    this.previous_balance=response.data[0].Outstanding;
                    //console.log(response.data[0].Outstanding);
                });

            },
            remove:function (id) {
                //$("#row" + id).remove();
                $("[data-id='count" + id+ "']").val(0);
                $("[data-id='amount" + id+ "']").val(0);
                this.totalamount_method();
                $("#row" + id).hide();
                //   this.countrow--;
                //  console.log(this.countrow);
            },
            type_discount: function (id, value) {

                $("[data-id='discount_amount" + id+ "']").val("");
                $("#finalprice" + id).val($("#amount" + id).val());
                this.totalamount_method();
                $("#extra" + id).val("");
            }, totalamount_method: function () {
                // console.log(this.countrow);
                var cont = null;
                var contsub = null;
                for (var i = 0; i < this.countrow; i++) {
                    var attid = "[data-id='count" + i + "']";
                    cont += parseFloat($(attid).val());
                    var attidsub = "[data-id='amount" + i + "']";
                    contsub += parseFloat($(attidsub).val());
                    // console.log(contsub);
                }

                $('#finalamount').val(cont);
                $('#subamount').val(contsub);
                $('#subamount_view').val("Rs. "+accounting.formatMoney(contsub,{symbol: "",  format: "%v %s" }));
                $('#finalamount_view').val("Rs. "+accounting.formatMoney(cont,{symbol: "",  format: "%v %s" }));
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
                var discount_amount=$("[data-id='discount_amount" + id+ "']").val();
                $("#finalprice" + id).val(unit * qty - unit * qty /100 * discount_amount);
                $("#amount_view" + id).val(accounting.formatMoney(unit * qty , { symbol: "",  format: "%v %s" }));
                $("#finalprice_view" + id).val(accounting.formatMoney(unit * qty - unit * qty /100 * discount_amount, { symbol: "",  format: "%v %s" }));
                this.totalamount_method();
                //  $("[data-id='discount_amount" + id+ "']").val("");
                $("#discount_id" + id).val([]);
                //  $("#extra" + id).val("");
            },
            isNumber: function(e) {
               //alert();
                //console.log(e);
        return false;
    },
            add_invoice: function (e) {


                this.payment_type_id = $("#payment_type_id").val();
                this.finalamount = $("#finalamount").val();
                this.decs = $("#decs").val();
                //console.log(this.countrow);
                var count=0;
                for (var i = 0; i < this.countrow; i++) {
                    if($("[data-id='amount" + i + "']").val()!=0) {
                        this.product_id[count]=$("[data-id='order_id_" + i + "']").val();
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
                    'amount':this.amount,'product_id': this.product_id,'qty_db':this.qty_db,
                    'productamount':this.productamount,'extra':'','retailer_id':this.retailer_id,
                    'order_id_pattern':this.order_id_pattern
                };
                //  console.log(this.invoice);

                axios.post('../../invoice/store', this.invoice).then((response) => {
                   // console.log(response.data);
                    if(response.data==201){
                        location.assign("../../invoice/list");
                    }
                });
            },
        }
    }

</script>


