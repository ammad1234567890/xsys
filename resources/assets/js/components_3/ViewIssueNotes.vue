<template>


    <div class="row">
        <div class=" col-md-12 paddingmarginzero">
            <div class="paddingmarginzero">
                <h4 class="heading-inline">All Issue Notes</h4>
            </div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#non-approved">Non-Approved</a></li>
                <li><a data-toggle="tab" href="#approved">Approved</a></li>
            </ul>

            <div class="tab-content">
                <div id="non-approved" class="tab-pane fade in active">
                    <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="col-md-5 paddingmarginzero ">
                        Non-Approved WIN
                    </div>
                    <div class="col-md-6  text-right">

                    </div>  &nbsp;
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet portlet-table">
                                <div class="portlet-content">
                                    <div class="table-responsive">
                                        <table id="non-approved-win" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <td>S.no</td>
                                                    <td>From</td>
                                                    <td>To</td>
                                                    <td>Status</td>
                                                    <td>Date</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(issue_note, index) in non_approved_issue_notes">
                                                    <td>{{index+1}}</td>
                                                    <td>{{issue_note.warehouse_from.name}}</td>
                                                    <td>{{issue_note.warehouse_to.name}}</td>
                                                    <td><i class="fa fa-spinner"></i> </td>
                                                    <td>{{issue_note.created_at | moment}}</td>
                                                    <td><button v-on:click="show_products(index)">Products</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
                <div id="approved" class="tab-pane">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="col-md-5 paddingmarginzero ">
                                Approved WIN
                            </div>
                            <div class="col-md-6  text-right">

                            </div>  &nbsp;
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="portlet portlet-table">
                                        <div class="portlet-content">
                                            <div class="table-responsive">
                                                <table id="approved-win" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <td>S.no</td>
                                                        <td>From</td>
                                                        <td>To</td>
                                                        <td>Status</td>
                                                        <td>Approved By</td>
                                                        <td>Date</td>
                                                        <td>Action</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(issue_note, index) in approved_issue_notes">
                                                        <td>{{index+1}}</td>
                                                        <td>{{issue_note.warehouse_from.name}}</td>
                                                        <td>{{issue_note.warehouse_to.name}}</td>
                                                        <td><i class="fa fa-check"></i> </td>
                                                        <td>{{issue_note.approved_by.name}}</td>
                                                        <td>{{issue_note.created_at | moment}}</td>
                                                        <td><button v-on:click="show_product_approve(index)">Products</button></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
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
        <!-- View Details Modal Start-->
        <div class="modal fade bs-add-Model-modal-md" tabindex="5" role="dialog"  id="issue_note_info_modal" aria-labelledby="bs-add-Model-modal-md">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Summary - Issue Note</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <h5><b>Date:</b> {{created_date | moment}}</h5>
                                <h5><b>From:</b> {{from_warehouse}} <span style="float:right;"><b>To:</b> {{to_warehouse}}</span></h5>

                                <hr/>
                                <h4>Issued Stock Details</h4>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Model</td>
                                        <td>Color</td>
                                        <td>Qty</td>
                                        <td>Unit Price(PKR)</td>
                                            
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="products in all_products.transfer_products">
                                        <td>{{products.product.name}}</td>
                                        <td>{{products.product_color.color}}</td>
                                        <td style="text-align:right;">{{products.quantity}}</td>
                                        <td style="text-align:right;">{{products.price | currency(' ')}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-github" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- View Details Modal END -->

    </div>
</template>
<script>
    export default {
        data() {
            return {
                list_of_issue_notes:[],
                non_approved_issue_notes:[],
                approved_issue_notes:[],
                from_warehouse:'',
                to_warehouse:'',
                created_date:'',
                all_products:[]

            }
        },
        mounted() {
            console.log('Component mounted.44')
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
        created() {
            axios.get('./get_issue_notes').then(response => {
                this.list_of_issue_notes = response.data;
                for(var i=0; i<response.data.length; i++){
                    if(response.data[i].is_approved==1){
                        this.approved_issue_notes.push(response.data[i]);
                    }
                    else{
                        this.non_approved_issue_notes.push(response.data[i]);
                    }
                }
            });
        },
        methods: {
            show_products:function(index){
               // alert(index);
                this.all_products=this.non_approved_issue_notes[index];
                this.from_warehouse=this.non_approved_issue_notes[index].warehouse_from.name;
                this.to_warehouse=this.non_approved_issue_notes[index].warehouse_to.name;
                this.created_date=this.non_approved_issue_notes[index].created_at;
                $('#issue_note_info_modal').modal('show');
            },

            show_product_approve:function(index){
                this.all_products=this.approved_issue_notes[index];
                this.from_warehouse=this.approved_issue_notes[index].warehouse_from.name;
                this.to_warehouse=this.approved_issue_notes[index].warehouse_to.name;
                this.created_date=this.approved_issue_notes[index].created_at;
                $('#issue_note_info_modal').modal('show');
            }

        }
    }
</script>