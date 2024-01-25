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
{{--                <a href="{{ route('products.create') }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-2" alt="img"> Add New {{ $section->heading }}</a>--}}
            </div>
        </div>

        <!-- main alert @s -->
        @include('partials.alerts')
        <!-- main alert @e -->

        <div class="card">
            <div class="card-body">

                <form action="{{route("sales.index")}}" method="get" >
                <div class="row">

                    <div class="col-lg-2 col-sm-6 col-12">
                        <div class="table-top">
                            <div class="search-set">
                                <div class="search-input">
                                    <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-12">
                        <div class="form-group">
                            <div class="input-groupicon">
                                <input type="text" value="{{request()->get('to_date')}}" name="to_date" placeholder="To Date" class="datetimepicker">
                                <div class="addonset">
                                    <img src="{{ asset('assets/img/icons/calendars.svg') }}" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-12">
                        <div class="form-group">
                            <div class="input-groupicon">
                                <input type="text" value="{{request()->get('from_date')}}" name="from_date" placeholder="From Date" class="datetimepicker">
                                <div class="addonset">
                                    <img src="{{ asset('assets/img/icons/calendars.svg') }}" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-12">
                        <div class="form-group">
                            <select name="branch_id" class="form-select" placeholder="Search By Branch">
                                <option value="">All</option>
                                @if($branches)
                                    @foreach($branches as $key => $branch)
                                        <option value="{{$branch->id}}" {{($branch->id== request()->get('branch_id')) ? "selected" : ""}}>{{$branch->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                        <div class="form-group">
                            <input type="submit" name="submit" value="Search" class="btn btn-primary">
                        </div>
                    </div>




                </div>
                </form>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table datanew">
                                        <thead>
                                        <tr>
                                            <th>Customer Name</th>
                                             <th>Is Return</th>
                                            <th>Date</th>
                                            <th>Reference</th>
                                            <th>Payment</th>
                                            <th>Total</th>
                                            <th>Biller</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if( $sales )
                                            @foreach( $sales as $sale )
                                                <tr id="rowID-{{ $sale->id }}">
                                                    <td><a style="color: #ff9f43;" href="{{ route("customer.edit", $sale->customer_id) }}">{{ $sale->customer_name ?? "" }}</a></td>
                                                    <td>
                                                        @if($sale->is_return==1)
                                                            <span class="badges bg-danger">Yes</span>
                                                        @else
                                                            <span class="badges bg-lightgreen">No</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $sale->created_at->format('d M Y') ?? "" }}</td>
                                                    <td><a style="color: #ff9f43;" class="me-3" href="{{ route("sales.show", $sale->sale_auto_id) }}">{{ $sale->invoice_number }}</a></td>
                                                    <td><span class="badges bg-lightgreen">{{ucfirst($sale->status)}}</span></td>
                                                    <td>{!! getAmountFormat($sale->total) !!}</td>
                                                    <td>{{ ucfirst($sale->created_by_name) }}</td>
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
