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
            <div class="card ">
                <div class="card-body py-3">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Validation fails! Please contact the administrator about this.
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-dashed" id="evaluation-table">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="text-start">Faculty Member</th>
                                        <th class="text-center">Department</th>
                                        <th class="text-center">Employment Status</th>
                                        <th class="text-center">Evaluation Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($evaluations as $evaluation)
                                        <tr>
                                            <td class="text-start align-middle">{{ $evaluation->evaluation->faculty->fullname }}</td>
                                            <td class="text-center align-middle">{{ $evaluation->evaluation->faculty->department->short_name }}</td>
                                            <td class="text-center align-middle">{{ $evaluation->evaluation->faculty->employment_status }}</td>
                                            <td class="text-center align-middle">
                                                @if ($defaultPeriod->evaluation_status == '0')
                                                    <span class="badge badge-warning">Evaluation has not started.</span>
                                                @endif
                                                @if ($defaultPeriod->evaluation_status == '1')
                                                    @if($evaluation->hasCompleted)
                                                        <span class="badge badge-success">Completed</span>
                                                    @else
                                                        <span class="badge badge-warning">Not Started</span>
                                                    @endif
                                                @endif
                                                @if ($defaultPeriod->evaluation_status == '2')
                                                    <span class="badge badge-danger">Evaluation is now closed!</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                @if ($defaultPeriod->evaluation_status == '0')
                                                    <span class="badge badge-info">Options will be available once evaluation starts.</span>
                                                @endif
                                                @if ($defaultPeriod->evaluation_status == '1')
                                                    @if($evaluation->hasCompleted)
                                                        <button type="button" data-key="{{ $evaluation->id }}" data-evaluation-id="{{ $evaluation->evaluation_id }}" class="btn btn-info btn-sm btn-square btn-preview-result">
                                                            Preview Result
                                                        </button>
                                                    @else
                                                        <a href="/evaluate/{{ $evaluation->id }}/{{ $evaluation->evaluation_id }}" class="btn btn-success btn-sm btn-square">
                                                            Evaluate Now
                                                        </a>
                                                    @endif
                                                @endif
                                                @if ($defaultPeriod->evaluation_status == '2')
                                                    <span class="badge badge-danger">Evaluation is now closed!</span>
                                                @endif
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

        let type = $('#filterEvaluationType').val();

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

        $(document).on('click', '.btn-preview-result', function () {
            let assignmentId = $(this).attr('data-key');
            let evaluationId = $(this).attr('data-evaluation-id');

            box = new WinBox(`View Evaluation Result`, {
                root: document.querySelector('.page-content'),
                class: ["no-min", "no-full"],
                url: `/evaluation/result/${assignmentId}/${evaluationId}?winbox=1`,
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
