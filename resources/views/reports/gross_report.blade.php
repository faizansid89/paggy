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
                        <li class="breadcrumb-item active">Sales Report</li>
                    </ul>
                </div>
                <div class="page-btn">
                    <div class="row">
                        <div class="col-4">
                            <div class="dash-widget dash1 mb-0">
                                <div class="dash-widgetcontent">
                                    <h5><span>{{number_format($totalSale,2)}}</span></h5>
                                    <h6>Sale Amount</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="dash-widget dash1 mb-0">
                                <div class="dash-widgetcontent">
                                    <h5><span>{{number_format($totalGrossProfit,2)}}</span></h5>
                                    <h6>Gross Profit</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="dash-widget dash1 mb-0">
                                <div class="dash-widgetcontent">
                                    <h5><span> {{ number_format(($totalGrossProfit / $totalSale) * 100, 2) }}%</span></h5>
                                    <h6>Profit Percentage</h6>
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
                                    <form action="{{route("gross.report")}}" method="get">
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
                                        <table class="table datanew">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
{{--                                                <th>Quantity x Price = Total</th>--}}
{{--                                                <th>Product Discount</th>--}}
                                                <th>Cost Price</th>
                                                <th>Sell Price</th>
                                                <th>Gross Profit</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if( $products )
                                                @foreach($products as $key => $product)
                                                    <tr>
                                                        <td>{{$product['product_name']}}</td>
{{--                                                        <td>{{$product['product_name']}}</td>--}}
{{--                                                        <td>{{$product['product_name']}}</td>--}}
                                                        <td>{{number_format($product['cost_price'],2)}}</td>
                                                        <td>{{$product['sub_total']}}</td>
                                                        <td style="color: {{ $product['gross_profit'] < 0 ? 'red' : 'green' }}">{{number_format($product['gross_profit'],2)}}</td>
                                                        <td>{{$product['created_at']}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
{{--                                        <table class="table datanew">--}}
{{--                                            <thead>--}}
{{--                                            <tr>--}}
{{--                                                <th>Name</th>--}}
{{--                                                <th>Quantity x Price = Total</th>--}}
{{--                                                <th>Product Discount</th>--}}
{{--                                                <th>Product Sub Total</th>--}}
{{--                                                <th>Cost Price</th>--}}
{{--                                                <th>Gross Profit</th>--}}
{{--                                                <th>Date</th>--}}
{{--                                            </tr>--}}
{{--                                            </thead>--}}
{{--                                            <tbody>--}}
{{--                                            @if( $sales )--}}
{{--                                                @foreach($sales as $sale)--}}
{{--                                                    @php--}}
{{--                                                        $quantity_sale_item = $sale->itemQuantity;--}}
{{--                                                        $product_name = $sale->product_name;--}}
{{--                                                        $price = $sale->price;--}}
{{--                                                        $unit_name = $sale->saleItemUnit .' - '.$sale->unit_name;--}}
{{--                                                        $quantity_sale_item = $sale->itemQuantity;--}}
{{--                                                        $sub_total = $sale->sub_total;--}}

{{--                                                        $unit_quantity = ($sale->unit_quantity != 0) ? $sale->unit_quantity : 1 ;--}}
{{--                                                        $unit_cost_price = $sale->unit_cost_price;--}}
{{--                                                        $sale_unit_quantity = $sale->sale_unit_quantity;--}}


{{--                                                        if($sale->saleItemUnit == 1 && $unit_cost_price>0 && $unit_quantity>0 ){--}}
{{--                                                            $calculation = $unit_cost_price / $unit_quantity;--}}
{{--                                                            $gross =  $sub_total - ($calculation * $quantity_sale_item) ;--}}
{{--                                                        }--}}
{{--                                                        else {--}}
{{--                                                            $calculation =  $unit_cost_price / $unit_quantity;--}}
{{--                                                            $gross = $sub_total - ($calculation * $sale_unit_quantity);--}}
{{--                                                        }--}}
{{--                                                    @endphp--}}
{{--                                                    <tr id="rowID-{{ $sale->product_id }}">--}}
{{--                                                        <td>{{$sale->product_name}}</td>--}}
{{--                                                        <td>{{$quantity_sale_item}} {{ $sale->unit_name }} x {{number_format($sale->price, 2)}} = {{ number_format($quantity_sale_item * $sale->price, 2) }}</td>--}}
{{--                                                        <td>{{$sale->saleDiscount}}</td>--}}
{{--                                                        <td>{{$sale->sub_total}}</td>--}}
{{--                                                        @if($sale_unit_quantity == 1)--}}
{{--                                                            <td>{{ number_format($calculation * $quantity_sale_item, 2) }}</td>--}}
{{--                                                        @else--}}
{{--                                                            <td>{{ number_format($calculation * $sale_unit_quantity, 2) }}</td>--}}
{{--                                                        @endif--}}
{{--                                                        <td style="color: {{ $gross < 0 ? 'red' : 'green' }}">{{number_format($gross,2)}}</td>--}}
{{--                                                        <td>{{$sale->itemDate}}</td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}
{{--                                            @endif--}}
{{--                                            </tbody>--}}
{{--                                        </table>--}}
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

                <script>
                    function printdiv(elem) {
                        var header_str = '<html><body><img src="{{ asset('assets/img/logo.png') }} " alt="" style="width:200px; margin: 15px;">';
            var footer_str = '</body></html>';
            var new_str = document.getElementById(elem).innerHTML;
            var old_str = document.body.innerHTML;
            document.body.innerHTML = header_str + new_str + footer_str;
            window.print();
            document.body.innerHTML = old_str;
            return false;
        }
    </script>
@endsection
