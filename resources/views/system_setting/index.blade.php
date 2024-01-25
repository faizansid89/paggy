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

                @if((in_array('create-product', getUserPermissions())))
                    <div class="page-btn">
                        @if((in_array('create-product', getUserPermissions())))
                            <a class="btn btn-added getProduct"><img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-2" alt="img"> Add new</a>
                        @endif
                    </div>
                @endif
            </div>

            <div id="myModal" class="modal fade show ytytyt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title selectProductName">Add Product</h5>
                        </div>

                        <div class="modal-body">
                            {!! Form::model($setting, ['route' => $section->route, 'class' => 'form-validate', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
                            @method($section->method)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image</label>
                                        {!! Form::file('file', null, ['id'=>'opop','class' => 'form-control drop select2', 'placeholder' => 'Select a option', 'required' => 'required']); !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Type</label>
                                        {!! Form::select('type', array('web_logo' => 'Web logo', 'first_banner' => 'First Banner','second_banner'=>'Second Banner','favicon'=>'FavIcon'), null, ['class' => 'form-control select', 'placeholder' => 'Select a option', 'required' => 'required']); !!}
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Link</label>
                                        {!! Form::text('link',  null, ['class' => 'form-control select', 'placeholder' => 'Select a option']); !!}
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
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

            <div class="card">
                <div class="card-body">
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
                                                <th>File</th>
                                                <th>Type</th>
                                                <th>Links</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($settings as $key => $setting)
                                                    <tr>
                                                        <th>{{ $key+1}}</th>
                                                        <th><img src="{{ $setting->file }}" width="50px"> </th>
                                                        <th>{{$setting->type}}</th>
                                                        <th>{{$setting->link}}</th>
                                                        <th><a href="{{ route('system.delete',$setting->id) }}"> <img src="{{asset('assets/img/icons/delete.svg')}}" alt="deleteProduct"/></a> </th>
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
            @endsection

            @section('scripts')
                <script>
                    $(document).on('click', ".getProduct", function(e){
                        e.preventDefault();
                        $('.ytytyt').modal('show');
                    });
                </script>
                <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
                <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>


@endsection
