@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Barangay Profile</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Barangay Profile</li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid dashboard-default">
        <div class="row">
            <div class="col-xxl-4 col-xl-4 col-lg-4 py-3 px-5">
                <div class="">
                    <div class="">
                        <div class="row mb-2 mt-lg-5">
                            <div class="text-center">
                                <img class="rounded-circle img-thumbnail shadow-lg w-75" alt=""
                                    src="{{ asset('storage/'.$barangay->BarangayLogo) }}">
                            </div>
                        </div>
                        <hr class="my-4">
                        <table class="table table-condensed f-16">
                            <tbody>
                                <tr>
                                    <td>Barangay</td>
                                    <td>:</td>
                                    <td class="fw-bold text-primary">{{ $barangay->Barangay }}</td>
                                </tr>
                                <tr>
                                    <td>Municipality</td>
                                    <td>:</td>
                                    <td class="fw-bold text-primary">{{ $barangay->Municipality }}</td>
                                </tr>
                                <tr>
                                    <td>Province</td>
                                    <td>:</td>
                                    <td class="fw-bold text-primary">{{ $barangay->Province }}</td>
                                </tr>
                                <tr>
                                    <td>Contact No.</td>
                                    <td>:</td>
                                    <td class="fw-bold text-primary">{{ $barangay->ContactNo }}</td>
                                </tr>
                                <tr>
                                    <td>Email Ad</td>
                                    <td>:</td>
                                    <td class="fw-bold text-primary">{{ $barangay->EmailAddress }}</td>
                                </tr>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8 col-xl-8 col-lg-8">
                <div class="card" style="min-height: 75vh">
                    <div class="card-header pb-0">
                        <h4>Barangay Settings</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="icon-tab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="icon-main-tab" data-bs-toggle="tab"
                                    href="#icon-main" role="tab" aria-controls="icon-main" aria-selected="true"><i
                                        class="icofont icofont-settings"></i>Main</a></li>
                            <li class="nav-item"><a class="nav-link" id="logo-icon-tab" data-bs-toggle="tab"
                                    href="#logo-icon" role="tab" aria-controls="logo-icon" aria-selected="false"><i
                                        class="icofont icofont-ui-image"></i>Logos</a></li>
                        </ul>
                        <div class="tab-content" id="icon-tabContent">
                            <div class="tab-pane fade show active" id="icon-main" role="tabpanel"
                                aria-labelledby="icon-main-tab">
                                {!! Form::model($barangay, [
                                    'method' => 'PUT',
                                    'route' => ['update.barangay.settings', $barangay->id],
                                    'class' => 'mt-4',
                                ]) !!}
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <span><i class="fa fa-check"></i></span>{{ $message }}
                                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>Whoops!</strong> There were some problems with your input.
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <h5 class="text-primary">Barangay Profile Details</h5>
                                <hr class="mt-0 mb-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label f-w-500">Barangay</label>
                                            {!! Form::text('Barangay', null, ['placeholder' => 'Barangay', 'class' => 'form-control', 'readonly']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label f-w-500">Municipality</label>
                                            {!! Form::text('Municipality', null, ['placeholder' => 'Municipality', 'class' => 'form-control', 'readonly']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label f-w-500">Province</label>
                                            {!! Form::text('Province', null, ['placeholder' => 'Province', 'class' => 'form-control', 'readonly']) !!}
                                        </div>
                                    </div>
                                    <h5 class="text-primary mt-3">Contact Information</h5>
                                    <hr class="mt-0 mb-2">
                                    <div class="col-sm-6 col-md-5">
                                        <div class="mb-3">
                                            <label class="form-label f-w-500">Contact No.</label>
                                            {!! Form::text('ContactNo', null, ['placeholder' => 'ContactNo', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-7">
                                        <div class="mb-3">
                                            <label class="form-label f-w-500">Email Address</label>
                                            {!! Form::text('EmailAddress', null, ['placeholder' => 'EmailAddress', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <div class="pull-left">
                                        <div class="alert alert-info outline alert-sm p-2">
                                            <p><span><i class="fa fa-info"></i>: </span>You are only allowed to modify <em
                                                    class="text-decoration-underline">Contact Information</em> of the
                                                barangay</p>
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn btn-primary" type="submit">Update Profile </button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="tab-pane fade" id="logo-icon" role="tabpanel" aria-labelledby="logo-icon-tab">
                                <h5 class="text-primary">Barangay Logo</h5>
                                <hr class="mt-0 mb-2">
                                {!! Form::model($barangay, ['method' => 'PUT', 'route' => ['update.barangayLogo', $barangay->id], 'enctype' => 'multipart/form-data']) !!}
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <div class="mb-3">
                                            <img class="rounded-circle img-thumbnail img-100" src="{{ asset('storage/'.$barangay->BarangayLogo) }}">
                                        </div>
                                    </div>
                                        <div class="col-sm-8 col-md-8">
                                            <label class="col-sm-3 col-form-label">Upload New Logo</label>
                                                <input name="barangayImage" class="form-control" type="file">
                                        </div>
                                        <div class="col-sm-2 col-md-2 mt-4 pt-2">
                                            <button class="btn btn-primary" type="submit">Save Logo </button>
                                        </div>
                                </div>
                                {!! Form::close() !!}

                                <h5 class="text-primary">Municipal Logo</h5>
                                <hr class="mt-0 mb-2">
                                {!! Form::model($barangay, ['method' => 'PUT', 'route' => ['update.MunicipalLogo', $barangay->id], 'enctype' => 'multipart/form-data']) !!}
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <div class="mb-3">
                                            <img class="rounded-circle img-thumbnail img-100" src="{{ asset('storage/'.$barangay->MunLogo) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-md-8">
                                        <label class="col-sm-3 col-form-label">Upload New Logo</label>
                                        <input name="municipalImage" class="form-control" type="file">
                                    </div>
                                    <div class="col-sm-2 col-md-2 mt-4 pt-2">
                                        <button class="btn btn-primary" type="submit">Save Logo </button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
