@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.currencies'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-dollar-sign"></i> @lang('messages.edit') @lang('messages.currency') - {{ $currency->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('currency.update', $currency->id) }}" method="post" id="form" autocomplete="off">
        @csrf
        @method("PATCH")
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('currency.index') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-fw fa-save"></i> @lang('messages.update') @lang('messages.currency')
                        </button>
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
                            <input type="text" id="name" name="name" required maxlength="255" class="form-control" value="{{ old('name') ?? $currency->name }}" placeholder="@lang('messages.name')...">
                        </div>
                        <div class="form-group">
                            <label for="format_code">@lang('messages.formatCode')</label>
                            <div class="input-group">
                                <input type="text" id="format_code" name="format_code" required maxlength="5" class="form-control" placeholder="@lang('messages.formatCode') (xx_XX)" pattern="[a-z][a-z][-_][A-Z][A-Z]" value="{{ old('format_code') ?? $currency->format_code }}">
                                <div class="input-group-append">
                                    <a href="http://www.webtutoriales.com/articulos/codigos-de-paises-e-idiomas-i18n" class="btn btn-primary" target="_blank">
                                        <i class="fa fa-globe fa-fw"></i> @lang('messages.showCodes')
                                    </a>
                                </div>
                            </div>
                        </div>
                        @can('currency-status')
                            <div class="form-group">
                                <br>
                                <div class="custom-control custom-switch">
                                    <input type="hidden" name="status" value="0">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" @if($currency->status) checked @endif value="1">
                                    <label class="custom-control-label" for="status">@lang('messages.status')</label>
                                </div>
                            </div>
                        @endcan
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rate">@lang('messages.price')</label>
                            <input type="text" id="rate" name="rate" class="form-control" required value="{{ old('rate') ?? $currency->rate }}" placeholder="@lang('messages.price')...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            $("#form").submit(function() {
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

