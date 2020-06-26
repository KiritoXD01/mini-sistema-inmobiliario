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
                            <td style="width: 10%;">
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
                                                <form action="{{ route('userRole.changeStatus', $userRole->id) }}" method="post" id="formChangeStatus-{{ $userRole->id }}">
                                                    @csrf
                                                    @if($userRole->status)
                                                        <button type="button" class="dropdown-item" onclick="disableItem({{ $userRole->id }})">
                                                            <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                                        </button>
                                                    @else
                                                        <button type="button" class="dropdown-item" onclick="enableItem({{ $userRole->id }})">
                                                            <i class="fa fa-square fa-fw"></i> @lang('messages.enable')
                                                        </button>
                                                    @endif
                                                </form>
                                            @endcan
                                            <div class="dropdown-divider"></div>
                                            @can('user-role-delete')
                                                <form action="{{ route('userRole.destroy', $userRole->id) }}" method="post" id="formDelete-{{ $userRole->id }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="button" class="dropdown-item" onclick="deleteItem({{ $userRole->id }})">
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
        function deleteItem(id) {
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
                                document.getElementById(`formDelete-${id}`).submit();
                            }
                        });
                    }
                });
        }

        function disableItem(id) {
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
                                document.getElementById(`formChangeStatus-${id}`).submit();
                            }
                        });
                    }
                });
        }

        function enableItem(id) {
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
                                document.getElementById(`formChangeStatus-${id}`).submit();
                            }
                        });
                    }
                });
        }

        $(document).ready(function(){
            $("#datatable").dataTable({
                "order": [[ 0, "asc" ]]
            });
        });
    </script>
@endsection
