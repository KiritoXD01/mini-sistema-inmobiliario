@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.create').' '.trans('messages.property'))

@section('css')
<style>
    .ck-editor__editable_inline {
        min-height: 400px;
    }
</style>
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-home"></i> @lang('messages.create') @lang('messages.property')
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('property.store') }}" method="post" autocomplete="off" id="form" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('property.index') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fa fa-fw fa-save"></i> @lang('messages.save') @lang('messages.property')
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">@lang('messages.name')</label>
                            <input type="text" id="name" name="name" required maxlength="255" class="form-control" value="{{ old('name') }}" placeholder="@lang('messages.name')...">
                        </div>
                        <div class="form-group">
                            <label for="code">@lang('messages.code')</label>
                            <input type="text" id="code" name="code" class="form-control" maxlength="255" value="{{ old('code') }}" placeholder="@lang('messages.code')...">
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label for="price">@lang('messages.price')</label>
                                <input type="text" id="price" name="price" required class="form-control" value="{{ old('price') }}" placeholder="@lang('messages.price')...">
                            </div>
                            <div class="col-4">
                                <label for="currency_id">@lang('messages.currency')</label>
                                <select id="currency_id" name="currency_id" class="form-control" required style="width: 100%;">
                                    <option value="" selected hidden disabled>-- @lang('messages.currency') --</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}" data-rate="{{ $currency->rate }}" data-code="{{ $currency->format_code }}" @if(old('currency_id') == $currency->id) selected @endif>{{ $currency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="convertedPrice">@lang('messages.convertedPrice')</label>
                                <input type="text" id="convertedPrice" class="form-control" placeholder="@lang('messages.convertedPrice')..." value="" readonly style="background-color: white;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="property_status_id">@lang('messages.propertyStatus')</label>
                            <select id="property_status_id" name="property_status_id" class="form-control" style="width: 100%;" required>
                                <option value="" disabled selected hidden>-- @lang('messages.propertyStatus') --</option>
                                @foreach($allPropertyStatus as $propertyStatus)
                                    <option value="{{ $propertyStatus->id }}" @if(old('property_status_id') == $propertyStatus->id) selected @endif>{{ $propertyStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="property_type_id">@lang('messages.propertyType')</label>
                            <select id="property_type_id" name="property_type_id" class="form-control" required style="width: 100%;">
                                <option value="" disabled selected hidden>-- @lang('messages.propertyType') --</option>
                                @foreach($propertyTypes as $propertyType)
                                    <option value="{{ $propertyType->id }}" @if($propertyType->id == old('property_type_id')) selected @endif>{{ $propertyType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lounge_quantity">@lang('messages.lounge_quantity')</label>
                            <input type="text" id="lounge_quantity" name="lounge_quantity" class="form-control" required value="{{ old('lounge_quantity') }}" placeholder="@lang('messages.lounge_quantity')..." onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group">
                            <label for="kitchen_quantity">@lang('messages.kitchen_quantity')</label>
                            <input type="text" id="kitchen_quantity" name="kitchen_quantity" class="form-control" required value="{{ old('kitchen_quantity') }}" placeholder="@lang('messages.kitchen_quantity')..." onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" checked value="1">
                                <label class="custom-control-label" for="status">@lang('messages.status')</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="property_legal_condition_id">@lang('messages.propertyLegalCondition')</label>
                            <select id="property_legal_condition_id" name="property_legal_condition_id" class="form-control" required style="width: 100%;">
                                <option value="" disabled selected hidden>-- @lang('messages.propertyLegalCondition') --</option>
                                @foreach($propertyLegalConditions as $propertyLegalCondition)
                                    <option value="{{ $propertyLegalCondition->id }}" @if($propertyLegalCondition->id == old('property_legal_condition_id')) selected @endif>{{ $propertyLegalCondition->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="country_id">@lang('messages.country')</label>
                            <select id="country_id" name="country_id" class="form-control" required style="width: 100%;">
                                <option value="" disabled selected hidden>-- @lang('messages.country') --</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @if($country->id == old('country_id')) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city_id">@lang('messages.city')</label>
                            <select id="city_id" name="city_id" class="form-control" required style="width: 100%;" disabled>
                                <option value="" disabled selected hidden>-- @lang('messages.city') --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bedroom_quantity">@lang('messages.bedroom_quantity')</label>
                            <input type="text" id="bedroom_quantity" name="bedroom_quantity" class="form-control" required value="{{ old('bedroom_quantity') }}" placeholder="@lang('messages.bedroom_quantity')..." onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group">
                            <label for="bathroom_quantity">@lang('messages.bathroom_quantity')</label>
                            <input type="text" id="bathroom_quantity" name="bathroom_quantity" class="form-control" required value="{{ old('bathroom_quantity') }}" placeholder="@lang('messages.bathroom_quantity')..." onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group">
                            <label for="parking_quantity">@lang('messages.parking_quantity')</label>
                            <input type="text" id="parking_quantity" name="parking_quantity" class="form-control" required value="{{ old('parking_quantity') }}" placeholder="@lang('messages.parking_quantity')..." onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group">
                            <label for="property_level">@lang('messages.property_level')</label>
                            <input type="text" id="property_level" name="property_level" class="form-control" required value="{{ old('property_level') }}" placeholder="@lang('messages.property_level')..." onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="custom-control custom-switch">
                                    <input type="hidden" name="has_water" value="0">
                                    <input type="checkbox" class="custom-control-input" id="has_water" name="has_water" value="1">
                                    <label class="custom-control-label" for="has_water">@lang('messages.has_water')</label>
                                </div>
                                <br>
                                <div class="custom-control custom-switch">
                                    <input type="hidden" name="has_heating" value="0">
                                    <input type="checkbox" class="custom-control-input" id="has_heating" name="has_heating" value="1">
                                    <label class="custom-control-label" for="has_heating">@lang('messages.has_heating')</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="custom-control custom-switch">
                                    <input type="hidden" name="has_air_conditioning" value="0">
                                    <input type="checkbox" class="custom-control-input" id="has_air_conditioning" name="has_air_conditioning" value="1">
                                    <label class="custom-control-label" for="has_air_conditioning">@lang('messages.has_air_conditioning')</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">@lang('messages.description')</label>
                            <textarea id="description" name="description" class="form-control"></textarea>
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
                <div class="input-images"></div>
            </div>
        </div>
    </form>
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

            $("#property_status_id").select2({
                theme: 'bootstrap4'
            });
            $("#property_legal_condition_id").select2({
                theme: 'bootstrap4'
            });
            $("#property_type_id").select2({
                theme: 'bootstrap4'
            });
            $("#country_id").select2({
                theme: 'bootstrap4'
            });
            $("#currency_id").select2({
                theme: 'bootstrap4'
            });

            //Event handler to update the converted price when
            //the currency changes
            $("#currency_id").change(function(){
                if (document.getElementById("price").value.length > 0) {
                    setConvertedPrice();
                }
            });

            //Event handler to update the converted price when
            //the price changes
            $("#price").change(function(){
                if (this.value.length > 0 && parseFloat($("#currency_id").find(':selected').data("rate")) > 0) {
                    setConvertedPrice();
                }
            });

            //Event handler to allow only one dot and numbers
            $("#price").keydown(function(event){
                if (event.shiftKey) {
                    event.preventDefault();
                }

                if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

                } else {
                    event.preventDefault();
                }

                if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                    event.preventDefault();
            });

            //Filter the cities with the country_id
            $("#country_id").change(function(){
                const country_id = this.value;
                const url = "{{ route('property.getCitiesByCountry')}}";

                $.get(url, {
                    country_id: country_id
                },
                function(result){
                    let html = "";
                    result.forEach(item => {
                        html += `<option value="${item.id}">${item.name}</option>`;
                    });
                    $("#city_id").html(html);
                    $("#city_id").select2({
                        theme: 'bootstrap4'
                    });
                    document.getElementById("city_id").disabled = false;
                });
            });

            $('.input-images').imageUploader();

            ClassicEditor
                .create(document.querySelector("#description"),{
                    removePlugins: ['MediaEmbed', 'EasyImage', 'Image', "ImageCaption", "ImageStyle", "ImageToolbar", "ImageUpload"]
                })
                .then(editor => console.log(editor))
                .catch(error => console.log(error));
        });

        function isNumberKey(evt) {
            let charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function setConvertedPrice() {
            const price = parseFloat(document.getElementById("price").value).toFixed(2);
            const rate  = parseFloat($("#currency_id").find(":selected").data("rate")).toFixed(2);
            const code  = $("#currency_id").find(":selected").data("code");

            const money = Intl.NumberFormat(code).format(parseFloat(price * rate).toFixed(2));

            document.getElementById("convertedPrice").value = money;
        }
    </script>
@endsection
