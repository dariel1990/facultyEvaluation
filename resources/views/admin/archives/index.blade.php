@extends('layouts.app')
@prepend('page-css')
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

@endprepend
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ $pageTitle }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Archive</li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 box-col-12">
                <div class="card">
                    <div class="col-lg-12 px-3 py-3">
                        <div class="pull-left">
                            @can('archive-create')
                                <a class="btn btn-sm btn-success" href="{{ route('archives.create') }}"> Record Archives</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body p-2">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <span><i class="fa fa-check"></i></span>{{ $message }}
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-12 col-xl-12 px-4">
                            <div class="table-responsive">
                                <table class="table table-dashed" id="record-table">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>Title</th>
                                            <th>Proponent</th>
                                            <th>Date Conducted</th>
                                            <th>Participants</th>
                                            <th>No. of Participants</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($archives as $record)
                                            <tr>
                                                <td>{{ $record->activity_title }}</td>
                                                <td>{{ $record->proponent }}</td>
                                                <td>{{ $record->activity_date }}</td>
                                                <td>{{ $record->participants }}</td>
                                                <td>{{ $record->participants_no }}</td>
                                                <td class="text-center">
                                                    <a class="badge badge-info" href="{{ route('archives.update', $record->id) }}"><i data-feather="edit"></i></a>
                                                    <a href="#" class="badge badge-danger delete-record" data-key="{{ $record->id }}"><i data-feather="trash"></i></a>
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
        <script src="{{ asset('/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets/libs/sweetalert2/sweetalert.min.js') }}"></script>
        <script>
            $('.delete-record').click(function (e) {
                let id = $(this).attr('data-key');
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
                            url: `/archives/${id}`,
                            method : 'DELETE',
                            success : function (response) {
                                if(response.success == true){
                                    swal({
                                            text : 'Successfully deleted!',
                                            icon : 'success',
                                            timer : 1500,
                                            buttons : false,
                                        })
                                    setTimeout( () => {
                                        location.reload();
                                    }, 1500)
                                }else{
                                    swal({
                                        title : 'Warning!',
                                        text : `You're not allowed to do this!`,
                                        icon : 'warning',
                                        timer : 1500,
                                        buttons : false,
                                    })
                                }
                            },
                        });
                    }
                });
            });

            $('#record-table').DataTable();
        </script>
    @endpush
@endsection
