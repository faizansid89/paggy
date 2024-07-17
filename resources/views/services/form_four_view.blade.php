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

<style>
    label.form-label {
    font-size: 18px;
    font-weight: 500;
    padding-right: 20px;
}
</style>
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
            
                                <div class="form-row row">
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label" for="validationCustom01">First name:</label>
                                      <label class="form">{{ $formData->first_name }}</label>
                                      <!--<input type="text" class="form-control" id="validationCustom01" name="first_name" placeholder="First name" value="" required="">-->
                                      <div class="valid-feedback">
                                         Looks good!
                                      </div>
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label" for="validationCustom02">Last name: </label>
                                      <label class="form">{{ $formData->last_name }}</label>
                                      <!--<input type="text" class="form-control" id="validationCustom02" name="last_name" placeholder="Last name" value="{{ $formData->last_name }}" required="">-->
                                      <div class="valid-feedback">
                                         Looks good!
                                      </div>
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label">Email:</label>
                                      <label class="form">{{ $formData->email }}</label>
                                      <!--<input type="email" class="form-control" placeholder="Email" value="{{ $formData->email }}" name="email">-->
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label">Contact Number:</label>
                                      <label class="form">{{ $formData->phone }}</label>

                                      <!--<input type="text" class="form-control" placeholder="Phone Number" name="phone" value="{{ $formData->phone }}" onkeypress="return isNumber(event)">-->
                                   </div>
                                   <div class="col-md-12 mb-3">
                                       <div class="form-group">
                                          <label class="form-label">Select a Service:</label>
                                          <label class="form">Expert Testimony</label>
                                       </div>
                                   </div>
                                </div>
                                <div class="form-row row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Your Role</label>
                                            <div class="form-check"> 
                                                <input class="form-check-input" type="radio" name="your_role" id="Prosecutor" checked="">
                                                <label class="form-check-label" for="Prosecutor">{{ $formData->your_role }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label>Type of Case</label>
                                            <div class="form-check"> 
                                                <input class="form-check-input" type="radio" name="type_of_case" id="Divorce/Custody" checked="">
                                                <label class="form-check-label" for="Divorce/Custody">{{ $formData->type_of_case }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3 TypeofCaseFields hidden">
                                       <label for="TypeofCase" class="form-label">Other</label>
                                       <input type="text" name="type_of_case_others" class="form-control" id="TypeofCase" value="{{ $formData->type_of_case_others }}"> >
                                    </div>
                                    <div class="form-row row">
                                        <div class="col-md-3 mb-3">
                                            <div class="form-group">
                                               <label>Appoinment Date</label>
                                               <label>{{ $formData->appoinment_date }}</label>
                                               {{-- <input class="form-control" placeholder="Enter Title" required="required" name="appoinment_date" id="appoinment_date" type="date" > --}}
                                               <div id="selectDate">
                                                    {{-- <input type="text" id="datepicker"> --}}
                                               </div>
                                            </div>
                                        </div>
                                         <div class="col-md-2 mb-3">
                                            <div class="form-group">
                                              <label for="time">Appoinment Time</label>
                                              <label>{{ $formData->appoinment_time }}</label>
                                              <!--<input class="form-control" type="text" name="appoinment_time" id="ExpertTestimonyDateTime">-->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row row" id='serviceTimingFetch'>
                                        
                                    </div>

                                    <div class="form-row row">
                                        <div class="col-md-12 mb-3">
                                           <label for="inputBriefOverviewofCase" class="form-label">Brief Overview of Case</label>
                                           <textarea class="form-control" placeholder="Please Describe" required="required" name="brief_overview_of_case" cols="50" rows="5" spellcheck="false">{{ $formData->brief_overview_of_case}}</textarea>
                                        </div>
                                        <!--<div class="col-md-12 mb-3">-->
                                        <!--    <div class="form-control-wrap">-->
                                        <!--        <div class="custom-file">-->
                                        <!--            <div class="dropzone" data-test="photos" id="dropzone"></div>-->
                                        <!--            <div class="form-note">Max. files: 5.</div>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--    <input type="hidden" class="form-control" name="photos" id="photos" />-->
                                        <!--</div>-->
                                    </div>
                                    
                                </div>
                                <!--<div class="text-end">-->
                                <!--    <button type="submit" class="btn btn-primary">Submit</button>-->
                                <!--</div>-->
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