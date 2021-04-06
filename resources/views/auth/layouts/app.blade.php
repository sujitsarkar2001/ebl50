<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            @if (Route::is('login'))
                Login
            @elseif (Route::is('register'))
                Register
            @else 
                Reset Password
            @endif
        </title>

        <link rel="shortcut icon" type="image/jpg" href="/uploads/setting/{{setting('favicon')}}"/>
        
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        
        @stack('css')
        <!-- Theme style -->
        <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
    </head>
    <body class="hold-transition login-page">
        
        @yield('content')

        <!-- jQuery -->
        <script src="/assets/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        
        @stack('js')
        
        <!-- AdminLTE App -->
        <script src="/assets/dist/js/adminlte.min.js"></script>
    </body>
</html>
