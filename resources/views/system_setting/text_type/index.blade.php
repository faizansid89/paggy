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

                @if((in_array('create-product', getUserPermissions())))
                    <div class="page-btn">
                        @if((in_array('create-product', getUserPermissions())))
                            <a href="{{ route('text.create') }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-2" alt="img"> Add new</a>
                        @endif
                    </div>
                @endif
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
                                                <th></th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($text as $key => $setting)
                                                    <tr>
                                                        <th>{{ $key+1}}</th>
                                                        <th><img src="{{ $setting->file }}" width="50px"> </th>
                                                        <th>{{$setting->type}}</th>
                                                        <th>{{$setting->link}}</th>
                                                        <th><a href="{{ route('system.delete',$setting->id) }}"> <img src="{{asset('assets/img/icons/delete.svg')}}" alt="deleteProduct"/></a> </th>
                                                    </tr>
                                                 @endforeach
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
                <script>
                    $(document).on('click', ".getProduct", function(e){
                        e.preventDefault();
                        $('.ytytyt').modal('show');
                    });
                </script>
                <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
                <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>


@endsection
