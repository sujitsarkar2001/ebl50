@extends('layouts.admin.app')

@section('title', 'Edit Withdraw Info')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit</h3>
        </div>
        @if ($withdraw->status == 1)
            <div class="card-body">
                <h3>Already Paid this amount</h3>
            </div>
        @else
        <form action="{{route('admin.withdraw.update', $withdraw->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Amount" value="{{$withdraw->amount}}">
                        @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="method">Method</label>
                        <select name="method" id="method" class="form-control @error('method') is-invalid @enderror">
                            <option value="Bank" @isset($withdraw) {{$withdraw->method == 'Bank' ? 'selected':''}} @endisset>Bank</option>
                            <option value="Bkash" @isset($withdraw) {{$withdraw->method == 'Bkash' ? 'selected':''}} @endisset>Bkash</option>
                            <option value="Nagad" @isset($withdraw) {{$withdraw->method == 'Nagad' ? 'selected':''}} @endisset>Nagad</option>
                            <option value="Rocket" @isset($withdraw) {{$withdraw->method == 'Rocket' ? 'selected':''}} @endisset>Rocket</option>
                        </select>
                        @error('method')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
    
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="holder_name">Holder Name</label>
                        <input type="text" name="holder_name" id="holder_name" class="form-control @error('holder_name') is-invalid @enderror" placeholder="Holder name" value="{{$withdraw->holder_name}}">
                        @error('holder_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="account_number">Account Number</label>
                        <input type="number" name="account_number" id="account_number" class="form-control @error('account_number') is-invalid @enderror" placeholder="Account number" value="{{$withdraw->account_number}}">
                        @error('account_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{$withdraw->date}}">
                        @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="charge">Charge (<span id="show_charge"></span>%)</label>
                        <input type="number" id="charge" class="form-control" placeholder="Charge" value="{{$withdraw->charge ?? ''}}" readonly>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="after_charge">After Charge</label>
                        <input type="number" id="after_charge" class="form-control" placeholder="After Charge" value="{{$withdraw->after_charge ?? ''}}" readonly>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="form-group">
                    <button class="mt-1 btn btn-primary">
                        <i class="fas fa-arrow-circle-up"></i>
                        Update
                    </button>
                </div>
            </div>

        </form>
        @endif
        
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
                let method  = $('#method').val();
                let amount  = $('#amount').val();
                let percent = 0;
                
                if (method == 'Bank') {
                    percent = "{{setting('withdraw_charge_in_bank')}}";
                } 
                else if (method == 'Bkash') {
                    percent = "{{setting('withdraw_charge_in_bkash')}}";
                }
                else if (method == 'Nagad') {
                    percent = "{{setting('withdraw_charge_in_nagad')}}";
                }
                else {
                    percent = "{{setting('withdraw_charge_in_rocket')}}";
                }

                let total =  ((percent/ 100) * amount).toFixed(2);
                
                $('#charge').val(total);
                $('#after_charge').val(amount - total);
                $('#show_charge').text(percent);
            }
            $('#method').on('change', function() { calculate() });
        });
    </script>
@endpush