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
                        <table class="table table-hover table-bordered" id="countries-table">
                            <thead>
                                <th>#</th>
                                <th>Country Name</th>
                                <th>Capital city</th>
                            </thead>
                            <tbody></tbody>
                        </table>
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
                                <span class="text-danger error-text country_name_error mt-1"></span>
                            </div>
                            <div class="form-group">
                                <label for="">Capital city</label>
                                <input type="text" class="form-control" name="capital_city" placeholder="Enter Capital city">
                                <span class="text-danger error-text capital_city_error mt-1"></span>
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

        // toastr.options.preventDuplicates = true;
        toastr.options = {
            "closeButton": true,
            // "debug": false,
            // "newestOnTop": false,
            // "progressBar": false,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": false,
            // "onclick": null,
            // "showDuration": "300",
            // "hideDuration": "1000",
            // "timeOut": "60000",
            // "extendedTimeOut": "60000",
            // "showEasing": "swing",
            // "hideEasing": "linear",
            // "showMethod": "fadeIn",
            // "hideMethod": "fadeOut"
        };

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
                            $('#countries-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.msg);
                        }
                    }
                });
            });

            // Get All Countries Lists
            $('#countries-table').DataTable({
                processing: true,
                info:true,
                ajax:"{{ route('get.countries.lists') }}",
                'pageLength': 5,
                'aLengthMenu': [[5,10,25,50,-1],[5,10,25,50,'All']],
                columns: [
                    // {data:'id',name:'id'},
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'country_name',name:'country_name'},
                    {data:'capital_city',name:'capital_city'},
                ]
            });

        });

    </script>
</body>
</html>