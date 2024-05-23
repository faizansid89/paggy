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
                                   <input type="number" class="form-control" placeholder="Phone Number">
                                </div>
                            </div>

                            <div class="form-row row">
                                <div class="col-md-12 mb-3">
                                    <div class="custom-file-container" data-upload-id="mySecondImage">
                                       <label>Please Upload all files here (Allow Multiple) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                       <label class="custom-file-container__custom-file">
                                       <input type="file" class="custom-file-container__custom-file__custom-file-input" multiple="">
                                       <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                                       <span class="custom-file-container__custom-file__custom-file-control">Choose file...<span class="custom-file-container__custom-file__custom-file-control__button"> Browse </span></span>
                                       </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                   <div class="form-group">
                                      <label>Schedule</label>
                                      <div class="form-check"> 
                                        <input class="form-check-input" type="radio" name="radioClinicialSchedule" id="Interview1hr">
                                         <label class="form-check-label" for="Interview1hr">Interview (1 hr)</label>
                                      </div>
                                      <div class="form-check">
                                         <input class="form-check-input" type="radio" name="radioClinicialSchedule" id="Supervision1hr" checked="">
                                         <label class="form-check-label" for="Supervision1hr">Supervision (1 hr)</label>
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
                                      <input class="form-control" type="text" id="clinicialdatetime">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <aside class="product-order-list">
                                       <div class="head d-flex align-items-center justify-content-between w-100">
                                          <div class>
                                             <h5>Clinicial Payment</h5>
                                             <span>$20.00</span>
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
       $('#clinicialdatetime').datetimepicker({
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