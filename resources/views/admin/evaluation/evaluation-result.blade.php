@extends('layouts.winbox')
@prepend('page-css')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet"
        type="text/css" />
@endprepend
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2 text-end">
                                <img src="{{ asset('assets/images/NEMSU.png') }}" width="60%">
                            </div>
                            <div class="col-8 text-center">
                                <h5 class="m-0">Republic of the Philippines</h5>
                                <h4 class="m-0 text-primary">NORTH EASTERN MINDANAO STATE UNIVERSITY</h4>
                                <h5 class="m-0">Lianga Campus</h5>
                                <h5 class="m-0 fw-light">Lianga, Surigao del Sur, 8307</h5>
                                <h5 class="m-0 fw-light">Website: <code>www.nemsu.edu.ph</code></h5>
                            </div>
                            <div class="col-2"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <h3 class="m-0">FACULTY EVALUATION FORM</h3>
                            </div>
                        </div>
                        <div class="row mt-5 h5 fw-light">
                            <div class="col-2">
                                Name of Faculty
                            </div>
                            <div class="col-4 border-bottom">
                                :&nbsp;<span class="fw-bold">{{ $evaluation->faculty->fullname }}</span>
                            </div>
                            <div class="col-1">
                            </div>
                            <div class="col-2 text-end">
                                Rating Period
                            </div>
                            <div class="col-3 border-bottom">
                                :&nbsp;<span class="fw-bold">{{ $evaluation->academicYear->semester == '1' ? '1st' : '2nd' }} sem of AY {{ $evaluation->academicYear->academic_year}}</span>
                            </div>
                        </div>
                        <div class="row h5 fw-light">
                            <div class="col-2">
                                Faculty Rank
                            </div>
                            <div class="col-4 border-bottom">
                                :&nbsp;<span class="fw-bold">{{ $evaluation->faculty->employment_status }}</span>
                            </div>
                        </div>
                        <div class="row mt-5 h5 fw-light">
                            <div class="col-3">
                                Evaluator:
                            </div>
                            <div class="col-3">
                                <label class="d-block fw-bold" for="type">
                                    <input class="radio_animated" disabled id="type" type="radio" name="type" {{ ($userType == 'Student') ? 'checked' : '' }}>Student
                                </label>
                            </div>
                            <div class="col-3">
                                <label class="d-block fw-bold" for="type">
                                    <input class="radio_animated" disabled id="type" type="radio" name="type" {{ ($userType == 'Peer') ? 'checked' : '' }}>Peer
                                </label>
                            </div>
                            <div class="col-3">
                                <label class="d-block fw-bold" for="type">
                                    <input class="radio_animated" disabled id="type" type="radio" name="type" {{ ($userType == 'Supervisor') ? 'checked' : '' }}>Supervisor
                                </label>
                            </div>
                        </div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> You did not finished the evaluation. Check your work, you might have missed an item!
                            </div>
                        @endif
                        <form method="POST" action="/evaluations/submit/{{ $evaluationId }}">
                            @csrf
                            <div class="row mt-3 h6 fw-light">
                                <div class="col-12">
                                    <strong>Instruction: </strong>Please evaluate the faculty using the scale below. Select your rating for each item.
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold text-center">Scale</th>
                                                <th class="fw-bold text-center">Descriptive Rating</th>
                                                <th class="fw-bold text-center">Qualitative Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold text-center">5</td>
                                                <td class="text-center">Outstanding</td>
                                                <td class="text-start">The performance almost always exceeds the job requirements. The faculty is an exceptional role model.</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-center">4</td>
                                                <td class="text-center">Very Satisfactory</td>
                                                <td class="text-start">The performance meets and often exceeds the job requirements.</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-center">3</td>
                                                <td class="text-center">Satisfactory</td>
                                                <td class="text-start">The performance meets job requirements.</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-center">2</td>
                                                <td class="text-center">Fair</td>
                                                <td class="text-start">The performance needs some development to meet job requirements.</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-center">1</td>
                                                <td class="text-center">Poor</td>
                                                <td class="text-start">The faculty fails to meet job requirements</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-4 h6 fw-light">
                                <div class="col-12">
                                    <table class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold text-center align-middle">Criteria</th>
                                                <th width="20%" class="fw-bold text-center" colspan="5">Scale</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $grandTotal = 0;
                                                $totalAverage = 0;
                                            @endphp
                                            @foreach($criterias as $index => $criteria)
                                            @php
                                                $criteriaTotalScore = 0;
                                            @endphp
                                                <tr>
                                                    <td class="fw-bold">{{ chr(65 + $index) }}. {{ $criteria->criteria }}</td>
                                                    <th class="fw-bold text-center">5</th>
                                                    <th class="fw-bold text-center">4</th>
                                                    <th class="fw-bold text-center">3</th>
                                                    <th class="fw-bold text-center">2</th>
                                                    <th class="fw-bold text-center">1</th>
                                                </tr>
                                                @foreach ($criteria->question as $question)
                                                    @php
                                                        $questionId = $question->id;
                                                        $selectedRating = old('rate' . $questionId) ?? ($answers->where('question_id', $questionId)->first()->rate ?? null);
                                                        $criteriaTotalScore += ($selectedRating ? (int)$selectedRating : 0);
                                                    @endphp
                                                <tr>
                                                    <td class="">{{ $loop->index +1 }}. {{ $question->question }}</td>
                                                    <td class="fw-bold text-center align-middle"><input disabled class="radio_animated me-0" value="5" type="radio" name="rate{{ $question->id }}" {{ old('rate' . $question->id) == '5' || ($answers->where('question_id', $question->id)->first()->rate ?? null) == '5' ? 'checked' : '' }}></td>
                                                    <td class="fw-bold text-center align-middle"><input disabled class="radio_animated me-0" value="4" type="radio" name="rate{{ $question->id }}" {{ old('rate' . $question->id) == '4' || ($answers->where('question_id', $question->id)->first()->rate ?? null) == '4' ? 'checked' : '' }}></td>
                                                    <td class="fw-bold text-center align-middle"><input disabled class="radio_animated me-0" value="3" type="radio" name="rate{{ $question->id }}" {{ old('rate' . $question->id) == '3' || ($answers->where('question_id', $question->id)->first()->rate ?? null) == '3' ? 'checked' : '' }}></td>
                                                    <td class="fw-bold text-center align-middle"><input disabled class="radio_animated me-0" value="2" type="radio" name="rate{{ $question->id }}" {{ old('rate' . $question->id) == '2' || ($answers->where('question_id', $question->id)->first()->rate ?? null) == '2' ? 'checked' : '' }}></td>
                                                    <td class="fw-bold text-center align-middle"><input disabled class="radio_animated me-0" value="1" type="radio" name="rate{{ $question->id }}" {{ old('rate' . $question->id) == '1' || ($answers->where('question_id', $question->id)->first()->rate ?? null) == '1' ? 'checked' : '' }}></td>
                                                </tr>
                                                @endforeach
                                                @php
                                                    $grandTotal = $grandTotal + $criteriaTotalScore;
                                                @endphp
                                                <tr>
                                                    <td class="fw-bold text-end">TOTAL SCORE</td>
                                                    <td class="fw-bold text-center" colspan="5">{{ $criteriaTotalScore }}</td>
                                                </tr>
                                            @endforeach
                                            @php
                                                $totalAverage = $grandTotal / 4;
                                            @endphp
                                            <tr>
                                                <td class="fw-bold text-end">GRAND TOTAL</td>
                                                <td class="fw-bold text-center" colspan="5">{{ $grandTotal }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold text-end">TOTAL AVERAGE</td>
                                                <td class="fw-bold text-center" colspan="5">{{ $totalAverage }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-3 h6 fw-bold">
                                <div class="col-12">
                                    <label for="comment">Remarks(Comments): </label>
                                    <textarea row="5" id="comment" name="comment" class="form-control" readonly>{{ $assignment->comment }}</textarea>
                                </div>
                            </div>
                        </form>
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
@endpush
@endsection
