<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <!-- Fev Icon -->
    <link rel="shortcut icon" href="img/icon.ico"/> 
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Xsys</title>

  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300,700">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <!-- App CSS -->
  <link rel="stylesheet" href="css/target-admin.css">

  <link href="css/style.css" rel="stylesheet" />




</head>
<body>
<div id="app">
  <div>
    @yield('content')
  </div>
 
</div>
</footer>
  <script src="{{ asset('js/libs/jquery-1.10.1.min.js')}}"></script>
  <script src="{{ asset('js/libs/jquery-ui-1.9.2.custom.min.js')}}"></script>
  <script src="{{ asset('js/libs/bootstrap.min.js')}}"></script>
<!-- <script src="{{ asset('js/libs/excanvas.compiled.js')}}"></script> -->
  <!--[if lt IE 9]>
  <![endif]-->
  
  <!-- Plugin JS 
  <script src="js/plugins/icheck/jquery.icheck.js"></script>
  <script src="js/plugins/select2/select2.js"></script>
  <script src="js/libs/raphael-2.1.2.min.js"></script>
  <script src="js/plugins/morris/morris.min.js"></script>
  <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>
  <script src="js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>-->

  <!-- App JS 
  <script src="js/target-admin.js"></script>-->
  
  <!-- Plugin JS 
  <script src="js/demos/dashboard.js"></script>
  <script src="js/demos/calendar.js"></script>
  <script src="js/demos/charts/morris/area.js"></script>
  <script src="js/demos/charts/morris/donut.js"></script>
-->
  


  
</body>
</html>
