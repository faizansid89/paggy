@extends('layouts.dashboard')

@section('content')

    <style></style>
    <div class="page-wrapper">
        <div class="content">
            @if(auth()->user()->role_id != 3)
                <div class="card dash-count das2">
                    <div class="card-header">
                        <h1>Welcome {{ auth()->user()->name }}</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-12 mb-4">
                        <div class="dash-widget dash1 mb-0">
                            <div class="dash-widgetimg">
                                        <span><img src="{{ asset('assets/img/icons/dash2.svg') }}"
                                                   alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5><span>{!! getAmountFormat($streams->sum('amount')) !!}</span></h5>
                                <h6>Total Stream Sales</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-12 mb-4">
                        <div class="dash-widget dash1 mb-0">
                            <div class="dash-widgetimg">
                                <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5><span>{!! getAmountFormat($webinars->sum('amount')) !!}</span></h5>
                                <h6>Total Webinar Sales</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-12 mb-4">
                        <div class="dash-widget dash1 mb-0">
                            <div class="dash-widgetimg">
                                <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5><span>{!! getAmountFormat(($webinars->sum('amount') + $streams->sum('amount'))) !!}</span></h5>
                                <h6>Total Sales</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 col-12 d-flex">
                        <div class="dash-count das2">
                            <div class="dash-counts">
                                <h4>{!! $users->where('role_id', 2)->count() !!}</h4>
                                <h5>Professional Educator</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12 d-flex">
                        <div class="dash-count das2">
                            <div class="dash-counts">
                                <h4>{!! $users->where('role_id', 3)->count() !!}</h4>
                                <h5>General Public</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-6 col-sm-6 col-12">
                        <div id="pie-chart-apex"></div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-12">
                        <div id="bar-chart-apex"></div>
                    </div>
                </div>
                <div class="row">
                    <div id="line-chart-apex"></div>
                </div> --}}
            @else
                <div class="card dash-count das2">
                    <div class="card-header">
                        <h1>Welcome {{ auth()->user()->name }}</h1>
                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart-sales.js') }}"></script>
    <script src="{{ asset('assets/js/chart-ecommerce.js') }}"></script>
    <script src="{{ asset('assets/js/chart-analytics.js') }}"></script>



    <script>
        $(document).ready(function () {
            alertify.success("Welcome {{ auth()->user()->name }} ");
        });
    </script>


    <script>
        @if(count($lastSevenDays) != 0)
        @php
            $saleAmount = [];
            $saleDate = '';
            foreach ($currentMonthRecords as $key => $currentMonthRecord){
                $saleAmount[$key] = $currentMonthRecord->total_amount;
                $saleDate .= "'". \Carbon\Carbon::parse($currentMonthRecord->date_part)->format('d M')  . "',";
            }
        @endphp



        var optionsLineChart = {
            series: [{
                name: 'Sales',
                data: [{!! implode(',', $saleAmount) !!}]
            }],
            labels: [{!! $saleDate !!}],
            chart: {
                type: 'area',
                width: "100%",
                height: 360
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: '#8b2232',
                }
            },
            tooltip: {
                fillSeriesColor: false,
                onDatasetHover: {
                    highlightDataSeries: false,
                },
                theme: 'light',
                style: {
                    fontSize: '12px',
                    fontFamily: 'Inter',
                },
            },
        };

        var lineChartEl = document.getElementById('line-chart-apex');
        if (lineChartEl) {
            var lineChart = new ApexCharts(lineChartEl, optionsLineChart);
            lineChart.render();
        }
        @endif
    </script>



    <script>
        @if(count($lastSevenDays) != 0)
        @php
            $saleAmount = [];
            $saleDate = '';
            foreach ($lastSevenDays as $key => $lastSevenDay){
                $saleAmount[$key] = $lastSevenDay->total_amount;
                $saleDate .= "'". \Carbon\Carbon::parse($lastSevenDay->date_part)->format('d M')  . "',";
            }
        @endphp

        var optionsLineChart = {
            series: [{
                name: 'Sales',
                data: [{!! implode(',', $saleAmount) !!}]
            }],

            chart: {
                type: 'bar',
                width: "100%",
                height: 360
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: '#8b2232',
                }
            },
            plotOptions: {
                bar: {
                    columnWidth: '25%',
                    borderRadius: 5,
                    radiusOnLastStackedBar: true,
                    colors: {
                        backgroundBarColors: ['#F2F4F6', '#F2F4F6', '#F2F4F6', '#F2F4F6'],
                        backgroundBarRadius: 5,
                    },
                }
            },
            labels: [1, 2, 3, 4, 5, 6, 7],
            xaxis: {
                categories: [{!! $saleDate !!}],
                crosshairs: {
                    width: 1
                },
            },
            tooltip: {
                fillSeriesColor: false,
                onDatasetHover: {
                    highlightDataSeries: false,
                },
                theme: 'light',
                style: {
                    fontSize: '12px',
                    fontFamily: 'Inter',
                },
                y: {
                    formatter: function (val) {
                        return "$ " + val
                    }
                }
            },
        };

        var barChartEl = document.getElementById('bar-chart-apex');
        if (barChartEl) {
            var barChart = new ApexCharts(barChartEl, optionsBarChart);
            barChart.render();
        }
        @endif
    </script>
    <script>
        @if(count($lastSevenDays) != 0)
        var optionsPieChart = {
            series: [{!! round($percentGraphs['Webinar Percentage'], 2) !!}, {!! round($percentGraphs['Stream Percentage'], 2) !!}],
            chart: {
                type: 'pie',
                height: 360,
            },
            theme: {
                monochrome: {
                    enabled: true,
                    color: '#8b2232',
                }
            },
            labels: ['Webinar Percentage', 'Stream Percentage'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            tooltip: {
                fillSeriesColor: false,
                onDatasetHover: {
                    highlightDataSeries: false,
                },
                theme: 'light',
                style: {
                    fontSize: '12px',
                    fontFamily: 'Inter',
                },
                y: {
                    formatter: function (val) {
                        return val + " %"
                    }
                }
            },
        };

        var pieChartEl = document.getElementById('pie-chart-apex');
        if (pieChartEl) {
            var pieChart = new ApexCharts(pieChartEl, optionsPieChart);
            pieChart.render();
        }
        @endif
    </script>
@endsection
