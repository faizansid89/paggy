@extends('layouts.dashboard')

@section('content')
<style>
.page-btn.firt {
    position: absolute;
    float: right;
    right: 15%;
}
</style>
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
            <div class="page-btn firt">
                @if((in_array('create-product', getUserPermissions())))
                    <a class="btn btn-added getProduct" ><img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-2" alt="img"> Upload {{ $section->heading }}</a>
                @endif
            </div>
            @if((in_array('create-product', getUserPermissions())))
            <div class="page-btn">
                @if((in_array('create-product', getUserPermissions())))
                    <a href="{{ route('products.create') }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-2" alt="img"> Add New {{ $section->heading }}</a>
                @endif
            </div>
            @endif
        </div>
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title selectProductName">Add Product</h5>
                    </div>
                    <!-- Form with validation -->
                    <h6><a href="/public/uploads/productss.csv">Products csv Download</a></h6>

                <div class="modal-body">

                {!! Form::model($products, ['route' => $section->route, 'class' => 'form-validate', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
                    @method($section->method)



                    <div class="row">
                        <div class="col-lg-12 float-md-right">
                            <div class="total-order">
                                <ul>
                                    <li>
                                        <h4>Product File Upload	</h4>
                                        <h5>{!! Form::file('file', null, ['class' => 'form-control selectedItemDiscount', 'placeholder' => 'Enter Discount Amount']) !!}</h5>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                            <div class="d-flex align-items-center formLoading" style="display: none !important; width: 100%;"><br/>
                                <strong style="margin-right: 15px;">Processing...</strong>
                                <div class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
{{--                        <div class="search-path">--}}
{{--                            <a class="btn btn-filter" id="filter_search">--}}
{{--                                <img src="{{ asset('assets/img/icons/filter.svg') }}" alt="img">--}}
{{--                                <span><img src="{{ asset('assets/img/icons/closes.svg') }}" alt="img"></span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img"></a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel" id="exportSelected"><img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a>
                            </li>
                        </ul>
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
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>SKU</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Discount</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( $products )
                                    @foreach( $products as $product )
                                        <tr id="rowID-{{ $product->id }}">
                                            <td><input type="checkbox" name="product[]" value="{{ $product->id }}"></td>
                                            <td>{{ $product->id }}</td>
                                            <td class="productimgname">
                                                <a href="{{ route("products.show", $product->id) }}">{{$product->name}}</a>
                                            </td>
                                            <td>{{$product->sku}}</td>
                                            <td>{{ isset($product->categories->name) ? $product->categories->name : 0  }}</td>
                                            <td>{{ isset($product->brands->name) ? $product->brands->name : 0 }}</td>
                                            <td>{{ $product->discount  }}</td>
                                            <td>{{$product->users->name}}</td>
                                            <td>
                                                <a class="me-3" href="{{ route("products.show", $product->id) }}">
                                                    <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="img">
                                                </a>
                                                @if((in_array('update-product', getUserPermissions())))
                                                <a class="me-3" href="{{ route("products.edit", $product->id) }}">
                                                    <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                                </a>
                                                @endif
{{--                                                <a class="confirm-text" href="javascript:void(0);">--}}
{{--                                                    <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="img">--}}
{{--                                                </a>--}}
                                            </td>
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
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
         $(document).on('click', ".getProduct", function(e){
                e.preventDefault();
                $('#myModal').modal('show');
            });
    </script>
            <script>
                $(document).ready(function() {
                    // Select/Deselect checkboxes
                    $('#checkAll').click(function() {
                        $('.checkbox').prop('checked', this.checked);
                    });

                    // Export selected rows
                    $('#exportSelected').click(function() {
                        var selectedRows = $('input[name="product[]"]:checked').map(function() {
                            return $(this).val();
                        }).get();

                        if (selectedRows.length > 0) {
                            // create a hidden form element to send the selected rows to the server
                            var form = document.createElement('form');
                            form.method = 'GET';
                            form.action = '{{ route("export.selected") }}';

                            // create a hidden input field to hold the selected rows
                            var input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'rows';
                            input.value = selectedRows.join(',');
                            form.appendChild(input);

                            // append the form to the body and submit it
                            document.body.appendChild(form);
                            form.submit();
                            document.body.removeChild(form);
                        } else {
                            alert('Please select at least one row.');
                        }
                    });
                });
            </script>
@endsection
