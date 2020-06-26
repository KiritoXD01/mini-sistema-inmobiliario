@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.user'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-users"></i> @lang('messages.show') @lang('messages.user') - {{ $user->full_name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('user.index') }}" class="btn btn-warning">
                        <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.back')
                    </a>
                </div>
                <div class="col-6">
                    <div class="dropdown float-right">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            @lang('messages.actions')
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            @can('user-edit')
                                <a class="dropdown-item" href="{{ route('user.edit', $user->id) }}">
                                    <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                </a>
                                <div class="dropdown-divider"></div>
                            @endcan
                            @can('user-status')
                                <form action="{{ route('user.changeStatus', $user->id) }}" method="post" id="formChangeStatus">
                                    @csrf
                                    @if($user->status)
                                        <button type="submit" class="dropdown-item" onclick="disableItem()">
                                            <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                        </button>
                                    @else
                                        <button type="submit" class="dropdown-item" onclick="enableItem()">
                                            <i class="fa fa-square fa-fw"></i> @lang('messages.enable')
                                        </button>
                                    @endif
                                </form>
                            @endcan
                            <div class="dropdown-divider"></div>
                            @can('user-delete')
                                <form action="{{ route('user.destroy', $user->id) }}" method="post" id="formDelete">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button" class="dropdown-item" onclick="deleteItem()">
                                        <i class="fa fa-trash fa-fw"></i> @lang('messages.delete')
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="firstname">@lang('messages.firstname')</label>
                            <input type="text" id="firstname" class="form-control" value="{{ $user->firstname }}" placeholder="@lang('messages.firstname')..." readonly>
                        </div>
                        <div class="col-6">
                            <label for="lastname">@lang('messages.lastname')</label>
                            <input type="text" id="lastname" class="form-control" value="{{ $user->lastname }}" placeholder="@lang('messages.lastname')..." readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" class="form-control" value="{{ $user->email }}" placeholder="Email..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="role">@lang('messages.userRole')</label>
                        <input type="text" id="role" class="form-control" value="{{ $user->roles->first()->name }}" placeholder="@lang('messages.userRole')..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">@lang('messages.status')</label>
                        <input type="text" id="status" class="form-control" value="@if($user->status) @lang('messages.enabled') @else @lang('messages.disabled') @endif" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="code">@lang('messages.code')</label>
                        <input type="text" id="code" class="form-control" value="{{ $user->code }}" placeholder="@lang('messages.code')..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="phonenumber">@lang('messages.phoneNumber')</label>
                        <input type="text" id="phonenumber" class="form-control" value="{{ $user->phonenumber }}" placeholder="@lang('messages.phoneNumber')..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_at">@lang('messages.created_at')</label>
                        <input type="text" id="created_at" class="form-control" value="{{ $user->created_at }}" placeholder="@lang('messages.created_at')..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_by">@lang('messages.created_by')</label>
                        <input type="text" id="created_by" class="form-control" value="{{ $user->createdBy->full_name }}" placeholder="@lang('messages.created_by')..." readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection

