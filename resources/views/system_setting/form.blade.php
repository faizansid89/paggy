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
                            <li class="breadcrumb-item"><a href="{{ route('offer_product.index') }}">{{ $section->heading }}</a></li>
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
                            {!! Form::model($offer_product, ['route' => $section->route, 'class' => 'form-validate', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
                            @method($section->method)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Product Name</label>
                                            {!! Form::select('product_id',$product, null, ['class' => 'form-control select', 'placeholder' => 'Select a option', 'required' => 'required']); !!}
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type</label>
                                            {!! Form::select('type', array('featured_product' => 'Featured Product', 'deal' => 'Deal','top_selling'=>'Top Selling'), null, ['class' => 'form-control select', 'placeholder' => 'Select a option', 'required' => 'required']); !!}
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
