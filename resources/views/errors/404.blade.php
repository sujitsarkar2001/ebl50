@if (auth()->user()->is_admin == true)
    @php
        $app   = 'layouts.admin.app';
        $route = route('admin.dashboard');
    @endphp
@else
    @php
        $app   = 'layouts.user.app';
        $route = route('dashboard');
    @endphp
@endif

@extends($app)



@section('title', 'Contact')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="">404</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{$route}}">Home</a></li>
                <li class="breadcrumb-item active">404</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

            <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href="{{$route}}">return to dashboard</a> or try using the search form.
            </p>
        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>
<!-- /.content -->

@endsection