<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Xsys - Authentication</title>

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
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />

    <link rel="shortcut icon" href="{{asset('img/icon.ico')}}"/>


</head>
<body>
<div class="container">
    <div class="col-md-8 white_text  paddingTop50" >

        <img src="{{ asset('img/inv1.png')}}" /> <img src="{{ asset('img/inv2.png')}}" /> <img src="{{ asset('img/inv3.png')}}" />
        <br /><br />
        <h1 class=""> Blade Technologies</h1>
        <p>Based in England and being a distinguished supplier in IT industry for over two decades, Blade Technologies is currently providing high end solutions to clients worldwide. Our major area of operation is in hardware and software industries.</p>
    </div>
    <div class="col-md-4">
        <div class="login-container">
            <div id="output"></div>
            <!--     <div >    <img src="img/logo.png" width="50%"  /><br /><br /></div>-->
            <div class="avatar"></div>
            @yield('content')
        </div>
    </div>


</div>






</body>
</html>
