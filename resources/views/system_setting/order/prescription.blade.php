@extends('layouts.dashboard')

@section('content')
    <style>
        .page-btn.firt {
            position: absolute;
            float: right;
            right: 15%;
        }
    </style>
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
                                    <div class="table-responsive">
                                        <table class="table datanew">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer Name</th>
                                                <th>Customer Phone</th>
                                                <th>Image</th>
                                                <th>Order Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if( $pres )
                                                @foreach( $pres as $key => $supp )
                                                    <tr id="rowID-{{ $supp->id }}">
                                                        <td>{{ $key + 1  }}</td>
                                                        <td>{{ $supp->name }}</td>
                                                        <td>{{$supp->phone }}</td>
                                                        <td><a href="{{ $supp->prescription_image}}" target="_blank"> <img  src="{{ $supp->prescription_image}}" style="width: 10%" ></a></td>
                                                        <td>{!! ($supp->status == '0') ? '<span class="badges bg-lightred">pending</span>' : '<span class="badges bg-lightgreen">Complete</span>'!!}</td>
                                                        <td>
                                                            <a class="me-3" href="#">
                                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                                            </a>
                                                        </td>
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
                <script>
                    $(document).on('click', ".getProduct", function(e){
                        e.preventDefault();
                        $('#myModal').modal('show');
                    });
                </script>
@endsection
