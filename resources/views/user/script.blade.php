<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: '{!! route('home') !!}',
            dataType: "HTML",
            beforeSend: function() {
                $('#loading-image').removeClass('d-none').addClass('d-block')
            },
            success: function (response) {
                $('#main-content').empty()
                $('#main-content').html(response)
            },
            complete: function() {
                $('#loading-image').addClass('d-none').removeClass('d-block')
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });

        $(document).on('click', '#view-page', function(e) {
            e.preventDefault();

            $('#sidebar').css('width', '0')
            let url = $(this).attr('href');

            $.ajax({
                type: "GET",
                url: url,
                dataType: "HTML",
                beforeSend: function() {
                    $('#loading-image').removeClass('d-none').addClass('d-block')
                },
                success: function (response) {

                    $('#main-content').empty()
                    $('#main-content').html(response)
                },
                complete: function() {
                    $('#loading-image').addClass('d-none').removeClass('d-block')
                },
                error: function(xhr) {
                    console.log(xhr);
                },
            });
        })
    });
</script>
