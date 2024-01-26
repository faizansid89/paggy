@extends('layouts.dashboard')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="page-title">
                    <h4>{{ $section->heading }}</h4>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                        <li class="breadcrumb-item active">{{ $section->title }}</li>
                    </ul>
                </div>


                @if(\Auth::user()->role_id == 0)
                    {{-- <div class="btn-group" >
                        <a href="{{ route('webinar.evolution') }}" class="btn btn-outline-secondary">All</a>
                        <a href="{{ route('webinar.general_wE') }}" class="btn btn-secondary">General Public</a>
                        <a href="{{ route('webinar.professional_wE') }}" class="btn btn-dark">Professional Education</a>
                    </div> --}}
                @endif

                @if((in_array('create-evaluation-webinar', getUserPermissions())))
                    <button type="button" class="btn btn-added" data-toggle="modal" data-target="#bd-example-modal-lg">
                        Form Evaluation
                    </button>
                @endif
                <style>
                    .row.innerform {
                        padding-left: 20px;
                        padding-right: 20px;
                    }
                </style>
                <div class="modal fade " id="bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Webinar Evaluation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('webinar.evaluation_create') }}" method="Post" autocomplete="off">
                                    @csrf
                                    <div class="form-group" >
                                        <label for="course">Select Webinar:</label>
                                        <select name="webinar_id" class="form-control" required>
                                            <option value="">Select Webinar</option>
                                            @foreach($webinar as $web)
                                                <option value="{{ $web->webinar_id }}" >{{ $web->webinar->related }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" >
                                        <label for="course">Title of course:</label>
                                        <input type="text" name="title" class="form-control" id="course" aria-describedby="emailHelp">
                                    </div>
                                    <div class="form-group">
                                        <label for="Date">Date course was taken:</label>
                                        <input type="date" name="date"  class="form-control" id="Date">
                                    </div>
                                    <div class="form-group">
                                        <label for="Date">1. On a scale of 1-5, with 1 being poor and 5 being excellent, how would you rate</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="Date">a. The content of the course?</label>
                                        <input type="text" name="1a_course" class="form-control" id="Date">
                                    </div>
                                    <div class="row innerform">
                                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Date">b. The speaker’s knowledge of the material?</label>
                                        <input type="text"  name="1b_material" class="form-control" id="Date">
                                    </div>
                                        </div>
                                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Date">c. The speaker’s ability to hold your attention?</label>
                                        <input type="text"  name="1c_attention" class="form-control" id="Date">
                                    </div>
                                        </div>
                                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Date">d. The length of the course? </label>
                                        <input type="text" name="1d_length"  class="form-control" id="Date">
                                    </div>
                                        </div>
                                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Date">e. The visual aspects of the course? </label>
                                        <input type="text"  name="1e_visual_aspects" class="form-control" id="Date">
                                    </div>
                                        </div>
                                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Date">f. The degree of complexity of the course? </label>
                                        <input type="text" name="1f_degree" class="form-control" id="Date">
                                    </div>
                                        </div>
                                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Date">g. The cost of the course? </label>
                                        <input type="text"  name="1g_cost" class="form-control" id="Date">
                                    </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class ="col-md-6">
                                    <div class="form-group">
                                        2. Did you find this course helpful?
                                    </div>
                                    <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input"  name="course_helpful" type="radio" name="exampleRadios" id="exampleRadios1" value="yes" checked>
                                        <label class="form-check-label" for="exampleRadios1">
                                           Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="course_helpful"  type="radio" name="exampleRadios" id="exampleRadios2" value="no">
                                        <label class="form-check-label" for="exampleRadios2">
                                            No
                                        </label>
                                    </div>
                                    </div>
                                        </div>
                                        <div class ="col-md-6">
                                    <div class="form-group">
                                       3. Would you recommend this course to somebody you know?
                                    </div>
                                    <div class="form-group" >
                                    <div class="form-check">
                                        <input class="form-check-input"  name="recommend_this" type="radio" name="exampleRadios" id="exampleRadios3" value="yes" checked>
                                        <label class="form-check-label" for="exampleRadios3">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="recommend_this"  type="radio" name="exampleRadios" id="exampleRadios4" value="no">
                                        <label class="form-check-label" for="exampleRadios4">
                                            No
                                        </label>
                                    </div>
                                    </div>
                                    </div>
                                  </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                    <div class="form-group" >
                                        <label for="course">4. What did you like the best about this course?</label>
                                        <input type="text"  name="best_about"  class="form-control" id="best" aria-describedby="emailHelp">
                                    </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label for="course">5. What did you like the least about this course?</label>
                                                <input type="text" name="least_about"  class="form-control" id="least" aria-describedby="emailHelp">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group" >
                                            <label for="course">6. What suggestions do you have to improve the course?</label>
                                            <input type="text" name="suggestions_improve"  class="form-control" id="improve" aria-describedby="emailHelp">
                                        </div>
                                    </div>
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label for="course">7. What suggestions do you have for future courses?</label>
                                                <input type="text"  name="suggestions_future" class="form-control" id="suggestions" aria-describedby="emailHelp">
                                            </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                            8. How likely are you to take another course from wRight Insight? (Please check one)
                                        </div>
                                    <div class="form-group" >
                                            <div class="form-check">
                                                <input class="form-check-input"  name="take_another_course" type="radio" name="gridRadios" id="gridRadios1" value="Not at all" checked>
                                                <label class="form-check-label" for="gridRadios1">
                                                    a. Not at all
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="take_another_course"  type="radio" name="gridRadios" id="gridRadios2" value="Maybe">
                                                <label class="form-check-label" for="gridRadios2">
                                                    b. Maybe
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input"  name="take_another_course" type="radio" name="gridRadios" id="gridRadios3" value="Highly likely" >
                                                <label class="form-check-label" for="gridRadios3">
                                                    c. Highly likely _
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input"  name="take_another_course" type="radio" name="gridRadios" id="gridRadios4" value="Definitely">
                                                <label class="form-check-label" for="gridRadios4">
                                                    d. Definitely _
                                                </label>
                                            </div>
                                            <input type="text" name="webinar_type" class="form-control" value="webinar">
                                        </div>

                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">




                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                                    <div class="table-responsive">
                                        <table class="table datanew">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>User Name</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if( isset($record) )
                                                @foreach( $record as $live )
                                                    <tr>
                                                        <td>{{$live->id }}</td>
                                                        <td>{{  $live->title }} </td>
                                                        <td>{{$live->date }}</td>
                                                        <td>{{ ($live->user == null) ? "" : $live->user->name }} <br/> {{ ($live->user == null) ? "" : $live->user->email }}</td>
                                                        <td>{{ ($live->user->role == null)? "" : $live->user->role->name }}</td>
                                                        <td><a href="{{ route('webinar.evolution_show',$live->id) }}"> <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="img"> </a></td>
                                                    </tr>

                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
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
