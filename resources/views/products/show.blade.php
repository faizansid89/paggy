@extends('layouts.dashboard')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="page-title">
                <h4>{{ $section->heading }}</h4>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ $section->title }}</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ul>
            </div>
            <div class="page-btn">
                <a href="{{ URL::previous() }}" class="btn btn-added">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="productdetails">
                            <ul class="product-bar">
                                <li>
                                    <h4>Product</h4>
                                    <h6>{{ $product->name }}</h6>
                                </li>
                                <li>
                                    <h4>Category</h4>
                                    <h6>{{ isset($product->categories) ? $product->categories->name : "" }}</h6>
                                </li>
                                <li>
                                    <h4>Sub Category</h4>
                                    <h6>{{ isset($product->subCategory) ? $product->subCategory->name : "" }}</h6>
                                </li>
                                <li>
                                    <h4>Brand</h4>
                                    <h6>{{ isset($product->brands) ? $product->brands->name : "" }}</h6>
                                </li>

                                <li>
                                    <h4>SKU</h4>
                                    <h6>{{ $product->sku }}</h6>
                                </li>
                                <li>
                                    <h4>Minimum Qty</h4>
                                    <h6>{{ $product->min_alert_qty }}</h6>
                                </li>
                                <li>
                                    <h4>Tax</h4>
                                    <h6>{{ $product->tax }}</h6>
                                </li>
                                <li>
                                    <h4>Discount Type</h4>
                                    <h6>{{ $product->discount }}</h6>
                                </li>

                                <li>
                                    <h4>Free Product</h4>
                                    <h6>{!! ($product->is_free == 0) ? '<span class="badges bg-lightred">No</span>' : '<span class="badges bg-lightgreen">Yes</span>'  !!}</h6>
                                </li>
                                <li>
                                    <h4>Product has Batch Code</h4>
                                    <h6>{!! ($product->is_batch_code == 0) ? '<span class="badges bg-lightred">No</span>' : '<span class="badges bg-lightgreen">Yes</span>' !!}</h6>
                                </li>
                                <li>
                                    <h4>Description</h4>
                                    <h6>{!! $product->description !!}</h6>
                                </li>
                                <li>
                                    <h4>Status</h4>
                                    <h6>{!! ($product->status == 0) ? '<span class="badges bg-lightred">Inactive</span>' : '<span class="badges bg-lightgreen">Active</span>'  !!}</h6>
                                </li>
                                <li>
                                    <h4>Created By</h4>
                                    <h6>{{ $product->users->name }}</h6>
                                </li>
                                <li>
                                    <h4>Create Time</h4>
                                    <h6>{{ formatDate($product->created_at) }} {{ formatTime($product->created_at) }}</h6>
                                </li>
                                <li>
                                    <h4>Last Update Time</h4>
                                    <h6>{{ formatDate($product->updated_at) }} {{ formatTime($product->updated_at) }} </h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h4 class="card-title mb-0">Product Price Structure</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Unit</th>
                                                    <th>Quantity</th>
                                                    <th>Cost Price</th>
                                                    <th>Sale Price</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($productUnitStatus as $productUnit)
                                                <tr>
                                                    <td>{{ $productUnit->units->name }}</td>
                                                    <td>{{ $productUnit->quantity }}</td>
                                                    <td>{!! getAmountFormat($productUnit->cost_price) !!}</td>
                                                    <td>{!! getAmountFormat($productUnit->sale_price) !!}</td>
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
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card d-none">
                    <div class="card-body">
                        @if($product->is_batch_code == 0)
                            @php
                                $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                            @endphp
                            <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="text-center">{!! $generator->getBarcode($product->sku, $generator::TYPE_CODE_128) !!}</td>
                                            <td rowspan="2" class="text-center">
                                                <a class="printimg">
                                                    <img src="{{ asset('assets/img/icons/printer.svg')  }}" alt="print">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ $product->sku }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="productdetails">
                            <ul class="product-bar">
                                <li>
                                    <h4><strong>Purchase Order</strong></h4>
                                    <h6><strong>Batch Code</strong></h6>
                                </li>
                                @foreach($receviedItems as $key => $receviedItem )
                                    <li>
                                        <h4><a href="{{ route("purchases.show", $receviedItem) }}">Purchase # {{ $receviedItem }}</a></h4>
                                        <h6>{!! ($product->is_batch_code == 1) ?  $key : '<span class="badges bg-lightred">Product Has No Batch Code</span>' !!}</h6>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="productdetails">
                            <ul class="product-bar">
                                <li>
                                    <h4><strong>Branch Name</strong></h4>
                                    <h6><strong>Product Quantity</strong></h6>
                                </li>
                                @foreach($inventery as $int )
                                    <li>
                                        <h4>{{ $int->branch[0]->name ? $int->branch[0]->name : "" }}</h4>
                                        <h6>{{ $int->quantity ? $int->quantity : ""  }}</h6>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        @if($product->images != null)
                        <div class="slider-product-details">
                            <div class="owl-carousel owl-theme product-slide">
                                @foreach(explode(',', $product->images) as $images)
                                <div class="slider-product">
                                    <img src="{{ $images }}" alt="{{ $product->name }}">
                                    <h4>{{ $product->name }}</h4>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                            <div class="slider-product-details">
                                <div class="owl-carousel owl-theme product-slide">
                                    <div class="slider-product">
                                        <img src="https://via.placeholder.com/1000" alt="{{ $product->name }}">
                                        <h4>{{ $product->name }}</h4>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection
