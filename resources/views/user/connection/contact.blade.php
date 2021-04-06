@extends('layouts.user.app')

@section('title', 'Contact')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="">Contact</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Contact</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Contact</h3>

        </div>
        <form action="" method="post" id="contact">
            @csrf
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com">
                        <small class="form-text text-danger email-error"></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject">
                        <small class="form-text text-danger subject-error"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" rows="6" class="form-control"></textarea>
                    <small class="form-text text-danger message-error"></small>
                </div>
                <div class="form-group alert-message d-none">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Congratulations!!</strong> Receive your contact information successfully
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="mt-1 btn btn-primary">Submit</button>
            </div>
        </form>
        
        
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@push('js')
    <script>
        $(document).on('submit', '#contact', function (e) {
            e.preventDefault();
            let data = $(this).serialize();
            $('small.form-text').text('');
            $('.card-footer button').addClass('disabled')
            $.ajax({
                type: "POST",
                url: "{{ route('connection.store.contact') }}",
                data: data,
                dataType: "JSON",
                success: function (response) {
                    if (response.alert == 'success') {
                        $('.alert-message').removeClass('d-none')
                        $('input.form-control').val('')
                        $('textarea.form-control').val('')
                        $('.card-footer button').removeClass('disabled')
                    }
                },
                error: function(e) {
                    $('.card-footer button').removeClass('disabled')
                    if (typeof e.responseJSON.errors.email != 'undefined') {
                        $('small.email-error').text(e.responseJSON.errors.email[0])
                    }
                    if (typeof e.responseJSON.errors.subject != 'undefined') {
                        $('small.subject-error').text(e.responseJSON.errors.subject[0])
                    }
                    if (typeof e.responseJSON.errors.message != 'undefined') {
                        $('small.message-error').text(e.responseJSON.errors.message[0])
                    }
                }
            });
        })
    </script>
@endpush