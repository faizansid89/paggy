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
                                       <input type="text" class="form-control" id="validationCustom01" placeholder="First name" name="first_name" value="" required="">
                                       <div class="valid-feedback">
                                          Looks good!
                                       </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                       <label class="form-label" for="validationCustom02">Last name</label>
                                       <input type="text" class="form-control" id="validationCustom02" placeholder="Last name" value="" name="last_name" required="">
                                       <div class="valid-feedback">
                                          Looks good!
                                       </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                       <label class="form-label">Email</label>
                                       <input type="email" class="form-control" placeholder="Email" name="email">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                       <label class="form-label">Contact Number</label>
                                       <input type="text" class="form-control" placeholder="Phone Number" name="phone" onkeypress="return isNumber(event)">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                       <div class="form-group">
                                          <label class="form-label">Select a Service</label>
                                             <select class="select" name="consultation_services" id="ConsultationServices">
                                                <option value="Consultation 45 min" selected="selected">Consultation 45 min</option>
                                                <option value="Consultation 60 min">Consultation 60 min</option>
                                                <option value="Consultation 90 min">Consultation 90 min</option>
                                                <option value="Consultation 120 min">Consultation 120 min</option>
                                             </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Your Role</label>
                                            <div class="form-check"> 
                                                <input class="form-check-input" type="radio" name="your_role" id="Prosecutor" checked="">
                                                <label class="form-check-label" for="Prosecutor">Prosecutor</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="your_role" id="DefenseAttorney">
                                                <label class="form-check-label" for="DefenseAttorney">Defense Attorney</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="your_role" id="PlaintiffAttorney">
                                                <label class="form-check-label" for="PlaintiffAttorney">Plaintiff Attorney</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="your_role" id="RespondentAttorney">
                                                <label class="form-check-label" for="RespondentAttorney">Respondent Attorney</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="your_role" id="Client">
                                                <label class="form-check-label" for="Client">Client</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Type of Case</label>
                                            <div class="form-check"> 
                                                <input class="form-check-input" type="radio" name="type_of_case" id="Divorce/Custody" checked="">
                                                <label class="form-check-label" for="Divorce/Custody">Divorce/Custody</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_of_case" id="ProtectiveOrder">
                                                <label class="form-check-label" for="ProtectiveOrder">Protective Order</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_of_case" id="Criminal">
                                                <label class="form-check-label" for="Criminal">Criminal</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="other" type="radio" name="type_of_case" id="Other" >
                                                <label class="form-check-label" for="Other">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4 mb-3 TypeofCaseFields hidden">
                                       <label for="TypeofCase" class="form-label">Other</label>
                                       <input type="text" name="type_of_case_others" class="form-control" id="TypeofCase">
                                    </div>
                                 </div>
                                 <div class="form-row row">
                                     <div class="col-md-12">
                                         <h3 class="mb-3">Court Date:</h3>
                                     </div>
                                 </div>
                                 <div class="form-row row">
                                     <div class="col-md-4 mb-3">
                                         <div class="form-group">
                                            <label>Select Date</label>
                                            <input class="form-control" placeholder="Enter Title" name="appoinment_date" type="date">
                                         </div>
                                     </div>
                                     <div class="col-md-4 mb-3">
                                         <div class="form-group col-md-6">
                                           <label for="time">Time</label>
                                           <input class="form-control" type="text" id="consultationDateTime" name="appoinment_time">
                                         </div>
                                     </div>
                                     <div class="col-md-12 mb-3">
                                        <label for="inputBriefOverviewofCase" class="form-label">Brief Overview of Case</label>
                                        <textarea class="form-control" placeholder="Please Describe" required="required" name="brief_overview_of_case" cols="50" rows="5" spellcheck="false"></textarea>
                                     </div>
                                     <div class="col-md-12 mb-3">
                                        <div class="form-control-wrap">
                                            <div class="custom-file">
                                                <div class="dropzone" data-test="photos" id="dropzone"></div>
                                                <div class="form-note">Max. files: 5.</div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="photos" id="photos" />
                                    </div>
                                 </div>
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
        $(document).ready(function() {
            // TypeOfCase section;
            $('input[name="type_of_case"]').on('change', function() {
                if ($(this).val() === 'other') {
                    $('.TypeofCaseFields').removeClass('hidden');
                } else {
                    $('.TypeofCaseFields').addClass('hidden');
                }
            });

        });
        $('#consultationDateTime').datetimepicker({
            format: 'hh:mm:ss a'
        });
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/richtext.min.css') }}">
    <script src="{{ asset('assets/js/jquery.richtext.js') }}"></script>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    
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


        var imageUploadClass;

        $('.dropzone').on('click',function(e) {
            console.log('On Click - '+$(this).data('test'));
            imageUploadClass = $(this).data('test');
        });

        Dropzone.options.dropzone =
        {
            url: '{{url('dashboard/image/upload/store')}}',
            maxFilesize: 25,
            renameFile: function (file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + '_' + file.name;
            },
            acceptedFiles: "image/*",
            addRemoveLinks: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            timeout: 50000,
            removedfile: function (file) {
                console.log(file._removeLink.className);
                console.log($(this).data('test'));
                var imageUploadClass = $(this).closest('#dropzone').data('test');

                console.log(imageUploadClass);
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: '{{ url("dashboard/image/delete") }}',
                    data: {filename: name},
                    success: function (data) {
                        console.log(imageUploadClass);
                        var newArr = [];
                        if ($('#'+imageUploadClass).val().length != 0){
                            newArr = $('#'+imageUploadClass).val().split(',');
                            console.log('Remove Item');
                            console.log(newArr);
                        }
                        console.log("File has been successfully removed!!");
                        var removeItem = data;
                        newArr = jQuery.grep(newArr, function (va) {
                            return va != removeItem;
                        });
                        $('#'+imageUploadClass).val(newArr);
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
                var fileRef;
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            success: function (file, response) {
                console.log(imageUploadClass);
                var newArr = [];
                if ($('#'+imageUploadClass).val().length != 0){
                    newArr = $('#'+imageUploadClass).val().split(',');
                    console.log(newArr);
                }
                console.log(newArr);
                $.each(response, function (key, value) {
                    console.log(value);
                    newArr.push(value);
                });
                console.log(newArr);
                $('#'+imageUploadClass).val(newArr);
            },
            error: function (file, response) {
                return false;
            }
        };
    </script>
@endsection