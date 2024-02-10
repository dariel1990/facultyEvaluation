@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>{{ $pageTitle }}</h2>
                </div>
                <div class="pull-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Archive Management</li>
                        <li class="breadcrumb-item active">Save Archive</li>
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
    {!! Form::open(array('route' => 'archives.store','method'=>'POST')) !!}
        <div class="row">
            <div class="col-xxl-4 col-xl-4 col-lg-4 box-col-12">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-12 mb-3">
                            <label for="con-mail">Proponent<strong class="text-danger">{{ ($errors->has('proponent') ? '*' : '') }}</strong></label>
                            {!! Form::text('proponent', old('proponent'), ['placeholder' => 'Enter Proponent`s Name', 'class' => 'form-control' . ($errors->has('proponent') ? ' is-invalid' : '')]) !!}
                        </div>
                        <div class="col-12">
                            <label for="Members">Activity/Project Members</label>
                            <div id="members">
                                <div class="member">
                                    <label for="member">Member:</label>
                                    <input type="text" name="member_name[]" class="form-control member-input" required>
                                </div>
                                <div class="input-group mb-2">
                                        <span class="input-group-text py-2" style="width:150px">Email Address <strong class="text-danger">&nbsp;{{ ($errors->has('EmailAddress') ? '*' : '') }}</strong></span>
                                        {!! Form::text('EmailAddress', old('EmailAddress'), ['placeholder' => 'Enter Email Address', 'class' => 'form-control' . ($errors->has('EmailAddress') ? ' is-invalid' : '')]) !!}
                                    </div>
                            </div>
                            <button class="btn btn-primary" id="addProduct" type="button">Add Product</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8 col-xl-8 col-lg-8 box-col-12">
                <div class="card">
                    <div class="card-body row">
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
                            <div class="row">
                                <div class="col-12">
                                    <label for="con-mail">Activity Title<strong class="text-danger">{{ ($errors->has('activity_title') ? '*' : '') }}</strong></label>
                                    {!! Form::text('activity_title', old('activity_title'), ['placeholder' => 'Enter title of the activity', 'class' => 'form-control' . ($errors->has('activity_title') ? ' is-invalid' : '')]) !!}
                                </div>
                                <div class="col-4 mt-2">
                                    <label for="con-mail">Date Conducted<strong class="text-danger">{{ ($errors->has('activity_date') ? '*' : '') }}</strong></label>
                                    {!! Form::date('activity_date', old('activity_date'), ['id' => 'activityDate', 'class' => 'form-control' . ($errors->has('activity_date') ? ' is-invalid' : '')]) !!}
                                </div>
                                <div class="col-4 mt-2">
                                    <label for="con-mail">Venue <strong class="text-danger">{{ ($errors->has('venue') ? '*' : '') }}</strong></label>
                                    {!! Form::text('venue', old('venue'), ['placeholder' => 'Enter Venue', 'class' => 'form-control' . ($errors->has('venue') ? ' is-invalid' : '')]) !!}
                                </div>
                                <div class="col-4 mt-2">
                                    <label for="con-mail">Approved Budget <strong class="text-danger">{{ ($errors->has('budget') ? '*' : '') }}</strong></label>
                                    {!! Form::number('budget', old('budget'), ['placeholder' => 'Enter Budget', 'class' => 'form-control' . ($errors->has('budget') ? ' is-invalid' : '')]) !!}
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="con-mail">Abstract <strong class="text-danger">{{ ($errors->has('abstract') ? '*' : '') }}</strong></label>
                                    {!! Form::textarea('abstract', old('abstract'), ['id' => 'abstract', 'class' => 'form-control mb-2' . ($errors->has('abstract') ? ' is-invalid' : ''), 'rows' => '3']) !!}
                                </div>
                                <div class="col-4 mt-3">
                                    <label for="con-mail">Participants <strong class="text-danger">{{ ($errors->has('participants') ? '*' : '') }}</strong></label>
                                    {!! Form::text('participants', old('participants'), ['placeholder' => 'Enter participants', 'class' => 'form-control' . ($errors->has('participants') ? ' is-invalid' : '')]) !!}
                                </div>
                                <div class="col-3 mt-3">
                                    <label for="con-mail">No. of Participants <strong class="text-danger">{{ ($errors->has('participants_no') ? '*' : '') }}</strong></label>
                                    {!! Form::number('participants_no', old('participants_no'), ['placeholder' => 'Enter No. of Participants', 'class' => 'form-control' . ($errors->has('participants_no') ? ' is-invalid' : '')]) !!}
                                </div>
                                <div class="col-5 mt-3">
                                    <label for="con-mail">Attach the file of the Activity<strong class="text-danger">{{ ($errors->has('activity_document') ? '*' : '') }}</strong></label>
                                    {!! Form::file('activity_document', old('activity_document'), ['class' => 'form-control' . ($errors->has('activity_document') ? ' is-invalid' : '')]) !!}
                                </div>
                                <div class="col-6 text-end mt-4"></div>

                                <div class="col-6 text-end mt-4">
                                    <button class="btn btn-primary text-uppercase"
                                            type="submit">Save Record</button>
                                    <a href="{{ route('archives') }}" class="btn btn-danger text-uppercase"
                                        type="submit">Go back to List</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
@push('page-scripts')
<script src="{{ asset('/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        CKEDITOR.replace('abstract');
    });
</script>
@endpush
@endsection
