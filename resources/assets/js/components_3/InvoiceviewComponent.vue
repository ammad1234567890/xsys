<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Invoice</h3>
                            </div>
                            <div class="card-content card-padding">
                                <div class="m-b-20">
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4> Amazon Delivery <br>
                                    <br>
                                    <img id="invoice-logo" v-bind:src="'./img/'+image"  alt="Company Logo"> </h4>
                                                <address>
                                  1234 Silver Gate Avenue, Suite 430 <br>
                                  San Francisco, CA, 94118 <br>
                                  <abbr title="Mail">E-mail:</abbr>&nbsp;&nbsp;example@company.com <br>
                                  <abbr title="Phone">Phone:</abbr>&nbsp;&nbsp;(123) 456-7890 <br>
                                  <abbr title="Fax">Fax:</abbr>&nbsp;&nbsp;800-692-7753 <br>
                                  <br>
                                  </address>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <h4>Invoice Info</h4>
                                                <p> <a class="font-size-20" href="javascript:void(0)">E1234-567-89</a> <br>
                                                    <span class="font-size-20">Robert Taylor</span> </p>
                                                <address>
                                  5678 Golden Gate Avenue, Suite 101 <br>
                                  San Francisco, CA, 94118 <br>
                                  <abbr title="Phone">P:</abbr>&nbsp;&nbsp;(123) 456-7890 <br>
                                  </address>
                                                <span>Invoice Date: March 12, 2016</span> <br>
                                                <span>Due Date: March 15, 2016</span> <br>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped text-right">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Description</th>
                                                        <th class="text-right">Quantity</th>
                                                        <th class="text-right">Unit Cost</th>
                                                        <th class="text-right">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td class="text-left">Dell Laptop</td>
                                                        <td>35</td>
                                                        <td>$400.00</td>
                                                        <td>$25,000.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">2</td>
                                                        <td class="text-left">Samsung CF591 Series Curved 27-Inch Monitor</td>
                                                        <td>21</td>
                                                        <td>$100.00</td>
                                                        <td>$2,100.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">3</td>
                                                        <td class="text-left">NETGEAR AC750 WiFi Range Extender</td>
                                                        <td>58</td>
                                                        <td>$59.00</td>
                                                        <td>$1,563.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">4</td>
                                                        <td class="text-left">TP-LINK Archer C7 AC1750 Wireless</td>
                                                        <td>231</td>
                                                        <td>$40.00</td>
                                                        <td>$2,281.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right clearfix">
                                            <div class="pull-right">
                                                <p> Sub - Total amount: <strong><span>$35,400.00</span></strong> </p>
                                                <p> VAT: <strong><span>$123.00</span></strong> </p>
                                                <p class="page-invoice-amount"> <strong>Grand Total: <span>$35,523.00</span></strong> </p>
                                                <br>
                                            </div>
                                        </div>
                                        <hr>
                                        <p class="small hint-text">Services will be invoiced in accordance with the Service Description. You must pay all undisputed invoices in full within 30 days of the invoice date, unless otherwise specified under the Special Terms and Conditions.
                                            All payments must reference the invoice number. Unless otherwise specified, all invoices shall be paid in the currency of the invoice</p>
                                        <p class="small hint-text">Insight retains the right to decline to extend credit and to require that the applicable purchase price be paid prior to performance of Services based on changes in insight's credit policies or your financial
                                            condition and/or payment record. Insight reserves the right to charge interest of 1.5% per month or the maximum allowable by applicable law, whichever is less, for any undisputed past due invoices. You are
                                            responsible for all costs of collection, including reasonable attorneys' fees, for any payment default on undisputed invoices. In addition, Insight may terminate all further work if payment is not received
                                            in a timely manner.</p>
                                        <hr>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary"> <i class="icmn-checkmark margin-right-5"></i> Proceed to payment </button>
                                            <button type="button" class="btn btn-default" onClick="javascript:window.print();"> <i class="icmn-printer margin-right-5"></i> Print </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                image:'logo_placeholder.png',
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
