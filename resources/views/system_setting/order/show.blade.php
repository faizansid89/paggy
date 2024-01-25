@extends('layouts.dashboard')

@section('content')
<style>
    .page-btn.firt {
        position: absolute;
        float: right;
        right: 15%;
    }
</style>
<audio id="newRecAddSound" src="{{ asset('assets/sound/beep.mp3') }}"></audio>
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="page-title">
                <h4>{{ $section->heading }}</h4>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('orders.index') }}">{{ $section->title }}</a></li>
                </ul>
            </div>


        </div>

        <div class="card">
            <div class="card-body">


                <div class="row">
                    <div class="col-sm-12">

                        <!-- main alert @s -->
                        @include('partials.alerts')
                        <!-- main alert @e -->

                        <div class="card" id="cart_view">
                            {!! $session_items !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="barCode"></div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>


        $(document).on('click', '.delete_product', function (event) {
            event.preventDefault();
            var sku = $(this).data('sku');
            delete_product(sku);
        });

        $(document).on('click', '.btn-increase, .btn-decrease', function (event) {
            event.preventDefault();
            var sku = $(this).data('sku');
            var unit_name = $(this).data('unit_name');
            var quantity = $(this).hasClass('btn-increase') ? 1 : -1;

            $.ajax({
                type: 'POST',
                url: '{{ route('update.product') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    sku: sku,
                    unit_name: unit_name,
                    quantity: quantity
                },
                success: function (response) {
                    if (response.message == 'Inventory Storage Limit exceeded') {
                        alert(response.message);
                    }
                    document.getElementById('newRecAddSound').play();
                    $('#cart_view').html(response.cart);

                    var url = window.location.href;
                },
                error: function () {
                    // alert('An error occurred while updating the quantity');
                }
            });
        });

        // Generic Function to delete product in session
        function delete_product(sku) {
            if (sku == "all") {
                var msg = "Are you sure you want to delete all products?";
            } else {
                var msg = "Are you sure you want to delete?";
            }
            if (confirm(msg)) {
                $.ajax({
                    url: '{{ route('product.delete') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        sku: sku
                    },
                    success: function (response) {
                        document.getElementById('newRecAddSound').play();
                        location.href = response.url;
                    },
                    error: function (xhr) {
                        //alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            }
        }

        $(document).ready(function () {
            $(document).on("blur", "#given_amount", function (e) {
                var total = "{{\Cart::getTotal()}}";
                var given_amount = $(this).val();
                var return_amount = given_amount - total;
                console.log(return_amount.toFixed(2));

                if (return_amount >= 0) {
                    $("#pay_now").prop('disabled', false);
                } else {
                    $("#pay_now").prop('disabled', true);
                }

                $(".return_amount").text(return_amount.toFixed(2));
                $(".return_amount").val(return_amount.toFixed(2));
            });
        });

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        $(document).ready(function ($) {
            //$('#cash_sale').submit(function (event) {
            $(document).on('submit', '#cash_sale', function (event) {
                event.preventDefault();
                jQuery.noConflict();
                var customer_id = $("#customer_name").children("option:selected").data("customer_id");
                var customer_name = $("#customer_name").children("option:selected").val();

                var given_amount = $("#given_amount").val();
                var return_amount = $(".return_amount").val();

                var pynow = document.querySelector('#pay_now');
                pynow.disabled = true;
                pynow.textContent = 'Loading...';


                var form = $('form')[0]; // You need to use standard javascript object here
                var formData = new FormData(form);
                formData.append('customer_id', customer_id);
                formData.append('customer_name', customer_name);
                formData.append('given_amount', given_amount);
                formData.append('return_amount', return_amount);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('order.sale') }}',
                    data: formData,
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        //alert(response.message);

                        // print

                        $("#barCode").html(response.html);
                        var divToPrint = document.getElementById('barCode');
                        var popupWin = window.open('', '_blank', 'width=800,height=1200');
                        popupWin.document.open();
                        popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
                        popupWin.document.close();

                        pynow.textContent = 'Pay Now';
                        pynow.disabled = false;

                        //alert(response.html);
                        window.location.replace(response.redirect_to);
                    },
                    error: function () {
                        // alert('An error occurred while updating the quantity');
                    }
                });
            });
        });

    </script>
@endsection
