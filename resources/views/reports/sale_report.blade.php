@extends('layouts.dashboard')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="page-title">
                    <h4>{{ $section->heading }}</h4>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                        <li class="breadcrumb-item active">{{ $section->title }}</li>
                        <li class="breadcrumb-item active">Sales Report</li>
                    </ul>
                </div>
                {{--                <div class="page-btn">--}}
                {{--                    <button class="btn btn-added" onClick="printdiv('printable_div_id');" style="float: left; margin-right: 5px;">PRINT</button>--}}
                {{--                </div>--}}
                <div class="page-btn">
                    <div class="row">
                        {{--                        <div class="col-lg-6 col-12 d-flex" style="min-width: 260px;">--}}
                        {{--                            <div class="dash-widget dash1 mb-0">--}}
                        {{--                                <div class="dash-widgetimg">--}}
                        {{--                                    <span><img src="http://localhost/wecare/public/assets/img/icons/dash2.svg" alt="img"></span>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="dash-widgetcontent">--}}
                        {{--                                    <h5><span>{!! getAmountFormat($sales->where('is_return',0)->sum('total')) !!}</span></h5>--}}
                        {{--                                    <h6>Total Sales</h6>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}


                        <div class="col-4">
                            <div class="dash-widget dash1 mb-0">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}"
                                               alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5><span>{!! getAmountFormat($sales->sum('total')) !!}</span></h5>
                                    <h6>Total Sales</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="dash-widget dash1 mb-0">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>
                                        <span>{!! getAmountFormat($sales->where('status', 'cash')->sum('total')) !!}</span>
                                    </h5>
                                    <h6>Total Cash Sales</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mt-2">
                            <div class="dash-widget dash1 mb-0">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>
                                        <span>{!! getAmountFormat($sales->where('status', 'card')->sum('total')) !!}</span>
                                    </h5>
                                    <h6>Total Card Sales</h6>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <!-- main alert @s -->
            @include('partials.alerts')
            <!-- main alert @e -->

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{route("reports.saleReport")}}" method="get">
                                        <div class="row">
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <div class="table-top">
                                                    <div class="search-set">
                                                        <div class="search-input">
                                                            <a class="btn btn-searchset"><img
                                                                    src="{{ asset('assets/img/icons/search-white.svg') }}"
                                                                    alt="img"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
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
                                            <div class="col-lg-2 col-sm-6 col-12">
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
                                                    <select name="status" class="form-select"
                                                            placeholder="Search By Sales Type">
                                                        <option value="">Sales Type</option>
                                                        <option
                                                            value="cash" {{('cash'== request()->get('status')) ? "selected" : ""}}>
                                                            Cash
                                                        </option>
                                                        <option
                                                            value="card" {{('card'== request()->get('status')) ? "selected" : ""}}>
                                                            Card
                                                        </option>
                                                        <option
                                                            value="credit" {{('credit'== request()->get('status')) ? "selected" : ""}}>
                                                            Credit
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <select name="branch_id" class="form-select">
                                                        <option value="">All</option>
                                                        @foreach($branches as $key => $branch)
                                                            <option
                                                                value="{{$key}}" {{($key== request()->get('branch_id')) ? "selected" : ""}}>{{$branch}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                                <div class="form-group">
                                                    <input type="submit" name="submit" value="Search"
                                                           class="btn btn-primary">
                                                    {{--                                                <a class="btn btn-filters ms-auto"><img src="{{ asset('assets/img/icons/search-whites.svg') }}" alt="img"></a>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive" id='printable_div_id'>
                                        <table id="example" class="table display" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Is Return</th>
                                                <th>Date</th>
                                                <th>Branch</th>
                                                <th>Customer</th>
                                                <th>Reference</th>
                                                <th>Payment</th>
                                                <th>Biller Name</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if( $sales )
                                                @foreach( $sales as $sale )
                                                    <tr id="rowID-{{ $sale->id }}">
                                                        <td>
                                                            @if($sale->is_return==1)
                                                                <span class="badges bg-danger">Yes</span>
                                                            @else
                                                                <span class="badges bg-lightgreen">No</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ formatDate($sale->created_at) }} {{ formatTime($sale->created_at) }}</td>
                                                        <td>{{$sale->branch->name}}</td>
                                                        <td><a style="color: #ff9f43;"
                                                               href="{{ route("customer.edit", $sale->customer_id) }}">{{$sale->customer_name}}</a>
                                                        </td>
                                                        <td><a style="color: #ff9f43;"
                                                               href="{{ route("sales.show", $sale->id) }}">{{$sale->invoice_number}}</a>
                                                        </td>

                                                        <td>
                                                            <span
                                                                style="text-transform: capitalize;">

                                                                  @if($sale->status=='cash')
                                                                    <span class="badges bg-lightgreen">Cash</span>
                                                                @elseif($sale->status=='card')
                                                                    <span class="badges bg-info">Card</span>
                                                                @else
                                                                    <span class="badges bg-warning">Credit</span>
                                                                @endif


                                                            </span> {!! getAmountFormat($sale->total) !!}
                                                        </td>

                                                        <td>{{ $sale->created_by_name }}</td>
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
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <!-- JSZip -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <!-- DataTables Print Button JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <!-- PDFMake -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection
