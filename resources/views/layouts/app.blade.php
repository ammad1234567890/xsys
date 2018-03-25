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
    <link rel="shortcut icon" href="{{asset('img/icon.ico')}}"/>
    <!-- Datatable -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

  <link href="{{ asset('css/style.css')}}" rel="stylesheet" />

    <style>
        .modal-backdrop{
            display:none;
        }
        .modal-content{
            margin-top:76px;
        }
        .modal-header .close{
            margin-top:-9px;
        }
    </style>



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
                                <span style="    color: #fff;
    font-size: 14px;
    margin-right: 15px;">Welcome: {{ Auth::user()->name }}</span>
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

                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out"></i>
                                            &nbsp;&nbsp;Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>


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

                <div class="col-md-4 paddingmarginzero logo"  >
                    <a href="{{url('/home')}}"><img src="{{ asset('img/xsyslogo.png')}}" width="160px" style="margin-top:-9px;"/></a>
                </div>
                <div class="col-md-8">
                    <div class="mainbar-collapse collapse">

                        <ul class="nav navbar-nav mainbar-nav navbar-right">

                            <li class="active">
                                <a href="{{url('/home')}}">
                                    <img src="{{ asset('img/dashb-white.png')}}" alt="dashboard" width="35px" />
                                    <br/>
                                    Dashboard
                                </a>
                            </li>
                            <li class="dropdown ">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                    <img src="{{ asset('img/e-learning-white.png')}}" alt="dashboard" width="35px" />
                                    <br/>
                                    Catalogue
                                    <span class="caret"></span>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ url('category') }}">
                                             Create Category
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('showCategory') }}">
                                            Category List
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('product') }}">
                                             Create Product
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('showproduct') }}">
                                             Products List
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('importIMEI') }}">
                                            Import IMEI
                                        </a>
                                    </li>
                                </ul>

                            </li>
                            <li class="dropdown ">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                    <img src="{{ asset('img/four-blocks-cube-white.png')}}" alt="dashboard" width="35px" />
                                    <br/>
                                    Purchase Orders
                                    <span class="caret"></span>

                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('order/create') }}">Create Order</a></li>
                                    <li><a href="{{ url('order/all_orders') }}">Orders Detail</a></li>
                                    <li><a href="{{ url('order/receive') }}">New Shipment</a></li>
                                    <li><a href="{{ url('order/payment') }}">PO Payment</a></li>
                                    <li><a href="{{ url('order/received_orders') }}">Received Orders</a></li>
                                </ul>

                            </li>
                            <li class="dropdown ">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                    <img src="{{ asset('img/hotel-staff-white.png')}}" alt="dashboard" width="35px" />
                                    <br/>
                                    Staff
                                    <span class="caret"></span>

                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/staff') }}">Create Staff</a></li>
                                </ul>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/viewStaff') }}">Staff List</a></li>
                                </ul>

                            </li>
                            <li class="dropdown ">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                    <img src="{{ asset('img/store-white.png')}}" alt="dashboard" width="35px" />
                                    <br/>
                                    Outlets
                                    <span class="caret"></span>

                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('/retailer')}}">Create Dealer Account</a></li>
                                    <li><a href="{{url('/retailer_list')}}">Dealers List</a></li>
                                    <li><a href="{{url('/retailer/create_order')}}">Create Supply Order</a></li>
                                    <li><a href="{{url('/retailer_order/orders')}}">Supply Order Detail</a></li>
                                </ul>

                            </li>
                            <li class="dropdown ">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                    <img src="{{ asset('img/bars-white.png')}}" alt="dashboard" width="35px" />
                                    <br/>
                                    Finance
                                    <span class="caret"></span>

                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{url('finance/orders_approval')}}">Orders Approval</a></li>
                                    <li><a href="{{ url('/invoice/list/') }}">Invoice History</a></li>
                                    <li><a href="{{ url('warehouseStock') }}">Stock Report</a></li>
                                    <li><a href="{{url('/retailer_order/payment')}}">Receive Payment</a></li>
                                    <li><a href="{{url('/bank')}}">Registered Banks</a></li>
                                    <li><a href="{{url('/ledger')}}">Ledger</a></li>
                                </ul>

                            </li>
                            <li class="dropdown ">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                    <img src="{{ asset('img/factory-stock-house-white.png')}}" alt="dashboard" width="35px" />
                                    <br/>
                                    Warehouse
                                    <span class="caret"></span>

                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('createNewWarehouse') }}">Create Warehouse</a></li>
                                    <li><a href="{{ url('warehouse') }}">Warehouse List</a></li>
                                    <li><a href="{{ url('warehouseStaff') }}">Allocate Staff</a></li>
                                    <li><a href="{{ url('warehouseStaffView') }}">Warehouse Staff</a></li>
                                    <li><a href="{{ url('mainWarehouseReceive') }}">Warehouse Receive</a></li>
                                    <li><a href="{{ url('warehouseIssue') }}">Sales Invoice</a></li>
                                </ul>

                            </li>
                            <li class="dropdown ">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                    <img src="{{ asset('img/newspaper-white.png')}}" alt="dashboard" width="35px" />
                                    <br/>
                                    Reports
                                    <span class="caret"></span>

                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Finance Report</a></li>

                                </ul>

                            </li>

                        </ul>

                    </div> <!-- /.navbar-collapse -->
                </div>
            </div> <!-- /.container -->

        </div> <!-- /.mainbar -->
        <div class="container fullwidth">

            <div class="content">

                <div class="row">
                    <div class=" col-md-2 " style="border-right: 1px solid #dadada;">
                        <div class="verticalmenu text-center">
                            <h3 class="h2box ">Modules</h3>
                            <div class="menutab active">
                                <a href="{{ url('home') }}">
                                    <div class="menuitem cursorpointer" >
                                        <img src="{{ asset('img/dashb.png')}}" alt="dashboard" width="40px" /><br />
                                        Dashboard
                                    </div>
                                </a>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/e-learning.png')}}" alt="dashboard" style="width:40px;"/><br />
                                    Catalogue
                                </div>
                                <ul class="collapse " id="collapseExample2">
                                    <a href="{{ url('category') }}">
                                        <li> Create Category</li>
                                    </a>
                                    <a href="{{ url('showCategory') }}">
                                        <li> Category List</li>
                                    </a>
                                    <a href="{{ url('product') }}">
                                        <li> Create Product</li>
                                    </a>
                                    <a href="{{ url('showproduct') }}">
                                        <li> Products List </li>
                                    </a>
                                    <a href="{{ url('importIMEI') }}">
                                        <li> Import IMEI</li>
                                    </a>
                                </ul>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample3" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/four-blocks-cube.png')}}" alt="dashboard" style="width:40px;"/><br />
                                    Purchase Orders
                                </div>
                                <ul class="collapse " id="collapseExample3">
                                    <a href="{{ url('order/create') }}">
                                        <li> Create Order</li>
                                    </a>
                                    <a href="{{ url('order/all_orders') }}">
                                        <li> Orders List</li>
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
                                    <img src="{{ asset('img/hotel-staff.png')}}" alt="dashboard" width="40px" /><br />
                                    Staff
                                </div>
                                <ul class="collapse " id="collapseExample4">
                                    <a href="{{ url('staff') }}">
                                        <li>Create Staff</li>
                                    </a>
                                    <a href="{{ url('viewStaff') }}">
                                        <li>Staff List</li>
                                    </a>

                                </ul>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample5" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/store.png')}}" alt="dashboard" width="40px"/><br />
                                    Outlets
                                </div>
                                <ul class="collapse " id="collapseExample5">
                                    <a href="{{ url('/retailer') }}">
                                        <li>Create Dealer Account</li>
                                    </a>
                                    <a href="{{ url('/retailer_list') }}">
                                        <li>Dealers List </li>
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
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample7" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/factory-stock-house.png')}}" alt="dashboard" width="40px"/><br />
                                    Warehouse
                                </div>
                                <ul class="collapse " id="collapseExample7">
                                    <a href="{{ url('createNewWarehouse') }}">
                                        <li>Create Warehouse </li>
                                    </a>
                                    <a href="{{ url('warehouse') }}">
                                        <li>Warehouse List</li>
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
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample6" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/bars.png')}}" alt="dashboard" width="40px"/><br />
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
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample8" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/newspaper.png')}}" alt="dashboard" width="40px" /><br />
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
                                    <img src="{{ asset('img/key.png')}}" alt="dashboard" width="40px"/><br />
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
                                        <img src="{{ asset('img/eye.png')}}" alt="dashboard" width="40px"/><br />
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
