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
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('userRole.index') }}" class="btn btn-warning">
                        <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.back')
                    </a>
                </div>
                <div class="col-6">
                    @if ($role->id > 3)
                        <div class="dropdown float-right">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                @lang('messages.actions')
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                @if($role->id > 3)
                                    @can('user-role-edit')
                                        <a class="dropdown-item" href="{{ route('userRole.edit', $role->id) }}">
                                            <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @endcan
                                    @can('user-role-status')
                                        <form action="{{ route('userRole.changeStatus', $role->id) }}" method="post" id="formChangeStatus">
                                            @csrf
                                            @if($role->status)
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
                                    @can('user-role-delete')
                                        <form action="{{ route('userRole.destroy', $role->id) }}" method="post" id="formDelete">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" class="dropdown-item" onclick="deleteItem()">
                                                <i class="fa fa-trash fa-fw"></i> @lang('messages.delete')
                                            </button>
                                        </form>
                                    @endcan
                                @endif
                            </div>
                        </div>
                    @endif
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

@section('javascript')
    <script>
        function deleteItem() {
            Swal
                .fire({
                    title: "@lang('messages.deleteItem')",
                    icon: 'question',
                    showCancelButton: true,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: "@lang('messages.yes')",
                    cancelButtonText: "No",
                    reverseButtons: true
                })
                .then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: "@lang('messages.pleaseWait')",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                Swal.showLoading();
                                document.getElementById(`formDelete`).submit();
                            }
                        });
                    }
                });
        }

        function disableItem() {
            Swal
                .fire({
                    title: "@lang('messages.disableItem')",
                    icon: 'question',
                    showCancelButton: true,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: "@lang('messages.yes')",
                    cancelButtonText: "No",
                    reverseButtons: true
                })
                .then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: "@lang('messages.pleaseWait')",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                Swal.showLoading();
                                document.getElementById(`formChangeStatus`).submit();
                            }
                        });
                    }
                });
        }

        function enableItem() {
            Swal
                .fire({
                    title: "@lang('messages.enableItem')",
                    icon: 'question',
                    showCancelButton: true,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: "@lang('messages.yes')",
                    cancelButtonText: "No",
                    reverseButtons: true
                })
                .then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: "@lang('messages.pleaseWait')",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                Swal.showLoading();
                                document.getElementById(`formChangeStatus`).submit();
                            }
                        });
                    }
                });
        }

    </script>
@endsection
