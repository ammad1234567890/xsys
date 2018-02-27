<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/target-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <style>
/**
 * Create the box for the checkbox
 */
 .checkboxFive {
    width: 25px;
    margin: 0px 0px;
    position: relative;
}
.checkboxFive label {
    cursor: pointer;
    position: absolute;
    width: 25px;
    height: 25px;
    top: 0;
    left: 0;
    background: #eee;
    border:1px solid #ddd;
}
/**
 * Display the tick inside the checkbox
 */
.checkboxFive label:after {
    opacity: 0.2;
    content: '';
    position: absolute;
    width: 9px;
    height: 5px;
    background: transparent;
    top:8px;
    left: 7px;
    border: 3px solid #333;
    border-top: none;
    border-right: none;

    transform: rotate(-45deg);
}
/**
 * Create the hover event of the tick
 */
.checkboxFive label:hover::after {
    opacity: 0.5;
}

/**
 * Create the checkbox state for the tick
 */
.checkboxFive input[type=checkbox]:checked + label:after {
    opacity: 1;
}
     .image_close_btn{
        position: absolute;
        top: 0px;
        right: 21px;
        border-radius: 17px;
        background: white;
        border-color: black;
    } 
    .form-section{
        border:1px solid #636b6f;
        padding:20px;
        position: relative;
    }
    .form-section-heading{
        background:#959595;
        display: inline-block;
        padding: 5px;
        color: #fff;
        position: absolute;
        top:-5px;
        font-size: 10px;
            box-shadow: 0px -1px 3px 0px #000;
    }
    .padding10px{
        padding:10px;
    }
    </style>
</head>
<body>
<div id="app">
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
                            <img src="{{ asset('img/avatars/avatar-1-xs.jpg') }}" class="navbar-profile-avatar" alt="">
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
                                <a href="{{ route('logout') }}">
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
                <a href="{{url('/')}}"><img src="{{ asset('img/logo.png') }}" /></a>
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
                            <a href="index.html">
                                <div class="menuitem cursorpointer" >
                                    <img src="{{asset('img/ic_dashboard.png')}}" alt="dashboard" /><br />
                                    Dashboard
                                </div>
                            </a>
                        </div>
                        <div class="menutab active">
                            <a href="{{url('/product')}}">
                                <div class="menuitem cursorpointer" >
                                    <img src="{{asset('img/ic_dashboard.png')}}" alt="dashboard" /><br />
                                    Products
                                </div>
                            </a>
                        </div>
                        <div class="menutab active">
                            <a href="{{url('/category')}}">
                                <div class="menuitem cursorpointer" >
                                    <img src="{{asset('img/ic_dashboard.png')}}" alt="dashboard" /><br />
                                    Category
                                </div>
                            </a>
                        </div>
                        <div class="menutab active">
                            <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
                                <img src="{{asset('img/ic_practicesetup.png')}}" alt="dashboard" /><br />
                                Retailers
                            </div>
                            <ul class="collapse " id="collapseExample2">
                                <a href="{{url('/retailer')}}">
                                    <li> Retailers</li>
                                </a>
                                <a href="{{url('/retailer/outlets')}}">
                                    <li> Retailer Outlets</li>
                                </a>
                            </ul>
                        </div>
                        <div class="menutab active">
                            <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample3" aria-expanded="false" aria-controls="collapseExample">
                                <img src="{{asset('img/ic_practicesetup.png')}}" alt="Orders" /><br />
                                Orders
                            </div>
                            <ul class="collapse " id="collapseExample3">
                                <a href="{{url('/order/create')}}">
                                    <li> Create Order</li>
                                </a>
                                <a href="{{url('/order/receive')}}">
                                    <li> Recieve Order</li>
                                </a>
                                <a href="{{url('/order/payment')}}">
                                    <li> Orders Payment</li>
                                </a>
                            </ul>
                        </div>
                        <div class="menutab active">
                            <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample4" aria-expanded="false" aria-controls="collapseExample">
                                <img src="{{asset('img/ic_practicesetup.png')}}" alt="Orders" /><br />
                                Staff
                            </div>
                            <ul class="collapse " id="collapseExample4">
                                <a href="{{url('/staff')}}">
                                    <li> Staff</li>
                                </a>
                                <a href="{{url('/order/receive')}}">
                                    <li> Recieve Order</li>
                                </a>
                                <a href="{{url('/order/payment')}}">
                                    <li> Orders Payment</li>
                                </a>
                            </ul>
                        </div>

                        <div class="menutab active">
                            <a href="{{url('/general')}}">
                                <div class="menuitem cursorpointer" >
                                    <img src="{{asset('img/ic_dashboard.png')}}" alt="dashboard" /><br />
                                    General Entry
                                </div>
                            </a>
                        </div>


                    </div>
                </div>

                <div class="col-md-10">

                    <div class="main_content_area" style="margin-top: 8px;">
                        @yield('content')
                    </div>


                </div>
            </div>


        </div> <!-- /.content -->
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>




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

    </div> <!-- /.container -->
</div>






<!--[if lt IE 9]>
<script src="./js/libs/excanvas.compiled.js"></script>
-->
<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>



</body>
</html>
