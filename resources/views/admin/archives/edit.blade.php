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
                        <li class="breadcrumb-item">Resident Management</li>
                        <li class="breadcrumb-item active">Add Resident</li>
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
    {!! Form::open(array('route' => ['barangay.resident.update', $resident->id],'method'=>'put')) !!}
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3 box-col-12">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="id-image mb-2">
                                            <img class="img-thumbnail p-3" src="{{ asset('storage/'.$barangay->BarangayLogo) }}" height="350" width="350">
                                        </div>
                                        <label for="con-mail">Last Name </label> <strong class="text-danger">{{ ($errors->has('LastName') ? '*' : '') }}</strong>
                                        {!! Form::text('LastName', $resident->LastName, ['placeholder' => 'Enter Last Name', 'class' => 'form-control mb-2' . ($errors->has('LastName') ? ' is-invalid' : '')]) !!}
                                        <label for="con-mail">First Name</label> <strong class="text-danger">{{ ($errors->has('FirstName') ? '*' : '') }}</strong>
                                        {!! Form::text('FirstName', $resident->FirstName, ['placeholder' => 'Enter First Name', 'class' => 'form-control mb-2' . ($errors->has('FirstName') ? ' is-invalid' : '')]) !!}
                                        <label for="con-mail">Middle Name</label> <strong class="text-danger">{{ ($errors->has('MiddleName') ? '*' : '') }}</strong>
                                        {!! Form::text('MiddleName', $resident->MiddleName, ['placeholder' => 'Enter Middle Name', 'class' => 'form-control mb-2' . ($errors->has('MiddleName') ? ' is-invalid' : '')]) !!}
                                        <label for="con-mail">Suffix</label> <strong class="text-danger">{{ ($errors->has('Suffix') ? '*' : '') }}</strong>
                                        {!! Form::text('Suffix', $resident->Suffix, ['placeholder' => 'Enter Suffix', 'class' => 'form-control mb-2' . ($errors->has('Suffix') ? ' is-invalid' : '')]) !!}
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-9 col-xl-9 col-lg-9 box-col-12">
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
                                <div class="col-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text py-2" style="width:150px">Email Address <strong class="text-danger">&nbsp;{{ ($errors->has('EmailAddress') ? '*' : '') }}</strong></span>
                                        {!! Form::text('EmailAddress', $resident->EmailAddress, ['placeholder' => 'Enter Email Address', 'class' => 'form-control' . ($errors->has('EmailAddress') ? ' is-invalid' : '')]) !!}
                                    </div>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text py-2" style="width:150px">Education <strong class="text-danger">&nbsp;{{ ($errors->has('Education') ? '*' : '') }}</strong></span>
                                        <select name="Education" class="form-select {{ ($errors->has('Education') ? ' is-invalid' : '') }}">
                                            <option selected disabled value=''>Select One</option>
                                            <option value='College Graduate' {{ $resident->Education === 'College Graduate' ? 'selected' : '' }}>College Graduate</option>
                                            <option value='Undergraduate' {{ $resident->Education === 'Undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                                            <option value='High School' {{ $resident->Education === 'High School' ? 'selected' : '' }}>High School</option>
                                            <option value='Elementary' {{ $resident->Education === 'Elementary' ? 'selected' : '' }}>Elementary</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text py-2" style="width:150px">Alias <strong class="text-danger">&nbsp;{{ ($errors->has('Alias') ? '*' : '') }}</strong></span>
                                        {!! Form::text('Alias',  $resident->Alias, ['placeholder' => 'Enter Nickname', 'class' => 'form-control' . ($errors->has('Alias') ? ' is-invalid' : '')]) !!}
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            <label for="con-mail">Birthdate <strong class="text-danger">{{ ($errors->has('BirthDate') ? '*' : '') }}</strong></label>
                                            {!! Form::date('BirthDate',  $resident->BirthDate, ['id' => 'birthdate', 'class' => 'form-control' . ($errors->has('BirthDate') ? ' is-invalid' : '')]) !!}
                                        </div>
                                        <div class="col-2">
                                            <label for="con-mail">Age <strong class="text-danger">{{ ($errors->has('Age') ? '*' : '') }}</strong></label>
                                            {!! Form::text('Age',  $resident->Age, ['readonly', 'id' => 'age', 'class' => 'form-control' . ($errors->has('Age') ? ' is-invalid' : '')]) !!}
                                        </div>
                                        <div class="col-5">
                                            <label for="con-mail">Religion <strong class="text-danger">{{ ($errors->has('Religion') ? '*' : '') }}</strong></label>
                                            {!! Form::text('Religion',  $resident->Religion, ['class' => 'form-control' . ($errors->has('Religion') ? ' is-invalid' : '')]) !!}
                                        </div>
                                    </div>
                                    <label for="con-mail">Birthplace <strong class="text-danger">{{ ($errors->has('BirthPlace') ? '*' : '') }}</strong></label>
                                    {!! Form::textarea('BirthPlace',  $resident->BirthPlace, ['class' => 'form-control mb-2' . ($errors->has('BirthPlace') ? ' is-invalid' : ''), 'rows' => '3']) !!}
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="con-mail">Civil Status <strong class="text-danger">{{ ($errors->has('CivilStatus') ? '*' : '') }}</strong></label>
                                            <select name="CivilStatus" class="form-select {{ ($errors->has('CivilStatus') ? ' is-invalid' : '') }}">
                                                <option selected disabled value=''>Select One</option>
                                                <option value='Single' {{ $resident->CivilStatus === 'Single' ? 'selected' : '' }}>Single</option>
                                                <option value='Married' {{ $resident->CivilStatus === 'Married' ? 'selected' : '' }}>Married</option>
                                                <option value='Widowed' {{ $resident->CivilStatus === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                                <option value='Separated' {{ $resident->CivilStatus === 'Separated' ? 'selected' : '' }}>Separated</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="con-mail">Gender <strong class="text-danger">{{ ($errors->has('Gender') ? '*' : '') }}</strong></label>
                                            <select name="Gender" class="form-select {{ ($errors->has('Gender') ? ' is-invalid' : '') }}">
                                                <option selected disabled value=''>Select One</option>
                                                <option value='Male' {{ $resident->Gender === 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value='Female' {{ $resident->Gender === 'Female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="con-mail">PWD</label>
                                            <select name="personWithDisability" class="form-select">
                                                <option selected value='0' {{ $resident->personWithDisability === '0' ? 'selected' : '' }}>No</option>
                                                <option value='1' {{ $resident->personWithDisability === '1' ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="con-mail">Vaccinated</label>
                                            <select name="isVaccinated" class="form-select">
                                                <option selected value='1' {{ $resident->isVaccinated === '1' ? 'selected' : '' }}>Yes</option>
                                                <option value='0' {{ $resident->isVaccinated === '0' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text py-2" style="width:150px">Contact No. <strong class="text-danger">&nbsp;{{ ($errors->has('ContactNo') ? '*' : '') }}</strong></span>
                                        {!! Form::text('ContactNo', $resident->ContactNo, ['placeholder' => 'Enter Contact No', 'class' => 'form-control' . ($errors->has('ContactNo') ? ' is-invalid' : '')]) !!}
                                    </div>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text py-2" style="width:150px">Occupation <strong class="text-danger">&nbsp;{{ ($errors->has('Occupation') ? '*' : '') }}</strong></span>
                                        {!! Form::text('Occupation', $resident->Occupation, ['placeholder' => 'Enter Occupation', 'class' => 'form-control' . ($errors->has('Occupation') ? ' is-invalid' : '')]) !!}
                                    </div>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text py-2" style="width:150px">Citizenship <strong class="text-danger">&nbsp;{{ ($errors->has('Citizenship') ? '*' : '') }}</strong></span>
                                        {!! Form::text('Citizenship', $resident->Citizenship, ['placeholder' => 'Enter Citizenship', 'class' => 'form-control' . ($errors->has('Citizenship') ? ' is-invalid' : '')]) !!}
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="con-mail">Purok <strong class="text-danger">{{ ($errors->has('CivilStatus') ? '*' : '') }}</strong></label>
                                            <select name="purok_id" id="purok" class="form-select {{ ($errors->has('CivilStatus') ? ' is-invalid' : '') }}">
                                                <option selected disabled value=''>Select One</option>
                                                @foreach ($puroks as $record)
                                                    <option value="{{ $record->purok_id }}" {{ $resident->purok_id == $record->purok_id ? 'selected' : '' }}>{{ $record->PurokName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="con-mail">Status</label>
                                            <select name="isActive" class="form-select">
                                                <option selected value='1' {{ $resident->isActive === '1' ? 'selected' : '' }}>Active</option>
                                                <option value='0' {{ $resident->isActive === '0' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label for="con-mail">Address <strong class="text-danger">{{ ($errors->has('Address') ? '*' : '') }}</strong></label>
                                    {!! Form::textarea('Address', $resident->Address,  ['readonly', 'id' => 'address', 'data-address' => $barangayAddress, 'class' => 'form-control mb-2' . ($errors->has('Address') ? ' is-invalid' : ''), 'rows' => '3']) !!}
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label for="con-mail">Household Category <strong class="text-danger">{{ ($errors->has('hh_category') ? '*' : '') }}</strong></label>
                                            <select name="hh_category" class="form-select {{ ($errors->has('hh_category') ? ' is-invalid' : '') }}">
                                                <option selected disabled value=''>Select One</option>
                                                <option value='Family Head' {{ $resident->hh_category === 'Family Head' ? 'selected' : '' }}>Family Head</option>
                                                <option value='Family Member' {{ $resident->hh_category === 'Family Member' ? 'selected' : '' }}>Family Member</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="con-mail">Household No. <strong class="text-danger">{{ ($errors->has('hh_id') ? '*' : '') }}</strong></label>
                                            <input type="text" name="hh_id" value="{{ $householdId->HouseholdNo }}" placeholder="Enter Household ID" class="form-control {{ ($errors->has('hh_id') ? ' is-invalid' : '') }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="con-mail">Voters Status</label>
                                            <select name="VoterStatus" class="form-select mb-3">
                                                <option selected value='1' {{ $resident->VoterStatus === '1' ? 'selected' : '' }}>Yes</option>
                                                <option value='0' {{ $resident->VoterStatus === '0' ? 'selected' : '' }}>No</option>
                                            </select>
                                            <button class="btn btn-info shadow-lg btn-block w-100 text-uppercase"
                                            type="submit">Update Details</button>
                                        </div>
                                        <div class="col-6">
                                            <label for="con-mail">Precinct</label>
                                            {!! Form::text('Precinct', $resident->Precinct, array('placeholder' => 'Enter Precinct','class' => 'form-control mb-3')) !!}
                                            <a href="{{ route('barangay.residents') }}" class="btn btn-danger btn-block w-100 text-uppercase"
                                                type="submit">Go back to List</a>
                                        </div>
                                    </div>
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
<script>
    $(document).ready(function() {
        // Get references to the birthdate and age input fields
        const $birthdateInput = $('#birthdate');
        const $ageInput = $('#age');
        const $purokInput = $('#purok');

        // Add an event listener to the birthdate input to calculate age on change
        $birthdateInput.on('change', function() {
            const birthdate = new Date($(this).val());
            const today = new Date();
            const age = today.getFullYear() - birthdate.getFullYear();

            // Check if the birthday has occurred this year already
            if (today.getMonth() < birthdate.getMonth() || (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate())) {
                age--;
            }

            // Update the age input field with the calculated age
            $ageInput.val(age);
        });

        $purokInput.on('change', function() {
            console.log('ok');
            const $barangayAddress = $('#address').attr('data-address');
            const selectedPurok = $('#purok option:selected');
            const purokText = selectedPurok.text();
            let completeAddress = purokText + ', ' + $barangayAddress;

            $('#address').val(completeAddress);
        });
    });
</script>
@endpush
@endsection
