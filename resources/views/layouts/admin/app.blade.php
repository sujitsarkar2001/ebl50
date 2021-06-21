<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <link rel="shortcut icon" type="image/jpg" href="{{asset('/')}}uploads/setting/{{setting('favicon')}}"/>

        <title>@yield('title')</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('/')}}assets/plugins/fontawesome-free/css/all.min.css">
        
        <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/toast.min.css">

        @stack('css')

        <!-- Theme style -->
        <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
        <style>
            div.fixed.inset-0.flex.items-end.justify-center {z-index: 999999;}
            .loader {
                border: 5px solid #f3f3f3;
                border-radius: 50%;
                border-top: 5px solid blue;
                border-right: 5px solid green;
                border-bottom: 5px solid red;
                border-left: 5px solid pink;
                width: 50px;
                height: 50px;
                -webkit-animation: spin 2s linear infinite;
                animation: spin 2s linear infinite;
                position: fixed;
                top: 23%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            @-webkit-keyframes spin {
                0% { -webkit-transform: rotate(0deg); }
                100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">

            <!-- Navbar -->
            @include('layouts.admin.partials.navbar')
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            @include('layouts.admin.partials.aside')
            <!-- /.main sidebar container -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                @yield('content')
                
            </div>
            <!-- /.content-wrapper -->

            <div class="loader d-none"></div>

            <!-- Footer -->
                <x-footer-component></x-footer-component>
            <!-- /.footer -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{asset('/')}}assets/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('/')}}assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('/')}}assets/dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        

        @stack('js')

        <script src="{{asset('/')}}assets/frontend/js/toast.min.js"></script>
        <script src="{{asset('/')}}assets/dist/js/demo.js"></script>
        <script>
            $(document).ready(function () {
                function countNewMessage(){
                    $.ajax({
                        type: "GET",
                        url: "{{route('admin.connection.live.chat.new-sms.count')}}",
                        dataType: "JSON",
                        success: function (response) {
                            $('li#countMessage span').text(response)
                        }
                    });
                }

                setInterval(function () {
                    countNewMessage();
                }, 7000);
            });
            
        </script>
    </body>
</html>
