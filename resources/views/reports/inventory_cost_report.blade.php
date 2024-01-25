@extends('layouts.dashboard')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="page-title">
                    <h4>{{ $section->heading }}</h4>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                        <li class="breadcrumb-item active">{{ $section->title }}</li>
                        <li class="breadcrumb-item active">Inventory Cost Price Report</li>
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

                            <div class="card" id='printable_div_id'>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table display" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>SKU</th>
                                                <th>Current Quantity</th>
                                                <th>QA Stock Quantity</th>
                                                <th>QA Stock Time Quantity</th>
                                                <th>Differnce Quantity</th>
                                                <th>Price Per Pcs</th>
                                                <th>Price Loss / Profit</th>
                                                <th>Current Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $totalPrice = 0;
                                                $inventoryPrice = 0;
                                            @endphp
                                            @if( $inventory )
                                                @foreach( $inventory as $inv )
                                                    <tr id="rowID-{{ $inv->id }}">
                                                        <td>
                                                            <a href="{{ route("products.show", $inv->id) }}">{{ $inv->name }}</a>
                                                        </td>
                                                        <td>{{$inv->sku}}</td>
                                                        <td>{{ ($inv->getInventory != null) ? $inv->getInventory->quantity : 0 }}</td>
                                                        <td>{{ ($inv->getInventory != null) ? $inv->getInventory->branch_quantity : 0 }}</td>
                                                        <td>{{ ($inv->getInventory != null) ? $inv->getInventory->branch_quantity_time : 0 }}</td>
                                                        <td>
                                                            @if($inv->getInventory != null)
                                                                {{ $inv->getInventory->branch_quantity -  $inv->getInventory->branch_quantity_time }}
                                                            @endif
                                                        </td>
                                                        <td>Rs. {{ ($inv->productUnitState != null) ? $inv->productUnitState->sale_price : 0 }}</td>
                                                        <td>
                                                            @if($inv->getInventory != null)
                                                                @if($inv->productUnitState == null)
                                                                    {{ dd($inv->productUnitState) }}
                                                                @endif

                                                                @php
                                                                    $diffPrice =  ($inv->getInventory->branch_quantity -  $inv->getInventory->branch_quantity_time) *  $inv->productUnitState->sale_price;
                                                                    $totalPrice += $diffPrice;
                                                                @endphp
                                                                @if($diffPrice < 0)
                                                                    <span class="text-red">Rs. {{ $diffPrice }}</span>
                                                                @else
                                                                    <span class="text-green">Rs. {{ $diffPrice }}</span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php
                                                            $quantityUnit = ($inv->getInventory != null) ? $inv->getInventory->quantity : 0;
                                                            $salePrice = ($inv->productUnitState != null) ? $inv->productUnitState->sale_price : 0;
                                                            $inventoryPrice += $salePrice * $quantityUnit;
                                                            @endphp
                                                            Rs. {{ $salePrice * $quantityUnit }}

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>


                                    <h3>Stock Time Amount : Rs. {{ number_format($totalPrice, 0, '.', ',') }}</h3>
                                    <h3>Inventory Amount : Rs. {{ number_format($inventoryPrice, 0, '.', ',') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <!-- JSZip -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <!-- DataTables Print Button JS -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <!-- PDFMake -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection
