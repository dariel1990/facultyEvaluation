@extends('layouts.app')
@prepend('page-css')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        .winbox {
            background: linear-gradient(90deg, #ff00f0, #0050ff);
            border-radius: 12px 12px 0 0;
        }
    </style>
@endprepend
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Supervisors</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Supervisor</li>
                        <li class="breadcrumb-item active">Lists</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="email-wrap bookmark-wrap">
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="email-right-aside bookmark-tabcontent contacts-tabs">
                        <div class="card mb-0">
                            <div class="card-header d-flex">
                                <button class="btn btn-pill btn-primary shadow btn-add-supervisor"
                                    type="button" data-bs-toggle="modal" data-bs-target="#addSupervisor">
                                    Add Supervisor</button>
                            </div>
                            <div class="card-body p-2">
                                <div class="row list-persons" id="addcon">
                                    <div class="col-xl-12">
                                        <table class="table table-condensed" id="record-table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-start">Supervisor</th>
                                                    <th class="text-center">Contact #</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($supervisors as $record)
                                                <tr>
                                                    <td class="text-start fw-bold">{{ $record->fullname }}</td>
                                                    <td class="text-center">{{ $record->contact_no }}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-info btn-xs btn-square btn-edit-supervisor" data-key="{{ $record->id }}" data-bs-toggle="modal" data-bs-target="#addSupervisor"><i class="fa fa-pencil"></i></button>
                                                        <button class="btn btn-danger btn-xs btn-square btn-delete-supervisor" data-key="{{ $record->id }}"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade modal-bookmark" id="addSupervisor"
                        role="dialog" aria-labelledby="addSupervisorLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addSupervisorLabel">Add Supervisor
                                    </h5>
                                    <button class="btn-close" type="button"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="add-form">
                                        @csrf
                                            <div class="row">
                                                <div class="mb-2 col-md-4 mt-0">
                                                    <label for="con-mail">First Name</label>
                                                    {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control first_name', 'required', 'id' => 'first_name', 'autocomplete' => 'off')) !!}
                                                </div>
                                                <div class="mb-2 col-md-2 mt-0">
                                                    <label for="con-mail">Middle Initial</label>
                                                    {!! Form::text('middle_name', null, array('placeholder' => 'M.I.','class' => 'form-control middle_name', 'required', 'id' => 'middle_name', 'autocomplete' => 'off')) !!}
                                                </div>
                                                <div class="mb-2 col-md-4 mt-0">
                                                    <label for="con-mail">Last Name</label>
                                                    {!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control last_name', 'required', 'id' => 'last_name', 'autocomplete' => 'off')) !!}
                                                </div>
                                                <div class="mb-2 col-md-2 mt-0">
                                                    <label for="con-mail">Suffix</label>
                                                    {!! Form::text('suffix', null, array('placeholder' => 'Suffix','class' => 'form-control suffix', 'required', 'id' => 'suffix', 'autocomplete' => 'off')) !!}
                                                    <div class='text-danger' id="suffix-error-message"></div>
                                                </div>
                                                <div class="mb-4 col-md-12 mt-0">
                                                    <label for="con-mail">Contact #</label>
                                                    {!! Form::text('contact_no', null, array('placeholder' => 'Contact #','class' => 'form-control contact_no', 'required', 'id' => 'contact_no', 'autocomplete' => 'off')) !!}
                                                    <div class='text-danger' id="contact_no-error-message"></div>
                                                </div>
                                            </div>
                                            <div class="pull-right">
                                                <button class="btn btn-primary" type="button" id="btnSaveSupervisor">Save</button>
                                                <button class="btn btn-secondary d-none" type="button" id="btnSaveSupervisorChanges">Save Changes</button>
                                                <button class="btn btn-danger" type="button"
                                                data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @push('page-scripts')
        <script src="{{ asset('/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('/assets/libs/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('/assets/libs/sweetalert2/sweetalert.min.js') }}"></script>
        <script>
            $(function(){
                var table = $("table").dataTable();

                $('.btn-add-supervisor').on('click', function() {
                    $("#add-form")[0].reset();
                    $("#btnSaveSupervisor").removeClass('d-none');
                    $("#btnSaveSupervisorChanges").addClass('d-none');
                });

                $('#btnSaveSupervisor').click(function (e) {
                    e.preventDefault();
                    let data = $("#add-form").serialize();
                    $.ajax({
                        url: `/supervisor`,
                        method : 'POST',
                        data: data,
                        success : function (response) {
                            if(response.success == true){
                                swal({
                                    text : 'Successfully added!',
                                    icon : 'success',
                                    timer : 2500,
                                    buttons : false,
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            }
                        },
                        error: function (response) {
                            if (response.status === 422) {
                                let errors = response.responseJSON.errors;
                                const inputNames = [
                                    "first_name",
                                    "middle_name",
                                    "last_name",
                                    "suffix",
                                    "contact_no",
                                ];
                                $.each(inputNames, function (index, value) {
                                    if (errors.hasOwnProperty(value)) {
                                        $(`.${value}`).addClass("is-invalid");
                                        $(`#${value}-error-message`).html("");
                                        $(`#${value}-error-message`).append(
                                            `${errors[value][0]}`
                                        );
                                    } else {
                                        $(`.${value}`).removeClass("is-invalid");
                                        $(`#${value}-error-message`).html("");
                                    }
                                });

                            }
                        },
                    });
                });

                $('.btn-edit-supervisor').on('click', function() {
                    const id = $(this).attr('data-key');
                    $("#btnSaveSupervisor").addClass('d-none');
                    $("#btnSaveSupervisorChanges").removeClass('d-none').attr('data-key', id);

                    $.ajax({
                    url : `/supervisor/${id}`,
                            success : function (record) {
                                $("#first_name").val(record.first_name);
                                $("#middle_name").val(record.middle_name);
                                $("#last_name").val(record.last_name);
                                $("#suffix").val(record.suffix);
                                $("#contact_no").val(record.contact_no);
                            },
                    });
                });

                $('#btnSaveSupervisorChanges').click(function (e) {
                    e.preventDefault();
                    const id = $(this).attr('data-key');
                    let data = $("#add-form").serialize();
                    $.ajax({
                        url: `/supervisor/${id}`,
                        method : 'PUT',
                        data: data,
                        success : function (response) {
                            if(response.success == true){
                                swal({
                                    text : 'Successfully updated!',
                                    icon : 'success',
                                    timer : 2500,
                                    buttons : false,
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            }
                        },
                        error: function (response) {
                            if (response.status === 422) {
                                let errors = response.responseJSON.errors;
                                const inputNames = [
                                    "first_name",
                                    "middle_name",
                                    "last_name",
                                    "suffix",
                                    "contact_no",
                                ];
                                $.each(inputNames, function (index, value) {
                                    if (errors.hasOwnProperty(value)) {
                                        $(`.${value}`).addClass("is-invalid");
                                    } else {
                                        $(`.${value}`).removeClass("is-invalid");
                                    }
                                });

                            }
                        },
                    });
                });

                $('.btn-delete-supervisor').on('click', function() {
                    const id = $(this).attr('data-key');
                    swal({
                        text: "Are you sure you want to delete this?",
                        icon: "warning",
                        buttons: [
                            'No',
                            'Yes!'
                        ],
                        dangerMode: true,
                        closeOnClickOutside: false,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url : `/supervisor/${id}`,
                                method : 'DELETE',
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                success : function (response) {
                                    if(response.success == true){
                                        swal({
                                            text : 'Successfully deleted!',
                                            icon : 'success',
                                            timer : 1500,
                                            buttons : false,
                                        });
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1500);
                                    }
                                },
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
