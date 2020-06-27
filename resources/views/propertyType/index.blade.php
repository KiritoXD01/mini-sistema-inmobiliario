@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.propertyTypes'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-home"></i> @lang('messages.propertyTypes')
        </h1>
        @can('property-type-create')
            <div class="btn-group">
                <a href="{{ route('propertyType.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                    <i class="fas fa-plus-circle fa-sm fa-fw text-white-50"></i> @lang('messages.create') @lang('messages.propertyType')
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
                        <th>@lang('messages.name')</th>
                        <th>@lang('messages.status')</th>
                        <td>@lang('messages.actions')</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($propertyTypes as $propertyType)
                        <tr class="text-center">
                            <td>{{ $propertyType->name }}</td>
                            <td>
                                @if($propertyType->status)
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
                                        @can('property-type-show')
                                            <a class="dropdown-item" href="{{ route('propertyType.show', $propertyType->id) }}">
                                                <i class="fa fa-eye fa-fw"></i> @lang('messages.show')
                                            </a>
                                            <div class="dropdown-divider"></div>
                                        @endcan
                                        @can('property-type-edit')
                                            <a class="dropdown-item" href="{{ route('propertyType.edit', $propertyType->id) }}">
                                                <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                            </a>
                                            <div class="dropdown-divider"></div>
                                        @endcan
                                        @can('property-type-status')
                                            <form action="{{ route('propertyType.changeStatus', $propertyType->id) }}" method="post" id="formChangeStatus-{{ $propertyType->id }}">
                                                @csrf
                                                @if($propertyType->status)
                                                    <button type="button" class="dropdown-item" onclick="disableItem({{ $propertyType->id }})">
                                                        <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                                    </button>
                                                @else
                                                    <button type="button" class="dropdown-item" onclick="enableItem({{ $propertyType->id }})">
                                                        <i class="fa fa-square fa-fw"></i> @lang('messages.enable')
                                                    </button>
                                                @endif
                                            </form>
                                            <div class="dropdown-divider"></div>
                                        @endcan
                                        @can('property-type-delete')
                                            <form action="{{ route('propertyType.destroy', $propertyType->id) }}" method="post" id="formDelete-{{ $propertyType->id }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" class="dropdown-item" onclick="deleteItem({{ $propertyType->id }})">
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
        $(document).ready(function(){
            $("#datatable").dataTable({
                "order": [[ 0, "asc" ]]
            });
        });
    </script>
@endsection
