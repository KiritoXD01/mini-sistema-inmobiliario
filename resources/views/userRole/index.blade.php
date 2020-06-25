@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.userRoles'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-users-cog"></i> @lang('messages.userRoles')
        </h1>
        @can('user-role-create')
            <a href="{{ route('userRole.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle fa-sm fa-fw text-white-50"></i> @lang('messages.create') @lang('messages.userRole')
            </a>
        @endcan
    </div>
    <!-- End Page Heading -->

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover" id="datatable">
                    <thead>
                    <tr>
                        <th>@lang('messages.name')</th>
                        <th>@lang('messages.status')</th>
                        <td>@lang('messages.actions')</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userRoles as $userRole)
                        <tr class="text-center">
                            <td>{{ $userRole->name }}</td>
                            <td>
                                @if($userRole->status)
                                    <span class="badge badge-primary">@lang('messages.enabled')</span>
                                @else
                                    <span class="badge badge-danger">@lang('messages.disabled')</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        @lang('messages.actions')
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('user-role-show')
                                            <a class="dropdown-item" href="{{ route('userRole.show', $userRole->id) }}">
                                                <i class="fa fa-eye fa-fw"></i> @lang('messages.show')
                                            </a>
                                        @endcan
                                        @if($userRole->id > 3)
                                            <div class="dropdown-divider"></div>
                                            @can('user-role-edit')
                                                <a class="dropdown-item" href="{{ route('userRole.edit', $userRole->id) }}">
                                                    <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                                </a>
                                            @endcan
                                            <div class="dropdown-divider"></div>
                                            @can('user-role-status')
                                                <form action="{{ route('userRole.changeStatus', $userRole->id) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        @if($userRole->status)
                                                            <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                                        @else
                                                            <i class="fa fa-square fa-fw"></i> @lang('messages.enable')
                                                        @endif
                                                    </button>
                                                </form>
                                            @endcan
                                            <div class="dropdown-divider"></div>
                                            @can('user-role-delete')
                                                <form action="{{ route('userRole.destroy', $userRole->id) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fa fa-trash fa-fw"></i> @lang('messages.delete')
                                                    </button>
                                                </form>
                                            @endcan
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Table -->
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            $("#datatable").dataTable({
                "order": [[ 0, "asc" ]]
            });
        });
    </script>
@endsection
