<template>
        <div class="row">
            
                
        <!--    <div class="card headcolor">
            <div class="card-header">
                    <h3 class="card-title pad-bot">
                        <h4 class="heading-inline" style="text-transform: uppercase; "> Dealer New Payment</h4> </h3>
            </div>
            <hr/>
            </div> -->
                    <div class="row">

                        <div class="col-md-12">
                            <div class="panel panel-info" >
                                <div class="panel-heading">
                                    <h2 class="panel-title">Dealer New Payment</h2>
                                </div>
                                <div class="col-md-12" style="    font-size: 14px; font-weight:bold; text-align:left; padding-left:30px;" v-if="new_payment.total_outstanding!=''">
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span style="text-transform: uppercase;">Dealer Name: {{new_payment.selected_invoice_retailer}}</span> <br/>Remaining Outstanding: {{new_payment.total_outstanding | currency('')}}
                                        </div>
                                    </div>
                                    <br/>
                                    
                                </div>
                                

                                <div class="panel-body">
                                    <div class="alert alert-success"  v-if="message">
                                        <strong>{{message}}</strong>
                                    </div>
                                    <div class="col-md-12">
                                        <form @submit.prevent="submit_payment">
                                           <div class="row">
                                            <div class="col-md-2"><label>Deposit Slip Number</label></div>
                                            <div class="col-md-3"><input type="text" class="textbox" v-model="new_payment.deposit_slip_no" required></div>
                                            <div class="col-md-1"></div>
                                            <div class="col-md-2"><label>Bank Name</label></div>
                                            <div class="col-md-3">
                                            <select class="textbox_dropdown" v-model="new_payment.bank_id" required>
                                                            <option value="">Bank Name</option>
                                                            <option v-for="(bank, index) in banks" v-bind:value="bank.id">{{bank.bank_name}}</option>
                                            </select>
                                            </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2"><label>Retailer Outlets</label></div>
                                                <div class="col-md-3">
                                                    <select class="textbox_dropdown" v-model="new_payment.selected_invoice_retailer_outlet_id" @change="get_invoices_by_outlet()" required>
                                                        <option value="">Select Outlet</option>
                                                        <option v-for="(outlet, index) in outletsData" v-bind:value="outlet.id">{{outlet.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-2"><label>Invoice No.</label></div>
                                                <div class="col-md-3">
                                                    <select class="textbox_dropdown" v-model="selected_invoice_index" @change="change_invoice()" required>
                                                            <option value="">Select Invoice No</option>
                                                            <option v-for="(invoice, index) in invoices" v-bind:value="index">{{invoice.invoice_no}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2"><label>Currency</label></div>
                                                <div class="col-md-3">
                                                    <select class="textbox_dropdown" v-model="new_payment.currency_id" required>
                                                            <option value="">Select Currency</option>
                                                            <option v-for="(currency, index) in currencies" v-bind:value="currency.id">{{currency.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-2"><label>Payment Type</label></div>
                                                <div class="col-md-2">
                                                    <select class="textbox_dropdown" v-model="selected_payment_index" @change="change_payment()" required>
                                                            <option value="">Select Payment Type</option>
                                                            <option v-for="(payment, index) in payments" v-bind:value="index">{{payment.type}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="new_payment.reverse" @change="change_reversible_check($event)"/> Reversible
                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>
                                            <div class="row" v-if="selected_payment_index==2">
                                                <div class="col-md-2"><label>Cheque no</label></div>
                                                <div class="col-md-3">
                                                    <input type="text" class="textbox_dropdown" v-model="new_payment.cheque_no" required>
                                                </div>

                                            </div>
                                            <div class="row">
                                                
                                                <div class="col-md-2"><label>Amount in PKR</label></div>
                                                <div class="col-md-3">
                                                    <vue-numeric currency="Rs" class="textbox_dropdown" separator="," v-model="new_payment.amount_in_rs"></vue-numeric>
                                                </div>
                                                
                                                <div class="col-md-1"></div>
                                                <div class="col-md-2"><label>Remarks</label></div>
                                                <div class="col-md-3">
                                                    <textarea class="textbox_dropdown" v-model="new_payment.remarks" required>

                                                    </textarea>
                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>


                            
                                            <div class="row">
                                                <div class="col-md-11">

                                                    <button type="submit" class="btn btn-success pull-right">Submit</button>

                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--New Dealer Payment panel ending-->
                
				
				<!--Payment Listing Panel starting-->
                    <div class="panel panel-info">
            <div class="panel-heading">
                <h2 class="panel-title">Dealer Payment Details</h2>
            </div>
            <div class="panel-body">
                 <table id="bank_detail_table" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                    <tr>
                        <th class="col-md-2">Date</th>
                        <th>DS.No</th>
						<th>Dealer Code</th>
                        <th>Outlet</th>
                        <th>Invoice No</th>
						<th>Bank</th>
                        <th class="col-md-2">Payment Type</th>
                        <th>Amount</th>
                        <th>Status</th>
						<th>Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(collection, index) in allCollections">
						<td>{{collection.created_at | moment}}</td>
                        <td>{{collection.deposit_slip_number}}</td>
						<td>{{collection.retailer.retailer_no}}</td>
                        <td>{{collection.retailer_outlet.name}}</td>
						<td>{{collection.invoice.invoice_no}}</td>
                        <td>{{collection.bank.bank_name}}</td>
                        <td>{{collection.payment_type.type}} <span v-if="collection.cheque_number!=null"> ({{collection.cheque_number}})</span></td>
                        <td style="text-align:right;"> {{collection.amount}} </td>
                        <td>
                            <span v-if="collection.is_reversible==1">
                                <span class="fa fa-mail-reply-all" title="Reversed" style="color:red;"></span>
                            </span>
                            <span v-else>
                                <span class="fa fa-check" style="color:green;"></span>
                            </span>
                        </td>
                        <td><button class="btn btn-info btn-xs" @click="edit_collection(index,collection.id)">Edit</button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

            <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="editable_modal" aria-labelledby="bs-add-Model-modal-md">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Payment</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-section padding10px">

                                <div class="row">
                                    <div class="col-md-12">
                                        <form @submit.prevent="submit_payment">
                                            <div class="row">
                                                <div class="col-md-2"><label>Deposit Slip</label></div>
                                                <div class="col-md-3"><input type="text" class="textbox" v-model="edit_payment.deposit_slip_no" required></div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-2"><label>Bank Name</label></div>
                                                <div class="col-md-3">
                                                    <select class="textbox_dropdown" v-model="edit_payment.bank_id" required>
                                                        <option value="">Bank Name</option>
                                                        <option v-for="(bank, index) in banks" v-bind:value="bank.id">{{bank.bank_name}}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2"><label>Outlet</label></div>
                                                <div class="col-md-3">
                                                    <select class="textbox_dropdown" v-model="edit_payment.selected_invoice_retailer_outlet_id" @change="get_invoices_by_outlet()" required>
                                                        <option value="">Select Outlets</option>
                                                        <option v-for="(outlet, index) in outletsData" v-bind:value="outlet.id">{{outlet.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-2"><label>Invoice No.</label></div>
                                                <div class="col-md-3">
                                                    <select class="textbox_dropdown" v-model="edit_payment.invoice_id" @change="change_invoice()" required>
                                                        <option value="">Select Invoice No</option>
                                                        <option v-for="(invoice, index) in invoices" v-bind:value="invoice.id">{{invoice.invoice_no}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2"><label>Currency</label></div>
                                                <div class="col-md-3">
                                                    <select class="textbox_dropdown" v-model="edit_payment.currency_id" required>
                                                        <option value="">Select Currency</option>
                                                        <option v-for="(currency, index) in currencies" v-bind:value="currency.id">{{currency.name}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-2"><label>Payment</label></div>
                                                <div class="col-md-2">
                                                    <select class="textbox_dropdown" v-model="edit_payment.payment_id" @change="change_payment()" required>
                                                        <option value="">Select Payment Type</option>
                                                        <option v-for="(payment, index) in payments" v-bind:value="payment.id">{{payment.type}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="edit_payment.reverse" @change="change_reversible_check($event)"/> Reversible
                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>
                                            <div class="row" v-if="selected_payment_index==2">
                                                <div class="col-md-2"><label>Cheque no</label></div>
                                                <div class="col-md-3">
                                                    <input type="text" class="textbox_dropdown" v-model="edit_payment.cheque_no" required>
                                                </div>

                                            </div>
                                            <div class="row">

                                                <div class="col-md-2"><label>Amount</label></div>
                                                <div class="col-md-3">
                                                    <vue-numeric currency="Rs" class="textbox_dropdown" separator="," v-model="edit_payment.amount_in_rs"></vue-numeric>
                                                </div>

                                                <div class="col-md-1"></div>
                                                <div class="col-md-2"><label>Remarks</label></div>
                                                <div class="col-md-3">
                                                    <textarea class="textbox_dropdown" v-model="edit_payment.remarks" required>

                                                    </textarea>
                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>



                                            <div class="row">
                                                <div class="col-md-11">

                                                    <button type="submit" class="btn btn-success pull-right">Submit</button>

                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- View Details Modal END -->


            </div>
        </div>

</template>

<script>
    export default {
        data() {
            return {
                message:'',
                invoices:[],
                allCollections:[],
                outletsData:[],
                banks:[],
                currencies:[],
                payments:[],
                selected_invoice_index:'',
                selected_payment_index:'',
                new_payment:{
                    bank_id:'',
                    invoice_id:'',
                    invoice_actual_amount:'',
                    payment_id:'',
                    currency_id:'',
                    reverse:0,
                    selected_invoice_retailer_id:'',
                    selected_invoice_retailer_outlet_id:'',
                    selected_invoice_retailer:'',
                    selected_invoice_retailer_outlet:'',
                    cheque_no:'',
                    amount_in_rs:'',
                    deposit_slip_no:'',
                    outstanding_amount:'',
                    remarks:'',
                    total_outstanding:'',
                    retailer_id:''
                },
                edit_payment:{
                    bank_id:'',
                    invoice_id:'',
                    invoice_actual_amount:'',
                    payment_id:'',
                    currency_id:'',
                    reverse:0,
                    selected_invoice_retailer_id:'',
                    selected_invoice_retailer_outlet_id:'',
                    selected_invoice_retailer:'',
                    selected_invoice_retailer_outlet:'',
                    cheque_no:'',
                    amount_in_rs:'',
                    deposit_slip_no:'',
                    outstanding_amount:'',
                    remarks:'',
                    total_outstanding:'',
                    retailer_id:''
                }

            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            }
        },
        created(){
            this.get_all_collections();
            this.get_all_invoices();
            this.get_all_banks();
            this.get_all_currencies();
            this.get_all_payment();
            this.get_all_outlets();
        },
        methods:{
            get_all_invoices:function(){
                axios.get('../retailer/get_invoices').then((response)=>{
                    this.invoices=response.data;
                });
            },
            get_all_banks:function(){

                axios.get('../bank/get_all_banks').then((response)=>{
                    this.banks=response.data;
                });
            },
            get_all_currencies:function(){

                axios.get('../get_currencies').then((response)=>{
                    this.currencies=response.data;
                });
            },
            get_all_payment:function(){
                axios.get('../get_payment_types').then((response)=>{
                    this.payments=response.data;
                });
            },
            change_invoice:function(){
                //alert(this.selected_invoice_index);

                this.new_payment.invoice_id= this.invoices[this.selected_invoice_index].id;
                this.new_payment.selected_invoice_retailer=this.invoices[this.selected_invoice_index].retailer_order.retailer.name;
                this.new_payment.selected_invoice_retailer_outlet=this.invoices[this.selected_invoice_index].retailer_order.retailer_outlet.name;
                this.new_payment.invoice_actual_amount=this.invoices[this.selected_invoice_index].total_amount;

                this.new_payment.retailer_id=this.invoices[this.selected_invoice_index].retailer_order.retailer_outlet.id;
                this.new_payment.selected_invoice_retailer_id=this.invoices[this.selected_invoice_index].retailer_order.retailer.id;
                this.new_payment.selected_invoice_retailer_outlet_id=this.invoices[this.selected_invoice_index].retailer_order.retailer_outlet.id;
                axios.post('../RetailerTotalOutstanding',this.new_payment).then((response)=>{
                    this.new_payment.total_outstanding=response.data[0]['Outstanding'];
                });
            },
            get_all_outlets:function(){
                axios.get('../outlet/get_all_outlets').then(response=>{
                    this.outletsData=response.data;
                });
            },
            change_payment:function(){
                this.new_payment.payment_id=this.payments[this.selected_payment_index].id;
            },
            submit_payment:function(){
                axios.post('../retailer/order/add_payment',this.new_payment).then((response)=> {
                    if(response.data==201){
                        this.message="Retailer Collection Submitted!";
                            this.new_payment.bank_id='';
                            this.new_payment.invoice_id='';
                            this.new_payment.invoice_actual_amount='';
                            this.new_payment.payment_id='0';
                            this.new_payment.currency_id='';
                            this.new_payment.selected_invoice_retailer_id='';
                            this.new_payment.selected_invoice_retailer_outlet_id='';
                            this.new_payment.selected_invoice_retailer='';
                            this.new_payment.selected_invoice_retailer_outlet='';
                            this.new_payment.cheque_no='';
                            this.new_payment.amount_in_rs='';
                            this.new_payment.deposit_slip_no='';
                            this.new_payment.total_outstanding='';
                            this.new_payment.remarks='';
                            this.selected_payment_index='';
                            this.selected_invoice_index='';
                            this.new_payment.reverse=0;
                            this.get_all_collections();
                        $("html, body").animate({
                            scrollTop: 0
                        }, 600);
                    }
                });

            },
            change_reversible_check:function($event){
                const checked = $event.target.checked;

                if(checked){
                    this.new_payment.reverse=1;
                }
                else{
                    this.new_payment.reverse=0;
                }
            },
            get_invoices_by_outlet:function(){
                axios.post('../get_invoice_by_retailer',this.new_payment).then((response)=>{
                    this.invoices=response.data;
                    this.new_payment.selected_invoice_retailer=response.data[0].retailer_order.retailer.name;
                    this.new_payment.selected_invoice_retailer_id=response.data[0].retailer_order.retailer.id;
                });

            },
            get_all_collections:function(){
                axios.get('../retailer/order/get_all_collection').then(response=>{
                    this.allCollections=response.data;
                });
            },
            edit_collection:function(index, $id){
                axios.post('../retailer/order/check_edit_order',{'order_id':$id}).then((response)=>{
                    if(response.data==201){
                        this.edit_payment.bank_id=this.allCollections[index].bank_id;
                        this.edit_payment.invoice_id=this.allCollections[index].invoice_id;
                        this.edit_payment.payment_id=this.allCollections[index].payment_type_id;
                        this.edit_payment.selected_invoice_retailer_outlet_id=this.allCollections[index].retailer_outlet_id;
                        this.edit_payment.currency_id=this.allCollections[index].currency_id;
                        this.edit_payment.deposit_slip_no=this.allCollections[index].deposit_slip_number;
                        this.edit_payment.remarks=this.allCollections[index].remarks;
                        this.edit_payment.reverse=this.allCollections[index].is_reversible;
                        this.edit_payment.amount_in_rs=this.allCollections[index].amount;
                        $('#editable_modal').modal('show');
                    }
                    else{
                        alert(response.data);
                    }
                });
            }
        }
    }
</script>
