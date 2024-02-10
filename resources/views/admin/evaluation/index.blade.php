@extends('layouts.app')
@prepend('page-css')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        .swal-text {
            text-align: center;
        }
    </style>
@endprepend
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Evaluations for {{ $defaultPeriod->semester == '1' ? '1st Semester of' : '2nd Semester of' }} of {{ $defaultPeriod->academic_year }}</h2>
                </div>
                <div class="pull-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Evaluations</li>
                        <li class="breadcrumb-item active">Lists</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 box-col-12">
            <div class="card">
                <div class="card-body py-3">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        <div class="row">
                            <div class="col-4 mb-2">
                                <div class="input-group mb-2">
                                    <div class="input-group-text">Evaluation Type</div>
                                    <select class='form-select' id='filterEvaluationType'>
                                        <option value="Student">Student</option>
                                        <option value="Peer">Peer</option>
                                        <option value="Supervisor">Supervisor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4"></div>
                            <div class="col-4 mb-2">
                                <div class="input-group mb-2">
                                    <div class="input-group-text">Search</div>
                                    <input class="form-control" id="keyword">
                                </div>
                            </div>
                        </div>
                        <div class="table">
                            <table class="table table-dashed" id="evaluation-table">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="text-start">Faculty Member</th>
                                        <th class="text-center">Department</th>
                                        <th class="text-center">Employment Status</th>
                                        <th class="text-start">Evaluation Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade modal-bookmark" id="assignPeer"
                role="dialog" aria-labelledby="assignPeerLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="assignPeerLabel">Assign this Evaluation to Peer Faculties
                            </h5>
                            <button class="btn-close" type="button"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="assign-peer-form">
                                <div class="row g-2">
                                    <div class="mb-2 col-md-12 mt-0">
                                        <input type="hidden" id="evaluation_id" name="evaluation_id">
                                        <label for="con-name">Assign Faculties</label>
                                        <select class="form form-select faculty-input" name="faculty_id[]" id="faculty_id" multiple="multiple">
                                            <option value="">Search name here</option>
                                            @foreach($faculties as $faculty)
                                                <option
                                                    value="{{ $faculty->id }}">{{ $faculty->fullname }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class='text-danger' id="faculty_id-error-message"></div>
                                    </div>
                                </div>
                                <div class="pull-right mt-2">
                                    <button class="btn btn-primary" type="button" id="btnAssignPeer">Assign Peers</button>
                                    <button class="btn btn-danger" type="button"
                                    data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade modal-bookmark" id="assignSupervisor"
                role="dialog" aria-labelledby="assignSupervisorLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="assignSupervisorLabel">Assign this Evaluation to Supervisor
                            </h5>
                            <button class="btn-close" type="button"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="assign-supervisor-form">
                                <div class="row g-2">
                                    <div class="mb-2 col-md-12 mt-0">
                                        <input type="hidden" id="sup_evaluation_id" name="sup_evaluation_id">
                                        <label for="con-name">Assign Supervisor</label>
                                        <select class="form form-select supervisor-input" name="supervisor_id[]" id="supervisor_id" multiple="multiple">
                                            <option value="">Search name here</option>
                                            @foreach($supervisors as $supervisor)
                                                <option
                                                    value="{{ $supervisor->id }}">{{ $supervisor->fullname }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class='text-danger' id="supervisor_id-error-message"></div>
                                    </div>
                                </div>
                                <div class="pull-right mt-2">
                                    <button class="btn btn-primary" type="button" id="btnAssignSupervisor">Assign Peers</button>
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
@push('page-scripts')
<script src="{{ asset('/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/libs/sweetalert2/sweetalert.min.js') }}"></script>
<script src="{{ asset('/assets/libs/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        let type = $('#filterEvaluationType').val();

        $('.faculty-input').select2({
            width: '100%',
        });

        $('.supervisor-input').select2({
            width: '100%',
        });

        let dataTable = $('#evaluation-table').DataTable({
            serverSide: true,
            processing: false,
            ordering: false,
            bLengthChange: true,
            paginate: true,
            info: true,
            dom: '',
            language:  {
                "processing": '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            },
            ajax : `/evaluations/dataTableList/${type}`,
            columns : [
                {
                    class : 'align-middle text-start',
                    data : 'FacultyFullname',
                    name : 'FacultyFullname',
                    searchable: true,
                    orderable: false,
                },
                {
                    class : 'align-middle text-center',
                    data : 'Department',
                    name : 'Department',
                    searchable: true,
                    orderable: false,
                },
                {
                    class : 'align-middle text-center',
                    data : 'Status',
                    name : 'Status',
                    searchable: true,
                    orderable: false,
                },
                {
                    class : 'align-middle text-start ms-5 ps-5',
                    data : 'HasCompleted',
                    name : 'HasCompleted',
                    searchable: true,
                    orderable: false,
                    render : function (_, _, data) {
                        return `<span class="border-bottom"><strong>${data.HasCompleted}</strong> completed</span><br><span><strong>${data.Assigned}</strong> assigned</span>`;
                    },
                },
                {
                    class : 'align-middle text-center',
                    data : 'actions',
                    name : 'actions',
                    searchable: false,
                    orderable: false,
                    render : function (_, _, data, row) {
                        if(data.type == 'Student') btnClass = 'btn-assign-students';
                        if(data.type == 'Peer') btnClass = 'btn-assign-peer';
                        if(data.type == 'Supervisor') btnClass = 'btn-assign-supervisor';

                        return `
                            <button class="btn btn-success btn-sm btn-square ${btnClass}" data-key="${data.id}" data-faculty-id="${data.faculty_id}" data-faculty-fullname="${data.faculty.fullname}">
                                Assign to ${data.type}s
                            </button>
                            <div class="btn-group" role="group">
                                <button class="btn btn-info btn-sm btn-square dropdown-toggle" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-bs-original-title="" title="">View Reports</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 43px);" data-popper-placement="bottom-start">
                                    <a class="dropdown-item view-comments" href="#" data-bs-original-title="" title="" data-key="${data.id}" data-faculty-id="${data.faculty_id}" data-faculty="${data.faculty.fullname}">Comments</a>
                                    <a class="dropdown-item view-evaluation" href="#" data-bs-original-title="" title="" data-key="${data.id}" data-faculty-id="${data.faculty_id}" data-faculty="${data.faculty.fullname}">Performance Evaluation</a>
                            </div>
                        `;
                    },
                },
            ]
        });

        $('#filterEvaluationType').change(function (e) {
            let type = $(this).val();

            dataTable.ajax.url(`/evaluations/dataTableList/${type}`).load();
        });

        $(`#keyword`).keyup(function(e){
            $('#evaluation-table').DataTable().search(e.target.value).draw();


        });

        $(document).on('click', '.btn-assign-students', function(e) {
            let evaluation_id = $(this).data('key');
            let faculty_id = $(this).data('faculty-id');
            let facultyFullname = $(this).data('faculty-fullname');

            swal({
                title: "Are you sure about this?",
                text: `You are about to assign this evaluation to students of \n ${facultyFullname}`,
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
                        url : `/evaluation/students/assignment`,
                        method : 'POST',
                        data: {faculty_id : faculty_id , evaluation_id : evaluation_id},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success : function (response) {
                            if(response.success == true){
                                swal({
                                    text : `Successfully assigned to the students of \n${facultyFullname}.`,
                                    icon : 'success',
                                    buttons : false,
                                });
                            }else{
                                swal({
                                    text : ` ${facultyFullname} has no students yet. Please add or import students to his/her assigned subjects.`,
                                    icon : 'warning',
                                    buttons : false,
                                });
                            }
                        },
                    });
                }
            });
        });

        let removedOptions = [];

        $(document).on('click', '.btn-assign-peer', function(e) {
            let evaluation_id = $(this).data('key');
            let faculty_id = $(this).data('faculty-id');
            let facultyFullname = $(this).data('faculty-fullname');

            $('#evaluation_id').val(evaluation_id);

            $('#assignPeerLabel').html('').text(`Evaluations for ${facultyFullname}`);

            $('#assignPeer').modal('show');

            let removedOption = $('#faculty_id option[value="' + faculty_id + '"]').detach();
            removedOptions.push(removedOption);

        });

        $('#btnAssignPeer').on('click', function (e) {
            e.preventDefault();
            let selectedFaculties = $('#faculty_id').val();
            if(selectedFaculties.length > 0){
                let data = $("#assign-peer-form").serialize();
                $.ajax({
                    url: "/evaluation/peers/assignment",
                    method: "POST",
                    data: data,
                    success: function (response) {
                        if(response.success){
                            swal({
                                text : 'Successfully assigned.',
                                icon : 'success',
                                timer : 1500,
                                buttons : false,
                            });
                            $('#assignPeer').modal('hide');
                        }
                    },
                });
            }else{
                swal({
                    text : 'No faculty selected',
                    icon : 'warning',
                    timer : 1500,
                    buttons : false,
                });
            }

        });

        $('#assignPeer').on('hidden.bs.modal', function () {
            // Restore the removed options
            for (let i = 0; i < removedOptions.length; i++) {
                $('#faculty_id').append(removedOptions[i]);
            }

            // Clear the array
            removedOptions = [];
        });

        $(document).on('click', '.btn-assign-supervisor', function(e) {
            let evaluation_id = $(this).data('key');
            let faculty_id = $(this).data('faculty-id');
            let facultyFullname = $(this).data('faculty-fullname');

            $('#sup_evaluation_id').val(evaluation_id);

            $('#assignSupervisorLabel').html('').text(`Evaluations for ${facultyFullname}`);

            $('#assignSupervisor').modal('show');

        });

        $('#btnAssignSupervisor').on('click', function (e) {
            e.preventDefault();
            let selectedSupervisors = $('#supervisor_id').val();
            if(selectedSupervisors.length > 0){
                let data = $("#assign-supervisor-form").serialize();
                $.ajax({
                    url: "/evaluation/supervisor/assignment",
                    method: "POST",
                    data: data,
                    success: function (response) {
                        if(response.success){
                            swal({
                                text : 'Successfully assigned.',
                                icon : 'success',
                                timer : 1500,
                                buttons : false,
                            });
                            $('#assignPeer').modal('hide');
                        }
                    },
                });
            }else{
                swal({
                    text : 'No faculty selected',
                    icon : 'warning',
                    timer : 1500,
                    buttons : false,
                });
            }
        });

        $(document).on('click', '.view-comments', function () {
            let evaluationId = $(this).attr('data-key');
            let facultyId = $(this).attr('data-faculty-id');
            let faculty = $(this).attr('data-faculty');

            box = new WinBox(`View Comments for ${faculty}`, {
                root: document.querySelector('.page-content'),
                class: ["no-min", "no-full"],
                url: `/evaluation/print/comments/${evaluationId}?winbox=1`,
                index : 999999,
                background: "#2a3042",
                border: "0.3em",
                width: "100%",
                height: "100%",
                top: 10,
                left: 291,
            }).movable();
        });

        $(document).on('click', '.view-evaluation', function () {
            let evaluationId = $(this).attr('data-key');
            let facultyId = $(this).attr('data-faculty-id');
            let faculty = $(this).attr('data-faculty');

            box = new WinBox(`View Performance Evaluation Result for ${faculty}`, {
                root: document.querySelector('.page-content'),
                class: ["no-min", "no-full"],
                url: `/evaluation/print/performance/${evaluationId}?winbox=1`,
                index : 999999,
                background: "#2a3042",
                border: "0.3em",
                width: "100%",
                height: "100%",
                top: 10,
                left: 291,
            }).movable();
        });

    });
</script>
@endpush
@endsection
