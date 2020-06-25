<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Mini Sistema Registro">
    <meta name="author" content="Javier Mercedes">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }} - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="{{ asset('vendor/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <style>
        .backgroundImg {
            background-image: url("{{ asset('img/logo.png') }}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
        }
    </style>
</head>

<body class="bg-gradient-primary">

<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block backgroundImg"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">@lang('messages.welcome') @lang('messages.user')</h1>
                                </div>
                                <form action="{{ route('login') }}" class="user needs-validation" autocomplete="off" method="post" id="form">
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="list-group">
                                                @foreach ($errors->all() as $error)
                                                    <li class="list-group-item">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('error') }}</strong>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="email" name="email" autofocus required placeholder="@lang('messages.pleaseEnterEmail')..." value="{{ old('email') }}">
                                        <div class="invalid-feedback">@lang('messages.pleaseEnterEmail')</div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" required placeholder="@lang('messages.pleaseEnterPassword')...">
                                        <div class="invalid-feedback">@lang('messages.pleaseEnterPassword')</div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block" id="btnSubmit">
                                        <i class="fa fa-sign-in-alt fa-fw"></i> @lang('messages.login')
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <button type="button" class="btn btn-link" id="btnForgotPassword">
                                        <i class="fa fa-fw fa-unlock-alt"></i>@lang('messages.forgotPassword')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="modalForgotPassword">
        <form action="{{ route('password.email') }}" method="POST" autocomplete="off">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('messages.forgotPassword')</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="emailToSend">Email</label>
                            <input type="email" id="emailToSend" name="email" class="form-control" required maxlength="255" value="" placeholder="Email...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('messages.close')</button>
                        <button type="submit" class="btn btn-success">@lang('messages.send') Email</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('vendor/js/sb-admin-2.min.js') }}"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>
    $(document).ready(function() {
        $("#form").submit(function() {
            Swal.fire({
                title: "@lang('messages.pleaseWait')",
                allowEscapeKey: false,
                allowOutsideClick: false,
                onOpen: () => {
                    Swal.showLoading();
                }
            });
        });

        $("#btnForgotPassword").click(function() {
            $("#modalForgotPassword").modal({
                backdrop: 'static'
            });
        });
    });
</script>

</body>

</html>
