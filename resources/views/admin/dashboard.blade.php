@extends('layouts.admin.app')

@section('title', 'Dashboard')

@push('css')
    <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@endpush

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Total Member</span>
                            <span class="info-box-number">
                                {{$total_member}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Active Member</span>
                            <span class="info-box-number">
                                {{$total_active_member}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hand-point-left"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Total Left Site Member</span>
                            <span class="info-box-number">
                                {{$total_left_member}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-middle-finger"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Total Middle Side Member </span>
                            <span class="info-box-number">
                                {{$total_middle_member}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hand-point-right"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Total Right Side Member</span>
                            <span class="info-box-number">
                                {{$total_right_member}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-check-alt"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Total Site Income</span>
                            <span class="info-box-number">
                                {{$site_income}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$income_balance}}</h3>
    
                    <p>Income Balance</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$shop_balance}}</h3>
    
                    <p>Shop Balance</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner" style="padding: 5px;">
                    <h4>Single Package</h4>
                </div>
                <div class="d-flex justify-content-between mx-1">
                    <p class="mb-0">Today Income</p>
                    <span>{{$today_single_package_income}}</span>
                </div>
                <div class="d-flex justify-content-between mx-1">
                    <p class="mb-0">Week Income</p>
                    <span>{{$week_single_package_income}}</span>
                </div>
                <div class="d-flex justify-content-between mx-1">
                    <p class="mb-0">Year Income</p>
                    <span>{{$year_single_package_income}}</span>
                </div>
                <div class="d-flex justify-content-between mx-1">
                    <p class="mb-0">Total Income</p>
                    <span>{{$total_single_package_income}}</span>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner" style="padding: 5px;">
                    <h4>Share Package</h4>
                </div>
                <div class="d-flex justify-content-between mx-1">
                    <p class="mb-0">Today Income</p>
                    <span>{{$today_share_package_income}}</span>
                </div>
                <div class="d-flex justify-content-between mx-1">
                    <p class="mb-0">Week Income</p>
                    <span>{{$week_share_package_income}}</span>
                </div>
                <div class="d-flex justify-content-between mx-1">
                    <p class="mb-0">Year Income</p>
                    <span>{{$year_share_package_income}}</span>
                </div>
                <div class="d-flex justify-content-between mx-1">
                    <p class="mb-0">Total Income</p>
                    <span>{{$total_share_package_income}}</span>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check-alt"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$today_sponsor_income}}</h3>
    
                    <p>Today Sponsor Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$week_sponsor_income}}</h3>
    
                    <p>This Week Sponsor Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$month_sponsor_income}}</h3>
    
                    <p>This Month Sponsor Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$total_sponsor_income}}</h3>
    
                    <p>Total Sponsor Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$today_video_income}}</h3>
    
                    <p>Today Daily Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-laptop-house"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$week_video_income}}</h3>
    
                    <p>This Week Daily Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-laptop-house"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$month_video_income}}</h3>
    
                    <p>This Month Daily Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-laptop-house"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$total_video_income}}</h3>
    
                    <p>Total Daily Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-laptop-house"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$today_generation_income}}</h3>
    
                    <p>Today Generation Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$week_generation_income}}</h3>
    
                    <p>This Week Generation Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$month_generation_income}}</h3>
    
                    <p>This Month Generation Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$total_generation_income}}</h3>
    
                    <p>Total Generation Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$month_level_income}}</h3>
    
                    <p>Month Level Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$total_level_income}}</h3>
    
                    <p>Total Level Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$today_single_package_income}}</h3>
    
                    <p>Today Single Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$week_single_package_income}}</h3>
    
                    <p>Week Single Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$year_single_package_income}}</h3>
    
                    <p>Year Single Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$total_single_package_income}}</h3>
    
                    <p>Total Single Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$today_share_package_income}}</h3>
    
                    <p>Today Share Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$week_share_package_income}}</h3>
    
                    <p>Week Share Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$year_share_package_income}}</h3>
    
                    <p>Year Share Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$total_share_package_income}}</h3>
    
                    <p>Total Share Income</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div> --}}
        

    </div>
    <!-- Default box -->
    {{-- <div class="card">
        <div class="card-header">
            <h3 class="card-title">Title</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            
        </div>
        <!-- /.card-body -->
    </div> --}}
    <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@push('js')
    
@endpush