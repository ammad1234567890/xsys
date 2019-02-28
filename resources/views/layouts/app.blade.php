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
<link rel="stylesheet" href="{{ asset('css/slick.css')}}">
  <link href="{{ asset('css/style.css')}}" rel="stylesheet" />
   <link rel="stylesheet" href="{{ asset('css/freeze.css')}}">
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

        [v-cloak] > * { display:none; }
        [v-cloak]::before { 

          content: " ";
          display: block; 
          width: 16px;
          height: 16px;
          position: fixed;
          top: 50%;
          left: 50%;
          background-image: url('data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==');
        }
        .mobile-look-container{
            box-shadow: 0px 1px 9px -1px darkgrey;
            margin-top:20px;
        }

        .product-image{
            height:350px;
            display: inline-block;
        }
        .product-image img{
            height:100%;
            text-align: center;
            width: 100%;
        }
        .product-heading{
            border-top:1px solid #d9d9d9;
            background: #fff;
            padding: 10px;
            color: #585858;
        }
        .product-heading h4{
            text-transform: uppercase;
            font-weight:bold;
            font-size:15px;
            text-decoration:underline;
        }
        .product-heading .colors{
            margin-top:-5px;
        }
        .product-heading .released_date{
            margin-top:-9px;
        }
        .specs-btn{
            border-radius:0px;
            background:#e3e3e3;
            color:#000;
            width:100%;
        }
        .slider-for .slick-list{
            width:100%;
        }

        .slider-nav .slick-prev{
            position: absolute;
            left: 0px;
            z-index: 999;
            height: 100%;
            text-indent: -1999px;
            background-image:url('../img/back.png');
            background-size:100% 45%;
            background-position: center; 
            background-repeat: no-repeat;
            background-color: #b3c8c7;
            border: none;
        }
        .slider-nav .slick-next{
            position: absolute;
            right: 0px;
            top:0px;
            z-index: 999;
            height: 100%;
            text-indent: -1999px;
            background-image:url('../img/next.png');
            background-size:100% 45%;
            background-position: center; 
            background-repeat: no-repeat;
            background-color: #b3c8c7;
            border: none;
        }
        .sidebar_btn {
             position: absolute; z-index: 999; top: -3px;  left: -8px; font-size: 25px;
            }
.display_none{ display:none;}



    </style>

    <script>
        window.laravel={!! json_encode([

            'csrfToken'=>csrf_token(),

        ]) !!};
    </script>

