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

                            <div class="steps active" id="content1">
                                <div class="form-row row">
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label" for="validationCustom01">First name</label>
                                      <input type="text" class="form-control" id="validationCustom01" name="first_name" placeholder="First name" value="{{ auth()->user()->name }}" required="">
                                      <div class="valid-feedback">
                                         Looks good!
                                      </div>
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label" for="validationCustom02">Last name</label>
                                      <input type="text" class="form-control" id="validationCustom02" name="last_name" placeholder="Last name" value="" required="">
                                      <div class="valid-feedback">
                                         Looks good!
                                      </div>
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label">Email</label>
                                      <input type="email" class="form-control" placeholder="Email" value="{{ auth()->user()->email }}" name="email">
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label">Contact Number</label>
                                      <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="{{ auth()->user()->phone }}" onkeypress="return isNumber(event)">
                                   </div>
                                </div>

                                <div class="form-row row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Your Role</label>
                                            <div class="form-check"> 
                                                <input class="form-check-input" type="radio" name="your_role" id="Prosecutor" value="Prosecutor">
                                                <label class="form-check-label" for="Prosecutor">Prosecutor</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="your_role" id="DefenseAttorney" checked="" value="Defense Attorney">
                                                <label class="form-check-label" for="DefenseAttorney">Defense Attorney</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="your_role" id="PlaintiffAttorney" checked="" value="Plaintiff Attorney">
                                                <label class="form-check-label" for="PlaintiffAttorney">Plaintiff Attorney</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="your_role" id="RespondentAttorney" checked="" value="Respondent Attorney">
                                                <label class="form-check-label" for="RespondentAttorney">Respondent Attorney</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="your_role" id="Client" checked="" value="Client">
                                                <label class="form-check-label" for="Client">Client</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Type of Case</label>
                                            <div class="form-check"> 
                                                <input class="form-check-input" type="radio" name="type_of_case" id="Divorce/Custody" checked="" value="Divorce/Custody">
                                                <label class="form-check-label" for="Divorce/Custody">Divorce/Custody</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_of_case" id="ProtectiveOrder" value="Protective Order">
                                                <label class="form-check-label" for="ProtectiveOrder">Protective Order</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_of_case" id="Criminal" value="Criminal">
                                                <label class="form-check-label" for="Criminal">Criminal</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="other" type="radio" name="type_of_case" id="Other" value="Other">
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
                                    <div class="col-md-12 mb-3">
                                       <label for="inputBriefOverviewofCase" class="form-label">Brief Overview of Case</label>
                                       <textarea class="form-control" placeholder="Please Describe" required="required" name="brief_overview_of_case" cols="50" rows="5" spellcheck="false"></textarea>
                                    </div>
                                </div>

                            </div>
                            <!-- STEP 1 END -->

                            <div class="steps" id="content2">
                                <div class="form-row row">
                                   <div class="col-md-12 mb-3">
                                      <h6 class="mb-5" style="text-transform: uppercase;"><strong>Note: Kindly download all these forms, fill them out, and then upload them again.</strong></h6>
                                      @if($downloadFiles)
                                      <div class="attach-files">
                                         <ul class="attach-list">
                                            @foreach($downloadFiles as $key => $downloadFile)
                                            <li style="text-align: center; width:200px; float:left;" class="attach-item" data-toggle="tooltip" data-placement="top" title="{{ $downloadFile->title }}"><a class="download" target="_blank" href="{{ $downloadFile->file_path }}"><img src="{{ asset('assets/img/DOC.png') }}" width="35px"><span><br/>{{ $downloadFile->title }}</span></a></></li>
                                            @endforeach
                                         </ul>
                                      </div>
                                      @endif
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <div class="form-control-wrap">
                                         <div class="custom-file">
                                            <div class="dropzone" data-test="photos" id="dropzone"></div>
                                            {{-- 
                                            <div class="form-note">Max. files: 5.</div>
                                            --}}
                                         </div>
                                      </div>
                                      <input type="hidden" class="form-control" name="photos" id="photos" />
                                   </div>
                                </div>
                            
                            </div>
                            <!-- STEP 2 END -->

                            <div class="steps" id="content3">
                                <div class="form-row row">
                                   <div class="col-md-12 mb-3">
                                      <div class="form-group">
                                         <label class="form-label">Select a Service</label>
                                         <select class="select"  name="appoinment_type"  id="ExpertTestimony">
                                            <option value="">Select Expert Testimony Service Timing</option>
                                            <option value="45 min">Expert Testimony 45 min</option>
                                            <option value="60 min">Expert Testimony 60 min</option>
                                            <option value="90 min">Expert Testimony 90 min</option>
                                            <option value="120 min">Expert Testimony 120 min</option>
                                            <option value="half day">Expert Testimony Half Day</option>
                                            <option value="full day">Expert Testimony Full Day</option>
                                         </select>
                                      </div>
                                   </div>
                                </div>
                                <div class="form-row row">
                                   <div class="col-md-3 mb-3">
                                      <div class="form-group">
                                         <label>Select Date</label>
                                         {{-- <input class="form-control" placeholder="Enter Title" required="required" name="appoinment_date" id="appoinment_date" type="date"> --}}
                                         <div id="selectDate">
                                            {{-- <input type="text" id="datepicker"> --}}
                                         </div>
                                      </div>
                                   </div>
                                   {{-- 
                                   <div class="col-md-2 mb-3">
                                      <div class="form-group">
                                         <label for="time">Time</label>
                                         <input class="form-control" type="text" name="appoinment_time" id="ExpertTestimonyDateTime">
                                      </div>
                                   </div>
                                   --}}
                                </div>
                                <div class="form-row row" id='serviceTimingFetch'>
                                </div>
                            </div>
                            <!-- STEP 3 END -->

                            <!-- NEXT PREV BUTTON LOGIC -->
                            <div class="form-row row">
                                <div class="col-6">
                                    <div class="text-start">
                                        <a id="prev" class="btn btn-lg btn-dark">Previous</a>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <a id="next" class="btn btn-lg btn-dark">Next</a>
                                        <button id="lastSubmit" type="submit" class="btn btn-lg btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <!-- NEXT PREV BUTTON LOGIC -->

                            </div>
                            

                            

                            

                            {!! Form::close() !!}
                        </div>
                        <!-- CARD BODY END -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<style>
    .steps { display: none; }
    .steps.active { display: block; }
    button { display: inline-block; margin: 5px; }
