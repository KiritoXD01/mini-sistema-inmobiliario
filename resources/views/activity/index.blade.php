@extends('layouts.app')
@section('title', env('APP_NAME').' - Logs')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-list"></i> Logs
        </h1>
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
                <table class="table table-hover" id="datatable" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>@lang('messages.name')</th>
                        <th>@lang('messages.description')</th>
                        <th>@lang('messages.causer')</th>
                        <th>@lang('messages.affectedItem')</th>
                        <th>@lang('messages.created_at')</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td>{{ $activity->log_name }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ (is_null($activity->causer_id)) ? "SYSTEM" : App\Models\User::find($activity->causer_id)->full_name }}</td>
                                <td>
                                    @if($activity->log_name == App\Enums\LogType::USER_LOG)
                                        {{ App\Models\User::find($activity->subject_id)->full_name }}
                                    @elseif($activity->log_name == App\Enums\LogType::COUNTRY_LOG)
                                        {{ App\Models\Country::find($activity->subject_id)->name }}
                                    @elseif($activity->log_name == App\Enums\LogType::CITY_LOG)
                                        {{ App\Models\City::find($activity->subject_id)->name }}
                                    @elseif($activity->log_name == App\Enums\LogType::PROPERTY_TYPE_LOG)
                                        {{ App\Models\PropertyType::find($activity->subject_id)->name }}
                                    @elseif($activity->log_name == App\Enums\LogType::PROPERTY_STATUS_LOG)
                                        {{ App\Models\PropertyStatus::find($activity->subject_id)->name }}
                                    @elseif($activity->log_name == App\Enums\LogType::CURRENCY_LOG)
                                        {{ App\Models\Currency::find($activity->subject_id)->name }}
                                    @elseif($activity->log_name == App\Enums\LogType::PROPERTY_LEGAL_CONDITION)
                                        {{ App\Models\PropertyLegalCondition::find($activity->subject_id)->name }}
                                    @elseif($activity->log_name == App\Enums\LogType::PROPERTY_LOG)
                                        {{ App\Models\Property::find($activity->subject_id)->name }}
                                    @else
                                        Undefined
                                    @endif
                                </td>
                                <td>{{ $activity->created_at }}</td>
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
                "order": [[ 4, "asc" ]]
            })
        });
    </script>
@endsection

