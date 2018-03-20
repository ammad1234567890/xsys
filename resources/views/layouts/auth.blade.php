<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Xcel') }}</title>

    <!-- Styles -->
    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
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
    <nav class="navbar navbar-primary navbar-transparent navbar-absolute">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('img/xsyslogo.png') }}" width="130px" alt="Xsys">
                </a>
            </div>
        </div>
    </nav>
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page"  data-color="blue">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->

            @yield('content')
            
            <footer class="footer">
                <div class="container">

                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="{{ url('/') }}">Xcell</a> Admin 
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->

    <script src="{{ asset('vendors/jquery-3.1.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/material.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>

        <!-- Forms Validations Plugin -->
    <script src="{{ asset('vendors/jquery.validate.min.js') }}"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="{{ asset('vendors/moment.min.js') }}"></script>
    <!--  Charts Plugin -->
    <script src="{{ asset('vendors/chartist.min.js') }}"></script>
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
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('js/demo.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>



</body>
</html>
