@extends('layouts.dashboard')

@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="row">
            <!--<div class="col-lg-4 col-sm-4 col-12">-->
                <!--    <div class="dash-widget dash1 mb-0">-->
                <!--        <div class="dash-widgetimg">-->
                <!--                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}"-->
                <!--                               alt="img"></span>-->
                <!--        </div>-->
                <!--        <div class="dash-widgetcontent">-->
                <!--            <h5><span>8678</span></h5>-->
                <!--            <h6>Today Total Sales</h6>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="col-lg-4 col-sm-4 col-12">-->
                <!--    <div class="dash-widget dash1 mb-0">-->
                <!--        <div class="dash-widgetimg">-->
                <!--            <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>-->
                <!--        </div>-->
                <!--        <div class="dash-widgetcontent">-->
                <!--            <h5><span>98</span></h5>-->
                <!--            <h6>Today Cash Sales</h6>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="col-lg-4 col-sm-4 col-12 mb-5">-->
                <!--    <div class="dash-widget dash1 mb-0">-->
                <!--        <div class="dash-widgetimg">-->
                <!--            <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>-->
                <!--        </div>-->
                <!--        <div class="dash-widgetcontent">-->
                <!--            <h5><span>099</span></h5>-->
                <!--            <h6>Today Card Sales</h6>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

                <!--<div class="col-lg-3 col-sm-6 col-12 d-flex">-->
                <!--    <div class="dash-count">-->
                <!--        <div class="dash-counts">-->
                <!--            <h4>9</h4>-->
                <!--            <h5>Customers</h5>-->
                <!--        </div>-->
                <!--        <div class="dash-imgs">-->
                <!--            <i data-feather="user"></i>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="col-lg-3 col-sm-6 col-12 d-flex">-->
                <!--    <div class="dash-count das1">-->
                <!--        <div class="dash-counts">-->
                <!--            <h4>8</h4>-->
                <!--            <h5>Suppliers</h5>-->
                <!--        </div>-->
                <!--        <div class="dash-imgs">-->
                <!--            <i data-feather="user-check"></i>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="col-lg-3 col-sm-6 col-12 d-flex">-->
                <!--    <div class="dash-count das2">-->
                <!--        <div class="dash-counts">-->
                <!--            <h4>9</h4>-->
                <!--            <h5>Purchase Invoice</h5>-->
                <!--        </div>-->
                <!--        <div class="dash-imgs">-->
                <!--            <i data-feather="file-text"></i>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="col-lg-3 col-sm-6 col-12 d-flex">-->
                <!--    <div class="dash-count das3">-->
                <!--        <div class="dash-counts">-->
                <!--            <h4>6</h4>-->
                <!--            <h5>Sales Invoice</h5>-->
                <!--        </div>-->
                <!--        <div class="dash-imgs">-->
                <!--            <i data-feather="file"></i>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

                {{--                <div class="col-lg-6 col-sm-6 col-12">--}}
                {{--                    <div class="dash-widget">--}}
                {{--                        <div class="dash-widgetimg">--}}
                {{--                            <span><img src="{{ asset('assets/img/icons/dash1.svg') }}" alt="img"></span>--}}
                {{--                        </div>--}}
                {{--                        <div class="dash-widgetcontent">--}}
                {{--                            <h5>Rs. <span class="counters"--}}
                {{--                                          data-count="{{ $sales->sum('total') }}">{!! $sales->sum('total') !!}</span>--}}
                {{--                            </h5>--}}
                {{--                            <h6>Total Sales</h6>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="col-lg-6 col-sm-6 col-12">--}}
                {{--                    <div class="dash-widget dash1">--}}
                {{--                        <div class="dash-widgetimg">--}}
                {{--                            <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>--}}
                {{--                        </div>--}}
                {{--                        <div class="dash-widgetcontent">--}}
                {{--                            <h5>Rs. <span class="counters" data-count="{{ $todaySale }}">{{ $todaySale }} </span></h5>--}}
                {{--                            <h6>Today Sales</h6>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}


            </div>

            </div>

        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            alertify.success("Welcome {{ auth()->user()->name }} ");
        });
    </script>


@endsection
