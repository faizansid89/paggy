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
                            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ $section->heading }}</a></li>
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
                        {!! Form::model($role, ['route' => $section->route, 'class' => 'form-validate', 'autocomplete' => 'off']) !!}
                        @method($section->method)
                            <div class="row g-gs">
                                      @php
                                         $disabled = $section->method == 'PUT' ? 'disabled' : '';
                                       @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="fv-full-name">Role Name</label>
                                        <div class="form-control-wrap">
                                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Role Name', 'required' => 'required', $disabled , ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="fv-topics">Status</label>
                                        <div class="form-control-wrap ">
                                            {!! Form::select('status', array(1 => 'Yes', 0 => 'No'), null, ['class' => 'form-control form-select', 'placeholder' => 'Select a option', 'required' => 'required', ]); !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr/>
                                    <div class="form-group">
                                        <label class="form-label" for="fv-full-name">Roles Permissions</label>
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
                                                                <label class="custom-control-label" for="{{ $per->name }}">{{ $per->display_name }}</label>
                                                                <input name="permissions[{{ $per->name }}]" type="checkbox" class="checkmark" id="{{ $per->name }}" value="{{ $per->name }}" {{ $checkExistvalue }} autocomplete="off">
                                                            </li>
                                                            
                                                           
                                                            @endforeach
                                                            <li>
                                                                <label class="inputcheck">Select All
                                                                    <input type="checkbox" checked> <span class="checkmark"></span> </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        {!! Form::button('<i class="fa fa-check-square-o"></i> Save', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
