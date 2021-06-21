<!-- DataTables  & Plugins -->
<script src="{{asset('/')}}assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('/')}}assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('/')}}assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('/')}}/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {

        let status = $('input#member_status').val();
        // show all data in table
        let table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
            "autoWidth": false,
            ajax: '/admin/user/'+status+'/data',
            columns: [
                {data: 'DT_RowIndex', searchable: false},
                {data: 'name', name: 'name'},
                {data: 'username', name: 'username'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'joining_date', name: 'joining_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // add new data
        $(document).on('click', '#add-btn', function(e) {

            e.preventDefault();

            $('.nav-item.nav-link').removeClass('active');
            $('#nav-basic').addClass('active');
            $('.tab-content .tab-pane').removeClass('active show');
            $('#basic').addClass('active show');

            $('#modal').modal('show');
            $('.modal-title').text('Add New Member');

            $('#form-submit').trigger("reset").attr('action', '{!! route('admin.user.store') !!}');
            $('input#method').removeAttr('name').val('');
            $('form small.form-text').text('');
            $('form .form-control').removeClass('is-invalid');
            $('button[type="submit"]').attr('disabled', false).text('Submit');
            $('select#direction').attr('disabled', false);

            let pass = '<div class="form-group col-md-6">';
            pass += '<label for="password">Password</label>';
            pass += '<input required type="password" name="password" id="password" class="form-control" placeholder="******">';
            pass += '<small class="form-text text-danger password"></small>';
            pass += '</div>';
            pass += '<div class="form-group col-md-6">';
            pass += '<label for="password_confirmation">Password</label>';
            pass += '<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">';
            pass += '</div>';
            $('.form-row.pass').html(pass);

            let refer = '<div class="form-group col-md-6">';
                refer += '<label for="sponsor_id">Sponsor ID</label>';    
                refer += '<input type="number" name="sponsor_id" id="sponsor_id" class="form-control" placeholder="Enter Sponsor ID">';    
                refer += '<small class="form-text text-danger sponsor_id"></small>';    
                refer += '</div>';    
                refer += '<div class="form-group col-md-6">';    
                refer += '<label for="placement_id">Placement ID</label>';    
                refer += '<input type="number" name="placement_id" id="placement_id" class="form-control" placeholder="Enter Placement ID">';    
                refer += '<small class="form-text text-danger placement_id"></small>';    
                refer += '</div>';
            $('.form-row.refer').html(refer);
            
            let single_package = '{!! setting('single_package') !!}';
            let share_package  = '{!! setting('share_package') !!}';
            let reg_package = '<option value="">Select Package</option>';
                reg_package += '<option value="'+single_package+'">Single Package ('+single_package+')</option>';
                reg_package += '<option value="'+share_package+'">Share Package ('+share_package+')</option>';
            
            $('select#register_package').html(reg_package);

            let gender = '<option value="">Select Gender</option>';
                gender += '<option value="Male">Male</option>';
                gender += '<option value="Female">Female</option>';
            
            $('select#gender').html(gender);
            
        });

        // store new data
        $(document).on('submit', '#form-submit', function(e) {
            e.preventDefault();

            let method   = $(this).attr('method');
            let action   = $(this).attr('action');
            var formData = $(this).serialize();

            $('small.form-text').text('')

            $.ajax({
                type: method,
                url: action,
                data: formData,
                dataType: "JSON",
                beforeSend: function () { 
                    $('button[type="submit"]').attr('disabled', true);
                },
                success: function (response) {
                    
                    if (response.alert == 'Success') {
                        
                        $.toast({
                            heading: 'Congratulations',
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        })

                        $('#modal').modal('hide');

                        table.ajax.reload();
                    }
                },
                complete: function () { 
                    $('button[type="submit"]').attr('disabled', false);
                },
                error: function (xhr) { 
                    
                    if (xhr.status == 422) {
                        if (typeof(xhr.responseJSON.errors) !== 'undefined') {
                            
                            $.each(xhr.responseJSON.errors, function (key, error) { 
                                $('small.'+key+'').text(error)
                            });

                            $.toast({
                                heading: xhr.status,
                                text: xhr.responseJSON.message,
                                icon: 'error',
                                position: 'top-right',
                                stack: false
                            });
                        }
                    }
                    else {
                        $.toast({
                            heading: xhr.status,
                            text: xhr.statusText,
                            icon: 'error',
                            position: 'top-right',
                            stack: false
                        });
                    }
                }
            });

        });

        // edit specific data
        $(document).on('click', '#showData', function(e) {

            e.preventDefault();

            let url = $(this).attr('href');

            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                beforeSend: function () { 
                    $('div.loader').removeClass('d-none').addClass('d-block');
                },
                success: function (response) {
                    if (response != '') {

                        $('#show-modal').modal('show');
                        $('.modal-title').text('Member Information');

                        $.each(response.member, function (key, val) { 
                            $('td.'+key+'').text(val);
                        });
                        $.each(response.info, function (key, val) { 
                            $('td.'+key+'').text(val);
                        });

                        if (response.sponsor != '') {
                            $.each(response.sponsor, function (key, val) { 
                                $('td.sponsor_'+key+'').text(val);
                            });
                        }

                        let approved = '';
                        let status   = '';
                        if (response.member.is_approved) {
                            approved += '<span class="badge badge-success">Approved</span>';
                        } else {
                            approved += '<span class="badge badge-success">Pending</span>';
                        }
                        if (response.member.status) {
                            status += '<span class="badge badge-success">Active</span>';
                        } else {
                            status += '<span class="badge badge-success">Disable</span>';
                        }
                        $('td.is_approved').html(approved);
                        $('td.status').html(status);

                        $('td.total_team_member').text(response.member.left+response.member.middle+response.member.right);
                        $('td.total_refer').text(response.referrals);
                        
                        $('td.right_side_member').text(response.right);
                        $('td.income_balance').text(response.income_balance.amount);
                        $('td.shop_balance').text(response.shop_balance.amount);
                        $('td.share_income').text(response.share_income);
                        $('td.sponsor_income').text(response.sponsor_income);
                        $('td.generation_income').text(response.generation_income);
                        $('td.daily_income').text(response.daily_income);
                        $('td.level_income').text(response.level_income);
                        $('td.withdraw_paid').text(response.withdraw_paid);
                        $('td.withdraw_pending').text(response.withdraw_pending);
                        $('td.money_exchanges').text(response.money_exchanges);
                        $('td.parent_send_shop_balance').text(response.parent_send_shop_balance);
                        $('td.send_shop_balance').text(response.send_shop_balance);
                    }
                },
                complete: function () { 
                    $('div.loader').removeClass('d-block').addClass('d-none');
                },
                error: function (xhr) {
                    $.toast({
                        heading: xhr.status,
                        text: xhr.statusText,
                        icon: 'error',
                        position: 'top-right',
                        stack: false
                    });
                }
            });
        });

        // edit specific data
        $(document).on('click', '#editData', function(e) {

            e.preventDefault();

            let url = $(this).attr('href');

            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                beforeSend: function () { 
                    $('div.loader').removeClass('d-none').addClass('d-block');
                },
                success: function (response) {
                    if (response != '') {

                        $('.nav-item.nav-link').removeClass('active');
                        $('#nav-basic').addClass('active');
                        $('.tab-content .tab-pane').removeClass('active show');
                        $('#basic').addClass('active show');
                        
                        $('#form-submit').trigger("reset").attr('action', '/admin/user/'+response.member.id);
                        $('input#method').attr('name', '_method').val('PUT');
                        
                        $('.form-row.pass').empty();
                        $('.form-row.refer').empty();
                        $('#modal').modal('show');
                        $('form small.form-text').text('');
                        $('form .form-control').removeClass('is-invalid');
                        $('.modal-title').text('Update Member');
                        
                        $('button[type="submit"]').attr('disabled', false).text('Update');
                        
                        // show value in input tag
                        $.each(response.member, function (key, val) { 
                            $('input#'+key+'').val(val);
                        });
                        $.each(response.info, function (key, val) { 
                            $('input#'+key+'').val(val);
                        });

                        $('select#direction').attr('disabled', true);
                        
                        let single_package = '{!! setting('single_package') !!}';
                        let share_package  = '{!! setting('share_package') !!}';
                        let reg_package = '<option value="">Select Package</option>';
                            reg_package += '<option value="'+single_package+'" '+(parseInt(response.member.register_package) == single_package ? 'selected':'')+'>Single Package ('+single_package+')</option>';
                            reg_package += '<option value="'+share_package+'" '+(parseInt(response.member.register_package) == share_package ? 'selected':'')+'>Share Package ('+share_package+')</option>';
                        
                        $('select#register_package').html(reg_package);

                        let gender = '<option value="">Select Gender</option>';
                            gender += '<option value="Male" '+(response.info.gender == 'Male' ? 'selected':'')+'>Male</option>';
                            gender += '<option value="Female" '+(response.info.gender == 'Female' ? 'selected':'')+'>Female</option>';
                        
                        $('select#gender').html(gender);
                    }
                },
                complete: function () { 
                    $('div.loader').removeClass('d-block').addClass('d-none');
                },
                error: function (xhr) {
                    $.toast({
                        heading: xhr.status,
                        text: xhr.statusText,
                        icon: 'error',
                        position: 'top-right',
                        stack: false
                    });
                }
            });
        });

        // Delete Data
        $(document).on('click', '#deleteData', function (e) { 
            e.preventDefault();

            let url = $(this).attr('href');
            let csrf = $('meta[name="csrf-token"').attr('content');
            if (!confirm('Are you sure delete this data?')) return;
            $.ajax({
                type: "DELETE",
                url: url,
                data: {
                    '_method' : 'DELETE',
                    '_token'  : csrf
                },
                dataType: "JSON",
                beforeSend: function () { 
                    $('div.loader').removeClass('d-none').addClass('d-block');
                },
                success: function (response) {
                    if (response.alert == 'Success') {
                        $.toast({
                            heading: 'Congratulations',
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        })
                        table.ajax.reload();
                    }
                },
                complete: function () { 
                    $('div.loader').removeClass('d-block').addClass('d-none');
                },
                error: function (xhr) { 
                    $.toast({
                        heading: xhr.status,
                        text: xhr.statusText,
                        icon: 'error',
                        position: 'top-right',
                        stack: false
                    });
                }
            }); 
            
        })

        // Update data status
        $(document).on('click', '#workMultiple', function (e) { 
            e.preventDefault();

            let btn = $(this);

            let url = $(this).attr('href');
            if (!confirm('Are you sure take this action?')) return;
            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                beforeSend: function () { 
                    $('div.loader').removeClass('d-none').addClass('d-block');
                    $(btn).addClass('disabled');
                },
                success: function (response) {
                    if (response.alert == 'Success') {
                        $.toast({
                            heading: 'Congratulations',
                            text: response.message,
                            icon: response.alert.toLowerCase(),
                            position: 'top-right',
                            stack: false
                        })
                        table.ajax.reload();
                    }
                },
                complete: function () { 
                    $('div.loader').removeClass('d-block').addClass('d-none');
                },
                error: function (xhr) { 
                    $.toast({
                        heading: xhr.status,
                        text: xhr.statusText,
                        icon: 'error',
                        position: 'top-right',
                        stack: false
                    });
                }
            }); 
            
        });

    });
</script>