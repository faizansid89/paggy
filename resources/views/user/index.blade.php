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
            @if((in_array('create-user', getUserPermissions())))
            <div class="page-btn">
                <a href="{{ route('user.create') }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-2" alt="img"> Add New {{ $section->heading }}</a>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role Name</th>
                                  
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( $user )
                                    @foreach( $user as $users )
                                        @if($users->id != 1)
                                        <tr id="rowID-{{ $users->id }}">
                                            <td>{{$users->id }}</td>
                                            <td>{{$users->name}}</td>
                                            <td>{{$users->email }}</td>
                                            <td>{{$users->phone}}</td>
                                            <td>{{$users->role->name ?? ""}}</td>
                                            <td>{!!($users->status == 0) ? '<span class="badges bg-lightred">Inactive</span>' : '<span class="badges bg-lightgreen">Active</span>'!!}</td>
                                            <td>
                                                @if((in_array('update-user', getUserPermissions())))
                                                <a class="me-3" href="{{ route("user.edit", $users->id) }}">
                                                    <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                                </a>
                                                @endif

                                                @if(auth()->user()->role_id == 0)
                                                    @canImpersonate($guard = null)
                                                        <a href="{{ route('impersonate', $users->id) }}">
                                                            <span class="badges bg-lightgreen"><img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img"></span>
                                                        </a>
                                                    @endCanImpersonate
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
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
