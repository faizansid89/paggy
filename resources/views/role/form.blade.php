@extends('layouts.dashboard')

@section('content')

    <div class="page-wrapper cardhead">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">{{ $section->heading }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('role.index') }}">{{ $section->heading }}</a></li>
                            <li class="breadcrumb-item active">{{ $section->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">

                    <!-- main alert @s -->
                    @include('partials.alerts')
                    <!-- main alert @e -->

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $section->title }}</h5>
                        </div>
                        <div class="card-body">
                            {!! Form::model($role, ['route' => $section->route, 'class' => 'form-validate', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
                            @method($section->method)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Role Name</label>
                                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Role Name', 'required' => 'required', 'disabled' => 'disabled']) !!}
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            {!! Form::select('status', array(1 => 'Active', 0 => 'Block'), null, ['class' => 'form-control select', 'placeholder' => 'Select a option', 'required' => 'required']); !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="productdetails product-respon">
                                            <ul>
                                                @if( $permissions )
                                                @foreach( $permissions->groupby('group') as $name => $permission )
                                                <li>
                                                    <h4>{{$name}}</h4>
                                                    <div class="input-checkset">
                                                        <ul>
                                                            @foreach($permission as $per)

                                                                @if(in_array($per->name, $rolePermissions))
                                                                    @php $checkExistvalue = 'checked' @endphp
                                                                @else
                                                                @php $checkExistvalue = ''  @endphp
                                                                @endif

                                                            <li>
                                                                <label class="custom-control-label inputcheck" for="{{ $per->name }}">{{ $per->display_name }}
                                                                <input name="permissions[{{ $per->name }}]" type="checkbox" class="checkmark" id="{{ $per->name }}" value="{{ $per->name }}" {{ $checkExistvalue }} autocomplete="off"> <span class="checkmark"></span></label>
                                                            </li>


                                                            @endforeach
{{--                                                            <li>--}}
{{--                                                                <label class="inputcheck">Select All--}}
{{--                                                                    <input type="checkbox" checked> <span class="checkmark"></span> </label>--}}
{{--                                                            </li>--}}
                                                        </ul>
                                                    </div>
                                                </li>
                                                @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
