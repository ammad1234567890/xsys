@extends('layouts.app')

@section('content')

                <div class="paddingmarginzero">
                    <h4 class="heading-inline">Weekly Inventory Updates
                        &nbsp;&nbsp;<small>For the week of March 16 - March 22, 2016</small>
                        &nbsp;&nbsp;</h4>

                    <div class="btn-group ">
                        <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                            <i class="fa fa-clock-o"></i>  &nbsp;
                            Change Week <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:;">March 16 - March 22, 2016</a></li>
                            <li><a href="javascript:;">March 16 - March 22, 2016</a></li>
                            <li><a href="javascript:;">March 16 - March 22, 2016</a></li>
                        </ul>
                    </div>
                </div>

                <br>

                <div class="row">

                    <div class="col-sm-6 col-md-3 paddingmarginzero">
                        <div class="row-stat">
                            <p class="row-stat-label">Inventory</p>
                            <h3 class="row-stat-value">Purchases</h3>
                            <span class="label label-success row-stat-badge">+43%</span>
                        </div> <!-- /.row-stat -->
                    </div> <!-- /.col -->

                    <div class="col-sm-6 col-md-3 paddingmarginzero">
                        <div class="row-stat">
                            <p class="row-stat-label">Inventory</p>
                            <h3 class="row-stat-value">Sales</h3>
                            <span class="label label-success row-stat-badge">+17%</span>
                        </div> <!-- /.row-stat -->
                    </div> <!-- /.col -->

                    <div class="col-sm-6 col-md-3 paddingmarginzero">
                        <div class="row-stat">
                            <p class="row-stat-label"> Inventory</p>
                            <h3 class="row-stat-value">Total</h3>
                            <span class="label label-success row-stat-badge">+26%</span>
                        </div> <!-- /.row-stat -->
                    </div> <!-- /.col -->

                    <div class="col-sm-6 col-md-3 paddingmarginzero">
                        <div class="row-stat">
                            <p class="row-stat-label">Currently Active Users</p>
                            <h3 class="row-stat-value">19</h3>
                            <span class="label label-danger row-stat-badge">+5%</span>
                        </div> <!-- /.row-stat -->
                    </div> <!-- /.col -->

                </div> <!-- /.row -->


                <br>

                <div class="row">

                    <div class=" col-md-2 paddingmarginzero">

                        <div class="col-md-6 paddingmarginzero"><label>Employee Name</label></div>
                        <div class="col-md-6 paddingmarginzero"><input type="text" class="textbox" /></div>





                    </div>

                    <div class=" col-md-1 paddingmarginzero">

                        <input type="date" class="textbox unstyled" />




                    </div>


                    <div class=" col-md-1 paddingmarginzero">


                        <select  class="textbox_dropdown">

                            <option>-select-</option>
                        </select>



                    </div>



                    <div class=" col-md-1 paddingmarginzero">


                        <input type="button" class="buttondesign" value="Click Me" data-toggle="modal" data-target="#exampleModal"/>


                    </div>




                </div>

                <div class="row">

                    <div class="col-md-8 paddingmarginzero">





                        <div class="portlet portlet-table">

                            <div class="portlet-header">

                                <h3>
                                    <i class="fa fa-group"></i>
                                    Recent Activities
                                </h3>

                                <ul class="portlet-tools pull-right">
                                    <li>
                                        <!--                  <button class="btn btn-sm btn-default">
                                                            Add User
                                                          </button>-->
                                    </li>
                                </ul>

                            </div> <!-- /.portlet-header -->

                            <div class="portlet-content">


                                <div class="table-responsive">

                                    <table id="user-signups" class="table table-striped table-bordered table-checkable">
                                        <thead>
                                        <tr>
                                            <th class="checkbox-column">
                                                <input type="checkbox" id="check-all" class="icheck-input" />
                                            </th>
                                            <th class="hidden-xs">First Name</th>
                                            <th>Last Name</th>
                                            <th>Status</th>
                                            <th class="text-center" style="width: 90px">Approve</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr>
                                            <td class="checkbox-column">
                                                <input type="checkbox" name="actiony" value="joey" class="icheck-input">
                                            </td>

                                            <td class="hidden-xs">Joey</td>
                                            <td>Greyson</td>
                                            <td><span class="label label-success">Approved</span></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="btn btn-xs btn-primary" data-original-title="Approve">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="checkbox-column">
                                                <input type="checkbox" name="actiony" value="wolf" class="icheck-input">
                                            </td>
                                            <td class="hidden-xs">Wolf</td>
                                            <td>Bud</td> <td><span class="label label-default">Pending</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="btn btn-xs btn-primary" data-original-title="Approve">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="checkbox-column">
                                                <input type="checkbox" name="actiony" value="sam" class="icheck-input">
                                            </td>

                                            <td class="hidden-xs">Sam</td>
                                            <td>Mitchell</td>
                                            <td><span class="label label-success">Approved</span></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="btn btn-xs btn-primary" data-original-title="Approve">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="checkbox-column">
                                                <input type="checkbox" value="carlos" name="actiony" class="icheck-input">
                                            </td>
                                            <td class="hidden-xs">Carlos</td>
                                            <td>Lopez</td>
                                            <td><span class="label label-success">Approved</span></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="btn btn-xs btn-primary" data-original-title="Approve">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="checkbox-column">
                                                <input type="checkbox" name="actiony" value="rob" class="icheck-input">
                                            </td>
                                            <td class="hidden-xs">Rob</td>
                                            <td>Johnson</td>
                                            <td><span class="label label-default">Pending</span></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="btn btn-xs btn-primary" data-original-title="Approve">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="checkbox-column">
                                                <input type="checkbox" value="mike" name="actiony" class="icheck-input">
                                            </td>
                                            <td class="hidden-xs">Mike</td>
                                            <td>Jones</td>
                                            <td><span class="label label-default">Pending</span></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="btn btn-xs btn-primary" data-original-title="Approve">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        </tbody>

                                    </table>


                                </div> <!-- /.table-responsive -->

                            </div> <!-- /.portlet-content -->

                            <div class="portlet-footer">
                                <div class="text-right">
                                    Apply to Selected: &nbsp;&nbsp;
                                    <select id="apply-selected" name="table-select" class="ui-select2" style="width: 125px">
                                        <option value="">Select Action</option>
                                        <option value="approve">Approve</option>
                                        <option value="edit">Edit</option>
                                        <option value="delete">Delete</option>

                                    </select>
                                </div>
                            </div> <!-- /.portlet-footer -->

                        </div> <!-- /.portlet -->

















                    </div> <!-- /.col -->



                    <div class="col-md-4 ">

                        <div class="portlet">

                            <div class="portlet-header">

                                <h3>
                                    <i class="fa fa-bar-chart-o"></i>
                                    Warehouse Inventory
                                </h3>

                            </div> <!-- /.portlet-header -->

                            <div class="portlet-content">


                                <!--    <img src="img/pie.png" />-->


                            </div> <!-- /.portlet-content -->

                        </div> <!-- /.portlet -->



                        <div class="portlet">

                            <div class="portlet-header">

                                <h3>
                                    <i class="fa fa-compass"></i>
                                    Overview
                                </h3>

                            </div> <!-- /.portlet-header -->

                            <div class="portlet-content">

                                <div class="progress-stat">

                                    <div class="progress-stat-label">
                                        % New Inventory
                                    </div> <!-- /.stat-label -->

                                    <div class="progress-stat-value">
                                        77.7%
                                    </div> <!-- /.stat-value -->

                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 77%">
                                            <span class="sr-only">77.74% Visit Rate</span>
                                        </div>
                                    </div> <!-- /.progress -->

                                </div> <!-- /.progress-stat -->


                                <div class="progress-stat">

                                    <div class="progress-stat-label">
                                        % Used Inventory
                                    </div> <!-- /.stat-label -->

                                    <div class="progress-stat-value">
                                        33.2%
                                    </div> <!-- /.stat-value -->

                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-tertiary" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%">
                                            <span class="sr-only">33% Process</span>
                                        </div>
                                    </div> <!-- /.progress -->

                                </div> <!-- /.progress-stat -->


                                <div class="progress-stat">

                                    <div class="progress-stat-label">
                                        Reject
                                    </div> <!-- /.stat-label -->

                                    <div class="progress-stat-value">
                                        42.7%
                                    </div> <!-- /.stat-value -->

                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-secondary" role="progressbar" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100" style="width: 42%">
                                            <span class="sr-only">42.7% Bounce Rate</span>
                                        </div>
                                    </div> <!-- /.progress -->

                                </div> <!-- /.progress-stat -->

                            </div> <!-- /.portlet-content -->

                        </div> <!-- /.portlet -->






                    </div> <!-- /.col -->

                </div> <!-- /.row -->

@endsection
