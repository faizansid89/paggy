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
                            <li class="breadcrumb-item"><a href="{{ route('livestream.index') }}">{{ $section->heading }}</a></li>
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
                            {!! Form::model($livestream, ['route' => $section->route, 'class' => 'form-validate', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
                            @method($section->method)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Stream Link</label>
                                            {!! Form::text('link', null, ['class' => 'form-control', 'placeholder' => 'Enter Name', 'required' => 'required']) !!}
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date </label>
                                            {!! Form::date ('date', null, ['class' => 'form-control', 'placeholder' => 'Date For Stream', 'required' => 'required']) !!}
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Related To</label>
                                            {!! Form::text('related', null, ['class' => 'form-control', 'placeholder' => 'Related To', 'required' => 'required']) !!}
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>General Public Price </label>
                                            {!! Form::text('g_pub_price', null, ['class' => 'form-control', 'placeholder' => 'General Public Price', 'required' => 'required', "onkeypress" => "return isNumber(event)"]) !!}
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Professional Education Price</label>
                                            {!! Form::text('pro_price', null, ['class' => 'form-control', 'placeholder' => 'Professional Education Price', 'required' => 'required', "onkeypress" => "return isNumber(event)"]) !!}
                                        </div>

                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            {!! Form::select('status', array(1 => 'Active', 0 => 'Block'), null, ['class' => 'form-control select', 'placeholder' => 'Select a option', 'required' => 'required']); !!}
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
