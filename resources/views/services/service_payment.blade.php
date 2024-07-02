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
                            {{ dd($appoinment->toArray()) }}
                        </div>
                        <div class="card-body">
                            {!! Form::model($service, ['route' => $section->route, 'class' => 'form-validate', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
                            @method($section->method)
                                {!! Form::text('niche', 'service', ['class' => 'mb-2 form-control']) !!}
                                {!! Form::text('amount', $appoinment->service_price, ['class' => 'mb-2 form-control webinarPrices']) !!}
                                {!! Form::text('id', $appoinment->service_id, ['class' => 'form-control webinarIds']) !!}
                                <div class="form-row row">
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label" for="validationCustom01">Card Number</label>
                                      {!! Form::text('card_number', '4111111111111111', ['class' => 'form-control card-number', "onkeypress" => "return isNumber(event)", 'max' => '16', 'min' => '16', 'required' => 'required']) !!}
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label" for="validationCustom02">Card Name</label>
                                      {!! Form::text('card_name', 'Faizan', ['class' => 'form-control', 'required' => 'required']) !!}
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label">Card Month</label>
                                      {!! Form::select('card_month', array('01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12'), null, ['class' => 'form-control select2 card-expiry-month', 'placeholder' => 'Select Month', 'required' => 'required']) !!}
                                   </div>
                                   <div class="col-md-12 mb-3">
                                      <label class="form-label">Card Year</label>
                                      {!! Form::select('card_year', array('24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35'), null, ['class' => 'form-control select2 card-expiry-year', 'placeholder' => 'Select Year', 'required' => 'required']) !!}
                                   </div>
                                   <div class="col-md-12 mb-3">
                                    <label class="form-label">Card CVV</label>
                                    {!! Form::text('card_cvv', '231', ['class' => 'form-control card-cvc', "onkeypress" => "return isNumber(event)", 'max' => '4', 'required' => 'required']) !!}
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
@section('scripts')
     <script>
       $(document).ready(function() {
            
        });
        
    </script>
   
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

@endsection