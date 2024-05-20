@extends('layouts.dashboard')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="page-title">
                <h4>{{ $section->heading }}</h4>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
                    <li class="breadcrumb-item active">{{ $section->title }}</li>
                </ul>
            </div>
            @if((in_array('create-user', getUserPermissions())))
            <div class="page-btn">
                <a href="{{ route("services_download_file.create", $id) }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-2" alt="img"> Add New {{ $section->heading }}</a>
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
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <!-- main alert @e -->

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( $services )
                                    @foreach( $services as $service )
                                        <tr id="rowID-{{ $service->id }}">
                                            <td>{{$service->id }}</td>
                                            <td>{{$service->title}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    {{-- @if((in_array('update-user', getUserPermissions()))) --}}
                                                        <a  type="button" class="btn btn-danger" href="{{ route('services_download_file.edit', ['id' => $id, 'services_download_file' => $service->id]) }}" style="color: #ffffff;">Edit</a>
                                                    {{-- @endif --}}

                                                </div>
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