</style>
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

                var selectedValue = $('#ExpertTestimony').val();
                // console.log('Selected value:', selectedValue);

                $.ajax({
                    url: '{{ route('services.getServiceDayTimings') }}', // Laravel route
                    type: 'POST',
                    data: {
                        _token: csrfToken, // CSRF token for Laravel
                        service_day : day,
                        service_type : selectedValue,
                        service_id : 4
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

            $('#ExpertTestimony').change(function() {
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
                        service_id : 4
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
        $('#ExpertTestimonyDateTime').datetimepicker({
            format: 'hh:mm a'
        });


        $(function() {
            $("#datepicker").datepicker({
                onSelect: function(dateText, inst) {
                    var date = $(this).datepicker('getDate');
                    var daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                    var day = daysOfWeek[date.getDay()];
                    console.log(day);
                }
            });
        });
        
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/richtext.min.css') }}">
    <script src="{{ asset('assets/js/jquery.richtext.js') }}"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    
    <script>
        //NEXT AND PREVIOUS CONDITION;
    $(document).ready(function(){
        var currentIndex = 0;
        var contents = $('.steps');
        var contentCount = contents.length;

        function updateButtons() {
            $('#prev').toggle(currentIndex > 0);
            $('#next').toggle(currentIndex < contentCount - 1);
            $('#lastSubmit').toggle(currentIndex === contentCount - 1);
        }

        $('#next').click(function(){
            if (currentIndex < contentCount - 1) {
                $(contents[currentIndex]).removeClass('active');
                currentIndex++;
                $(contents[currentIndex]).addClass('active');
                updateButtons();
            }
        });

        $('#prev').click(function(){
            if (currentIndex > 0) {
                $(contents[currentIndex]).removeClass('active');
                currentIndex--;
                $(contents[currentIndex]).addClass('active');
                updateButtons();
            }
        });

        updateButtons();
    });

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