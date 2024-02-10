@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Users Management</h2>
                </div>
                <div class="pull-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">User Management</li>
                        <li class="breadcrumb-item active">Edit User</li>
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
                            <p class="f-w-600 f-20 header-text-primary">Edit User</p>
                            <div class="setting-list">
                                <a class="btn btn-xs btn-link text-danger" href="/users"><i data-feather="x-circle"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body row ">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
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
                        {!! Form::model($user, ['method' => 'PUT','route' => ['users.update', $user->id]]) !!}
                            <h5 class="text-primary">User Credentials</h5>
                            <hr class="mt-0 mb-2">
                            <div class="mb-2 m-form__group">
                                <div class="input-group"><span class="input-group-text" style="width:140px">Username</span>
                                    {!! Form::text('username', null, array('placeholder' => 'username','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="mb-2 m-form__group">
                                <div class="input-group"><span class="input-group-text" style="width:140px">Email</span>
                                    {!! Form::text('email', null, array('placeholder' => 'email','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="mb-2 m-form__group">
                                <div class="input-group"><span class="input-group-text" style="width:140px">Password</span>
                                    <input class="form-control" name="password" type="password"
                                    placeholder="Enter Password">
                                </div>
                            </div>
                            <div class="mb-2 m-form__group">
                                <div class="input-group"><span class="input-group-text" style="width:140px">Role</span>
                                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-select')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block w-100 mt-3 text-uppercase"
                                    type="submit">Save Changes</button>
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
