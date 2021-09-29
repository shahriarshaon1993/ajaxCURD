<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- custom files --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/sweetalart2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/toastr/toastr.min.css') }}">

    <title>Ajax CURD</title>
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 45px">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        countries
                    </div>
                    <div class="card-body">
                        .......
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Add new country
                    </div>
                    <div class="card-body">
                        <form action="{{ route('add.country') }}" method="post" id="add-country-form">
                            @csrf
                            <div class="form-group">
                                <label for="">Country name</label>
                                <input type="text" class="form-control" name="country_name" placeholder="Enter country name">
                                <span class="text-danger error-text country_name_error"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Capital city</label>
                                <input type="text" class="form-control" name="capital_city" placeholder="Enter Capital city">
                                <span class="text-danger error-text capital_city_error"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-success">SAVE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/jquery/jQuery.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalart2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/toastr/toastr.min.js') }}"></script>

    <script>

        toastr.options.preventDuplicates = true;

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            
            // Add new country
            $('#add-country-form').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend:function() {
                        $(form).find('span.error-text').text('');
                    },
                    success:function(data) {
                        if(data.code == 0) {
                            $.each(data.error, function(prefix, val) {
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            });
                        }else {
                            $(form)[0].reset();
                            // alert(data.msg);
                            toastr.success(data.msg);
                        }
                    }
                });
            });

        });

    </script>
</body>
</html>