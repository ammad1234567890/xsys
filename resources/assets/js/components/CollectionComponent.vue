
<template>
    <div class="row">
        <div class="panel panel-info" v-if="enable_payment==0">
            <div class="panel-heading">
                <h2 class="panel-title">Select Outlet for Payment</h2>
            </div>



            <!-- RETAILER SHOW GRID -->
            <div class="panel-body">

                <div class="projects">
                    <div class="tableFilters">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="control">
                                    <div class="select">
                                        <Label>Records:</Label>
                                        <select v-model="tableData.length" @change="getProjects()">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">

                                <input class="textbox" type="text" v-model="tableData.search" placeholder="Search..."
                                       @input="getProjects()">
                            </div>
                        </div>
                    </div>
                    <datatable :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                        <tbody>
                        <tr v-for="(outlets, index) in outletsData" :key="outlets.id">
                            <td>{{outlets.name}}</td>
                            <td :title="outlets.business_person_name">{{outlets.retailer.retailer_no}}</td>
                            <td>{{outlets.advance_amount | currency('Rs')}}</td>
                            <!--<td>{{outlets.phone_no}}</td>-->
                            <td>{{outlets.city.name}}</td>
                            <td :title=outlets.region.name>{{outlets.region.name.slice(0,30)}}...</td>
                            <td :title=outlets.address>{{outlets.address.slice(0,30)}}...</td>


                            <td>

                                <div class="btn-group ">
                                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                        <i class="fa fa-money"></i>  &nbsp;
                                        Select Payment Type <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="javascript:;" @click="enabled_payment_form(1, outlets.id, outlets.name )">New Receiving</a></li>
                                        <li><a href="javascript:;" @click="enabled_payment_form(2, outlets.id, outlets.name )">Advance Payment</a></li>
                                        <li><a href="javascript:;" @click="enabled_payment_form(3, outlets.id, outlets.name )">Credit Note</a></li>
                                    </ul>
                                </div>
                            </td>





                        </tr>
                        </tbody>
                    </datatable>
                    <pagination :pagination="pagination"
                                @prev="getProjects(pagination.prevPageUrl)"
                                @next="getProjects(pagination.nextPageUrl)">
                    </pagination>
                </div>

            </div>
        </div>

        <!-- Alert Modal Start-->
        <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="payment_invoice_modal" aria-labelledby="bs-add-Model-modal-md">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Xsys - Alert</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <h5><b v-if="enable_payment==1">Deposit Slip: {{this.new_payment.deposit_slip_no}}</b> <b v-if="enable_payment==2" style="color: red;">"Deduction from Advance"</b></h5>
                                <h5><b>Total Amount: {{this.new_payment.amount_in_rs | currency('Rs')}}</b></h5>
                                <h5><b>Outlet: {{this.new_payment.outlet_name}}</b></h5>
                                <h5 v-if="new_payment.sales_officer_id!=0"><b>Sales Officer: {{this.new_payment.sales_officer_name}}</b></h5>
                                <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <th>Invoice No</th>
                                        <th v-if="new_payment.payment_id==3">
                                            Cheque No
                                        </th>
                                        <th>Amount</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    <tr v-for="(invoice, index) in new_payment.invoices" v-if="invoice.given_amount!=0">
                                        <td>{{invoice.order_no}}</td>
                                        <td>{{invoice.invoice_no}}</td>
                                        <td v-if="new_payment.payment_id==3">

                                            {{invoice.cheque_no}}
                                        </td>
                                        <td>
                                            {{invoice.given_amount | currency('Rs')}}
                                        </td>
                                    </tr>
                                    <tr v-if="enable_payment==1">
                                        <td colspan="2">Advance Amount</td>
                                        <td v-if="new_payment.payment_id==3">{{new_payment.advance_cheque_no}}</td>
                                        <td>{{new_payment.advance_amount  | currency('Rs')}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-github" @click="submit_payment()" v-if="enable_payment==1" :disabled="btn_disabled==1">Submit Payment</button>
                        <button type="button" class="btn btn-github" @click="submit_payment_from_advance()" :disabled="btn_disabled==1" v-else>Submit Payment From Advance</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alert Modal END -->







        <!--    <div class="card headcolor">
            <div class="card-header">
                    <h3 class="card-title pad-bot">
                        <h4 class="heading-inline" style="text-transform: uppercase; "> Dealer New Payment</h4> </h3>
            </div>
            <hr/>
            </div> -->
        <div v-if="invoice_enabled==0">
            <div class="row" v-if="enable_payment==1">

                <div class="col-md-12">
                    <div class="alert alert-success" id="message_div" v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <div class="panel panel-info" >
                        <div class="panel-heading">
                            <h2 class="panel-title"><i class="fa fa-arrow-circle-left" @click="outlet_enabled()"></i> Dealer New Payment</h2>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <form @submit.prevent="get_outstanding_invoices">

                                    <div class="row">
                                        <div class="col-md-2"><label>Deposit Slip Number<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3"><input type="text" class="textbox" v-model="new_payment.deposit_slip_no" required></div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-2"><label>Bank Name<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3">
                                            <select class="textbox_dropdown" v-model="new_payment.bank_id" required>
                                                <option value="">Bank Name</option>
                                                <option v-for="(bank, index) in banks" v-bind:value="bank.id">{{bank.bank_name}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2"><label>Outlet Name<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3">
                                            <input type="text" class="textbox" v-model="new_payment.retailer_outlet_name" readonly>
                                            <!-- <select class="textbox_dropdown" v-model="new_payment.retailer_outlet_id" @change="get_sales_officers()" required>
                                                 <option value="0">Select Outlet</option>
                                                 <option v-for="(outlet, index) in outletsData" v-bind:value="outlet.id">{{outlet.name}}</option>
                                             </select> -->
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-2"><label>Sales Officer</label></div>
                                        <div class="col-md-3">
                                            <select class="textbox_dropdown" v-model="new_payment.sales_officer_id">
                                                <option value="0" selected>Sales Officers</option>
                                                <option v-for="(officer, index) in sales_officers" v-bind:value="officer.id">{{officer.name}}</option>
                                            </select>

                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2"><label>Currency<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3">
                                            <select class="textbox_dropdown" v-model="new_payment.currency_id" required disabled>
                                                <option value="">Select Currency</option>
                                                <option v-for="(currency, index) in currencies" v-bind:value="currency.id">{{currency.name}}</option>
                                            </select>

                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-2"><label>Payment Type<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3">

                                            <select class="textbox_dropdown" v-model="new_payment.payment_id" required>
                                                <option value="">Select Payment Type</option>
                                                <option v-for="(payment, index) in payments" v-bind:value="payment.id">{{payment.type}}</option>
                                            </select>
                                        </div>
                                        <!-- <div class="col-md-2">
                                             <input type="checkbox" v-model="new_payment.reverse" @change="change_reversible_check($event)"/> Reversible
                                         </div> -->
                                        <div class="col-md-1"></div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-2"><label>Amount in PKR<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3">
                                            <vue-numeric currency="Rs" class="textbox_dropdown" name="payment_validation" separator="," v-model="new_payment.amount_in_rs"></vue-numeric>

                                        </div>

                                        <div class="col-md-1"></div>
                                        <div class="col-md-2"><label>Remarks</label></div>
                                        <div class="col-md-3">
                                                    <textarea class="textbox_dropdown" v-model="new_payment.remarks">

                                                    </textarea>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-11">

                                            <button type="submit" class="btn btn-success pull-right" :disabled="get_invoice_btn_disabled">Get Outstanding Invoices</button>

                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="enable_payment==2">

                <div class="col-md-12">
                    <div class="alert alert-success" id="message_div" v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <div class="panel panel-info" >
                        <div class="panel-heading">
                            <h2 class="panel-title"><i class="fa fa-arrow-circle-left" @click="outlet_enabled()"></i> Dealer Payment From Advance Amount <b>({{new_payment.saved_advance_amount}})</b></h2>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <form @submit.prevent="get_advance_outstanding_invoices">

                                    <div class="row">
                                        <div class="col-md-2"><label>Outlet Name<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3">
                                            <input type="text" class="textbox" v-model="new_payment.retailer_outlet_name" readonly>

                                            <!-- <select class="textbox_dropdown" v-model="new_payment.retailer_outlet_id" @change="get_sales_officers()" required>
                                                 <option value="0">Select Outlet</option>
                                                 <option v-for="(outlet, index) in outletsData" v-bind:value="outlet.id">{{outlet.name}}</option>
                                             </select> -->
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-2"><label>Sales Officer</label></div>
                                        <div class="col-md-3">
                                            <select class="textbox_dropdown" v-model="new_payment.sales_officer_id">
                                                <option value="0" selected>Sales Officers</option>
                                                <option v-for="(officer, index) in sales_officers" v-bind:value="officer.id">{{officer.name}}</option>
                                            </select>

                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2"><label>Currency<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3">
                                            <select class="textbox_dropdown" v-model="new_payment.currency_id" required disabled>
                                                <option value="">Select Currency</option>
                                                <option v-for="(currency, index) in currencies" v-bind:value="currency.id">{{currency.name}}</option>
                                            </select>

                                        </div>
                                        <div class="col-md-1"></div>

                                        <div class="col-md-2"><label>Amount in PKR<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3">
                                            <vue-numeric currency="Rs" class="textbox_dropdown" name="payment_validation" separator="," v-model="new_payment.amount_in_rs"></vue-numeric>

                                        </div>

                                        <div class="col-md-1"></div>

                                    </div>

                                    <div class="row">


                                        <div class="col-md-2"><label>Remarks</label></div>
                                        <div class="col-md-3">
                                                    <textarea class="textbox_dropdown" v-model="new_payment.remarks">

                                                    </textarea>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-11">

                                            <button type="submit" class="btn btn-success pull-right" :disabled="get_invoice_btn_disabled">Get Outstanding Invoices</button>

                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-if="enable_payment==3">

                <div class="col-md-12">
                    <div class="alert alert-success" id="message_div" v-if="message">
                        <strong>{{message}}</strong>
                    </div>
                    <div class="panel panel-info" >
                        <div class="panel-heading">
                            <h2 class="panel-title"><i class="fa fa-arrow-circle-left" @click="outlet_enabled()"></i> Credit Note Payment </h2>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <form @submit.prevent="submit_credit_note">

                                    <div class="row">
                                        <div class="col-md-2"><label>Credit Note Number<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3"><input type="text" class="textbox" v-model="new_payment.cn_no" required></div>
                                        <div class="col-md-1"></div>

                                        <div class="col-md-2"><label>Credit Note Type<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3">
                                            <select class="textbox_dropdown" v-model="new_payment.cn_type">
                                                <option value="0" selected>Select Credit Note Type</option>
                                                <option v-for="(types, index) in new_payment.cn_types" :value="types.id">{{types.name}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2"><label>Outlet Name<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3">
                                            <input type="text" class="textbox" v-model="new_payment.retailer_outlet_name" readonly>
                                            <!-- <select class="textbox_dropdown" v-model="new_payment.retailer_outlet_id" @change="get_sales_officers()" required>
                                                 <option value="0">Select Outlet</option>
                                                 <option v-for="(outlet, index) in outletsData" v-bind:value="outlet.id">{{outlet.name}}</option>
                                             </select> -->
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-2"><label>Sales Officer</label></div>
                                        <div class="col-md-3">
                                            <select class="textbox_dropdown" v-model="new_payment.sales_officer_id">
                                                <option value="0" selected>Sales Officers</option>
                                                <option v-for="(officer, index) in sales_officers" v-bind:value="officer.id">{{officer.name}}</option>
                                            </select>

                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>



                                    <div class="row">

                                        <div class="col-md-2"><label>Amount in PKR<span style="color:red;">*</span></label></div>
                                        <div class="col-md-3">
                                            <vue-numeric currency="Rs" class="textbox_dropdown" name="payment_validation" separator="," v-model="new_payment.amount_in_rs"></vue-numeric>

                                        </div>

                                        <div class="col-md-1"></div>
                                        <div class="col-md-2"><label>Remarks</label></div>
                                        <div class="col-md-3">
                                                    <textarea class="textbox_dropdown" v-model="new_payment.remarks">

                                                    </textarea>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-11">

                                            <button type="submit" class="btn btn-success pull-right">Create Note</button>

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


        <!--Payment Listing Panel starting-->

        <!--
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

                     <td><button class="btn btn-info btn-xs" @click="edit_collection(index,collection.id)">Edit</button></td>
                 </tr>
                 </tbody>
             </table>
         </div>
     </div> -->

        <!--
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
                                                    <option v-for="(invoice, index) in invoices" v-if="invoice.is_pay==0" v-bind:value="invoice.id">{{invoice.invoice_no}}</option>
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
                                                <vue-numeric currency="Rs"  class="textbox_dropdown" separator="," v-model="edit_payment.amount_in_rs"></vue-numeric>

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




        </div>
-->
        <div  id="show_invoices">
            <div class="row" v-if="invoice_enabled==1">

                <div class="col-md-12">
                    <div class="panel panel-info" >
                        <div class="panel-heading">
                            <h2 class="panel-title"><i class="fa fa-arrow-circle-left" @click="enable_payment_details()"></i> Dealer Payment Details <b>({{new_payment.retailer_outlet_name}})</b></h2>
                        </div>
                        <div class="panel-body">

                            <h5><b v-if="enable_payment!=2">Deposit Slip# {{new_payment.deposit_slip_no}}</b> <span style="float:right; font-weight: bold;">Total Amount: {{new_payment.amount_in_rs | currency('Rs')}}</span></h5>

                            <!-- <ul class="nav nav-tabs">
                                 <li class="active"><a data-toggle="tab" href="#invoice_payment">Invoice Payment</a></li>
                                 <li><a data-toggle="tab" href="#advance_payment">Advance Payment</a></li>
                             </ul> -->



                            <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Invoice No</th>
                                    <th>Total Amount</th>
                                    <th>Received Amount</th>
                                    <th>Remaining Amount</th>
                                    <th v-if="new_payment.payment_id==3">
                                        Cheque No
                                    </th>
                                    <th>Amount</th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr v-for="(invoice, index) in new_payment.invoices">
                                    <td>{{invoice.order_no}}</td>
                                    <td>{{invoice.invoice_no}}</td>
                                    <td>{{invoice.total_amount | currency('Rs')}}</td>
                                    <td>{{invoice.paid_amount | currency('Rs')}}</td>
                                    <td>{{invoice.payable_amount | currency('Rs')}}</td>
                                    <td v-if="new_payment.payment_id==3">
                                        <input type="textbox" placeholder="Cheque No" v-model="invoice.cheque_no"/>
                                    </td>
                                    <td>
                                        <vue-numeric class="textbox" :name="'given_payment'+index" v-validate="{ max_value:  invoice.payable_amount, min_value: 0 }" currency="Rs" separator="," v-model="invoice.given_amount"></vue-numeric>
                                        <span class="text-danger" v-show="errors.has('given_payment'+index)">
                                                      Invalid Amount
                                                    </span>
                                    </td>

                                </tr>
                                <tr v-if="enable_payment!=2">
                                    <td colspan="5">
                                        <b>Advance Amount</b>
                                    </td>
                                    <td v-if="new_payment.payment_id==3">
                                        <input type="textbox" placeholder="Cheque No" v-model="new_payment.advance_cheque_no"/>
                                    </td>
                                    <td>
                                        <vue-numeric class="textbox" :name="'given_advance_payment'" v-validate="{ max_value: new_payment.amount_in_rs, min_value: 0 }" currency="Rs" separator=","  v-model="new_payment.advance_amount"></vue-numeric>
                                        <span class="text-danger" v-show="errors.has('given_advance_payment')">
                                                      Invalid Amount
                                                    </span>
                                    </td>
                                </tr>
                                <tr colspan="2">
                                    <td>
                                    </td>
                                    <td></td>
                                    <td><b>{{new_payment.invoice_total_amount | currency('Rs')}}</b></td>
                                    <td><b>{{new_payment.invoice_receive_amount | currency('Rs')}}</b></td>
                                    <td><b>{{new_payment.invoice_remaining_amount | currency('Rs')}}</b></td>
                                    <td>

                                    <td v-if="new_payment.payment_id==3"></td>

                                </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12">

                                    <button class="btn btn-success pull-right" @click="create_payment">Create Payment</button>
                                </div>
                            </div>



                            <!--
                            <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th v-if="new_payment.payment_id==3">
                                        Cheque No
                                    </th>
                                    <th>Amount</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr v-for="(advance_payment, index) in new_advance_payment">
                                    <td v-if="new_payment.payment_id==3">
                                        <input type="text" placeholder="Cheque No" class="textbox" v-model="advance_payment.cheque_no"/>
                                    </td>
                                    <td>
                                        <vue-numeric :name="'advance_given_payment'+index" v-validate="{ max_value: new_payment.amount_in_rs, min_value: 0 }"  currency="Rs" separator="," class="textbox" v-model="advance_payment.amount"></vue-numeric>
                                        <span class="text-danger" v-show="errors.has('advance_given_payment'+index)">
                                          Invalid Amount
                                        </span>
                                    </td>
                                </tr>

                                <tr v-if="new_payment.payment_id==3">
                                    <td colspan="2"><button @click="add_new_cheque()">Add New Cheque</button></td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-success pull-right" @click="create_advance_payment()">Create Advance Payment</button>
                                </div>
                            </div>

                               -->





                        </div>
                    </div>
                </div>



            </div>
        </div>


    </div>
</template>

<script>
    import Datatable from './DatatableComponent.vue';
    import Pagination from './PaginationComponent.vue';
    import {constant} from '../constant.js';
    export default {
        components: {datatable: Datatable, pagination: Pagination},
        data() {
            let sortOrders = {};
            let columns = [
                {width: '20%', label: 'Outlet', name: 'Outlet' },
                {width: '10%', label: 'Dealer Code', name: 'Dealer Code'},
                {width: '20%', label: 'Saved Amount', name: 'Saved Amount'},
                //{width: '10%', label: 'Contact No', name: 'Contact No'},
                {width: '10%', label: 'City', name: 'City'},
                {width: '15%', label: 'Locality', name: 'Locality'},
                {width: '20%', label: 'Address', name: 'Address'},
                {width: '25%', label: 'Action', name: 'Action'},
            ];
            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });
            return {
                get_invoice_btn_disabled:false,
                btn_disabled:0,
                projects:[],
                columns: columns,
                sortKey: 'Dealer Code',
                sortOrders: sortOrders,
                tableData: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'desc',
                },
                pagination: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: ''
                },
                selected_collection_type:1,
                collection_types:[
                    {
                        id:1,
                        name:'New Payment',
                    },
                    {
                        id:2,
                        name:'From Advance',
                    }
                ],
                message:'',
                current_warehouse_id:'',
                sales_officers:[],
                enable_payment:0,
                invoice_enabled:0,
                outletsData:[],
                banks:[],
                currencies:[],
                payments:[],
                new_payment:{
                    invoice_total_amount:0,
                    invoice_receive_amount:0,
                    invoice_remaining_amount:0,
                    deposit_slip_no:'',
                    bank_id:'',//
                    retailer_outlet_id:0,//
                    retailer_outlet_name:'',
                    outlet_name:'',
                    sales_officer_id:0,
                    sales_officer_name:'',

                    payment_id:'',//
                    currency_id:3,//
                    amount_in_rs:0,//
                    remarks:'',//
                    invoices:[],
                    advance_cheque_no:'',
                    advance_amount:0,
                    saved_advance_amount:0,

                    cn_no:'',
                    cn_type:0,
                    cn_types:[]

                },
                new_advance_payment: [
                    {
                        cheque_no: '',
                        amount: 0,
                    }
                ]



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
            //this.get_all_collections();
            this.get_all_invoices();
            this.get_all_banks();
            this.get_all_currencies();
            this.get_all_payment();
            //this.get_warehouse();
            //this.get_warehouse_sales_officers();
            this.getProjects();
        },
        methods:{
            get_all_cr_types:function(){
                axios.get(constant.base_url+"get_cr_types").then((response)=>{
                    this.new_payment.cn_types=response.data;
                });
            },
            getProjects(url = constant.base_url+'get_all_outlets_dataTable') {
                this.tableData.draw++;
                axios.get(url, {params: this.tableData})
                    .then(response => {
                        let data = response.data;
                        if (this.tableData.draw == data.draw) {
                            this.outletsData = data.data.data;
                            console.log(this.outletsData);
                            this.configPagination(data.data);
                        }
                    })
                    .catch(errors => {
                        console.log(errors);
                    });
            },
            configPagination(data) {
                this.pagination.lastPage = data.last_page;
                this.pagination.currentPage = data.current_page;
                this.pagination.total = data.total;
                this.pagination.lastPageUrl = data.last_page_url;
                this.pagination.nextPageUrl = data.next_page_url;
                this.pagination.prevPageUrl = data.prev_page_url;
                this.pagination.from = data.from;
                this.pagination.to = data.to;
            },
            sortBy(key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.getProjects();
            },
            getIndex(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },
            get_all_invoices:function(){
                axios.get('../retailer/get_invoices').then((response)=>{
                    this.invoices=response.data;
                });
            },
            get_warehouse:function(){
                axios.get('../warehouse_by_manager').then((response) => {
                    this.warehouses=response.data;
                    //alert(response.data[0].id);
                    this.current_warehouse_id=response.data[0].warehouse_id;
                    axios.post('../warehouse_salesofficer', {warehouse_id: this.current_warehouse_id}).then((response) => {
                        for(var i=0; i<response.data[0].staff.length; i++){
                            this.sales_officers.push(response.data[0].staff[i]);
                        }
                    });

                    this.get_all_outlets(this.current_warehouse_id);
                });
            },
            get_warehouse_sales_officers:function() {

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

            },
            get_all_outlets:function($warehouse_id){
                axios.get('../outlet/get_all_outlets_order_of_warehouse/'+$warehouse_id).then(response=>{
                    var old_id=0;
                    for(var i=0; i<response.data.length; i++){
                        if(old_id!=response.data[i].id){
                            this.outletsData.push(response.data[i]);
                            old_id=response.data[i].id;
                        }

                    }

                });
            },
            change_payment:function(){
                this.new_payment.payment_id=this.payments[this.selected_payment_index].id;
            },
            submit_payment:function(){
                this.btn_disabled=1;
                axios.post('../retailer/order/add_payment',this.new_payment).then((response)=> {
                    //alert(response.data);
                    if(response.data==201){
                        alert("Payment has been Submitted!");
                        /*this.message="Payment received from " + this.new_payment.selected_invoice_retailer_outlet;
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
                        this.invoice_enabled=0;
                        this.new_payment.payment_validation=1000000;
                        this.new_payment.reverse=0;
                        this.get_all_collections();
                        setTimeout(function() {
                            $('#message_div').fadeOut(1000);
                        }, 1000);
                        $("html, body").animate({
                            scrollTop: 0
                        }, 600);*/
                        this.btn_disabled=0;
                        location.reload();
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
            get_sales_officers:function(){

                axios.get("../get_sales_officer_outlet_orders/"+this.new_payment.retailer_outlet_id).then(response=>{
                    //alert(response.data);
                    if(this.new_payment.retailer_outlet_id==0){
                        this.invoice_enabled=0;
                        this.new_payment.invoices=[];
                        alert("Please Select the Outlet");
                    }
                    else{
                        this.sales_officers=[];
                        var old_id=0;
                        for(var i=0; i<response.data.length; i++){
                            if(old_id!=response.data[i].sales_officer.id){
                                this.sales_officers.push(response.data[i].sales_officer);
                                old_id=response.data[i].sales_officer.id;
                            }

                        }
                    }

                });

            },
            get_outstanding_invoices(){
                this.invoice_enabled=0;
                this.new_payment.invoices=[];
                if(this.new_payment.retailer_outlet_id==0){
                    alert("Please Select the Outlet to proceed further steps!");
                }
                else if(this.new_payment.amount_in_rs==0){
                    alert("Please fill Total Amount Field!");
                }
                else{
                    for(var i=0; i<this.outletsData.length; i++){
                        if(this.outletsData[i].id==this.new_payment.retailer_outlet_id){
                            this.new_payment.outlet_name=this.outletsData[i].name;
                            break;
                        }
                    }
                    if(this.new_payment.sales_officer_id!=0){
                        for(var i=0; i<this.sales_officers.length; i++){
                            if(this.sales_officers[i].id==this.new_payment.sales_officer_id){
                                this.new_payment.sales_officer_name=this.sales_officers[i].name;
                                break;
                            }
                        }
                    }
                    this.get_invoice_btn_disabled=true;

                    axios.get('../get_outstanding_invoices/'+this.new_payment.deposit_slip_no+'/'+this.new_payment.retailer_outlet_id+'/'+this.new_payment.sales_officer_id).then((response)=> {

                        if(response.data==409){
                            alert("Try Different Deposit Slip, This Slip Number is already exist!");
                            this.get_invoice_btn_disabled=false;
                        }
                        else{
                            for(var i=0; i<response.data.length; i++){
                                this.new_payment.invoices.push({
                                    'invoice_no':response.data[i].invoice_no,
                                    'invoice_id':response.data[i].invoice_id,
                                    'order_no':response.data[i].order_no,
                                    'order_id':response.data[i].order_id,
                                    'paid_amount':response.data[i].invoice_paid_amount,
                                    'total_amount':response.data[i].invoice_total_amount,
                                    'payable_amount':response.data[i].invoice_total_amount-response.data[i].invoice_paid_amount,
                                    'cheque_no':'',
                                    'given_amount:':0
                                });
                            }
                            this.new_payment.invoice_total_amount=0;
                            this.new_payment.invoice_receive_amount=0;
                            this.new_payment.invoice_remaining_amount=0;
                            for(var i=0; i<this.new_payment.invoices.length; i++){
                                this.new_payment.invoice_total_amount+=parseInt(this.new_payment.invoices[i].total_amount);
                                this.new_payment.invoice_receive_amount+=parseInt(this.new_payment.invoices[i].paid_amount);
                                this.new_payment.invoice_remaining_amount+=parseInt(this.new_payment.invoices[i].payable_amount);
                            }
                            this.invoice_enabled=1;
                            this.get_invoice_btn_disabled=false;
                            /* $('html,body').animate({
                                     scrollTop: $("#show_invoices").offset().top},
                                 'slow'); */

                            //$('#payment_invoice_modal').modal('show');
                        }

                    });
                }
            },
            create_payment:function(){
                this.$validator.validateAll();
                if (!this.errors.any()) {
                    var total_amount=this.new_payment.amount_in_rs;
                    var final_given_amount=this.new_payment.advance_amount;
                    for(var i=0; i<this.new_payment.invoices.length; i++){
                        if(this.new_payment.invoices[i].given_amount!=0){
                            final_given_amount+=parseInt(this.new_payment.invoices[i].given_amount);
                        }
                    }

                    var is_cheque_null=0;

                    if(this.new_payment.payment_id==3){
                        for(var i=0; i<this.new_payment.invoices.length; i++) {
                            if (this.new_payment.invoices[i].cheque_no == '' && this.new_payment.invoices[i].given_amount!=0) {
                                is_cheque_null=1
                            }
                        }

                        if(is_cheque_null==1){
                            alert("Cheque Number cannot be Blank");
                        }
                        else{
                            if(final_given_amount<total_amount){
                                alert("Please complete given total amount,"+(total_amount-final_given_amount)+" Amount left");
                            }
                            else if(final_given_amount>total_amount){
                                alert("Amount "+(final_given_amount-total_amount)+" Exceeded from Total Amount: "+total_amount);
                            }
                            else{
                                $('#payment_invoice_modal').modal('show');
                            }
                        }
                    }
                    else{
                        if(final_given_amount<total_amount){
                            alert("Please complete given total amount,"+(total_amount-final_given_amount)+" Amount left");
                        }
                        else if(final_given_amount>total_amount){
                            alert("Amount "+(final_given_amount-total_amount)+" Exceeded from Total Amount: "+total_amount);
                        }
                        else{
                            $('#payment_invoice_modal').modal('show');
                        }
                    }
                }
            },
            add_new_cheque:function(){
                this.new_advance_payment.push({
                    cheque_no:'',
                    amount:0,
                });
            },
            create_advance_payment:function(){
                this.$validator.validateAll();
                if (!this.errors.any()) {
                    var total_amount = this.new_payment.amount_in_rs;
                    var final_given_amount = 0;

                    var is_cheque_null=0;

                    for(var i=0; i<this.new_advance_payment.length;i++){
                        final_given_amount+=this.new_advance_payment[i].amount;
                    }

                    if(this.new_payment.payment_id==3) {
                        for (var i = 0; i < this.new_advance_payment.length; i++) {
                            if (this.new_advance_payment[i].cheque_no == '' && this.new_advance_payment[i].amount != 0) {
                                is_cheque_null = 1
                            }
                        }

                        if (is_cheque_null == 1) {
                            alert("Cheque Number cannot be Blank");
                            return 0;
                        }
                    }

                    if(final_given_amount>total_amount){
                        alert("Amount "+(final_given_amount-total_amount)+" Exceeded from Total Amount: "+total_amount);
                        return 0;
                    }
                    else if(final_given_amount<total_amount){
                        alert("Please complete given total amount,"+(total_amount-final_given_amount)+" Amount left");
                        return 0;
                    }
                    else{
                        $('#payment_advance_modal').modal("show");
                    }
                }
            },
            submit_advance_payment:function(){
                var submit_data={
                    bank_id: this.new_payment.bank_id,
                    payment_id: this.new_payment.payment_id,
                    currency_id: 3,
                    retailer_outlet_id: this.new_payment.retailer_outlet_id,
                    sales_officer_id: this.new_payment.sales_officer_id,
                    amount_in_rs: this.new_payment.amount_in_rs,
                    deposit_slip_no: this.new_payment.deposit_slip_no,
                    remarks: this.new_payment.remarks,
                    payments: this.new_advance_payment

                }
                this.btn_disabled=1;


                axios.post('../retailer/order/add_advance_payment',submit_data).then((response)=> {
                    //alert(response.data);
                    if(response.data==201){
                        alert("Payment has been Submitted!");
                        location.reload();
                        this.btn_disabled=0;
                    }
                });
            },
            enabled_payment_form:function($payment_no, $outlet_id, $outlet_name){
                this.enable_payment=$payment_no;
                this.new_payment.retailer_outlet_id=$outlet_id;
                this.new_payment.retailer_outlet_name=$outlet_name;
                this.get_sales_officers();

                if(this.enable_payment==2){
                    this.get_outlet_advance_amount(this.new_payment.retailer_outlet_id);


                }
                else if(this.enable_payment==3){
                    this.get_all_cr_types();
                }

            },
            outlet_enabled(){
                this.enable_payment=0;
                this.invoice_enabled=0;
                this.new_payment.amount_in_rs=0;
            },
            get_outlet_advance_amount($outlet_id){
                axios.get(constant.base_url+'get_outlet_advance_amount/'+$outlet_id).then((response)=>{

                    if(response.data[0].advance_amount==null){
                        alert(this.new_payment.retailer_outlet_name+" doesn't have any advance amount")
                        this.enable_payment=0;
                    }
                    else if(response.data[0].advance_amount==0){
                        alert(this.new_payment.retailer_outlet_name+" doesn't have any advance amount");
                        this.enable_payment=0;
                    }
                    else{
                        this.new_payment.saved_advance_amount=response.data[0].advance_amount;
                    }
                });
            },
            get_advance_outstanding_invoices(){
                this.invoice_enabled=0;
                this.new_payment.invoices=[];

                if(this.new_payment.retailer_outlet_id==0){
                    alert("Please Select the Outlet to proceed further steps!");
                }
                else if(this.new_payment.amount_in_rs==0){
                    alert("Please fill Total Amount Field!");
                }
                else if(this.new_payment.amount_in_rs>this.new_payment.saved_advance_amount){
                    alert("Amount Exceeded from Saved Amount");
                }
                else{
                    for(var i=0; i<this.outletsData.length; i++){
                        if(this.outletsData[i].id==this.new_payment.retailer_outlet_id){
                            this.new_payment.outlet_name=this.outletsData[i].name;
                            break;
                        }
                    }
                    if(this.new_payment.sales_officer_id!=0){
                        for(var i=0; i<this.sales_officers.length; i++){
                            if(this.sales_officers[i].id==this.new_payment.sales_officer_id){
                                this.new_payment.sales_officer_name=this.sales_officers[i].name;
                                break;
                            }
                        }
                    }

                    this.get_invoice_btn_disabled=true;
                    axios.get('../get_outstanding_invoices/'+0+'/'+this.new_payment.retailer_outlet_id+'/'+this.new_payment.sales_officer_id).then((response)=> {

                        if(response.data==409){
                            alert("Try Different Deposit Slip, This Slip Number is already exist!");
                            this.get_invoice_btn_disabled=false;
                        }
                        else{
                            for(var i=0; i<response.data.length; i++){
                                this.new_payment.invoices.push({
                                    'invoice_no':response.data[i].invoice_no,
                                    'invoice_id':response.data[i].invoice_id,
                                    'order_no':response.data[i].order_no,
                                    'order_id':response.data[i].order_id,
                                    'paid_amount':response.data[i].invoice_paid_amount,
                                    'total_amount':response.data[i].invoice_total_amount,
                                    'payable_amount':response.data[i].invoice_total_amount-response.data[i].invoice_paid_amount,
                                    'cheque_no':'',
                                    'given_amount:':0
                                });
                            }
                            this.new_payment.invoice_total_amount=0;
                            this.new_payment.invoice_receive_amount=0;
                            this.new_payment.invoice_remaining_amount=0;
                            for(var i=0; i<this.new_payment.invoices.length; i++){
                                this.new_payment.invoice_total_amount+=parseInt(this.new_payment.invoices[i].total_amount);
                                this.new_payment.invoice_receive_amount+=parseInt(this.new_payment.invoices[i].paid_amount);
                                this.new_payment.invoice_remaining_amount+=parseInt(this.new_payment.invoices[i].payable_amount);
                            }
                            this.invoice_enabled=1;
                            this.get_invoice_btn_disabled=false;
                            /* $('html,body').animate({
                                     scrollTop: $("#show_invoices").offset().top},
                                 'slow');*/

                            //$('#payment_invoice_modal').modal('show');
                        }

                    });
                }
            },
            submit_payment_from_advance(){
                var submit_data={
                    retailer_outlet_id: this.new_payment.retailer_outlet_id,
                    sales_officer_id: this.new_payment.sales_officer_id,
                    currency_id:this.new_payment.currency_id,
                    amount_in_rs: this.new_payment.amount_in_rs,
                    remarks: this.new_payment.remarks,
                    invoices: this.new_payment.invoices
                }
                this.btn_disabled=1;

                axios.post('../retailer/order/add_advance_payment',submit_data).then((response)=> {
                    //alert(response.data);
                    if(response.data==201){
                        alert("Payment has been Submitted!");
                        this.btn_disabled=0;
                        location.reload();

                    }
                });
            },
            submit_credit_note(){


                var submit_data={
                    retailer_outlet_id: this.new_payment.retailer_outlet_id,
                    sales_officer_id: this.new_payment.sales_officer_id,
                    currency_id:this.new_payment.currency_id,
                    amount_in_rs: this.new_payment.amount_in_rs,
                    remarks: this.new_payment.remarks,
                    cn_no:this.new_payment.cn_no,
                    cn_type: this.new_payment.cn_type
                }
                this.btn_disabled=1;
                var result=confirm("Are you sure? Do you want to create CREDIT NOTE?");
                if(result){
                    axios.post('../retailer/order/create_credit_note',submit_data).then((response)=> {
                        //alert(response.data);
                        if(response.data==201){
                            alert("Credit Note has been Created!");
                            this.btn_disabled=0;
                            location.reload();
                        }
                        else if(response.data==402){
                            alert("Credit Note Number already exist!");
                        }
                    });
                }

            },
            enable_payment_details(){
                this.invoice_enabled=0;
            }

        }
    }
</script>
