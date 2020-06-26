@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.user'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-users"></i> @lang('messages.edit') @lang('messages.user') - {{ $user->full_name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('user.update', $user->id) }}" method="post" id="form" autocomplete="off">
        @csrf
        @method("PATCH")
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('user.index') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-fw fa-save"></i> @lang('messages.update') @lang('messages.user')
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-group">
                            @foreach ($errors->all() as $error)
                                <li class="list-group-item">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="firstname">@lang('messages.firstname')</label>
                                <input type="text" id="firstname" name="firstname" required autofocus maxlength="255" class="form-control" value="{{ old('firstname') ?? $user->firstname }}" placeholder="@lang('messages.firstname')...">
                            </div>
                            <div class="col-6">
                                <label for="lastname">@lang('messages.lastname')</label>
                                <input type="text" id="lastname" name="lastname" required autofocus maxlength="255" class="form-control" value="{{ old('lastname') ?? $user->lastname }}" placeholder="@lang('messages.lastname')...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required class="form-control" value="{{ old('email') ?? $user->email }}" placeholder="Email...">
                        </div>
                        <div class="form-group">
                            <label for="role">@lang('messages.userRole')</label>
                            <select id="role" name="role" class="form-control" required style="width: 100%;">
                                <option value="" selected hidden disabled>-- @lang('messages.userRole') --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role }}" @if($user->roles->first()->name == $role) selected @endif>{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->id != $user->id)
                            @can('user-delete')
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" @if($user->status) checked @endif value="1">
                                        <label class="custom-control-label" for="status">@lang('messages.status')</label>
                                    </div>
                                </div>
                            @endcan
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phonenumber">@lang('messages.phoneNumber')</label>
                            <input type="tel" id="phonenumber" name="phonenumber" class="form-control" value="{{ old('phonenumber') ?? $user->phonenumber }}" maxlength="30" placeholder="@lang('messages.phoneNumber')...">
                        </div>
                        <div class="form-group">
                            <label for="password">@lang('messages.change') @lang('messages.password')</label>
                            <input type="password" id="password" name="password" class="form-control" minlength="8" maxlength="100" value="" placeholder="@lang('messages.password')...">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">@lang('messages.confirmPassword')</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" value="" placeholder="@lang('messages.confirmPassword')...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            $("#password").keyup(function(){
                document.getElementById("password_confirmation").required = this.value.trim().length > 0;
            });

            $("#form").submit(function() {
                Swal.fire({
                    title: "@lang('messages.pleaseWait')",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            $("#role").select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endsection

