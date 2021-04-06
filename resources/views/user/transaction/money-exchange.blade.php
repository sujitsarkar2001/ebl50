@extends('layouts.user.app')

@section('title', 'Money Exchange')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Money Exchange</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Money Exchange</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{auth()->user()->incomeBalance->amount}}</h3>
    
                    <p>Income Balance Available</p>
                </div>
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{Auth::user()->shopBalance->amount}}</h3>
    
                    <p>Total Shop Balance</p>
                </div>
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{setting('money_exchange_charge')}} %</h3>
    
                    <p>Exchange Charge</p>
                </div>
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Money Exchange</h3>
                </div>
                <form action="{{route('exchange') }}" method="post">
                    @csrf
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Amount" value="{{old('amount')}}" required>
                            @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="charge">Charge</label>
                            <input type="number" id="charge" class="form-control" readonly placeholder="Charge">
                        </div>

                        <div class="form-group">
                            <label for="after_charge">After Charge</label>
                            <input type="number" id="after_charge" class="form-control" readonly placeholder="After Charge">
                        </div>
            
                    </div>
        
                    <div class="card-footer">
                        <div class="form-group">
                            <button class="mt-1 btn btn-primary">
                                <i class="fas fa-plus-circle"></i>
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
    <script>
        $(document).ready(function () {
            
            $('#amount').on('input', function() {
                calculate();
            });

            function calculate() {
                let amount = $('#amount').val();
                let percent = "{{setting('money_exchange_charge')}}";
                
                let total =  ((percent/ 100) * amount).toFixed(2);
                
                $('#charge').val(total);
                $('#after_charge').val(amount - total);
            }
        });
    </script>
@endpush