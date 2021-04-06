@extends('layouts.admin.app')

@section('title', 'Give Shop Balance')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Shop Balance</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Shop Balance</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Shop Balance</h3>
                </div>
                <form action="{{route('admin.withdraw.shop.balance.store')}}" method="post">
                    @csrf
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" required id="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="">
                            @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" required id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Amount" value="">
                            @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
        
                    <div class="card-footer">
                        <div class="form-group">
                            <button class="mt-1 btn btn-primary">
                                <i class="fas fa-arrow-circle-up"></i>
                                Submit
                            </button>
                        </div>
                    </div>
        
                </form>
                
            </div>
        </div>
    </div>
    
</section>
<!-- /.content -->

@endsection

@push('js')
    
@endpush