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
                <a href="{{ route('livestream.create') }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-2" alt="img"> Add New {{ $section->heading }}</a>
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
                                    <th>Stream Link</th>
                                    <th>Date</th>
                                    @if((in_array('general-user', getUserPermissions())))
                                    <th>General Price</th>
                                    @endif
                                    @if((in_array('professional-user', getUserPermissions())))
                                    <th>Professional Price</th>
                                    @endif
                                    <th>Related To</th>
                                    @if((in_array('update-livestream', getUserPermissions())))
                                        <th>Status</th>
                                        <th>Action</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @if( isset($livestream) )
                                        @foreach( $livestream as $live )

                                            <tr>
                                                <td>{{$live->id }}</td>
                                                <td>
                                                    @php
                                                        if(in_array('general-user', getUserPermissions())){
                                                            $amount = $live->g_pub_price;
                                                        }
                                                        else {
                                                            $amount = $live->pro_price;
                                                        }
                                                    @endphp

                                                    @if((in_array('purchase-livestream', getUserPermissions())))
                                                        @if(checkStreamPurchase($live->id) < 1)
                                                            <button type="button" class="btn btn-primary buyNowBtn" data-bs-toggle="modal" data-bs-target="#myModal"  data-id="{{ $live->id }}" data-name="{{ $live->related }}" data-price="{{ $amount }}" >Buy Now - {{ env('CURRENCY_SAMBOL')}}{!! $amount !!}</button>
                                                        @else
                                                            <a href="{{$live->link}}" target="_blank" class="btn btn-success" style="color: #ffffff;"><i class="fa fa-link"></i> Stream Link</a>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{$live->date }}</td>
                                                @if((in_array('general-user', getUserPermissions())))
                                                <td>${{ $live->g_pub_price  }}</td>
                                                @endif
                                                @if((in_array('professional-user', getUserPermissions())))
                                                    <td>{{ env('CURRENCY_SAMBOL')}}{{ $live->pro_price  }}</td>
                                                @endif
                                                <td>{{$live->related }}</td>

                                                @if((in_array('update-livestream', getUserPermissions())))
                                                <td>{!!($live->status == 0) ? '<span class="badges bg-lightred">Inactive</span>' : '<span class="badges bg-lightgreen">Active</span>'!!}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        @if((in_array('update-livestream', getUserPermissions())))
                                                            <a  type="button" class="btn btn-danger" href="{{ route("livestream.edit", $live->id) }}" style="color: #ffffff;">Edit</a>
                                                        @endif
                                                    </div>
                                                </td>
                                                @endif
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


<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title selectProductName">Purchase <span class="webinarName">asdsad</span> Webinar</h5>
            </div>
        {!! Form::model($livestream, ['route' => 'livestream.buy', 'class' => 'form-validate require-validation', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off', 'data-cc-on-file' => 'false', 'data-stripe-publishable-key' => env('STRIPE_SECRET_KEY')]) !!}
        @method('POST')
        <!-- Form with validation -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 float-md-right">
                        <div class="total-order mt-0">
                            <h5 class="card-title">Webinar Detail</h5>
                            <ul>
                                <li>
                                    <h4>Live Stream Name</h4>
                                    <h5 class="webinarName"></h5>
                                </li>
                                <li>
                                    <h4>Live Stream Price</h4>
                                    <h5 class="webinarPrice"></h5>
                                </li>
                                {!! Form::hidden('niche', 'livestream', ['class' => 'mb-2 form-control']) !!}
                                {!! Form::hidden('amount', null, ['class' => 'mb-2 form-control webinarPrices']) !!}
                                {!! Form::hidden('id', null, ['class' => 'form-control webinarIds']) !!}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 float-md-right">
                        <div class="total-order mt-0">
                            <h5 class="card-title">Card Detail</h5>
                            <ul>
                                <li>
                                    <h4>Card Number</h4>
                                    <h5>{!! Form::text('card_number', '4111111111111111', ['class' => 'form-control card-number', "onkeypress" => "return isNumber(event)", 'max' => '16', 'min' => '16', 'required' => 'required']) !!}</h5>
                                </li>
                                <li>
                                    <h4>Card Name</h4>
                                    <h5>{!! Form::text('card_name', 'Faizan', ['class' => 'form-control', 'required' => 'required']) !!}</h5>
                                </li>
                                <li>
                                    <h4>Card Month</h4>
                                    <h5>{!! Form::select('card_month', array('01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12'), null, ['class' => 'form-control select2 card-expiry-month', 'placeholder' => 'Select Month', 'required' => 'required']); !!}</h5>
                                </li>
                                <li>
                                    <h4>Card Year</h4>
                                    <h5>{!! Form::select('card_year', array('23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31', '32' => '32', '33' => '33', '34' => '34', '35' => '35'), null, ['class' => 'form-control select2 card-expiry-year', 'placeholder' => 'Select Year', 'required' => 'required']); !!}</h5>
                                </li>
                                <li>
                                    <h4>Card CVV</h4>
                                    <h5>{!! Form::text('card_cvv', '231', ['class' => 'form-control card-cvc', "onkeypress" => "return isNumber(event)", 'max' => '4', 'required' => 'required']) !!}</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="submitModal">Submit</button>
                    <button type="button" class="btn btn-secondary waves-effect" id="closeModal" data-bs-dismiss="modal">Close</button>
                    <div class="d-flex align-items-center formLoading" style="display: none !important; width: 100%;"><br/>
                        <strong style="margin-right: 15px;">Processing...</strong>
                        <div class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        $(function() {
            /*------------------------------------------
            --------------------------------------------
            Stripe Payment Code
            --------------------------------------------
            --------------------------------------------*/
            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                console.log('1');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });
                console.log('2');

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }
                console.log('3');

            });

            /*------------------------------------------
            --------------------------------------------
            Stripe Response Handler
            --------------------------------------------
            --------------------------------------------*/
            function stripeResponseHandler(status, response) {
                console.log('4');
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
                    var token = response['id'];

                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }

        });


        $(document).on('click', ".buyNowBtn", function (e) {
            e.preventDefault();

            var price = $(this).data("price");
            var id = $(this).data("id");
            var name = $(this).data("name");
            var type = $(this).data("type");

            $('.webinarPrice').text(price);
            $('.webinarPrices').val(price);
            $('.webinarName').text(name);
            $('.webinarTypes').val(type);
            $('.webinarId').text(id);
            $('.webinarIds').val(id);
        });
    </script>
@endsection
