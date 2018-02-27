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
        .content .col-md-12{
            background-color: transparent !important;
        }
    </style>
</head>
<body>
<div id="app">

    <div class="mainbar">

        <div class="container fullwidth">

            <button type="button" class="btn mainbar-toggle" data-toggle="collapse" data-target=".mainbar-collapse">
                <i class="fa fa-bars"></i>
            </button>

            <div class="col-md-5 paddingmarginzero logo"  >
                <a href="{{ url('/') }}"><img src="{{asset('img/logo.png')}}" /></a>
            </div>
            <div class="col-md-7">
                <div class="mainbar-collapse collapse">

                    <ul class="nav navbar-nav mainbar-nav navbar-right">
                        <li>
                            <a href="{{ route('login') }}" >
                                <i class="fa fa-sign-in"></i>
                                Login
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('register') }}">
                                <i class="fa fa-user"></i>
                                Register
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



                <div class="col-md-12">
                    <br/>
                    <br/>
                    @yield('content')
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
<script src="{{ asset('js/libs/jquery-1.10.1.min.js') }}"></script>
<script src="{{ asset('js/libs/jquery-ui-1.9.2.custom.min.js') }}"></script>
<script src="{{ asset('js/libs/bootstrap.min.js') }}"></script>
</body>
</html>
