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
                    <h3>Subjects per Class</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Subjects</li>
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
                    <div class="md-sidebar email-sidebar"><a class="btn btn-primary md-sidebar-toggle"
                            href="javascript:void(0)">class_id </a>
                        <div class="md-sidebar-aside email-left-aside">
                            <div class="card">
                                <div class="card-body">
                                    <div class="email-app-sidebar left-bookmark">
                                        <ul class="nav main-menu contact-options" role="tablist">
                                            <li class="nav-item">
                                                <span class="main-title text-uppercase text-secondary">
                                                    Classes
                                                    <hr>
                                                </span>
                                            </li>
                                            <li>
                                                @foreach ($classes as $record)
                                                    <a id="pills-{{ $record->id }}-tab" data-bs-toggle="pill" href="#pills-{{ $record->id }}" role="tab" aria-controls="pills-{{ $record->id }}"
                                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}" class="{{ $loop->first ? 'active' : '' }}"><span class="title"> {{ $record->class_code }}</span></a>
                                                @endforeach
                                            </li>
                                            <li>
                                                <button class="btn-sm btn-primary badge-light p-2 pull-right mt-2" id="btnAddClass" type="button" data-bs-toggle="modal" data-bs-target="#addClass">
                                                    Add Classes</button>
                                            </li>
                                        </ul>
                                        <div class="modal fade modal-bookmark" id="addClass"
                                            role="dialog" aria-labelledby="addClassLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addClassLabel">Record Classes
                                                        </h5>
                                                        <button class="btn-close" type="button"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="add-class-form">
                                                            <div class="row g-2">
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-mail">Course</label>
                                                                    {!! Form::text('course', null, array('placeholder' => 'Input Course','class' => 'form-control course', 'required', 'id' => 'course', 'autocomplete' => 'off')) !!}
                                                                    <div class='text-danger' id="course-error-message"></div>
                                                                </div>
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-mail">Year Level</label>
                                                                    <select class="form form-select year_level" name="year_level" id="year_level">
                                                                        <option selected value="1st Year">1st Year</option>
                                                                        <option value="2nd Year">2nd Year</option>
                                                                        <option value="3rd Year">3rd Year</option>
                                                                        <option value="4th Year">4th Year</option>
                                                                        <option value="5th Year">5th Year</option>
                                                                    </select>
                                                                    <div class='text-danger' id="year_level-error-message"></div>
                                                                </div>
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-mail">Section</label>
                                                                    {!! Form::text('section', null, array('placeholder' => 'section','class' => 'form-control section', 'required', 'id' => 'section', 'autocomplete' => 'off')) !!}
                                                                    <div class='text-danger' id="section-error-message"></div>
                                                                </div>
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-mail">Class Code</label>
                                                                    <input type="hidden" name="academic_id" value="{{ $defaultAcademicYear->id }}">
                                                                    {!! Form::text('class_code', null, array('class' => 'form-control class_code', 'readonly', 'id' => 'class_code', 'autocomplete' => 'off')) !!}
                                                                    <div class='text-danger' id="class_code-error-message"></div>
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
                                        <div class="modal fade modal-bookmark" id="addSubject"
                                            role="dialog" aria-labelledby="addSubjectLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addSubjectLabel">Add Subject
                                                        </h5>
                                                        <button class="btn-close" type="button"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="add-form">
                                                            <div class="row g-2">
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-name">Select Class</label>
                                                                    <select class="form form-select class_id" name="class_id" id="class_id">
                                                                        <option value="">Search name here</option>
                                                                        @foreach($classes as $class)
                                                                            <option
                                                                                value="{{ $class->id }}">{{ $class->class_code }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-name">Assign Faculty</label>
                                                                    <select class="form form-select faculty_id" name="faculty_id" id="faculty_id">
                                                                        <option value="">Search name here</option>
                                                                        @foreach($faculties as $faculty)
                                                                            <option
                                                                                value="{{ $faculty->id }}">{{ $faculty->fullname }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class='text-danger' id="faculty_id-error-message"></div>
                                                                </div>
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label>Subject Code</label>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            {!! Form::text('subject_code', null, array('placeholder' => 'Input Subject Code','class' => 'form-control subject_code', 'required', 'id' => 'subject_code')) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label>Description</label>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            {!! Form::text('description', null, array('placeholder' => 'Input Description','class' => 'form-control description', 'required', 'id' => 'description')) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="pull-right">
                                                                <button class="btn btn-primary" type="button" id="btnSaveSubject">Save</button>
                                                                <button class="btn btn-secondary d-none" type="button" id="btnSaveSubjectChanges">Save Changes</button>
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
                                    @foreach ($classes as $curr)
                                    <div class="tab-pane fade {{ $loop->first ? 'active show' : '' }}" id="pills-{{ $curr->id }}" role="tabpanel"
                                        aria-labelledby="pills-{{ $curr->id }}-tab">
                                        <div class="card mb-0">
                                            <div class="card-header d-flex">
                                                <button class="btn btn-pill btn-primary shadow btn-add-subject"
                                                    type="button" data-bs-toggle="modal" data-bs-target="#addSubject" data-class-id="{{ $curr->id }}">
                                                    Add Subject</button>
                                                <h5>{{ $curr->class_code }}</h5>
                                                <span class="f-14 pull-right mt-0">
                                                    <ul>
                                                        <li><a href="javascript:void(0)" data-key="{{ $curr->id }}" data-class-code="{{ $curr->class_code }}" data-action="edit" data-bs-toggle="modal" data-bs-target="#addClass">Edit</a>
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
                                                                    <th class="text-center">Subject Code</th>
                                                                    <th class="text-start">Assigned Faculty</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($subjects as $subject)
                                                                    @if($subject->class_id == $curr->id)
                                                                        <tr>
                                                                            <td class="text-center fw-bold">{{ $subject->subject_code }}</td>
                                                                            <td class="text-start">{{ $subject->faculty?->fullname }}</td>
                                                                            <td class="text-center">
                                                                                <button class="btn btn-primary btn-xs btn-square btn-view-subject" data-key="{{ $subject->id }}" data-code="{{ $subject->subject_code }}" data-bs-toggle="modal" data-bs-target="#viewStudents"><i class="fa fa-users"></i></button>
                                                                                <button class="btn btn-info btn-xs btn-square btn-edit-subject" data-key="{{ $subject->id }}" data-bs-toggle="modal" data-bs-target="#addSubject"><i class="fa fa-pencil"></i></button>
                                                                                <button class="btn btn-danger btn-xs btn-square btn-delete-subject" data-key="{{ $subject->id }}"><i class="fa fa-trash"></i></button>
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
                function isMobileOrTablet() {
                    return window.innerWidth <= 768; // Adjust the threshold as needed
                }

                // Set initial values
                let topPosition = 10;
                let leftPosition = 291;

                // Check if it's a mobile or tablet and update positions
                if (isMobileOrTablet()) {
                    topPosition = 0;
                    leftPosition = 0;
                }

                if (isMobileOrTablet()) {
                    topPosition = 0;
                    leftPosition = 0;
                }

                $("#faculty_id").select2();

                var table = $("table").dataTable();

                function classCode(){
                    let course = $("#course").val();
                    let yearLevel = $("#year_level").val();
                    let section = $("#section").val();

                    $("#class_code").val(`${course}-${yearLevel.charAt(0)}${section}`);
                }


                $('#course').keyup(function(){
                    classCode();
                });

                $('#year_level').change(function(){
                    classCode();
                });

                $('#section').keyup(function(){
                    classCode();
                });

                $("#btnAddClass").click(function (e){
                    $("#add-class-form")[0].reset();
                    $("#btnAddRecord").removeClass('d-none');
                    $("#btnSaveChangesRecord").addClass('d-none');
                });

                $('#btnAddRecord').click(function (e) {
                    e.preventDefault();
                    let data = $("#add-class-form").serialize();
                    $.ajax({
                        url: `/classes/store`,
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
                                    "class_code",
                                    "course",
                                    "year_level",
                                    "section",
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
                    let data = $("#add-class-form").serialize();
                    $.ajax({
                        url: `/classes/${id}`,
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
                                    "class_code",
                                    "course",
                                    "year_level",
                                    "section",
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
                    const class_code = $(this).attr('data-class-code');
                    $("#btnAddRecord").addClass('d-none');
                    $("#btnSaveChangesRecord").removeClass('d-none').attr('data-key', id);

                    $.ajax({
                    url : `/classes/${id}`,
                            success : function (record) {
                                $("#class_code").val(record.class_code);
                                $("#course").val(record.course);
                                $("#year_level").val(record.year_level);
                                $("#section").val(record.section);
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
                                url : `/classes/${id}`,
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

                $('.btn-add-subject').on('click', function() {
                    const id = $(this).attr('data-class-id');
                    $("#add-form")[0].reset();
                    $('#class_id').val(id);
                    $("#btnSaveSubject").removeClass('d-none');
                    $("#btnSaveSubjectChanges").addClass('d-none');
                });

                $('#btnSaveSubject').click(function (e) {
                    e.preventDefault();
                    let data = $("#add-form").serialize();
                    $.ajax({
                        url: `/subject`,
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
                                    "class_id",
                                    "faculty_id",
                                    "subject_code",
                                    "description",
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

                $('.btn-edit-subject').on('click', function() {
                    const id = $(this).attr('data-key');
                    $("#btnSaveSubject").addClass('d-none');
                    $("#btnSaveSubjectChanges").removeClass('d-none').attr('data-key', id);

                    $.ajax({
                    url : `/subject/${id}`,
                            success : function (record) {
                                $("#class_id").val(record.class_id);
                                $("#faculty_id").val(record.faculty_id);
                                $("#subject_code").val(record.subject_code);
                                $("#description").val(record.description);
                            },
                    });
                });

                $('#btnSaveSubjectChanges').click(function (e) {
                    e.preventDefault();
                    const id = $(this).attr('data-key');
                    let data = $("#add-form").serialize();
                    $.ajax({
                        url: `/subject/${id}`,
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
                                    "class_id",
                                    "faculty_id",
                                    "subject_code",
                                    "description",
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
                                url : `/subject/${id}`,
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

                $(document).on('click', '.btn-view-subject', function () {
                    let subjectId = $(this).attr('data-key');
                    let subjectCode = $(this).attr('data-code');

                    box = new WinBox(`View Enrolled Students of ${subjectCode}`, {
                        root: document.querySelector('.page-content'),
                        class: ["no-min", "no-full"],
                        url: `/students/${subjectId}?winbox=1`,
                        index : 999999,
                        background: "#2a3042",
                        border: "0.3em",
                        width: "100%",
                        height: "100%",
                        top: topPosition,
                        left: leftPosition,
                    }).movable();
                });
            });
        </script>
    @endpush
@endsection
