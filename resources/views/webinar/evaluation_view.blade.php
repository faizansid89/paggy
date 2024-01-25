@extends('layouts.dashboard')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="page-title">
                    <h4>{{ $section->heading }}</h4>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('webinar.evolution') }}">Webinar Evaluation</a></li>
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
                                    {{ dd($record->toArray()) }}
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
