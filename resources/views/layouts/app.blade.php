<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Xcell') }}</title>

    <!-- Styles -->
    <!-- Bootstrap core CSS     -->
    <!-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" /> -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!--  Material Dashboard CSS    -->
    <link href="{{ asset('css/turbo.css') }}" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <!--     Custom css    -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />




</head>
<body>
    <div id="app">
    <div class="wrapper">
        <div class="sidebar" data-background-color="gray">
            <div class="logo">
                <a href="{{ url('home') }}" class="simple-text">
                    <img src="{{ asset('img/logo.png') }}" width="130px" alt="BLADE logo">
                </a>
            </div>
            <div class="logo logo-mini">
                <a href="{{ url('home') }}" class="simple-text">
                    <img src="{{ asset('img/collapse-logo.png') }}" width="25px" alt="B">
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li>
                        <a href="{{ url('home') }}">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#catalogue" class="collapsed" aria-expanded="false">
                            <i class="material-icons">dvr</i>
                            <p>Catalogue
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="catalogue" aria-expanded="false" style="height: 0px;">
                            <ul class="nav">
                                <li>
                                    <a href="{{ url('category') }}">Category Management</a>
                                </li>
                                <li>
                                    <a href="{{ url('product') }}">Product Management</a>
                                </li>
                                <li>
                                    <a href="{{ url('mainWarehouseReceive') }}">Import IMEI</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#orders" class="collapsed" aria-expanded="false">
                            <i class="material-icons">receipt</i>
                            <p>Manufacture Orders
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="orders" aria-expanded="false" style="height: 0px;">
                            <ul class="nav">
                                <li>
                                    <a href="{{ url('order/all_orders') }}">Orders</a>
                                </li>
                                <li>
                                    <a href="{{ url('order/create') }}">Create Orders</a>
                                </li>
                                <li>
                                    <a href="{{ url('order/receive') }}">Receive New Order</a>
                                </li>
                                <li>
                                    <a href="{{ url('order/payment') }}">Orders Payment</a>
                                </li>
                                <li>
                                    <a href="{{ url('order/received_orders') }}">Received Orders</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#staff" class="collapsed" aria-expanded="false">
                            <i class="material-icons">assignment_ind</i>
                            <p>Staff
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="staff" aria-expanded="false" style="height: 0px;">
                            <ul class="nav">
                                <li>
                                    <a href="{{ url('staff') }}">Staff Management</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#warehouse" class="collapsed" aria-expanded="false">
                            <i class="material-icons">store</i>
                            <p>Warehouse
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="warehouse" aria-expanded="false" style="height: 0px;">
                            <ul class="nav">
                                <li>
                                    <a href="{{ url('warehouse') }}">Warehouse Management</a>
                                </li>
                                <li>
                                    <a href="{{ url('warehouseStaff') }}">Warehouse Staff</a>
                                </li>
                                <li>
                                    <a href="{{ url('mainWarehouseReceive') }}">Warehouse Receive</a>
                                </li>
                                <li>
                                    <a href="{{ url('warehouseIssue') }}">Warehouse Issue</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#retailerorder" class="collapsed" aria-expanded="false">
                            <i class="material-icons">description</i>
                            <p>Retailer Orders
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="retailerorder" aria-expanded="false" style="height: 0px;">
                            <ul class="nav">
                                <li>
                                    <a href="{{ url('/retailer') }}">Retailer</a>
                                </li>
                                <li>
                                    <a href="{{ url('/retailer/outlets') }}">Retailer Outlets</a>
                                </li>
                                <li>
                                    <a href="{{ url('retailer/create_order') }}">Create Retailer order</a>
                                </li>
                                <li>
                                    <a href="{{ url('retailer_order/orders') }}">Order Detail</a>
                                </li>
                                <li>
                                    <a href="{{ url('retailer_order/payment') }}">Order Payment</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#finance" class="collapsed" aria-expanded="false">
                            <i class="material-icons">account_balance</i>
                            <p>Finance
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="finance" aria-expanded="false" style="height: 0px;">
                            <ul class="nav">
                                <li>
                                    <a href="#">Invoice detail</a>
                                </li>
                                <li>
                                    <a href="#">Create Invoice</a>
                                </li>
                                <li>
                                    <a href="#">Collection</a>
                                </li>
                                <li>
                                    <a href="#">Bank</a>
                                </li>
                                <li>
                                    <a href="#">Ledger</a>
                                </li>
                                <li>
                                    <a href="{{ url('finance/orders_approval') }}">Orders Approval</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#reports" class="collapsed" aria-expanded="false">
                            <i class="material-icons">multiline_chart</i>
                            <p>Reports
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="reports" aria-expanded="false" style="height: 0px;">
                            <ul class="nav">
                                <li>
                                    <a href="#">Finance Report</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a data-toggle="collapse" href="#accesscontrol" class="collapsed" aria-expanded="false">
                            <i class="material-icons">lock</i>
                            <p>Access Control
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="accesscontrol" aria-expanded="false" style="height: 0px;">
                            <ul class="nav">
                                <li>
                                    <a href="{{ url('access') }}">Access</a>
                                </li>
                                <li>
                                    <a href="{{ url('userrole') }}">User Role</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="{{ url('general') }}">
                            <i class="material-icons">rounded_corner</i>
                            <p>Others</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-default navbar-absolute" data-topbar-color="default">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular f-26">keyboard_arrow_left</i>
                            <i class="material-icons visible-on-sidebar-mini f-26">keyboard_arrow_right</i>
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> XCELL
                        </a>

                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">

                            @guest
                                <li><a href="{{ route('login') }}"><i class="material-icons">fingerprint</i> Login</a></li>
                                <li><a href="{{ route('register') }}"><i class="material-icons">person_add</i> Register</a></li>
                            @else

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">5</span>
                                    <p class="hidden-lg hidden-md">
                                        Notifications
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Mike John responded to your email</a>
                                    </li>
                                    <li>
                                        <a href="#">You have 5 new tasks</a>
                                    </li>
                                    <li>
                                        <a href="#">You're now friend with Andrew</a>
                                    </li>
                                    <li>
                                        <a href="#">Another Notification</a>
                                    </li>
                                    <li>
                                        <a href="#">Another One</a>
                                    </li>
                                </ul>
                            </li>


                            

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">person</i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#"><i class="material-icons">settings</i> Settings</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="material-icons">exit_to_app</i>
                                            Logout
                                        </a>
        
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            @endguest
                            </li>
                            <li class="separator hidden-lg hidden-md"></li>
                        </ul>
                    </div>
                </div>
            </nav>
             @yield('content')

        </div>
    </div>

</div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="{{ asset('vendors/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
         -->    <script src="{{ asset('vendors/jquery-ui.min.js') }}" type="text/javascript"></script>
   <!--  <script src="{{ asset('vendors/bootstrap.min.js') }}" type="text/javascript"></script> -->
    <script src="{{ asset('vendors/material.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>

        <!-- Forms Validations Plugin -->
    <script src="{{ asset('vendors/jquery.validate.min.js') }}"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="{{ asset('vendors/moment.min.js') }}"></script>
    <!--  Charts Plugin -->
    <script src="{{ asset('vendors/chartist.min.js') }}"></script>
    <script src="{{ asset('vendors/charts/chartjs/Chart.min.js') }}"></script>

    <!--  Plugin for the Wizard -->
    <script src="{{ asset('vendors/jquery.bootstrap-wizard.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('vendors/bootstrap-notify.js') }}"></script>
    <!-- DateTimePicker Plugin -->
    <script src="{{ asset('vendors/bootstrap-datetimepicker.js') }}"></script>
    <!-- Vector Map plugin -->
    <script src="{{ asset('vendors/jquery-jvectormap.js') }}"></script>
    <!-- Sliders Plugin -->
    <script src="{{ asset('vendors/nouislider.min.js') }}"></script>
    <!--  Google Maps Plugin    -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js"></script> -->
    <!-- Select Plugin -->
    <script src="{{ asset('vendors/jquery.select-bootstrap.js') }}"></script>
    <!--  DataTables.net Plugin    -->
    <script src="{{ asset('vendors/jquery.datatables.js') }}"></script>
    <!-- Sweet Alert 2 plugin -->
    <script src="{{ asset('vendors/sweetalert2.js') }}"></script>
    <!--    Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="{{ asset('vendors/jasny-bootstrap.min.js') }}"></script>
    <!--  Full Calendar Plugin    -->
    <script src="{{ asset('vendors/fullcalendar.min.js') }}"></script>
    <!-- TagsInput Plugin -->
    <script src="{{ asset('vendors/jquery.tagsinput.js') }}"></script>
    <!-- Material Dashboard javascript methods -->

    <script src="{{ asset('js/turbo.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


  <!-- <script src="{{ asset('js/charts/flot-charts.js') }}"></script> -->
  <script src="{{ asset('js/charts/chartjs-charts.js') }}"></script>



</body>
</html>