</head>
<body>
    <div id="app" v-cloak>
    <notificationpopup-component :userid="{{Auth::user()->id}}"></notificationpopup-component>
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
                                <span class="navbar-profile-label"> &nbsp;</span>
                                <i class="fa fa-caret-down"></i>
                            </a>




                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-home"></i>
                                        &nbsp;&nbsp;
                                        <?php $warehouse_staff_data=""; ?>
                                        @foreach(\App\WarehouseStaff::with('warehouse','staff.staffType')->where('staff_id', Auth::user()->staff_id)->get() as $data)
                                            {{ $data->warehouse->name }}
                                            <?php $warehouse_staff_data = $data;?>
                                             <?php $staff_type= $data->staff->staffType->type; ?>

                                        @endforeach


                                        <?php
                                            if($warehouse_staff_data==""){  ?>
                                                @foreach(\App\User::with('staffRecord', 'staffRecord.staffType')->where('id', Auth::user()->id)->get() as $data)
                                                    {{ $data->staffRecord->staffType->type }}
                                            <?php $staff_type= $data->staffRecord->staffType->type; ?>
                                                @endforeach
                                         <?php   }
                                        ?>


                                    </a>
                                </li>

                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-envelope">

                                            {{ Auth::user()->email }}
                                        </i>
                                        &nbsp;&nbsp;
                                    </a>
                                </li>

                                <li>
                                    <a href="javascript:;">
                                        <i class="fa fa-user">

                                            <?php echo $staff_type; ?>
                                        </i>
                                        &nbsp;&nbsp;
                                    </a>
                                </li>

                                <li>
                                    <a href="{{url('change_pass')}}">
                                        <i class="fa fa-cogs"></i>
                                        &nbsp;&nbsp;Change Password
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





                        <!-- Notification -->

                        <headernotification-component

                                :allnotifications="{{auth()->user()->Notifications->sortBy('created_at')->take(10)}}"
                                :unread_notification_count="{{auth()->user()->unreadNotifications->count()}}"
                                :userid="{{Auth::user()->id}}"
                                :unreads="{{auth()->user()->Notifications->take(10)}}"

                        >
                        </headernotification-component>









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

                                    <li>
                                        <a href="{{ url('/our_products') }}">
                                            Our Products
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
                                    <li><a href="{{url('/retailer')}}">Create Outlet</a></li>
                                    <li><a href="{{url('/retailer_list')}}">Outlets List</a></li>
                                    <li><a href="{{url('/retailer/create_order')}}">Create Retail Order</a></li>
                                    <li><a href="{{url('/retailer_order/orders')}}">Retail Order Detail</a></li>
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
                                    <li><a href="{{url('/invoice/list/') }}">Invoice History</a></li>
                                    <li><a href="{{url('warehouseStock') }}">Stock Report</a></li>
                                    <li><a href="{{url('/retailer_order/payment')}}">Receive Payment</a></li>
                                    <li><a href="{{url('/retailer_order/order_payment_reversal')}}">Payment Reverse</a></li>
                                    <li><a href="{{url('/bank')}}">Registered Banks</a></li>
                                    <li><a href="{{url('/ledger')}}">Ledger</a></li>
                                    <li><a href="{{url('/so_tasks')}}">Survey Tasks</a></li>
                                    <li><a href="{{url('/order_list')}}">Online Orders</a></li>
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
                                    <li><a href="{{ url('createNewWarehouse') }}">New Warehouse</a></li>
                                    <li><a href="{{ url('warehouse') }}">Warehouse List</a></li>
                                    <li><a href="{{ url('warehouseStaff') }}">Allocate Staff</a></li>
                                    <li><a href="{{ url('warehouseStaffView') }}">Warehouse Staff</a></li>
                                    <!--<li><a href="{{ url('mainWarehouseReceive') }}">Consignment Receive</a></li>-->
                                    <li><a href="{{ url('receive_stock') }}">Consignment Receive</a></li>
                                    <li><a href="{{ url('warehouseIssue') }}">Sales Invoice</a></li>
                                    <li><a href="{{ url('cons_stock_item_detail') }}">Stock Details</a></li>
                                    <li><a href="{{ url('warehouse/change_stock_type') }}">Change Stock Type</a></li>
                                    <!-- <li><a href="{{ url('itemDetail') }}">Find IMEI</a></li>
                                    <li><a href="{{ url('productDetailsView') }}">Product Detail</a></li> -->
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
                    
                    <div class="sidebar_btn">
                    <a  href="#" id="btn_expand"><i class=" fa fa-chevron-circle-right"></i></a>
                    </div>
                    <div class="col-md-2" id="sidebar">
                        <div class="verticalmenu text-center">
                        <h3 class="h2box "> <a href="#" id="btn_collapse"><i class=" fa fa-chevron-circle-left"></i></a> Modules</h3>
                            <div class="menutab active">
                                <a href="{{ url('home') }}">
                                    <div class="menuitem cursorpointer" >
                                        <img src="{{ asset('img/dashb.png')}}" alt="dashboard" width="40px" /><br />
                                        Dashboard
                                    </div>
                                </a>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample5" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/store.png')}}" alt="dashboard" width="40px"/><br />
                                    Outlets
                                </div>
                                <ul class="collapse " id="collapseExample5">
                                    <a href="{{ url('retailer/create_order') }}">
                                        <li>Create Order </li>
                                    </a>

                                    <a href="{{ url('retailer_order/orders') }}">
                                        <li>All Orders</li>
                                    </a>
                                    <a href="{{ url('/retailer') }}">
                                        <li>Create Outlet</li>
                                    </a>
                                    <a href="{{ url('/retailer_list') }}">
                                        <li>Outlets List </li>
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
                                        <li>New Warehouse </li>
                                    </a>
                                    <a href="{{ url('warehouse') }}">
                                        <li>All Warehouses</li>
                                    </a>
									
									<a href="{{ url('/invoice/list/') }}">
                                        <li>Invoice History </li>
                                    </a>
                                   <!-- <a href="{{ url('mainWarehouseReceive') }}">
                                        <li>Consignment Receive</li>
                                    </a>-->

                                    <a href="{{ url('receive_stock') }}">
                                        <li>Consignment Receive</li>
                                    </a>


                                    <a href="{{ url('warehouseIssue') }}">
                                        <li>Sales Invoice </li>
                                    </a>

                                    <!-- <a href="{{ url('itemDetail') }}">
                                        <li>Find IMEI</li>
                                    </a> -->

                                    <a href="{{ url('warehouse/change_stock_type') }}">
                                        <li>Change Stock Type</li>
                                    </a>


                                    <a href="{{ url('cons_stock_item_detail') }}">
                                        <li>Stock Details</li>
                                    </a>
                                </ul>
                            </div>

                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample15" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/transfer.png')}}" alt="dashboard" width="40px"/><br />
                                    Stock Transfer
                                </div>
                                <ul class="collapse " id="collapseExample15">
                                    <a href="{{ url('issue_note') }}">
                                        <li>Create Transfer Request</li>
                                    </a>
                                    <a href="{{ url('transfer_requests') }}">
                                        <li>Approved</li>
                                    </a>

                                    <a href="{{ url('display_issue_note') }}">
                                        <li>View Issue Note</li>
                                    </a>

                                    <a href="{{ url('non_approved_issue_note') }}">
                                        <li>Requests Approval</li>
                                    </a>
									<a href="{{ url('receive_TransferStock') }}">
                                        <li>Receive Stock</li>
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

                                    <a href="{{url('/retailer_order/payment')}}">
                                        <li>Receive Payment </li>
                                    </a>

                                    <a href="{{url('/retailer/payment_slips')}}">
                                        <li>Payment Slips </li>
                                    </a>

                                    <a href="{{url('/bank')}}">
                                        <li>Registered Banks </li>
                                    </a>

                                    <a href="{{url('/ledger')}}">
                                        <li>Ledger </li>
                                    </a>

                                    <a href="{{url('/so_tasks')}}">
                                        <li>Survey Tasks </li>
                                    </a>
                                    <a href="{{url('/order_list')}}"><li>Online Orders</li></a>
                                </ul>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample8" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/newspaper.png')}}" alt="dashboard" width="40px" /><br />
                                    Reports
                                </div>
                                <ul class="collapse " id="collapseExample8">
                                    <a href="{{url('/report')}}">
                                        <li>Sales and Collection</li>
                                    </a>
                                   <a href="{{ url('warehouseStock') }}">
                                        <li>Stock Report </li>
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
                                        <li>Create Order</li>
                                    </a>
                                    <a href="{{ url('order/all_orders') }}">
                                        <li>All Orders</li>
                                    </a>
                                    <a href="{{ url('order/receive') }}">
                                        <li>New Consigment</li>
                                    </a>
                                    <a href="{{ url('order/payment') }}">
                                        <li>PO Payment</li>
                                    </a>
                                    <a href="{{ url('order/received_orders') }}">
                                        <li>Received Orders</li>
                                    </a>
                                </ul>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample4" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/hotel-staff.png')}}" alt="dashboard" width="40px" /><br />
                                    Staff Management
                                </div>
                                <ul class="collapse " id="collapseExample4">
                                    <a href="{{ url('staff') }}">
                                        <li>New Enrollment</li>
                                    </a>
                                    <a href="{{ url('viewStaff') }}">
                                        <li>Staff List</li>
                                    </a>
                                    <a href="{{ url('warehouseStaff') }}">
                                        <li>Allocate Staff</li>
                                    </a>
                                    <a href="{{ url('warehouseStaffView') }}">
                                        <li>Warehouse Staff List</li>
                                    </a>
                                </ul>
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
                                    <a href="{{ url('/our_products') }}">
                                        <li> Our Products</li>
                                    </a>
                                </ul>
                            </div>
                            <div class="menutab active">
                                <div class="menuitem cursorpointer" role="button" data-toggle="collapse" href="#collapseExample9" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="{{ asset('img/key.png')}}" alt="dashboard" width="40px"/><br />
                                    Access Control
                                </div>
                                <ul class="collapse " id="collapseExample9">

                                    <a href="{{ url('permission_manage') }}">
                                        <li>Create Permissions </li>
                                    </a>

                                    <a href="{{ url('access') }}">
                                        <li>Create Roles </li>
                                    </a>
                                    <a href="{{ url('userrole') }}">
                                        <li>Assign Roles</li>
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
                    <div class="col-md-10" id="content_placeholder">
                        <div class="content-container ">
                            @yield('content')
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
        </div>





    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
	  <script src="{{ asset('js/gridviewscroll.js') }}"></script>
  <script src="{{ asset('js/prettify.js') }}"></script>
  <script src="{{ asset('js/slick.js') }}"></script>
  <script src="{{ asset('js/accounting.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script>

$(document).ready(function () {
    // sidebar is pre-collapsed on the document load
    $("#btn_expand").hide();

    // collapse the sidebar
    $('#btn_collapse').click(function () {
        $(this).hide();
        $('#btn_expand').show();

        $('#sidebar').hide();
        $('#content_placeholder').removeClass('col-md-10');
        $('#content_placeholder').addClass('col-md-12');
    });

    // expand the sidebar
    $('#btn_expand').click(function () {
        $(this).hide();
        $('#btn_collapse').show();

        $('#sidebar').show('slow');
        $('#content_placeholder').removeClass('col-md-12');
        $('#content_placeholder').addClass('col-md-10');
    });
});

</script>




</body>
</html>
