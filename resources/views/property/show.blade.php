@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.show').' '.trans('messages.property'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-home"></i> @lang('messages.show') @lang('messages.property') - {{ $property->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-6">
                    <a href="{{ route('property.index') }}" class="btn btn-warning">
                        <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                    </a>
                </div>
                <div class="col-6">
                    <div class="dropdown float-right">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            @lang('messages.actions')
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            @can('property-edit')
                                <a class="dropdown-item" href="{{ route('property.edit', $property->id) }}">
                                    <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                </a>
                                <div class="dropdown-divider"></div>
                            @endcan
                            @can('property-status')
                                <form action="{{ route('property.changeStatus', $property->id) }}" method="post" id="formChangeStatus-{{ $property->id }}">
                                    @csrf
                                    @if($property->status)
                                        <button type="button" class="dropdown-item" onclick="disableItem({{ $property->id }})">
                                            <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                        </button>
                                    @else
                                        <button type="button" class="dropdown-item" onclick="enableItem({{ $property->id }})">
                                            <i class="fa fa-square fa-fw"></i> @lang('messages.enable')
                                        </button>
                                    @endif
                                </form>
                                <div class="dropdown-divider"></div>
                            @endcan
                            @can('property-delete')
                                <form action="{{ route('property.destroy', $property->id) }}" method="post" id="formDelete-{{ $property->id }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button" class="dropdown-item" onclick="deleteItem({{ $property->id }})">
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
                        <input type="text" id="name" class="form-control" value="{{ $property->name }}" placeholder="@lang('messages.name')..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="code">@lang('messages.code')</label>
                        <input type="text" id="code" class="form-control" value="{{ $property->code }}" placeholder="@lang('messages.code')..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="price">@lang('messages.price')</label>
                        <input type="text" id="price" class="form-control" value="{{ $property->price }}" placeholder="@lang('messages.price')..." readonly>
                    </div>
                    <div class="form-group">
                        <label for="property_status_id">@lang('messages.propertyStatus')</label>
                        <input type="text" id="property_status_id" class="form-control" value="{{ $property->propertyStatus->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="property_type_id">@lang('messages.propertyType')</label>
                        <input type="text" id="property_type_id" class="form-control" value="{{ $property->propertyType->name }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="property_legal_condition_id">@lang('messages.propertyLegalCondition')</label>
                        <input type="text" id="property_legal_condition_id" class="form-control" value="{{ $property->propertyLegalCondition->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="country_id">@lang('messages.country')</label>
                        <input type="text" id="country_id" class="form-control" value="{{ $property->country->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="city_id">@lang('messages.city')</label>
                        <input type="text" id="city_id" class="form-control" value="{{ $property->city->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">@lang('messages.status')</label>
                        <input type="text" id="status" class="form-control" value="@if($property->status) @lang('messages.enabled') @else @lang('messages.disabled') @endif" readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_by">@lang('messages.created_by')</label>
                        <input type="text" id="created_by" class="form-control" value="{{ $property->createdBy->full_name }}" placeholder="@lang('messages.created_by')..." readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">@lang('messages.description')</label>
                        <textarea id="description" name="description" class="form-control" readonly rows="5" style="resize: none;" placeholder="@lang('messages.description')...">{{ $property->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <i class="fa fa-image fa-fw"></i> @lang('messages.images')
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($property->propertyImages as $image)
                    <div class="col">
                        <img src="/{{ $image->path }}" style="width: 100%;" alt="{{ $image->id }}">
                    </div>
                @endforeach
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
