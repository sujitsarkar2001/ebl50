<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title')</title>
    
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/style.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/toast.min.css">
    <link rel="stylesheet" href="{{asset('/')}}assets/frontend/css/all.css">
    
    @notifyCss

    <script src="{{asset('/')}}assets/frontend/js/jquery.js"></script>
    <script src="{{asset('/')}}assets/frontend/js/bootstrap.min.js"></script>
    
    <script src="{{asset('/')}}assets/frontend/js/toast.min.js"></script>
    <script src="{{asset('/')}}assets/frontend/js/main.js"></script>
</head>
<body>

    @yield('content')
    

    <x:notify-messages />
    @notifyJs

    @stack('js')
</body>
</html>
