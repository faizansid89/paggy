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
                                             <select class="select" name="appoinment_type" id="ConsultationServices">
                                                <option value="">Select Consultation Service Timing</option>
                                                <option value="45 min">Consultation Service 45 min</option>
                                                <option value="60 min">Consultation Service 60 min</option>
                                                <option value="90 min">Consultation Service 90 min</option>
                                                <option value="120 min">Consultation Service 120 min</option>
                                                <option value="half day">Consultation Service Half Day</option>
                                                <option value="full day">Consultation Service Full Day</option>
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
                                            {{-- <input class="form-control" placeholder="Enter Title" name="appoinment_date" type="date"> --}}
                                            <div id="selectDate"></div>
                                         </div>
                                     </div>
                                </div>

                                <div class="form-row row" id='serviceTimingFetch'></div>

                                <div class="form-row row">
                                     {{-- <div class="col-md-4 mb-3">
                                         <div class="form-group col-md-6">
                                           <label for="time">Time</label>
                                           <input class="form-control" type="text" id="consultationDateTime" name="appoinment_time">
                                         </div>
                                     </div> --}}
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

            $(document).on('change', '.hasDatepicker', function() {
                var dateString = $('#datepicker').val();
                console.log(dateString);
                var date = new Date(dateString);
                var daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                var day = daysOfWeek[date.getDay()];
                console.log(day);
                // Get CSRF token
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                var selectedValue = $('#ConsultationServices').val();
                // console.log('Selected value:', selectedValue);

                $.ajax({
                    url: '{{ route('services.getServiceDayTimings') }}', // Laravel route
                    type: 'POST',
                    data: {
                        _token: csrfToken, // CSRF token for Laravel
                        service_day : day,
                        service_type : selectedValue,
                        service_id : 3
                    },
                    success: function(response) {
                        // console.log("Response from server:", response);
                        $('#serviceTimingFetch').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            });

            $('#ConsultationServices').change(function() {
                var selectedValue = $(this).val();
                $('#selectDate').html('<input type="text" name="appoinment_date" id="datepicker">');
                $('#serviceTimingFetch').html('');
                // Get CSRF token
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{ route('services.getServiceDays') }}', // Laravel route
                    type: 'POST',
                    data: {
                        _token: csrfToken, // CSRF token for Laravel
                        service_type: selectedValue,
                        service_id : 3
                    },
                    success: function(response) {
                        console.log("Response from server:", response);
                        var daysString = '';
                        daysString = JSON.stringify(response);
                        var today = new Date();
                        var threeMonthsLater = new Date();
                        threeMonthsLater.setMonth(today.getMonth() + 3);

                        var disabledDays = null;
                        var disabledDays = JSON.parse(daysString); //['tuesday', 'monday']; // Your dynamic days array
                        
                        var dayMap = {
                            'sunday': 0,
                            'monday': 1,
                            'tuesday': 2,
                            'wednesday': 3,
                            'thursday': 4,
                            'friday': 5,
                            'saturday': 6
                        };
                        // Convert the day names to numerical values
                        var disabledDaysNumbers = disabledDays.map(day => dayMap[day.toLowerCase()]);
                        $("#datepicker").datepicker({
                            dateFormat: 'yy-mm-dd',
                            minDate: today,
                            maxDate: threeMonthsLater,
                            beforeShowDay: function(date) {
                                var day = date.getDay();
                                return [disabledDaysNumbers.includes(day), ''];
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            });

        });
        $('#consultationDateTime').datetimepicker({
            format: 'hh:mm:ss a'
        });
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/richtext.min.css') }}">
    <script src="{{ asset('assets/js/jquery.richtext.js') }}"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

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