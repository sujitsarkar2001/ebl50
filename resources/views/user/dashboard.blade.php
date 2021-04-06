@extends('layouts.user.app')

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
                <h1>Blank Page</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                
                <div class="col-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-asterisk"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Sponsor Id</span>
                            <span class="info-box-number">
                                {{-- This function define to App\Helpers\Level.php --}}
                                {{Auth::user()->referer_id}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fab fa-hubspot"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Sponsor By</span>
                            <span class="info-box-number">
                                {{-- This function define to App\Helpers\Level.php --}}
                                {{Auth::user()->sponsor->name ?? ''}}
                                <span>({{Auth::user()->sponsor->referer_id ?? '0'}})</span>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-layer-group"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Your Level</span>
                            <span class="info-box-number">
                                {{-- This function define to App\Helpers\Level.php --}}
                                {{level(Auth::user())}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-globe-asia"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Your Direction</span>
                            <span class="info-box-number">
                                @if (Auth::user()->direction == 1)
                                    Left
                                @elseif (Auth::user()->direction == 2)
                                    Middle
                                @else
                                    Right
                                @endif
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hand-point-left"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Left Team</span>
                            <span class="info-box-number">
                                {{Auth::user()->countLeft()}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-middle-finger"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Middle Team</span>
                            <span class="info-box-number">
                                {{Auth::user()->countMiddle()}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hand-point-right"></i></span>
          
                        <div class="info-box-content">
                            <span class="info-box-text">Right Team</span>
                            <span class="info-box-number">
                                {{Auth::user()->countRight()}}
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
            <div class="small-box bg-danger">
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
        
    </div>

</section>
<!-- /.content -->

@endsection

@push('js')
    
@endpush