@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.cities'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-flag"></i> @lang('messages.cities')
        </h1>
        @can('user-create')
            <div class="btn-group">
                <a href="{{ route('city.create') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
                    <i class="fas fa-plus-circle fa-sm fa-fw text-white-50"></i> @lang('messages.create') @lang('messages.city')
                </a>
                <button type="button" class="d-none d-sm-inline-block btn btn-warning shadow-sm" id="btnModalImport">
                    <i class="fa fa-file-excel"></i> @lang('messages.import') @lang('messages.cities')
                </button>
                <a href="{{ route('city.export') }}" class="d-none d-sm-inline-block btn btn-success shadow-sm" id="btnModalExport">
                    <i class="fa fa-file-excel"></i> @lang('messages.export') @lang('messages.cities')
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
                        <th>@lang('messages.country')</th>
                        <th>@lang('messages.status')</th>
                        <td>@lang('messages.actions')</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cities as $city)
                        <tr class="text-center">
                            <td>{{ $city->name }}</td>
                            <td>{{ $city->country->name }}</td>
                            <td>
                                @if($city->status)
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
                                        @can('city-show')
                                            <a class="dropdown-item" href="{{ route('city.show', $city->id) }}">
                                                <i class="fa fa-eye fa-fw"></i> @lang('messages.show')
                                            </a>
                                            <div class="dropdown-divider"></div>
                                        @endcan
                                        @can('city-edit')
                                            <a class="dropdown-item" href="{{ route('city.edit', $city->id) }}">
                                                <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                            </a>
                                            <div class="dropdown-divider"></div>
                                        @endcan
                                        @can('city-status')
                                            <form action="{{ route('city.changeStatus', $city->id) }}" method="post" id="formChangeStatus-{{ $city->id }}">
                                                @csrf
                                                @if($city->status)
                                                    <button type="button" class="dropdown-item" onclick="disableItem({{ $city->id }})">
                                                        <i class="fa fa-square fa-fw"></i> @lang('messages.disable')
                                                    </button>
                                                @else
                                                    <button type="button" class="dropdown-item" onclick="enableItem({{ $city->id }})">
                                                        <i class="fa fa-square fa-fw"></i> @lang('messages.enable')
                                                    </button>
                                                @endif
                                            </form>
                                            <div class="dropdown-divider"></div>
                                        @endcan
                                        @can('city-delete')
                                            <form action="{{ route('city.destroy', $city->id) }}" method="post" id="formDelete-{{ $city->id }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" class="dropdown-item" onclick="deleteItem({{ $city->id }})">
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

    <!-- The Modal -->
    <form action="{{ route('city.import') }}" autocomplete="off" method="post" id="FormImport">
        @csrf
        <div class="modal fade" id="ModalImport">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('messages.import') @lang('messages.cities')</h4>
                        <button type="button" class="close" onclick="closeModal()">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>@lang('messages.name')</th>
                                    <th>@lang('messages.country')</th>
                                    <th>@lang('messages.delete')</th>
                                </tr>
                                </thead>
                                <tbody id="listItemsToAdd">
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <button type="button" class="btn btn-primary btn-block" id="btnAdd">
                                            <i class="fa fa-plus fa-fw"></i> @lang('messages.add') @lang('messages.city')
                                        </button>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td style="width: 50%;">
                                    <button type="button" class="btn btn-warning btn-block" onclick="closeModal()">
                                        <i class="fa fa-undo fa-fw"></i> @lang('messages.close')
                                    </button>
                                </td>
                                <td style="width: 50%;">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fa fa-save fa-fw"></i> @lang('messages.create') @lang('messages.cities')
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- End Modal -->
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

        function checkName(element)
        {
            if (element.checkValidity())
            {
                $.get("{{ route('city.checkName') }}", {
                        name: element.value
                    },
                    function(result)
                    {
                        if (result.name) {
                            element.classList.add("is-invalid");
                        }
                        else {
                            element.classList.remove("is-invalid");
                        }
                    });
            }
        }

        function addItem()
        {
            const id = Date.now();

            let html =
                `
                    <tr id="item-${id}">
                        <td>
                            <div class="form-group">
                                <input type="text" name="name[]" value="" maxlength="255" class="form-control" placeholder="@lang('messages.name')..." required onfocusout="checkName(this);" />
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <select name="country_id[]" id="country_id-${id}" class="form-control" required style="width: 100%">
                                    <option value="" selected hidden disabled>-- @lang('messages.country') --</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td style="width: 5%;">
                            <button type="button" class="btn btn-danger btn-block" onclick="removeItem(${id})">
                                <i class="fa fa-trash fa-fw"></i>
                            </button>
                        </td>
                    </tr>
                `;
            $("#listItemsToAdd").append(html);
            $("[name*=country_id]").each(function(){
                $(`#${this.id}`).select2({
                    theme: 'bootstrap4'
                });
            });
        }

        function removeItem(id)
        {
            const items = $("#listItemsToAdd tr").length;

            if (items > 1)
            {
                $(`#item-${id}`).remove();
            }
            else
            {
                $(`#item-${id} input`).val("");
                $(`#item-${id} select`).val("");
                $(`#item-${id} input`).removeClass("is-invalid");
            }
        }

        function closeModal()
        {
            $("#listItemsToAdd").html("");
            $("#ModalImport").modal("hide");
        }

        $(document).ready(function(){
            $("#datatable").dataTable({
                "order": [[ 0, "asc" ]]
            });

            $("#btnModalImport").click(function(){
                addItem();
                $("#ModalImport").modal({
                    backdrop: 'static'
                });
            });

            $("#FormImport").submit(function(){
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

            $("#btnAdd").click(function(){
                addItem();
            });
        });
    </script>
@endsection

