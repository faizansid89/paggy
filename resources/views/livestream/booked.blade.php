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
                    <div class="btn-group" >
                        <a href="{{ route('livestream.booked') }}" class="btn btn-outline-secondary">All</a>
                        <a href="{{ route('livestream.general') }}" class="btn btn-secondary">General Public</a>
                        <a href="{{ route('livestream.professional') }}" class="btn btn-dark">Professional Education</a>
                    </div>
                @endif
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">

                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img"></a>
                            </div>
                        </div>

                    </div>


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
                                                <th>Stream Link</th>
                                                <th>Date</th>
                                                <th>Related To</th>
                                                <th>Purchased By</th>
                                                <th>Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if( isset($record) )
                                                @foreach( $record as $live )

                                                    <tr>
                                                        <td>{{$live->id }}</td>
                                                        <td>{{ ($live->livestream) ? $live->livestream->link : "" }}</td>
                                                        <td>{{ ($live->livestream)? $live->livestream->date : "" }}</td>
                                                        <td>{{($live->livestream)? $live->livestream->related : "" }}</td>
                                                        <td>{{ ($live->user == null) ? "" : $live->user->name }} - {{ ($live->role == null) ? "" : $live->role->name }}</td>
                                                        <td>{{ env('CURRENCY_SAMBOL') }}{{$live->amount }}</td>
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
                <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
                <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
@endsection
