@extends('layouts.dashboard')

@section('content')
<style>
    /* .fc-direction-ltr .fc-daygrid-event .fc-event-time { color: #000000; } */
    .fc-daygrid-dot-event .fc-event-title { text-align: left; }
    .fc-event { background: #6a6a6a; text-align: left !important; }
</style>
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
        </div>

        <!-- main alert @s -->
        @include('partials.alerts')
        <!-- main alert @e -->

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/calender_global.js') }}"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialDate: '{{ $todayDate }}',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                height: 'auto',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                selectable: true,
                selectMirror: true,
                nowIndicator: true,
                events: [{!! $html !!}]
            });

            calendar.render();
        });
    </script>
@endsection
