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
            <div class="page-btn">
{{--                <a href="{{ route('sale.return.create') }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-2" alt="img"> Add New {{ $section->heading }}</a>--}}
            </div>
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

                                <form action="{{route("sync.logs")}}" method="get">


                                    <div class="row">

                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <div class="input-groupicon">
                                                    <input type="text" value="{{request()->get('to_date')}}"
                                                           name="to_date" placeholder="To Date"
                                                           class="datetimepicker">
                                                    <div class="addonset">
                                                        <img src="{{ asset('assets/img/icons/calendars.svg') }}"
                                                             alt="img">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <div class="input-groupicon">
                                                    <input type="text" value="{{request()->get('from_date')}}"
                                                           name="from_date" placeholder="From Date"
                                                           class="datetimepicker">
                                                    <div class="addonset">
                                                        <img src="{{ asset('assets/img/icons/calendars.svg') }}"
                                                             alt="img">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                                                <div class="col-lg-2 col-sm-6 col-12">
                                                                                    <div class="form-group">
                                                                                        <select name="branch_id" class="form-select"
                                                                                                placeholder="Search By Branch">
                                                                                            <option value="">All Branches</option>
                                                                                            @foreach($branches as $key => $branch)
                                                                                                <option
                                                                                                    value="{{$key}}" {{($key== request()->get('branch_id')) ? "selected" : ""}}>{{$branch}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                        <div class="col-lg-2 col-sm-6 col-12 ms-auto">
                                            <div class="form-group">
                                                <input type="submit" name="submit" value="Search"
                                                       class="btn btn-primary">
                                                {{--                                                <a class="btn btn-filters ms-auto"><img src="{{ asset('assets/img/icons/search-whites.svg') }}" alt="img"></a>--}}
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table datanew">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Branch Number</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if( $sync_logs )
                                            @foreach( $sync_logs as $key => $log )
                                                <tr id="rowID-{{ $key }}">
                                                    <td>{{ $log->created_at ?? "" }}</td>
                                                    <td>{{ $log->branch->name ?? "" }}</td>
                                                    <td>{{ $log->name ?? "" }}</td>
                                                    <td>{{ $log->status ?? "" }}</td>
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
