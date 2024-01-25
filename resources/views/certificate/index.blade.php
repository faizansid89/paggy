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
            @if((in_array('create-livestream', getUserPermissions())))
            <div class="page-btn">
                <a href="{{ route('webinar.certificate.store') }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-2" alt="img"> Add New {{ $section->heading }}</a>
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
                                    @if((in_array('generalPrice-webinar', getUserPermissions())))
                                    <th>General Price</th>
                                    @endif
                                    @if((in_array('proPrice-webinar', getUserPermissions())))
                                    <th>Professional Price</th>
                                    @endif
                                    <th>Related To</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( isset($certificates) )
                                    @foreach( $certificates as $certificate )

                                        <tr>
                                            <td>{{$live->id }}</td>
                                            @if((in_array('generalPrice-webinar', getUserPermissions())))
                                             <td>${{ $live->g_pub_price  }}</td>
                                            @endif
                                            @if((in_array('proPrice-webinar', getUserPermissions())))
                                                <td>${{ $live->pro_price  }}</td>
                                            @endif
                                            <td>{{$live->related }}</td>

                                            <td>{!!($live->status == 0) ? '<span class="badges bg-lightred">Inactive</span>' : '<span class="badges bg-lightgreen">Active</span>'!!}</td>
                                            <td>
                                                @if((in_array('edit-webinar', getUserPermissions())))
                                                <a class="me-3" href="{{ route("webinar.edit", $live->id) }}">
                                                    <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                                </a>
                                                @endif
                                                    @if((in_array('buy-webinar', getUserPermissions())))
                                                        <a class="btn btn-primary" href="{{ route("webinar.buy", $live->id) }}" >
                                                            Buy
                                                        </a>
                                                    @endif


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
@endsection
