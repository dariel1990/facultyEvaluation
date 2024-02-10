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
                    <h3>Faculty per Department</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Faculty</li>
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
                <div class="col-xl-3 xl-30 box-col-30">
                    <div class="md-sidebar email-sidebar">
                        <div class="md-sidebar-aside email-left-aside">
                            <div class="card">
                                <div class="card-body">
                                    <div class="email-app-sidebar left-bookmark">
                                        <ul class="nav main-menu contact-options" role="tablist">
                                            <li class="nav-item">
                                                <span class="main-title text-uppercase text-secondary">
                                                    Departments
                                                    <hr>
                                                </span>
                                            </li>
                                            <li>
                                                @foreach ($departments as $record)
                                                    <a id="pills-{{ $record->id }}-tab" data-bs-toggle="pill" href="#pills-{{ $record->id }}" role="tab" aria-controls="pills-{{ $record->id }}"
                                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}" class="{{ $loop->first ? 'active' : '' }}"><span class="title"> {{ $record->short_name }}</span></a>
                                                @endforeach
                                            </li>
                                            <li>
                                                <button class="btn-sm btn-primary badge-light p-2 pull-right mt-2" id="btnAddDepartment" type="button" data-bs-toggle="modal" data-bs-target="#addDepartment">
                                                    Add Department</button>
                                            </li>
                                        </ul>
                                        <div class="modal fade modal-bookmark" id="addDepartment"
                                            role="dialog" aria-labelledby="addDepartmentLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addDepartmentLabel">Record Department
                                                        </h5>
                                                        <button class="btn-close" type="button"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="add-department-form">
                                                            <div class="row g-2">
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-mail">Department Name</label>
                                                                    {!! Form::text('short_name', null, array('placeholder' => 'Input Department Name','class' => 'form-control short_name', 'required', 'id' => 'short_name', 'autocomplete' => 'off')) !!}
                                                                    <div class='text-danger' id="short_name-error-message"></div>
                                                                </div>
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-mail">Full Description</label>
                                                                    {!! Form::text('description', null, array('placeholder' => 'Full Description','class' => 'form-control description', 'required', 'id' => 'description', 'autocomplete' => 'off')) !!}
                                                                    <div class='text-danger' id="description-error-message"></div>
                                                                </div>
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-mail">Program Head</label>
                                                                    {!! Form::text('program_head', null, array('placeholder' => 'Program Head','class' => 'form-control program_head', 'required', 'id' => 'program_head', 'autocomplete' => 'off')) !!}
                                                                    <div class='text-danger' id="program_head-error-message"></div>
                                                                </div>
                                                            </div>
                                                            <div class="pull-right mt-3">
                                                                <button class="btn btn-secondary" type="button" id="btnAddRecord">Save</button>
                                                                <button class="btn btn-secondary d-none" type="button" id="btnSaveChangesRecord">Save Changes</button>
                                                                <button class="btn btn-primary" type="button"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade modal-bookmark" id="addFaculty"
                                            role="dialog" aria-labelledby="addFacultyLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addFacultyLabel">Add Faculty
                                                        </h5>
                                                        <button class="btn-close" type="button"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="add-form">
                                                            @csrf
                                                                <div class="row">
                                                                    <div class="mb-2 col-md-12 mt-0">
                                                                        <label for="con-name">Select Department</label>
                                                                        <select class="form form-select department_id" name="department_id" id="department_id">
                                                                            <option value="">Search name here</option>
                                                                            @foreach($departments as $department)
                                                                                <option
                                                                                    value="{{ $department->id }}">{{ $department->short_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
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
                                                                    <div class="mb-2 col-md-6 mt-0">
                                                                        <label for="con-mail">Contact #</label>
                                                                        {!! Form::text('contact_no', null, array('placeholder' => 'Contact #','class' => 'form-control contact_no', 'required', 'id' => 'contact_no', 'autocomplete' => 'off')) !!}
                                                                        <div class='text-danger' id="contact_no-error-message"></div>
                                                                    </div>
                                                                    <div class="mb-2 col-md-6 mt-0">
                                                                        <label for="con-name">Employment Status</label>
                                                                        <select class="form form-select employment_status" name="employment_status" id="employment_status">
                                                                            <option selected value="Permanent">Permanent</option>
                                                                            <option value="Contractual">Contractual</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <button class="btn btn-primary" type="button" id="btnSaveFaculty">Save</button>
                                                                    <button class="btn btn-secondary d-none" type="button" id="btnSaveFacultyChanges">Save Changes</button>
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
                </div>
                <div class="col-xl-9 col-md-12 box-col-8 xl-70 box-col-70">
                    <div class="email-right-aside bookmark-tabcontent contacts-tabs">
                        <div class="card email-body">
                            <div class="ps-0">
                                <div class="tab-content">
                                    @foreach ($departments as $curr)
                                    <div class="tab-pane fade {{ $loop->first ? 'active show' : '' }}" id="pills-{{ $curr->id }}" role="tabpanel"
                                        aria-labelledby="pills-{{ $curr->id }}-tab">
                                        <div class="card mb-0">
                                            <div class="card-header d-flex">
                                                <button class="btn btn-pill btn-primary shadow btn-add-faculty"
                                                    type="button" data-bs-toggle="modal" data-bs-target="#addFaculty" data-department-id="{{ $curr->id }}">
                                                    Add Faculty</button>
                                                <h5>{{ $curr->short_name }}</h5>
                                                <span class="f-14 pull-right mt-0">
                                                    <ul>
                                                        <li><a href="javascript:void(0)" data-key="{{ $curr->id }}" data-action="edit" data-bs-toggle="modal" data-bs-target="#addDepartment">Edit</a>
                                                        </li>
                                                        <li><a href="javascript:void(0)" data-key="{{ $curr->id }}" data-action="delete">Delete</a>
                                                        </li>
                                                    </ul>
                                                </span>
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="row list-persons" id="addcon">
                                                    <div class="col-xl-12">
                                                        <table class="table table-condensed" id="record-table" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-start">Faculty</th>
                                                                    <th class="text-center">Contact #</th>
                                                                    <th class="text-center">Status</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($faculties as $faculty)
                                                                    @if($faculty->department_id == $curr->id)
                                                                        <tr>
                                                                            <td class="text-start fw-bold">{{ $faculty->fullname }}</td>
                                                                            <td class="text-center">{{ $faculty->contact_no }}</td>
                                                                            <td class="text-center">{{ $faculty->employment_status }}</td>
                                                                            <td class="text-center">
                                                                                <button class="btn btn-info btn-xs btn-square btn-edit-faculty" data-key="{{ $faculty->id }}" data-bs-toggle="modal" data-bs-target="#addFaculty"><i class="fa fa-pencil"></i></button>
                                                                                <button class="btn btn-danger btn-xs btn-square btn-delete-subject" data-key="{{ $faculty->id }}"><i class="fa fa-trash"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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

                $("#btnAddDepartment").click(function (e){
                    $("#add-department-form")[0].reset();
                    $("#btnAddRecord").removeClass('d-none');
                    $("#btnSaveChangesRecord").addClass('d-none');
                });

                $('#btnAddRecord').click(function (e) {
                    e.preventDefault();
                    let data = $("#add-department-form").serialize();
                    $.ajax({
                        url: `/department/store`,
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
                                    "short_name",
                                    "description",
                                    "program_head",
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

                $('#btnSaveChangesRecord').click(function (e) {
                    e.preventDefault();
                    const id = $(this).attr('data-key');
                    let data = $("#add-department-form").serialize();
                    $.ajax({
                        url: `/department/${id}`,
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
                                    "short_name",
                                    "description",
                                    "program_head",
                                ];
                            $.each(inputNames, function (index, value) {
                                if (errors.hasOwnProperty(value)) {
                                    swal({
                                        text : `${errors[value][0]}`,
                                        icon : 'error',
                                        timer : 1500,
                                        buttons : false,
                                    });
                                }
                            });

                            }
                        },
                    });
                });

                $('a[data-action="edit"]').on('click', function() {
                    const id = $(this).attr('data-key');
                    $("#btnAddRecord").addClass('d-none');
                    $("#btnSaveChangesRecord").removeClass('d-none').attr('data-key', id);

                    $.ajax({
                    url : `/department/${id}`,
                            success : function (record) {
                                $("#short_name").val(record.short_name);
                                $("#description").val(record.description);
                                $("#program_head").val(record.program_head);
                            },
                    });
                });

                $('a[data-action="delete"]').on('click', function() {
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
                                url : `/department/${id}`,
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

                $('.btn-add-faculty').on('click', function() {
                    const id = $(this).attr('data-department-id');
                    $("#add-form")[0].reset();
                    $('#department_id').val(id);
                    $("#btnSaveFaculty").removeClass('d-none');
                    $("#btnSaveFacultyChanges").addClass('d-none');
                });

                $('#btnSaveFaculty').click(function (e) {
                    e.preventDefault();
                    let data = $("#add-form").serialize();
                    $.ajax({
                        url: `/faculty`,
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
                                    "employment_status",
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

                $('.btn-edit-faculty').on('click', function() {
                    const id = $(this).attr('data-key');
                    $("#btnSaveFaculty").addClass('d-none');
                    $("#btnSaveFacultyChanges").removeClass('d-none').attr('data-key', id);

                    $.ajax({
                    url : `/faculty/${id}`,
                            success : function (record) {
                                $("#department_id").val(record.department_id);
                                $("#first_name").val(record.first_name);
                                $("#middle_name").val(record.middle_name);
                                $("#last_name").val(record.last_name);
                                $("#suffix").val(record.suffix);
                                $("#contact_no").val(record.contact_no);
                                $("#employment_status").val(record.employment_status);
                            },
                    });
                });

                $('#btnSaveFacultyChanges').click(function (e) {
                    e.preventDefault();
                    const id = $(this).attr('data-key');
                    let data = $("#add-form").serialize();
                    $.ajax({
                        url: `/faculty/${id}`,
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
                                    "employment_status",
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

                $('.btn-delete-subject').on('click', function() {
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
                                url : `/faculty/${id}`,
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
