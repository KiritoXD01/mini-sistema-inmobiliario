@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.propertyStatus'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-home"></i> @lang('messages.propertyStatus')
        </h1>
        @can('property-status-create')
            <a href="{{ route('propertyStatus.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                <i class="fas fa-plus-circle fa-sm fa-fw text-white-50"></i> @lang('messages.create') @lang('messages.propertyStatus')
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
                    @foreach($allPropertyStatus as $propertyStatus)
                        <tr class="text-center">
                            <td>{{ $propertyStatus->name }}</td>
                            <td>
                                @if($propertyStatus->status)
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
                                        @can('property-status-show')
                                            <a class="dropdown-item" href="{{ route('propertyStatus.show', $propertyStatus->id) }}">
                                                <i class="fa fa-eye fa-fw"></i> @lang('messages.show')
                                            </a>
                                            <div class="dropdown-divider"></div>
                                        @endcan
                                        @can('property-status-edit')
                                            <a class="dropdown-item" href="{{ route('propertyStatus.edit', $propertyStatus->id) }}">
                                                <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                            </a>
                                            <div class="dropdown-divider"></div>
                                        @endcan
                                        @can('property-status-status')
                                            <form action="{{ route('propertyStatus.changeStatus', $propertyStatus->id) }}" method="post" id="formChangeStatus-{{ $propertyStatus->id }}">
                                                @csrf
                                                @if($propertyStatus->status)
                                                    <button type="button" class="dropdown-item" onclick="disableItem({{ $propertyStatus->id }})">
                                                        <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                                    </button>
                                                @else
                                                    <button type="button" class="dropdown-item" onclick="enableItem({{ $propertyStatus->id }})">
                                                        <i class="fa fa-square fa-fw"></i> @lang('messages.enable')
                                                    </button>
                                                @endif
                                            </form>
                                            <div class="dropdown-divider"></div>
                                        @endcan
                                        @can('property-status-delete')
                                            <form action="{{ route('propertyStatus.destroy', $propertyStatus->id) }}" method="post" id="formDelete-{{ $propertyStatus->id }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" class="dropdown-item" onclick="deleteItem({{ $propertyStatus->id }})">
                                                    <i class="fa fa-trash fa-fw"></i> @lang('messages.delete')
                                                </button>
                                            </form>
                                        @endcan
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

