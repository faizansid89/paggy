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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            {!! Form::textarea('description', null, ['class' => 'form-control contentArea', 'placeholder' => 'Enter Description', 'required' => 'required']) !!}
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
                                        <h3>Service Pricing</h3>
                                    </div>
                                </div>
                                <div id="serviceContainer">
                                    <div class="row serviceRow">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Service Type</label>
                                                <select class="select" name="service[1][type]">
                                                    <option value="45 min" selected="selected">45 min</option>
                                                    <option value="60 min">60 min</option>
                                                    <option value="90 min">90 min</option>
                                                    <option value="120 min">120 min</option>
                                                    <option value="half day">Half Day</option>
                                                    <option value="full day">Full Day</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Service Day</label>
                                                <select class="select" name="service[1][day]">
                                                    <option value="monday" selected="selected">Monday</option>
                                                    <option value="tuesday">Tuesday</option>
                                                    <option value="wednesday">Wednesday</option>
                                                    <option value="thursday">Thursday</option>
                                                    <option value="friday">Friday</option>
                                                    <option value="saturday">Saturday</option>
                                                    <option value="sunday">Sunday</option>
                                                 </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Service Start Time</label>
                                                <input type="text" name="service[1][time_start]" class="form-control service_time" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Service End Time</label>
                                                <input type="text" name="service[1][time_end]" class="form-control service_time" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Service Price</label>
                                                <input type="text" name="service[1][price]" class="form-control" placeholder="Enter Price" required="required" onkeypress="return isNumber(event)">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group" style="text-align: right;">
                                                <label>&nbsp;</label>
                                                <div class="btn-group">
                                                    <a type="button" class="btn btn-danger deleteRow" href="#" style="color: #ffffff;">-</a>
                                                    <a type="button" class="btn btn-warning addRow" href="#" style="color: #ffffff;">+</a>
                                                </div>
                                            </div>
                                        </div>
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


            var rowCount = 1;

            // Function to initialize datetimepicker and any select box plugins
            function initializePlugins(element) {
                element.find('.service_time').datetimepicker({
                    format: 'LT'
                });
                // Add any other plugin initialization code here if needed
            }

            // Initialize plugins for the initial row
            initializePlugins($('.serviceRow'));

            // Function to add a new row
            $(document).on('click', '.addRow', function(e) {
                e.preventDefault();
                rowCount++;
                var newRow = $('.serviceRow:first').clone();
                newRow.find('select, input').each(function() {
                    var name = $(this).attr('name');
                    var newName = name.replace(/\d+/, rowCount);
                    $(this).attr('name', newName);
                    if ($(this).is('input')) {
                        $(this).val('');
                    }
                });
                newRow.appendTo('#serviceContainer');
                initializePlugins(newRow);
            });

            // Function to remove a row
            $(document).on('click', '.deleteRow', function(e) {
                e.preventDefault();
                if ($('.serviceRow').length > 1) {
                    $(this).closest('.serviceRow').remove();
                } else {
                    alert("At least one service row is required.");
                }
            });

            // Event-driven initialization of datetimepicker
            $(document).on('focus', '.service_time', function(e) {
                $(this).datetimepicker({
                    format: 'LT'
                });
            });

        });
    </script>
@endsection