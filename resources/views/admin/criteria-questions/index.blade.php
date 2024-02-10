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
                    <h3>Criterias and Questions</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Questions</li>
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
                <div class="col-xl-4 xl-30 box-col-30">
                    <div class="md-sidebar email-sidebar">
                        <div class="md-sidebar-aside email-left-aside">
                            <div class="card">
                                <div class="card-body">
                                    <div class="email-app-sidebar left-bookmark">
                                        <ul id="sortable-list" class="nav main-menu contact-options" role="tablist">
                                            <li class="nav-item">
                                                <span class="main-title text-uppercase text-secondary">
                                                    Question Criterias
                                                    <hr>
                                                </span>
                                            </li>
                                            <li>
                                                @foreach ($criterias as $record)
                                                    <a id="pills-{{ $record->id }}-tab" data-bs-toggle="pill" href="#pills-{{ $record->id }}" role="tab" aria-controls="pills-{{ $record->id }}"
                                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}" class="{{ $loop->first ? 'active' : '' }}"><span class="title"> {{ $record->criteria }}</span></a>
                                                @endforeach
                                            </li>
                                            <li>
                                                <button class="btn-sm btn-primary badge-light p-2 pull-right mt-2" id="btnAddCriteria" type="button" data-bs-toggle="modal" data-bs-target="#addCriteria">
                                                    Add Criteria</button>
                                            </li>
                                        </ul>
                                        <div class="modal fade modal-bookmark" id="addCriteria"
                                            role="dialog" aria-labelledby="addCriteriaLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addCriteriaLabel">Record Criteria
                                                        </h5>
                                                        <button class="btn-close" type="button"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="add-criteria-form">
                                                            <div class="row g-2">
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-mail">Criteria</label>
                                                                    {!! Form::text('criteria', null, array('placeholder' => 'Enter Criteria','class' => 'form-control criteria', 'required', 'id' => 'criteria', 'autocomplete' => 'off')) !!}
                                                                    <div class='text-danger' id="criteria-error-message"></div>
                                                                </div>
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-mail">Percentage</label>
                                                                    {!! Form::text('percentage', null, array('placeholder' => 'Input Percentage','class' => 'form-control percentage', 'required', 'id' => 'percentage', 'autocomplete' => 'off')) !!}
                                                                    <div class='text-danger' id="percentage-error-message"></div>
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
                                        <div class="modal fade modal-bookmark" id="addQuestion"
                                            role="dialog" aria-labelledby="addQuestionLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addQuestionLabel">Add Question
                                                        </h5>
                                                        <button class="btn-close" type="button"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="add-form">
                                                            <div class="row g-2">
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label for="con-name">Select Class</label>
                                                                    <select class="form form-select criteria_id" name="criteria_id" id="criteria_id">
                                                                        <option value="">Search name here</option>
                                                                        @foreach($criterias as $criteria)
                                                                            <option
                                                                                value="{{ $criteria->id }}">{{ $criteria->criteria }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-2 col-md-12 mt-0">
                                                                    <label>Question</label>
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            {!! Form::text('question', null, array('placeholder' => 'Input Question','class' => 'form-control question', 'required', 'id' => 'question')) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="pull-right">
                                                                <button class="btn btn-primary" type="button" id="btnSaveQuestion">Save</button>
                                                                <button class="btn btn-secondary d-none" type="button" id="btnSaveQuestionChanges">Save Changes</button>
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
                <div class="col-xl-8 col-md-12 box-col-8 xl-70 box-col-70">
                    <div class="email-right-aside bookmark-tabcontent contacts-tabs">
                        <div class="card email-body">
                            <div class="ps-0">
                                <div class="tab-content">
                                    @foreach ($criterias as $criteria)
                                    <div class="tab-pane fade {{ $loop->first ? 'active show' : '' }}" id="pills-{{ $criteria->id }}" role="tabpanel"
                                        aria-labelledby="pills-{{ $criteria->id }}-tab">
                                        <div class="card mb-0">
                                            <div class="card-header d-flex">
                                                <button class="btn btn-pill btn-primary shadow btn-add-question"
                                                    type="button" data-bs-toggle="modal" data-bs-target="#addQuestion" data-criteria-id="{{ $criteria->id }}">
                                                    Add Question</button>
                                                <h5>{{ $criteria->criteria }} ({{ $criteria->percentage }}%)</h5>
                                                <span class="f-14 pull-right mt-0">
                                                    <ul>
                                                        <li><a href="javascript:void(0)" data-key="{{ $criteria->id }}" data-action="edit" data-bs-toggle="modal" data-bs-target="#addCriteria">Edit</a>
                                                        </li>
                                                        <li><a href="javascript:void(0)" data-key="{{ $criteria->id }}" data-action="delete">Delete</a>
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
                                                                    <th class="text-start">Question</th>
                                                                    <th class="text-center" width="10%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($questions as $question)
                                                                    @if($question->criteria_id == $criteria->id)
                                                                        <tr>
                                                                            <td class="text-start">{{ $question->question }}</td>
                                                                            <td class="text-center" width="10%">
                                                                                <button class="btn btn-info btn-xs btn-square btn-edit-subject" data-key="{{ $question->id }}" data-bs-toggle="modal" data-bs-target="#addQuestion"><i class="fa fa-pencil"></i></button>
                                                                                <button class="btn btn-danger btn-xs btn-square btn-delete-subject" data-key="{{ $question->id }}"><i class="fa fa-trash"></i></button>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
        <script>
            $(function(){
                $("#faculty_id").select2();

                var table = $("table").dataTable({
                    ordering: false,
                    paging: false,
                    "dom": ''
                });

                $("#btnAddCriteria").click(function (e){
                    $("#add-criteria-form")[0].reset();
                    $("#btnAddRecord").removeClass('d-none');
                    $("#btnSaveChangesRecord").addClass('d-none');
                });

                $('#btnAddRecord').click(function (e) {
                    e.preventDefault();
                    let data = $("#add-criteria-form").serialize();
                    $.ajax({
                        url: `/criteria/store`,
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
                                    "criteria",
                                    "percentage",
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
                    let data = $("#add-criteria-form").serialize();
                    $.ajax({
                        url: `/criteria/${id}`,
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
                                    "criteria",
                                    "percentage",
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
                    url : `/criteria/${id}`,
                            success : function (record) {
                                $("#criteria").val(record.criteria);
                                $("#percentage").val(record.percentage);
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
                                url : `/criteria/${id}`,
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

                $('.btn-add-question').on('click', function() {
                    const id = $(this).attr('data-criteria-id');
                    $("#add-form")[0].reset();
                    $('#criteria_id').val(id);
                    $("#btnSaveQuestion").removeClass('d-none');
                    $("#btnSaveQuestionChanges").addClass('d-none');
                });

                $('#btnSaveQuestion').click(function (e) {
                    e.preventDefault();
                    let data = $("#add-form").serialize();
                    $.ajax({
                        url: `/question/store`,
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
                                    "criteria_id",
                                    "question",
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
                    $("#btnSaveQuestion").addClass('d-none');
                    $("#btnSaveQuestionChanges").removeClass('d-none').attr('data-key', id);

                    $.ajax({
                    url : `/question/${id}`,
                            success : function (record) {
                                $("#criteria_id").val(record.criteria_id);
                                $("#question").val(record.question);
                            },
                    });
                });

                $('#btnSaveQuestionChanges').click(function (e) {
                    e.preventDefault();
                    const id = $(this).attr('data-key');
                    let data = $("#add-form").serialize();
                    $.ajax({
                        url: `/question/${id}`,
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
                                    "criteria_id",
                                    "question",
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
                                url : `/question/${id}`,
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
        <script>
            // Initialize Sortable.js for the list
            const sortableList = new Sortable(document.getElementById('sortable-list').getElementsByTagName('li')[1], {
                animation: 150,
                onEnd: function (evt) {
                    const criteriaList = document.querySelectorAll('#sortable-list a');
                    criteriaList.forEach((criteria, index) => {
                        console.log(criteria, index);
                        const criteriaId = criteria.id.split('-')[1];
                        fetch(`/update-criteria-order/${criteriaId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                order_by: index + 1,
                            }),
                        })
                        .then(response => response.json())
                        .then(data => console.log(data))
                        .catch(error => console.error('Error:', error));
                    });
                },
            });
        </script>
    @endpush
@endsection
