@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.show').' '.trans('messages.userRole'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-users-cog"></i> @lang('messages.show') @lang('messages.userRole') - {{ $role->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('userRole.index') }}" class="btn btn-warning">
                <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.back')
            </a>
            @if ($role->id > 3)
                @can('user-role-edit')
                    <a href="{{ route('userRole.index') }}" class="btn btn-primary">
                        <i class="fa fa-fw fa-edit"></i> @lang('messages.edit') @lang('messages.userRole')
                    </a>
                @endif
            @endif
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
                        <input type="text" id="name" class="form-control" value="{{ $role->name }}" placeholder="@lang('messages.name')..." readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">@lang('messages.status')</label>
                        <input type="text" id="status" class="form-control" value="@if($role->status) @lang('messages.enabled') @else @lang('messages.disabled') @endif" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($permissions as $permission)
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" disabled name="permission[]" id="permission-{{ $permission->id }}" @if(in_array($permission->id, $rolePermissions)) checked @endif value="{{ $permission->id }}">
                                <label class="custom-control-label" for="permission-{{ $permission->id }}">{{ $permission->description }}</label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

