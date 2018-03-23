<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Xsys</title>

    <!-- Styles -->
    <!-- Bootstrap core CSS     -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!--  Material Dashboard CSS    -->
   <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300,700">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">

  <!-- App CSS -->
  <link rel="stylesheet" href="{{ asset('css/target-admin.css')}}">

  <!-- Datatable -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

  <link href="{{ asset('css/style.css')}}" rel="stylesheet" />





</head>
<body>
    <div id="app">
    <!--  -->
        <div class="navbar ">

            <div class="container paddingmarginzero fullwidth">

                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!--      <a class="navbar-brand navbar-brand-image" href="index.html">
                            <img src="img/logo.png" alt="Site Logo">
                          </a>-->

                </div> <!-- /.navbar-header -->

                <div class="navbar-collapse collapse">



                    <ul class="nav navbar-nav noticebar navbar-left">
                        <li class="smalltxt">
                            <a href="javascript:;">File</a>
                        </li>
                        <li class="smalltxt">
                            <a href="javascript:;">About</a>
                        </li>
                        <li class="smalltxt">
                            <a href="javascript:;">Setup</a>
                        </li>
                        <li class="smalltxt">
                            <a href="javascript:;">Roles</a>
                        </li>
                        <li class="smalltxt">
                            <a href="javascript:;">Status</a>
                        </li>
                        <li class="smalltxt">
                            <a href="javascript:;">Help</a>
                        </li>


                    </ul>















                    <ul class="nav navbar-nav navbar-right">



                        <li class="dropdown navbar-profile">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                                <img src="{{ asset('img/avatars/avatar-1-xs.jpg')}}" class="navbar-profile-avatar" alt="">
                                <span class="navbar-profile-label">rod@rod.me &nbsp;</span>
                                <i class="fa fa-caret-down"></i>
                            </a>

                            <ul class="dropdown-menu" role="menu">

                                <li>
                                    <a href="page-profile.html">
                                        <i class="fa fa-user"></i>
                                        &nbsp;&nbsp;My Profile
                                    </a>
                                </li>

                                <li>
                                    <a href="page-pricing.html">
                                        <i class="fa fa-dollar"></i>
                                        &nbsp;&nbsp;Plans &amp; Billing
                                    </a>
                                </li>

                                <li>
                                    <a href="page-settings.html">
                                        <i class="fa fa-cogs"></i>
                                        &nbsp;&nbsp;Settings
                                    </a>
                                </li>

                                <li class="divider"></li>

                                <li>
                                    <a href="login.html">
                                        <i class="fa fa-sign-out"></i>
                                        &nbsp;&nbsp;Logout
                                    </a>
                                </li>

                            </ul>

                        </li>

                    </ul>



                    <ul class="nav navbar-nav noticebar navbar-right  " style=" padding-right:50px;">



                        <li class="dropdown">
                            <a href="page-notifications.html" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell"></i>
                                <span class="navbar-visible-collapsed">&nbsp;Notifications&nbsp;</span>
                                <span class="badge">3</span>
                            </a>

                            <ul class="dropdown-menu noticebar-menu" role="menu">
                                <li class="nav-header">
                                    <div class="pull-left">
                                        Notifications
                                    </div>

                                    <div class="pull-right">
                                        <a href="javascript:;">Mark as Read</a>
                                    </div>
                                </li>

                                <li>
                                    <a href="page-notifications.html" class="noticebar-item">
                <span class="noticebar-item-image">
                  <i class="fa fa-cloud-upload text-success"></i>
                </span>
                                        <span class="noticebar-item-body">
                  <strong class="noticebar-item-title">Templates Synced</strong>
                  <span class="noticebar-item-text">20 Templates have been synced to the Mashon Demo instance.</span>
                  <span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 12 minutes ago</span>
                </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="page-notifications.html" class="noticebar-item">
                <span class="noticebar-item-image">
                  <i class="fa fa-ban text-danger"></i>
                </span>
                                        <span class="noticebar-item-body">
                  <strong class="noticebar-item-title">Sync Error</strong>
                  <span class="noticebar-item-text">5 Designs have been failed to be synced to the Mashon Demo instance.</span>
                  <span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 20 minutes ago</span>
                </span>
                                    </a>
                                </li>

                                <li class="noticebar-menu-view-all">
                                    <a href="page-notifications.html">View All Notifications</a>
                                </li>
                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="page-notifications.html" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="navbar-visible-collapsed">&nbsp;Messages&nbsp;</span>
                            </a>

                            <ul class="dropdown-menu noticebar-menu" role="menu">
                                <li class="nav-header">
                                    <div class="pull-left">
                                        Messages
                                    </div>

                                    <div class="pull-right">
                                        <a href="javascript:;">New Message</a>
                                    </div>
                                </li>

                                <li>
                                    <a href="page-notifications.html" class="noticebar-item">
                <span class="noticebar-item-image">
                  <!--<img src="img/avatars/avatar-1-md.jpg" style="width: 50px" alt="">-->
                </span>

                                        <span class="noticebar-item-body">
                  <strong class="noticebar-item-title">New Message</strong>
                  <span class="noticebar-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</span>
                  <span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 20 minutes ago</span>
                </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="page-notifications.html" class="noticebar-item">
                <span class="noticebar-item-image">
                 <!-- <img src="img/avatars/avatar-2-md.jpg" style="width: 50px" alt="">-->
                </span>

                                        <span class="noticebar-item-body">
                  <strong class="noticebar-item-title">New Message</strong>
                  <span class="noticebar-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</span>
                  <span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 5 hours ago</span>
                </span>
                                    </a>
                                </li>

                                <li class="noticebar-menu-view-all">
                                    <a href="page-notifications.html">View All Messages</a>
                                </li>
                            </ul>
                        </li>


                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-exclamation-triangle"></i>
                                <span class="navbar-visible-collapsed">&nbsp;Alerts&nbsp;</span>
                            </a>

                            <ul class="dropdown-menu noticebar-menu noticebar-hoverable" role="menu">
                                <li class="nav-header">
                                    <div class="pull-left">
                                        Alerts
                                    </div>
                                </li>

                                <li class="noticebar-empty">
                                    <h4 class="noticebar-empty-title">No alerts here.</h4>
                                    <p class="noticebar-empty-text">Check out what other makers are doing on Explore!</p>
                                </li>
                            </ul>
                        </li>


                    </ul>



                </div> <!--/.navbar-collapse -->

            </div> <!-- /.container -->

        </div> <!-- /.navbar -->
        <div class="mainbar">

            <div class="container fullwidth">

                <button type="button" class="btn mainbar-toggle" data-toggle="collapse" data-target=".mainbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>

                <div class="col-md-5 paddingmarginzero logo"  >
                    <a href="index.html"><img src="{{ asset('img/logo.png')}}" /></a>
                </div>
                <div class="col-md-7">
                    <div class="mainbar-collapse collapse">

                        <ul class="nav navbar-nav mainbar-nav navbar-right">

                            <li class="active">
                                <a href="index.html">
                                    <i class="fa fa-dashboard"></i>
                                    Dashboard
                                </a>
                            </li>

                            <li class="dropdown ">
                                <a href="#about" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                    <i class="fa fa-desktop"></i>
                                    Inventory
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="ui-buttons.html"><i class="fa fa-user nav-icon"></i> Menu</a></li>
                                    <li><a href="ui-tabs.html"><i class="fa fa-bars nav-icon"></i> Menu</a></li>
                                    <li><a href="ui-notifications.html"><i class="fa fa-asterisk nav-icon"></i> Menu</a></li>
                                    <li><a href="ui-sliders.html"><i class="fa fa-tasks nav-icon"></i> Menu</a></li>
                                    <li><a href="ui-typography.html"><i class="fa fa-font nav-icon"></i> Menu</a></li>
                                    <li><a href="ui-portlets.html"><i class="fa fa-list-alt nav-icon"></i> Menu</a></li>


                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">
                                            <i class="fa fa-bar-chart-o"></i>
                                            &nbsp;&nbsp;Sub Menu
                                        </a>

                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="ui-chart-flot.html">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                    &nbsp;&nbsp;Menu
                                                </a>
                                            </li>

                                            <li>
                                                <a href="ui-chart-morris.html">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                    &nbsp;&nbsp;Menu
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>

                            <li class="dropdown ">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                    <i class="fa fa-align-left"></i>
                                    Approval
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li class="dropdown-header">Menu</li>

                                    <li>
                                        <a href="ui-form-regular.html">
                                            <i class="fa fa-location-arrow nav-icon"></i>
                                            Menu
                                        </a>
                                    </li>

                                    <li>
                                        <a href="ui-form-extended.html">
                                            <i class="fa fa-bolt nav-icon"></i>
                                            Menu
                                        </a>
                                    </li>

                                    <li>
                                        <a href="ui-form-validation.html">
                                            <i class="fa fa-check nav-icon"></i>
                                            Menu
                                        </a>
                                    </li>

                                    <li class="divider"></li>

                                    <li class="dropdown-header">Menu</li>

                                    <li>
                                        <a href="ui-table-basic.html">
                                            <i class="fa fa-table"></i>
                                            &nbsp;&nbsp;Menu
                                        </a>
                                    </li>

                                    <li>
                                        <a href="ui-table-advanced.html">
                                            <i class="fa fa-table"></i>
                                            &nbsp;&nbsp;Menu
                                        </a>
                                    </li>

                                    <li>
                                        <a href="ui-table-responsive.html">
                                            <i class="fa fa-table"></i>
                                            &nbsp;&nbsp;Menu
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown ">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                    <i class="fa fa-files-o"></i>
                                    Update
                                    <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a href="page-profile.html"><i class="fa fa-user nav-icon"></i> Menu</a></li>
                                    <li><a href="page-invoice.html"><i class="fa fa-money nav-icon"></i> Menu</a></li>
                                    <li><a href="page-pricing.html"><i class="fa fa-dollar nav-icon"></i> Pricing Plans</a></li>
                                    <li><a href="page-support.html"><i class="fa fa-question nav-icon"></i> Menu</a></li>
                                    <li><a href="page-gallery.html"><i class="fa fa-picture-o nav-icon"></i> Menu</a></li>
                                    <li><a href="page-settings.html"><i class="fa fa-cogs nav-icon"></i> Menu</a></li>
                                    <li><a href="page-calendar.html"><i class="fa fa-calendar nav-icon"></i> Menu</a></li>
                                </ul>
                            </li>

                            <li >
                                <a href="#contact" >
                                    <i class="fa fa-external-link"></i>
                                    Reports
                                </a>


                            </li>

                        </ul>

                    </div> <!-- /.navbar-collapse -->
                </div>
            </div> <!-- /.container -->

        </div> <!-- /.mainbar -->
        <div class="container fullwidth">

            <div class="content">

                <div class="row">
                    <div class=" col-md-2 " >
                        <div class="verticalmenu text-center">
                            <h3 class="h2box ">Modules</h3>




                            <div class="menutab active">
                                <a href="{{ url('home') }}">
                                    <div class="menuitem cursorpointer" >
                                        <img src="{{ asset('img/ic_dashboard.png')}}" alt="dashboard" /><br />
                                        Dashboard
                                    </div>
                                </a>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/ic_practicesetup.png')}}" alt="dashboard" /><br />
                                    Catalogue
                                </div>
                                <ul class="collapse " id="collapseExample2">
                                    <a href="{{ url('category') }}">
                                        <li> Category Management</li>
                                    </a>
                                    <a href="{{ url('product') }}">
                                        <li> Product Management</li>
                                    </a>
                                    <a href="{{ url('importIMEI') }}">
                                        <li> Import IMEI</li>
                                    </a>
                                </ul>
                            </div>


                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample3" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/ic_practicesetup.png')}}" alt="dashboard" /><br />
                                    Purchase Orders
                                </div>
                                <ul class="collapse " id="collapseExample3">
                                    <a href="{{ url('order/create') }}">
                                        <li> Create Order</li>
                                    </a>
                                    <a href="{{ url('order/all_orders') }}">
                                        <li> Orders</li>
                                    </a>
                                    <a href="{{ url('order/receive') }}">
                                        <li> New Shipment</li>
                                    </a>
                                    <a href="{{ url('order/payment') }}">
                                        <li> PO Payment</li>
                                    </a>
                                    <a href="{{ url('order/received_orders') }}">
                                        <li> Received Orders</li>
                                    </a>
                                </ul>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample4" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/ic_practicesetup.png')}}" alt="dashboard" /><br />
                                    Staff
                                </div>
                                <ul class="collapse " id="collapseExample4">
                                    <a href="{{ url('staff') }}">
                                        <li>Staff Management </li>
                                    </a>

                                </ul>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample5" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/ic_practicesetup.png')}}" alt="dashboard" /><br />
                                    Outlets
                                </div>
                                <ul class="collapse " id="collapseExample5">
                                    <a href="{{ url('/retailer') }}">
                                        <li>Dealer </li>
                                    </a>
                                    <a href="{{ url('retailer/create_order') }}">
                                        <li>Create Supply Order </li>
                                    </a>

                                    <a href="{{ url('retailer_order/orders') }}">
                                        <li>Supply Orders </li>
                                    </a>


                                </ul>
                            </div>

                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/ic_practicesetup.png')}}" alt="dashboard" /><br />
                                    Finance
                                </div>
                                <ul class="collapse " id="collapseExample6">
                                    <a href="{{ url('finance/orders_approval') }}">
                                        <li>Orders Approval </li>
                                    </a>
                                    <a href="{{ url('/invoice/list/') }}">
                                        <li>Invoice History </li>
                                    </a>

                                    <a href="{{ url('warehouseStock') }}">
                                        <li>Stock Report </li>
                                    </a>

                                    <a href="{{url('/retailer_order/payment')}}">
                                        <li>Receive Payment </li>
                                    </a>

                                    <a href="{{url('/bank')}}">
                                        <li>Registered Banks </li>
                                    </a>

                                    <a href="{{url('/ledger')}}">
                                        <li>Ledger </li>
                                    </a>

                                </ul>
                            </div>

                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample7" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/ic_practicesetup.png')}}" alt="dashboard" /><br />
                                    Warehouse
                                </div>
                                <ul class="collapse " id="collapseExample7">
                                    <a href="{{ url('createNewWarehouse') }}">
                                        <li>Create Warehouse </li>
                                    </a>
                                    <a href="{{ url('warehouse') }}">
                                        <li>Warehouse </li>
                                    </a>
                                    <a href="{{ url('warehouseStaff') }}">
                                        <li>Allocate Staff </li>
                                    </a>
                                    <a href="{{ url('warehouseStaffView') }}">
                                        <li>Warehouse Staff </li>
                                    </a>

                                    <a href="{{ url('mainWarehouseReceive') }}">
                                        <li>Warehouse Receive</li>
                                    </a>

                                    <a href="{{ url('warehouseIssue') }}">
                                        <li>Sales Invoice </li>
                                    </a>
                                </ul>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample8" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/ic_practicesetup.png')}}" alt="dashboard" /><br />
                                    Report
                                </div>
                                <ul class="collapse " id="collapseExample8">
                                    <a href="#">
                                        <li>Finance Report </li>
                                    </a>

                                </ul>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample9" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/ic_practicesetup.png')}}" alt="dashboard" /><br />
                                    Access Control
                                </div>
                                <ul class="collapse " id="collapseExample9">
                                    <a href="{{ url('access') }}">
                                        <li>Access </li>
                                    </a>
                                    <a href="{{ url('userrole') }}">
                                        <li>User Role</li>
                                    </a>


                                </ul>
                            </div>
                            <div class="menutab active">
                                <a href="{{ url('general') }}">
                                    <div class="menuitem cursorpointer" >
                                        <img src="{{ asset('img/ic_practicesetup.png')}}" alt="dashboard" /><br />
                                        Miscellaneous
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 " style=" background:#fff;">
                        <div class="content-container ">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>


    <!-- Scripts -->
    <footer class="footer">

        <div class="container">

            <div class="row">

                <div class="col-sm-3">

                    <h4>About us</h4>

                    <br>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>

                    <hr>

                    <p>&copy; 2018 Blade.</p>

                </div> <!-- /.col -->

                <div class="col-sm-3">

                    <h4>Support</h4>

                    <br>

                    <ul class="icons-list">
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">Frequently Asked Questions</a>
                        </li>
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">Ask a Question</a>
                        </li>
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">Video Tutorial</a>
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">Feedback</a>
                        </li>
                    </ul>

                </div> <!-- /.col -->

                <div class="col-sm-3">

                    <h4>Legal</h4>

                    <br>

                    <ul class="icons-list">
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">License</a>
                        </li>
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">Terms of Use</a>
                        </li>
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">Privacy Policy</a>
                        </li>
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">Security</a>
                        </li>
                    </ul>

                </div> <!-- /.col -->

                <div class="col-sm-3">

                    <h4>Site Map</h4>

                    <br>

                    <ul class="icons-list">
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">Inventory</a>
                        </li>
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">Inventory</a>
                        </li>
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">Inventory</a>
                        </li>
                        <li>
                            <i class="fa fa-angle-double-right icon-li"></i>
                            <a href="javascript:;">Inventory</a>
                        </li>
                    </ul>

                </div> <!-- /.col -->

            </div> <!-- /.row -->

        </div> <!-- /.container -->

    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/prettify.js') }}"></script>
  <script src="{{ asset('js/accounting.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>






</body>
</html>
