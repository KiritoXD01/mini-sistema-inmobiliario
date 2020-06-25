@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.userRole'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-users-cog"></i> @lang('messages.edit') @lang('messages.userRole') - {{ $role->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('userRole.update', $role->id) }}" method="post" autocomplete="off" id="form">
        @method('PATCH')
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('userRole.index') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-fw fa-save"></i> @lang('messages.save') @lang('messages.userRole')
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
                        <div class="form-group">
                            <label for="name">@lang('messages.name')</label>
                            <input type="text" id="name" name="name" required autofocus class="form-control" value="{{ old('name') ?? $role->name }}" placeholder="@lang('messages.name')...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if ($role->id > 1)
                            @can('user-role-status')
                                <br>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" @if($role->status) checked @endif value="1">
                                        <label class="custom-control-label" for="status">@lang('messages.status')</label>
                                    </div>
                                </div>
                            @endcan
                        @endif
                    </div>
                </div>
                <div class="row">
                    @foreach($permissions as $permission)
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="permission[]" id="permission-{{ $permission->id }}" @if(in_array($permission->id, $rolePermissions)) checked @endif value="{{ $permission->id }}">
                                    <label class="custom-control-label" for="permission-{{ $permission->id }}">{{ $permission->description }}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            $("#form").submit(function(){
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
        });
    </script>
@endsection
