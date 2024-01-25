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
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ $section->heading }}</a></li>
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
                </div>
            </div>

            {!! Form::model($products, ['route' => $section->route, 'class' => 'form-validate', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
            @method($section->method)

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $section->title }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        @if($section->method == 'PUT' && auth()->user()->role_id != 0)
                                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Product Name', 'disabled' => 'disabled']) !!}
                                        @else
                                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Product Name', 'required' => 'required']) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>SKU</label>
                                        @if($section->method == 'PUT' && auth()->user()->role_id != 0)
                                            {!! Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Enter SKU', 'disabled' => 'disabled']) !!}
                                        @else
                                            {!! Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Enter SKU', 'required' => 'required']) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Brand</label>
                                        @if($section->method == 'PUT' && auth()->user()->role_id != 0)
                                            {!! Form::select('brand_id', $brands,null, ['class' => 'form-control form-select select2', 'placeholder' => 'Select Brand', 'disabled' => 'disabled']); !!}
                                        @else
                                            {!! Form::select('brand_id', $brands,null, ['class' => 'form-control form-select select2', 'placeholder' => 'Select Brand']); !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Category</label>
                                        @if($section->method == 'PUT' && auth()->user()->role_id != 0)
                                            {!! Form::select('category_id', $categories,null, ['class' => 'form-control form-select select2', 'placeholder' => 'Select Category', 'disabled' => 'disabled']); !!}
                                        @else
                                            {!! Form::select('category_id', $categories,null, ['class' => 'form-control form-select select2', 'placeholder' => 'Select Category', 'required' => 'required']); !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Sub Category</label>
                                        @if($section->method == 'PUT' && auth()->user()->role_id != 0)
                                            {!! Form::select('sub_category_id', $subCategories, null, ['class' => 'form-control form-select select2', 'placeholder' => 'Select Sub Category', 'disabled' => 'disabled']); !!}
                                        @else
                                            {!! Form::select('sub_category_id', $subCategories, null, ['class' => 'form-control form-select select2', 'placeholder' => 'Select Sub Category']); !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Minimum Qty</label>
                                        @if($section->method == 'PUT' && auth()->user()->role_id != 0)
                                            {!! Form::text('min_alert_qty', null, ['class' => 'form-control', 'placeholder' => 'Enter Minimum Qty', 'disabled' => 'disabled']) !!}
                                        @else
                                            {!! Form::text('min_alert_qty', null, ['class' => 'form-control', 'placeholder' => 'Enter Minimum Qty']) !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Tax</label>
                                        @if($section->method == 'PUT' && auth()->user()->role_id != 0)
                                            {!! Form::text('tax', null, ['class' => 'form-control', 'placeholder' => 'Enter Tax', 'disabled' => 'disabled']) !!}
                                        @else
                                            {!! Form::text('tax', null, ['class' => 'form-control', 'placeholder' => 'Enter Tax']) !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Discount Type</label>
                                        {!! Form::text('discount', null, ['class' => 'form-control', 'placeholder' => 'Enter Discount']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Free Product</label>
                                        @if($section->method == 'PUT' && auth()->user()->role_id != 0)
                                            {!! Form::select('is_free', array(1 => 'Yes', 0 => 'No'), null, ['class' => 'form-control select', 'placeholder' => 'Select a option', 'disabled' => 'disabled']); !!}
                                        @else
                                            {!! Form::select('is_free', array(1 => 'Yes', 0 => 'No'), null, ['class' => 'form-control select', 'placeholder' => 'Select a option']); !!}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Batch Code Product</label>
                                        @if($section->method == 'PUT' && auth()->user()->role_id != 0)
                                            {!! Form::select('is_batch_code', array(1 => 'Yes', 0 => 'No'), null, ['class' => 'form-control select', 'placeholder' => 'Select a option', 'disabled' => 'disabled']); !!}
                                        @else
                                            {!! Form::select('is_batch_code', array(1 => 'Yes', 0 => 'No'), null, ['class' => 'form-control select', 'placeholder' => 'Select a option']); !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label> Status</label>
                                        {!! Form::select('status', array(1 => 'Active', 0 => 'Block'), null, ['class' => 'form-control select', 'placeholder' => 'Select a option', 'required' => 'required']); !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            @if($section->method == 'PUT' && auth()->user()->role_id != 0)
                                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'disabled' => 'disabled']) !!}
                                            @else
                                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description']) !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div> <!-- 8 Div Close -->

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Product Image</label>
                                    <div class="image-upload">
                                        <div class="dropzone" data-test="images" id="dropzone"></div>
                                        <input type="hidden" name="images" id="images"/>
                                    </div>
                                </div>
                            </div>
                            @if($section->method == 'PUT' && $products->images != null)
                                <div class="col-12">
                                    <div class="product-list">
                                        <ul class="row">
                                            @foreach(explode(',', $products->images) as $images)
                                                <li>
                                                    <div class="productviews">
                                                        <div class="productviewsimg">
                                                            <img src="{{ $images }}" alt="img" class="img-fluid" style="max-width: 100px; height: 100px;">
                                                        </div>
                                                        <div class="productviewscontent">
                                                            <input type="hidden" name="images_old[]" value="{{ $images }}">
                                                            <a href="javascript:void(0);" class="hideset">x</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <button type="reset" class="btn btn-cancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div> <!-- 4 Div Close -->


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Product Unit Settings</h5>
                                <a class="btn btn-primary" style="float: right;margin-top: -27px;" id="AddMoreUnits">Add More</a>
                            </div>
                            <div class="card-body" id="addUnitRow">
                                @if($section->method == 'PUT')
                                    @foreach($productUnitStatus as $productUnit)
                                        <div class="row" id="unitRow">
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Unit</label>
                                                    {!! Form::select('unit['.$productUnit->id.'][unit_id]', $units,$productUnit->unit_id, ['class' => 'form-control form-select select2', 'placeholder' => 'Select Unit', 'required' => 'required']); !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Qty</label>
                                                    {!! Form::text('unit['.$productUnit->id.'][quantity]', $productUnit->quantity, ['class' => 'form-control', 'placeholder' => 'Enter Unit Qty', 'required' => 'required']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Cost Price</label>
                                                    {!! Form::text('unit['.$productUnit->id.'][cost_price]', $productUnit->cost_price, ['class' => 'form-control', 'placeholder' => 'Enter Cost Price', 'required' => 'required']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Sale Price</label>
                                                    <div class="row">
                                                        <div class="col-lg-10 col-sm-10 col-10">
                                                            {!! Form::text('unit['.$productUnit->id.'][sale_price]', $productUnit->sale_price, ['class' => 'form-control', 'placeholder' => 'Enter Sale Price', 'required' => 'required']) !!}
                                                        </div>
                                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                            <div class="add-icon">
                                                                <a href="javascript:void(0);" class="btnRemoveUnit"><img src="{{ asset('assets/img/icons/delete1.svg') }}" alt="img"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row" id="unitRow">
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Unit</label>
                                                {!! Form::select('unit[0][unit_id]', $units,null, ['class' => 'form-control form-select select2', 'placeholder' => 'Select Unit', 'required' => 'required']); !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                {!! Form::text('unit[0][quantity]', null, ['class' => 'form-control', 'placeholder' => 'Enter Unit Qty', 'required' => 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Cost Price</label>
                                                {!! Form::text('unit[0][cost_price]', null, ['class' => 'form-control', 'placeholder' => 'Enter Cost Price', 'required' => 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Sale Price</label>
                                                <div class="row">
                                                    <div class="col-lg-10 col-sm-10 col-10">
                                                        {!! Form::text('unit[0][sale_price]', null, ['class' => 'form-control', 'placeholder' => 'Enter Sale Price', 'required' => 'required']) !!}
                                                    </div>
                                                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                        <div class="add-icon">
                                                            <a href="javascript:void(0);" class="btnRemoveUnit"><img src="{{ asset('assets/img/icons/delete1.svg') }}" alt="img"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

{{--            {!! Form::text('randomNumber', rand(101,999), ['class' => 'form-control', 'id' => 'setRandomNumber']) !!}--}}
        </div>
    </div>

@endsection


@section('scripts')
    <script>

        $(document).ready(function(){

            $(document).on('click', "#AddMoreUnits", function(e){
                e.preventDefault();
                var query = 5;
                $.ajax({
                    url:"{{ route('products.generateRandomNumber') }}",
                    type:"GET",
                    data:{'randomNumber':query},
                    success:function (data) {
                        $('#addUnitRow').append(data);
                    }
                })
            });



            $("body").on("click", ".btnRemoveUnit", function () {
                $(this).closest("#unitRow").remove();
            });



            function randomFunction() {
                var number = Math.floor((Math.random() * 100000) + 1);
                console.log(number);
                return number;
            }
        });
    </script>
@endsection
