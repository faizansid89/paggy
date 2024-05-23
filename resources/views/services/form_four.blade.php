@extends('layouts.dashboard')

@section('content')

    <div class="page-wrapper cardhead">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">{{ $section->heading }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">{{ $section->heading }}</a></li>
                            <li class="breadcrumb-item active">{{ $section->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">

                    <!-- main alert @s -->
                    @include('partials.alerts')
                    <!-- main alert @e -->

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $section->title }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::model($service, ['route' => $section->route, 'class' => 'form-validate', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
                            @method($section->method)
                                <div class="form-row row">
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label" for="validationCustom01">First name</label>
                                      <input type="text" class="form-control" id="validationCustom01" placeholder="First name" value="" required="">
                                      <div class="valid-feedback">
                                         Looks good!
                                      </div>
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label" for="validationCustom02">Last name</label>
                                      <input type="text" class="form-control" id="validationCustom02" placeholder="Last name" value="" required="">
                                      <div class="valid-feedback">
                                         Looks good!
                                      </div>
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label">Email</label>
                                      <input type="email" class="form-control" placeholder="Email">
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label">Contact Number</label>
                                      <input type="text" class="form-control" placeholder="Phone Number" onkeypress="return isNumber(event)">
                                   </div>
                                   <div class="col-md-12 mb-3">
                                       <div class="form-group">
                                          <label class="form-label">Select a Service</label>
                                             <select class="select" name="ExpertTestimony" id="ExpertTestimony">
                                                <option value="Therapy 120 min">Therapy 120 min</option>
                                                <option value="Therapy 60 min" selected="selected">Therapy 60 min</option>
                                                <option value="Free 15-minute consultation">Free 15-minute consultation</option>
                                                <option value="Expert Testimony full day">Expert Testimony full day</option>
                                                <option value="Expert Testimony half day">Expert Testimony half day</option>
                                                <option value="Consultation 120 min">Consultation 120 min</option>
                                                <option value="Consultation 90 min">Consultation 90 min</option>
                                                <option value="Consultation 60 min">Consultation 60 min</option>
                                                <option value="Expert Testimony 120 min">Expert Testimony 120 min</option>
                                                <option value="Expert Testimony 90 min">Expert Testimony 90 min</option>
                                                <option value="Expert Testimony 60 min">Expert Testimony 60 min</option>
                                                <option value="Clinical Supervision 120 min">Clinical Supervision 120 min</option>
                                                <option value="Clinical Supervision 90 min">Clinical Supervision 90 min</option>
                                                <option value="Clinical Supervision 60 min">Clinical Supervision 60 min</option>
                                                <option value="Expert Testimony 45 min">Expert Testimony 45 min</option>
                                                <option value="Therapy 45 min">Therapy 45 min</option>
                                                <option value="Consultation 45 min">Consultation 45 min</option>
                                             </select>
                                       </div>
                                   </div>
                                </div>
                                <div class="form-row row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label>Your Role</label>
                                            <div class="form-check"> 
                                                <input class="form-check-input" type="radio" name="radioYourRole" id="Prosecutor">
                                                <label class="form-check-label" for="Prosecutor">Prosecutor</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioYourRole" id="DefenseAttorney" checked="">
                                                <label class="form-check-label" for="DefenseAttorney">Defense Attorney</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioYourRole" id="PlaintiffAttorney" checked="">
                                                <label class="form-check-label" for="PlaintiffAttorney">Plaintiff Attorney</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioYourRole" id="RespondentAttorney" checked="">
                                                <label class="form-check-label" for="RespondentAttorney">Respondent Attorney</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioYourRole" id="Client" checked="">
                                                <label class="form-check-label" for="Client">Client</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label>Type of Case</label>
                                            <div class="form-check"> 
                                                <input class="form-check-input" type="radio" name="radioTypeofCase" id="Divorce/Custody">
                                                <label class="form-check-label" for="Divorce/Custody">Divorce/Custody</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioTypeofCase" id="ProtectiveOrder" checked="">
                                                <label class="form-check-label" for="ProtectiveOrder">Protective Order</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioTypeofCase" id="Criminal" checked="">
                                                <label class="form-check-label" for="Criminal">Criminal</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioTypeofCase" id="Other" checked="">
                                                <label class="form-check-label" for="Other">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                           <label>Select Date</label>
                                           <input class="form-control" placeholder="Enter Title" required="required" name="title" type="date">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group col-md-6">
                                          <label for="time">Time</label>
                                          <input class="form-control" type="text" id="ExpertTestimonyDateTime">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                       <label for="inputBriefOverviewofCase" class="form-label">Brief Overview of Case</label>
                                       <textarea class="form-control" placeholder="Please Describe" required="required" name="inputBriefOverviewofCase" cols="50" rows="5" spellcheck="false"></textarea>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-control-wrap">
                                            <div class="custom-file">
                                                <div class="dropzone" data-test="start_job_upload_photos" id="dropzone"></div>
                                                <div class="form-note">Max. files: 5.</div>
                                            </div>
                                        </div>
                                        {{-- <div class="custom-file-container" data-upload-id="mySecondImage">
                                           <label>Please Upload all files here (Allow Multiple) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                           <label class="custom-file-container__custom-file">
                                           <input type="file" class="custom-file-container__custom-file__custom-file-input" multiple="">
                                           <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                                           <span class="custom-file-container__custom-file__custom-file-control">Choose file...<span class="custom-file-container__custom-file__custom-file-control__button"> Browse </span></span>
                                           </label>
                                        </div> --}}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <aside class="product-order-list">
                                           <div class="head d-flex align-items-center justify-content-between w-100">
                                              <div class>
                                                 <h5>Expert Testimony Payment</h5>
                                                 <span>$35.00</span>
                                              </div>
                                           </div>
                                        </aside>
                                    </div>
                                    
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Date</label>
                                            {!! Form::date('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Input</label>
                                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Rich Tech Editor</label>
                                            {!! Form::textarea('description', null, ['class' => 'form-control contentArea', 'placeholder' => 'Enter Description', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Text Area</label>
                                            {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Thumbnail</label>
                                            {!! Form::file('thumbnail_file', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if($section->method == 'PUT')
                                            <img src="{{ $service->thumbnail }}" alt="" class="avatar avatar-xl rounded"  />
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Select DropDown</label>
                                            {!! Form::select('status', array(1 => 'Active', 0 => 'Block'), null, ['class' => 'form-control select', 'placeholder' => 'Select a option', 'required' => 'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Radio Button</label>
                                            <div class="form-check"> <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1"> Default radio </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked="">
                                                <label class="form-check-label" for="flexRadioDefault2"> Default checked radio </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Checkbox</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault"> Default checkbox </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked="">
                                                <label class="form-check-label" for="flexCheckChecked"> Checked checkbox </label>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
     <script>
        $('#ExpertTestimonyDateTime').datetimepicker({
            format: 'hh:mm:ss a'
        });
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/richtext.min.css') }}">
    <script src="{{ asset('assets/js/jquery.richtext.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.contentArea').richText({
                // text formatting
                bold: true,
                italic: true,
                underline: true,

                // text alignment
                leftAlign: true,
                centerAlign: true,
                rightAlign: true,
                justify: true,

                // lists
                ol: true,
                ul: true,

                // title
                heading: true,

                // link
                urls: true,

                // tables
                table: true,

                // code
                removeStyles: true,
                code: true,

                // colors
                colors: [],

                // dropdowns
                fileHTML: '',
                imageHTML: '',

                // privacy
                youtubeCookies: false,

                // preview
                preview: false,

                // placeholder
                placeholder: '',

                // dev settings
                useSingleQuotes: false,
                height: 0,
                heightPercentage: 0,
                id: "",
                class: "",
                useParagraph: false,
                maxlength: 0,
                useTabForNext: false,

                // callback function after init
                callback: undefined,
            });

        });
    </script>
@endsection