@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Academic Year Management</h2>
                </div>
                <div class="pull-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('academic.year') }}">Academic Year Management</a></li>
                        <li class="breadcrumb-item active">Academic Year Create</li>
                    </ol>
                </div>
            </div>
            <div class="col-lg-12 margin-tb mt-3">
                <div class="pull-left">
                </div>
                <div class="pull-right">
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
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="f-w-600 f-20 header-text-primary">Add Academic Year</p>
                            <div class="setting-list">
                                <a class="btn btn-xs btn-link text-danger" href="/academic/year"><i data-feather="x-circle"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body row ">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        @if (count($errors) > 0)
                        <div class="alert alert-light text-danger">
                            <strong>Whoops!</strong>
                            Inputs marked with an asterisk (*) indicate mandatory fields and must be filled out.
                            @foreach ($errors->all() as $error)
                                @unless (str_contains($error, 'required')) {{-- Exclude "required" error --}}
                                    <li>{{ $error }}</li>
                                @endunless
                            @endforeach
                        </div>
                        @endif
                        {!! Form::open(array('route' => 'academic.year.store','method'=>'POST')) !!}
                            <div class="mb-2 m-form__group">
                                <div class="input-group">
                                    <span class="input-group-text" style="width:150px">Academic Year</span>
                                    <input class="form-control {{ ($errors->has('academic_year') ? ' is-invalid' : '') }}" name="academic_year" type="text" value="{{ old('academic_year') }}"
                                    placeholder="Enter Academic Year">
                                </div>
                            </div>
                            <div class="mb-2 m-form__group">
                                <div class="input-group"><span class="input-group-text" style="width:150px">Semester</span>
                                    <input class="form-control {{ ($errors->has('semester') ? ' is-invalid' : '') }}" name="semester" type="text" value="{{ old('semester') }}"
                                    placeholder="Enter Semester">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block w-100 mt-3 text-uppercase"
                                    type="submit">Save Record</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('page-scripts')
<script src="{{ asset('/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/datatables/datatable.custom.js') }}"></script>
@endpush
@endsection
