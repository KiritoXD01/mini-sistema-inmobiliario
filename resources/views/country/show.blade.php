@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.country'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-users"></i> @lang('messages.show') @lang('messages.country') - {{ $country->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('country.index') }}" class="btn btn-warning">
                        <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                    </a>
                </div>
                <div class="col-6">
                    <div class="dropdown float-right">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            @lang('messages.actions')
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            @can('country-edit')
                                <a class="dropdown-item" href="{{ route('country.edit', $country->id) }}">
                                    <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                </a>
                                <div class="dropdown-divider"></div>
                            @endcan
                            @can('country-status')
                                <form action="{{ route('country.changeStatus', $country->id) }}" method="post" id="formChangeStatus">
                                    @csrf
                                    @if($country->status)
                                        <button type="submit" class="dropdown-item" onclick="disableItem()">
                                            <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                        </button>
                                    @else
                                        <button type="submit" class="dropdown-item" onclick="enableItem()">
                                            <i class="fa fa-square fa-fw"></i> @lang('messages.enable')
                                        </button>
                                    @endif
                                </form>
                                <div class="dropdown-divider"></div>
                            @endcan
                            @can('country-delete')
                                <form action="{{ route('country.destroy', $country->id) }}" method="post" id="formDelete">
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
                    <div class="form-group">
                        <label for="name">@lang('messages.name')</label>
                        <input type="text" id="name" class="form-control" value="{{ $country->name }}" placeholder="@lang('messages.name')..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">@lang('messages.status')</label>
                        <input type="text" id="status" class="form-control" value="@if($country->status) @lang('messages.enabled') @else @lang('messages.disabled') @endif" readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_by">@lang('messages.created_by')</label>
                        <input type="text" id="created_by" class="form-control" value="{{ $country->createdBy->full_name }}" placeholder="@lang('messages.created_by')..." readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="iso">ISO</label>
                        <input type="text" id="iso" class="form-control" value="{{ $country->iso }}" placeholder="ISO..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_at">@lang('messages.created_at')</label>
                        <input type="text" id="created_at" class="form-control" value="{{ $country->created_at }}" placeholder="@lang('messages.created_at')..." readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

