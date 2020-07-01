@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.show').' '.trans('messages.propertyLegalCondition'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-home"></i> @lang('messages.show') @lang('messages.propertyLegalCondition') - {{ $propertyLegalCondition->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('propertyLegalCondition.index') }}" class="btn btn-warning">
                        <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                    </a>
                </div>
                <div class="col-6">
                    <div class="dropdown float-right">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            @lang('messages.actions')
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            @can('property-legal-edit')
                                <a class="dropdown-item" href="{{ route('propertyStatus.edit', $propertyLegalCondition->id) }}">
                                    <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                </a>
                                <div class="dropdown-divider"></div>
                            @endcan
                            @can('property-legal-status')
                                <form action="{{ route('propertyLegalCondition.changeStatus', $propertyLegalCondition->id) }}" method="post" id="formChangeStatus-{{ $propertyLegalCondition->id }}">
                                    @csrf
                                    @if($propertyLegalCondition->status)
                                        <button type="button" class="dropdown-item" onclick="disableItem({{ $propertyLegalCondition->id }})">
                                            <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                        </button>
                                    @else
                                        <button type="button" class="dropdown-item" onclick="enableItem({{ $propertyLegalCondition->id }})">
                                            <i class="fa fa-square fa-fw"></i> @lang('messages.enable')
                                        </button>
                                    @endif
                                </form>
                                <div class="dropdown-divider"></div>
                            @endcan
                            @can('property-legal-delete')
                                <form action="{{ route('propertyLegalCondition.destroy', $propertyLegalCondition->id) }}" method="post" id="formDelete-{{ $propertyLegalCondition->id }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button" class="dropdown-item" onclick="deleteItem({{ $propertyLegalCondition->id }})">
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
                        <input type="text" id="name" class="form-control" value="{{ $propertyLegalCondition->name }}" placeholder="@lang('messages.name')..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">@lang('messages.status')</label>
                        <input type="text" id="status" class="form-control" value="@if($propertyLegalCondition->status) @lang('messages.enabled') @else @lang('messages.disabled') @endif" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="created_at">@lang('messages.created_at')</label>
                        <input type="text" id="created_at" class="form-control" value="{{ $propertyLegalCondition->created_at }}" placeholder="@lang('messages.created_at')..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_by">@lang('messages.created_by')</label>
                        <input type="text" id="created_by" class="form-control" value="{{ $propertyLegalCondition->createdBy->full_name }}" placeholder="@lang('messages.created_by')..." readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    </script>
@endsection
