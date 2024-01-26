@extends('layouts.dashboard')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="page-title">
                    <h4>{{ $section->heading }}</h4>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('livestream.evolution') }}">Live Stream Evaluation</a></li>
                        <li class="breadcrumb-item active">{{ $section->heading }}</li>
                    </ul>
                </div>


                @if(\Auth::user()->role_id == 0)
                    {{-- <div class="btn-group" >
                        <a href="{{ route('webinar.evolution') }}" class="btn btn-outline-secondary">All</a>
                        <a href="{{ route('webinar.general_wE') }}" class="btn btn-secondary">General Public</a>
                        <a href="{{ route('webinar.professional_wE') }}" class="btn btn-dark">Professional Education</a>
                    </div> --}}
                @endif
            </div>


            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <!-- main alert @s -->
                            @include('partials.alerts')
                            <!-- main alert @e -->

                            <div class="card">
                                <div class="card-body">
                                    <div class="row innerform">
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label for="course"><strong>Livestream:</strong></label>
                                                <label for="course">{{ $record->liststream->related }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label for="course"><strong>Title of course:</strong></label>
                                                <label for="course">{{ $record->title }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="course"><strong>Date course was taken:</strong></label>
                                                <label for="course">{{ $record->date }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="course"><strong>User:</strong></label>
                                                <label for="course">{{ ($record->user != null) ? $record->user->name: "" }} - {{ ($record->user->role != null) ? $record->user->role->name : "" }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="form-group">
                                        <label for="Date"><strong>1. On a scale of 1-5, with 1 being poor and 5 being excellent, how would you rate</strong> </label>
                                    </div>
                                    <div class="row innerform">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Date"><strong>a. The content of the course?</strong></label>
                                                <label for="course">{{ $record->{'1a_course'} }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Date"><strong>b. The speaker’s knowledge of the material?</strong></label>
                                                <label for="course">{{ $record->{'1b_material'} }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Date"><strong>c. The speaker’s ability to hold your attention?</strong></label>
                                                <label for="course">{{ $record->{'1c_attention'} }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Date"><strong>d. The length of the course? </strong></label>
                                                <label for="course">{{ $record->{'1d_length'} }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Date"><strong>e. The visual aspects of the course? </strong></label>
                                                <label for="course">{{ $record->{'1e_visual_aspects'} }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Date"><strong>f. The degree of complexity of the course? </strong></label>
                                                <label for="course">{{ $record->{'1f_degree'} }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Date"><strong>g. The cost of the course? </strong></label>
                                                <label for="course">{{ $record->{'1g_cost'} }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="form-group">
                                            <strong>2. Did you find this course helpful?</strong>
                                            <label for="course">{{ $record->course_helpful }}</label>
                                        </div>
                                        <div class="form-group">
                                            <strong>3. Would you recommend this course to somebody you know?</strong>
                                            <label for="course">{{ $record->recommend_this }}</label>
                                        </div>
                                        <div class="form-group">
                                            <strong>4. What did you like the best about this course?</strong>
                                            <label for="course">{{ $record->best_about }}</label>
                                        </div>
                                        <div class="form-group">
                                            <strong>5. What did you like the least about this course?</strong>
                                            <label for="course">{{ $record->least_about }}</label>
                                        </div>
                                        <div class="form-group">
                                            <strong>6. What suggestions do you have to improve the course?</strong>
                                            <label for="course">{{ $record->suggestions_improve }}</label>
                                        </div>
                                        <div class="form-group">
                                            <strong>7. What suggestions do you have for future courses?</strong>
                                            <label for="course">{{ $record->suggestions_future }}</label>
                                        </div>
                                        <div class="form-group">
                                            <strong>8. How likely are you to take another course from wRight Insight? (Please check one)</strong>
                                            <label for="course">{{ $record->take_another_course }}</label>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endsection

            @section('scripts')
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
                <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
                <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
@endsection
