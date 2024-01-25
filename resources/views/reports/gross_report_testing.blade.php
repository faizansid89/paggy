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
                        <li class="breadcrumb-item active">Gross Report</li>
                    </ul>
                </div>
                <div class="page-btn">
                    <a href="{{ route('generate_cost_price') }}" target="_blank" class="btn btn-primary">Generate Cost Price</a>
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
                                        <input type="hidden" name="view" value="testing" >
                                    </form>

                                    <div class="table-responsive" id='printable_div_id'>
                                        {{--                                        <table class="table datanew">--}}
                                        {{--                                            <thead>--}}
                                        {{--                                            <tr>--}}
                                        {{--                                                <th>Name</th>--}}
                                        {{--                                                <th>Quantity x Price = Total</th>--}}
                                        {{--                                                <th>Product Discount</th>--}}
                                        {{--                                                <th>Cost Price</th>--}}
                                        {{--                                                <th>Sell Price</th>--}}
                                        {{--                                                <th>Gross Profit</th>--}}
                                        {{--                                                <th>Date</th>--}}
                                        {{--                                            </tr>--}}
                                        {{--                                            </thead>--}}
                                        {{--                                            <tbody>--}}
                                        {{--                                            @if( $products )--}}
                                        {{--                                                @foreach($products as $key => $product)--}}
                                        {{--                                                    <tr>--}}
                                        {{--                                                        <td>{{$product['product_name']}}</td>--}}
                                        {{--                                                        <td>{{$product['product_name']}}</td>--}}
                                        {{--                                                        <td>{{$product['product_name']}}</td>--}}
                                        {{--                                                        <td>{{number_format($product['cost_price'],2)}}</td>--}}
                                        {{--                                                        <td>{{$product['sub_total']}}</td>--}}
                                        {{--                                                        <td style="color: {{ $product['gross_profit'] < 0 ? 'red' : 'green' }}">{{number_format($product['gross_profit'],2)}}</td>--}}
                                        {{--                                                        <td>{{$product['created_at']}}</td>--}}
                                        {{--                                                    </tr>--}}
                                        {{--                                                @endforeach--}}
                                        {{--                                            @endif--}}
                                        {{--                                            </tbody>--}}
                                        {{--                                        </table>--}}
                                        <table class="table datanew">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Quantity x Price = Total</th>
                                                <th>Product Discount</th>
                                                <th>Product Sub Total</th>
                                                <th>Cost Price</th>
                                                <th>Gross Profit</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
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
                                            @php
                                                $grossProfit = 0;
                                            @endphp
                                            @if( $todaySaleNew )
                                                @foreach($todaySaleNew as $todaySale)
                                                    <tr id="rowID-{{ $todaySale->product_id }}">
                                                        <td>
                                                            <a href="{{ route("products.show", $todaySale->product_id) }}">{{$todaySale->product_name}}
                                                                @if($todaySale->sku != null)
                                                                    <small class="badges bg-success">{{ $todaySale->sku }}</small>
                                                                @endif
                                                                @if($todaySale->batch_code != null)
                                                                    <small class="badges bg-dark">{{ $todaySale->batch_code }}</small>
                                                                @endif
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route("sales.show", $todaySale->sales_id) }}">
                                                                {{$todaySale->quantity}} {{ $todaySale->unit_name }}
                                                            x {{number_format($todaySale->price, 2)}}
                                                            = {{ number_format($todaySale->quantity * $todaySale->price, 2) }}
                                                            </a>
                                                        </td>
                                                        <td>{{$todaySale->discount}}</td>
                                                        <td>{{$todaySale->sub_total}}</td>
                                                        @if($todaySale->cost_price == 0)
                                                            <td>
                                                                {{ number_format($todaySale->cost_price, 2) }}
                                                                <button data-product="{{$todaySale->product_id}}" data-saleItem="{{ $todaySale->id  }}" class="btn btn-primary btn-sm seeBatchCode" data-bs-toggle="modal" data-bs-target="#exampleModal">Update Batch Code</button>
                                                            </td>
                                                        @else
                                                            <td>{{ number_format($todaySale->cost_price, 2) }}</td>
                                                        @endif
                                                        @php
                                                            $gross = $todaySale->sub_total - $todaySale->cost_price;
                                                        @endphp
                                                        @if($todaySale->cost_price==0)
                                                            <td style="color: {{ $gross < 0 ? 'red' : 'green' }}">0.00</td>
                                                            @php
                                                                $grossProfit += 0;
                                                            @endphp
                                                        @else
                                                            <td style="color: {{ $gross < 0 ? 'red' : 'green' }}">{{ number_format($gross, 2) }}</td>
                                                            @php
                                                                $grossProfit += $gross;
                                                            @endphp
                                                        @endif
                                                        <td>{{$todaySale->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="dash-widget dash1 mb-0">
                                        <div class="dash-widgetcontent">
                                            <h5><span>{{number_format($todaySaleNew->sum('sub_total'),2)}}</span></h5>
                                            <h6>Sale Amount</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="dash-widget dash1 mb-0">
                                        <div class="dash-widgetcontent">
                                            <h5><span>{{number_format($grossProfit,2)}}</span></h5>
                                            <h6>Gross Profit</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="dash-widget dash1 mb-0">
                                        <div class="dash-widgetcontent">
                                            @if($grossProfit != 0)
                                                <h5><span> {{ number_format(($grossProfit / $todaySaleNew->sum('sub_total')) * 100, 2) }}%</span></h5>
                                            @else
                                                <h5><span> 0%</span></h5>
                                            @endif
                                            <h6>Profit Percentage</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title selectProductName">Check All Batch Code Received</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <table class="table mb-0">
                                        <thead>
                                        <tr>
                                            <th>Purchase Order No.</th>
                                            <th>Batch Code</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="BatchCodeStatus">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>


            @endsection

            @section('scripts')
                <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
                <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>

                <script>

                    $(document).on('click', ".seeBatchCode", function (e) {

                        // Get the values of data-product and data-saleItem attributes
                        var productID = $(this).data('product');
                        var saleItemId = $(this).data('saleitem'); // Note the case sensitivity

                        // Now you can use productID and saleItemId as needed
                        console.log("Product ID: " + productID);
                        console.log("Sale Item ID: " + saleItemId);

                        $.ajax({
                            url: '{{ route('showProductBatchCode') }}',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            type: 'POST',
                            data: {
                                product_id: productID,
                                sale_line_item : saleItemId
                            },
                            success: function (response) {
                                $('#BatchCodeStatus').html(response);
                                $('#exampleModal').addClass('show');
                            },
                            error: function (xhr) {
                                alert('Error: ' + xhr.responseJSON.message);
                            }
                        });
                    });



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
