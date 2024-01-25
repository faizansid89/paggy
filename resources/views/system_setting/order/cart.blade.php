<div class="card-body pt-0 pb-0">
    <div class="totalitem">
        <h4>Total items : {{count($session_items) ?? ""}}</h4>
        @if($session_items)
            <a href="javascript:void(0);" class="delete_product" data-sku="all">Clear
                all </a>
        @endif
    </div>
    <div class="product-table">
        @if($session_items)
            @foreach($session_items as $item)
                @php
                    $sale_id = null;
                    $sale_id = (isset($item['attributes']['sale_id'])) ? $item['attributes']['sale_id'] : null;
                @endphp
                <ul class="product-lists p-0">
                    <li style="max-width: 300px; min-width: 300px;">
                        <div class="productimg">
                            <div class="productcontet">
                                <h4>{{$item['name']}} </h4>
                                <div class="productlinkset"
                                     style="margin: -5px 0px 5px 0px;">
                                    <h5>{{$item['id']}}</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li style="max-width: 150px; min-width: 150px;">
                        @if( isset($item['attributes']['discount']) && $item['attributes']['discount'] == 0 )
                            {{ (isset($item['attributes']['discount'])) ? $item['attributes']['discount'] : "" }} %
                            Discount Applied
                        @else
                            {{ (isset($item['attributes']['discount'])) ? $item['attributes']['discount'] : "" }}
                            % Discount Applied
                        @endif
                    </li>
                    <li>
                        <div class="increment-decrement">
                            <div class="input-groups">
                                <input type="button" value="-"
                                       data-sku="{{$item['id']}}"
                                       data-unit_name="{{$item['attributes']['unit_name'] ?? ""}}"
                                       class="button-minus dec button btn-decrease">
                                <input type="text" name="child"
                                       value="{{$item['quantity']}}"
                                       class="quantity-field">
                                <input type="button" value="+"
                                       data-sku="{{$item['id']}}"
                                       data-unit_name="{{$item['attributes']['unit_name'] ?? ""}}"
                                       class="button-plus inc button btn-increase">
                            </div>
                        </div>
                    </li>
                    <li>GST RATE {{$item['attributes']['tax'] ?? ""}}%</li>
                    <li style="text-transform: capitalize; ">{{$item['attributes']['unit_name'] ?? ""}}</li>
                    <li>{!! getAmountFormat($item['price']) !!}</li>
                    <li>{!! (isset($item['attributes']['total_item_price'])) ? getAmountFormat($item['attributes']['total_item_price']) : "" !!}</li>
                    <li>
                        @php
                            $skuI = $item['id'];
                            if (strpos($skuI, '@') !== false) {
                                $parts = explode('@', $skuI);
                                $sku = $parts[0];
                            } else {
                                 $sku = $item['id'];
                            }
                        @endphp
                        <a class="getProductBySearch" data-sku="{{$sku}}"
                           href="javascript:void(0);">
                            <img src="{{ asset('assets/img/icons/edit.svg') }}"
                                 alt="img"></a> &nbsp; &nbsp;
                        <a class="delete_product" data-sku="{{$item['id']}}"
                           href="javascript:void(0);">
                            <img src="{{ asset('assets/img/icons/delete-2.svg') }}"
                                 alt="img"></a>
                    </li>
                </ul>
            @endforeach
        @endif
    </div>
</div>

<div class="card-body pt-0 pb-2">
    <div class="setvalue">
        <ul>
            <li>
                <h5>Subtotal</h5>
                <h6>{!! getAmountFormat(\Cart::getSubTotal()) !!}</h6></li>
            <li>
                <h5>Tax </h5>
                <h6>{!! getAmountFormat(0) !!}</h6></li>
            <li class="total-value">
                <h5>Total </h5>
                <h6>{!! getAmountFormat(\Cart::getTotal()) !!}</h6></li>
        </ul>
    </div>
    <div class="setvaluecash mb-0" style="text-align: right;">
        <a href="#" data-bs-toggle="modal"
           data-bs-target="#cashModal" class="btn btn-success text-white">
            Place Order </a>
    </div>
</div>


<div class="modal fade" id="cashModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cash Order</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" id="cash_sale">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="total-order" style="max-width: 100%;">
                                <ul>
                                    <li>
                                        <h4>Total</h4>
                                        <h5>{!! getAmountFormat(\Cart::getTotal()) !!}</h5>
                                    </li>
                                    <li>
                                        <h4>Given Amount</h4>
                                        <h5>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">Rs. </span>
                                                <input type="text" class="form-control font-weight-bold"
                                                       name="given_amount" onkeypress="return isNumber(event)"
                                                       id="given_amount" required>
                                            </div>
                                        </h5>
                                    </li>
                                    <li class="total">
                                        <h4>Return Amount</h4>
                                        <input type="hidden" class="return_amount" name="return_amount">
                                        <h5 class="return_amount"></h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-submit me-2" id="pay_now">Place Order</button>
                        <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
