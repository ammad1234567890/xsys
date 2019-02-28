<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Xsys</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
          <link rel="shortcut icon" href="../../xsys_new_version/public/img/icon.ico">
        <!-- Styles -->
        <style>
          html, body {

          color: #636b6f;
          font-family: 'Raleway', sans-serif;
          font-weight: 100;
          height: 100vh;
          margin: 0;


          background: rgba(8,47,84,1);
          background: -moz-linear-gradient(top, rgba(8,47,84,1) 0%, rgba(0,0,0,1) 100%);
          background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(8,47,84,1)), color-stop(100%, rgba(0,0,0,1)));
          background: -webkit-linear-gradient(top, rgba(8,47,84,1) 0%, rgba(0,0,0,1) 100%);
          background: -o-linear-gradient(top, rgba(8,47,84,1) 0%, rgba(0,0,0,1) 100%);
          background: -ms-linear-gradient(top, rgba(8,47,84,1) 0%, rgba(0,0,0,1) 100%);
          background: linear-gradient(to bottom, rgba(8,47,84,1) 0%, rgba(0,0,0,1) 100%);
          filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#082f54', endColorstr='#000000', GradientType=0 );
          Copy text




          }

          .full-height {
          height: 100vh;
          }

          .flex-center {
          align-items: center;
          display: flex;
          justify-content: center;
          }

          .position-ref {
          position: relative;
          }

          .top-right {
          position: absolute;
          right: 10px;
          top: 18px;
          }

          .content {
          text-align: center;
          }

          .title {
          font-size: 84px;
          }

          .links > a {
          color: #fff;
          padding: 0 25px;
          font-size: 12px;
          font-weight: 600;
          letter-spacing: .1rem;
          text-decoration: none;
          text-transform: uppercase;
          }

          .m-b-md {
          margin-bottom: 30px;
          }


          .footer_bottom{
          
           bottom:10%; 
           width:100%;
           position:absolute;
            text-align:center;
           font-size:18px;
           font-weight:400;
           color:#ddd;
           
          
          }


        </style>
    </head>
    <body style=" background-color:#000;">
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
              
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                  
                    
                    <img src="../../xsys_new_version/public/img/xsyslogo.png" >
                </div>

           
            </div>


          <div class="footer_bottom">
            
            Powered by Deploy (PVT) Ltd.
          </div>
        </div>
    </body>
</html>
