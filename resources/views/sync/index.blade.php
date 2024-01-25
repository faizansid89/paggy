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

                </div>
            </div>


            <div class="card">
                <div class="card-body">

                    @if (session('message'))
                        <div class="alert alert-info">{{ session('message') }}</div>
                    @endif


                    <form action="" class="mb-5">
                        <div class="form-group">
                            <label for="branch" class="mr-2">Select Store:</label>
                            <select class="form-control" id="branch" name="branch">
                                <option value="none">Select Store</option>
                                @foreach($branches as $branch)
                                    <option value="{{$branch->branch_link}}">{{$branch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="sync_table" >
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Fetch Sales With Items</td>
                                <td>
                                    <a id="fetch_sales" class="btn btn-submit me-2 text-white api"
                                       data-route="{{ route('fetch-sales-with-items', 'placeholder') }}"
                                       href="javascript:">Run</a>
                                </td>
                            </tr>


                            <tr>
                                <td>Fetch Inventory</td>
                                <td>
                                    <a id="fetch_inventory" class="btn btn-submit me-2 text-white api"
                                       data-route="{{ route('fetch-inventory', 'placeholder') }}"
                                       href="javascript:">Run</a>
                                </td>
                            </tr>

                            <tr>
                                <td>Fetch Miss Sale</td>
                                <td>
                                    <a id="fetch_miss_sale" class="btn btn-submit me-2 text-white api"
                                       data-route="{{ route('fetch-miss-sale', 'placeholder') }}"
                                       href="javascript:">Run</a>
                                </td>
                            </tr>

                            <tr>
                                <td>Fetch Opening Balance</td>
                                <td>
                                    <a id="fetch_opening_balance" class="btn btn-submit me-2 text-white api"
                                       data-route="{{ route('fetch-opening-balance', 'placeholder') }}"
                                       href="javascript:">Run</a>
                                </td>
                            </tr>

                            <tr>
                                <td>Fetch Customers</td>
                                <td>
                                    <a id="fetch_customers" class="btn btn-submit me-2 text-white api"
                                       data-route="{{ route('fetch-customers', 'placeholder') }}"
                                       href="javascript:">Run</a>
                                </td>
                            </tr>

                            <tr>
                                <td>Fetch Return Sales</td>
                                <td>
                                    <a id="fetch_return_sales" class="btn btn-submit me-2 text-white api"
                                       data-route="{{ route('fetch-return-sales', 'placeholder') }}"
                                       href="javascript:">Run</a>
                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {


            $("#sync_table").css("display", "none");


            $(document).on('click', "#fetch_sales", function (e) {
                // var funnel =
                const dropvalue = $('#fetch_sales').val();
                console.log(dropvalue);
                if (dropvalue == "none") {
                    alert("Please select store");
                    return false;
                }
            });


            $(document).on('change', "#branch", function (e) {
                e.preventDefault();


                $("#sync_table").css("display", "block");

                var query = $(this).val();

                var route_fetch_sales = $('#fetch_sales').data('route');
                var newroute_fetch_sales = route_fetch_sales.replace("placeholder", 'branch_url=' + query);
                $('#fetch_sales').attr('href', newroute_fetch_sales);

                var route_fetch_inventory = $('#fetch_inventory').data('route');
                var newroute_fetch_inventory = route_fetch_inventory.replace("placeholder", 'branch_url=' + query);
                $('#fetch_inventory').attr('href', newroute_fetch_inventory);

                var route_fetch_miss_sale = $('#fetch_miss_sale').data('route');
                var newroute_fetch_miss_sale = route_fetch_miss_sale.replace("placeholder", 'branch_url=' + query);
                $('#fetch_miss_sale').attr('href', newroute_fetch_miss_sale);

                var route_fetch_opening_balance = $('#fetch_opening_balance').data('route');
                var newroute_fetch_opening_balance = route_fetch_opening_balance.replace("placeholder", 'branch_url=' + query);
                $('#fetch_opening_balance').attr('href', newroute_fetch_opening_balance);

                var route_fetch_customers = $('#fetch_customers').data('route');
                var newroute_fetch_customers = route_fetch_customers.replace("placeholder", 'branch_url=' + query);
                $('#fetch_customers').attr('href', newroute_fetch_customers);

                var route_fetch_return_sales = $('#fetch_return_sales').data('route');
                var newroute_fetch_return_sales = route_fetch_return_sales.replace("placeholder", 'branch_url=' + query);
                $('#fetch_return_sales').attr('href', newroute_fetch_return_sales);


            });

        });
    </script>
@endsection
