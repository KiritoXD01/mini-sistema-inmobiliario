@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.users'))

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-fw fa-users"></i> @lang('messages.users')
    </h1>
    @can('user-create')
        <div class="btn-group">
            <a href="{{ route('user.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle fa-sm fa-fw text-white-50"></i> @lang('messages.create') @lang('messages.user')
            </a>
            <button type="button" class="d-none d-sm-inline-block btn btn-warning shadow-sm" id="btnModalImport">
                <i class="fa fa-file-excel"></i> @lang('messages.import') @lang('messages.users')
            </button>
            <a href="{{ route('user.export') }}" class="d-none d-sm-inline-block btn btn-success shadow-sm" id="btnModalExport">
                <i class="fa fa-file-excel"></i> @lang('messages.export') @lang('messages.users')
            </a>
        </div>
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
                    <th>@lang('messages.firstname')</th>
                    <th>@lang('messages.lastname')</th>
                    <th>Email</th>
                    <th>@lang('messages.status')</th>
                    <th>@lang('messages.userRole')</th>
                    <td>@lang('messages.actions')</td>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="text-center">
                        <td>{{ $user->firstname }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->status)
                                <span class="badge badge-primary">@lang('messages.enabled')</span>
                            @else
                                <span class="badge badge-danger">@lang('messages.disabled')</span>
                            @endif
                        </td>
                        <td>{{ $user->roles->first()->name }}</td>
                        <td>
                            <form action="{{ route('user.destroy', $user->id) }}" method="post" id="formDelete{{ $user->id }}">
                                @method("DELETE")
                                @csrf
                                <div class="btn-group" role="group">
                                    @can('user-show')
                                        <a href="{{ route('user.show', $user->id) }}" class="btn btn-primary">
                                            <i class="fa fa-eye fa-fw"></i> @lang('messages.show')
                                        </a>
                                    @endcan
                                    @can('user-edit')
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info">
                                            <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                        </a>
                                    @endcan
                                    @can('user-delete')
                                        @if($user->status)
                                            <input type="hidden" name="status" value="0">
                                            <button type="button" class="btn btn-danger" onclick="deleteItem({{ $user->id }}, {{ $user->status }})" @if($user->id == auth()->user()->id) disabled @endif>
                                                <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                            </button>
                                        @else
                                            <input type="hidden" name="status" value="1">
                                            <button type="button" class="btn btn-primary" onclick="deleteItem({{ $user->id }}, {{ $user->status }})" @if($user->id == auth()->user()->id) disabled @endif>
                                                <i class="fa fa-check-square fa-fw"></i> @lang('messages.enable')
                                            </button>
                                        @endif
                                    @endcan
                                </div>
                            </form>
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
