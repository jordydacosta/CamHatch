<div class="row">
    <div class="col-md-11">
        <br>
        <p class="checkout-form-title dark-grey">@lang('checkout.order_overview')</p>
        <br>
        @foreach($content as $row)
            <table class="table table-bordered" style="vtable-layout:fixed; ">
                <thead>
                <tr>
                    <th class="uppercase">@lang('checkout.product')</th>
                    <th class="uppercase">@lang('checkout.total')</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="semi-bold">{{ $row->name }} ({{ $row->options->color }})</td>
                    <td> <span class="product_total">{{ $row->qty }}</span></td>
                </tr>
                <tr>
                    <td class="semi-bold">@lang('checkout.subtotal')</td>
                    <td>€ <span class="product_total">{{ sprintf('%0.2f', $price ) }}</span></td>
                </tr>
                <tr style="@if(!isset($total_price_charge) && Input::old('options-payment') != 'electronic')display: none;@endif"
                    id="electronic-payment-overview">
                    <td>
                        <span id="electronic-payment-total">
                            @if(isset($total_price_charge))
                                {{ "€ ".$total_price_charge }}
                                <input type="hidden" name="total_price_charge" value="{{ $total_price_charge }}">
                            @endif
                        </span>
                    </td>

                </tr>
                <tr>
                    <td class="semi-bold">Voucher
                        @if(isset($voucher))
                            @if($voucher->minimum_order_quantity <= Cart::count())
                                @if($voucher->amount != 0)
                                    @if($voucher->expires_at > Carbon\Carbon::today()->toDateString())
                                        <span id="voucher">{{$voucher->discount_percent}}% {{trans('checkout.discount')}}</span>
                                    @elseif($voucher->expires_at < Carbon\Carbon::today()->toDateString())
                                        <span id="voucher">0%</span>
                                    @else
                                        <span id="voucher">{{$voucher->discount_percent}}% {{trans('checkout.discount')}}</span>
                                    @endif
                                @else
                                    <span id="voucher">0%</span>
                                @endif
                            @else
                                <span id="voucher">0%</span>
                            @endif
                        @elseif (isset($discount))
                            <span id="voucher">{{$discount}}% {{trans('checkout.discount')}}</span>
                        @else
                            <span id="voucher"> 0%</span>
                        @endif </td>
                    <td>
                        @if(isset($voucher))
                            @if($voucher->minimum_order_quantity <= Cart::count())
                                @if($voucher->amount != 0)
                                    @if($voucher->expires_at > Carbon\Carbon::today()->toDateString())
                                        <span id="voucher">€ -{{sprintf('%0.2f',$percent)}} </span>
                                    @elseif($voucher->expires_at < Carbon\Carbon::today()->toDateString())
                                        <span id="voucher">€ 0</span>
                                    @else
                                        <span id="voucher">€ {{sprintf('%0.2f',$percent)}} </span>
                                    @endif
                                @else
                                    <span id="voucher">€ 0</span>
                                @endif
                            @else
                                <span id="voucher">€ 0</span>
                            @endif
                        @else
                            <span id="voucher">€ 0</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="semi-bold">@lang('checkout.shipping')</td>
                    <td>

                        € <span class="shipping-cost">{{ sprintf('%0.2f', $shipping['cost']) }}</span>
                        <input type="hidden" name="shipping_cost" value="{{ $shipping['cost'] }}">
                        <input type="hidden" name="shipping_plan" value="{{ $shipping['plan'] }}">
                    </td>
                </tr>
                <tr>
                    <td class="semi-bold">@lang('checkout.total')</td>
                    <td>
                        € <span id="total-price">{{ sprintf('%0.2f', $total_price) }}</span>
                        <small>
                            {!! trans('checkout.btw', ['btw' => '<span id="btw-include">€ '.$btw_include.'</span>']) !!}
                        </small>
                    </td>
                </tr>
                </tbody>
            </table>
        @endforeach

        <br>
        <p style="text-align: right;">{{trans('checkout.algemene_voorwaarden')}}</p>
        <button type="button" class="btn btn-yellow" id="empty-cart">
            <span class="arrow arrow-back"></span>{{trans('checkout.cancel')}}
        </button>

        <button type="submit" class="btn btn-yellow uppercase ladda-button pull-right" data-style="expand-left"
                id="place-order">
            @if(isset($total_price_charge))
                @lang('checkout.proceed_to_payment')
            @else
                @lang('checkout.proceed_to_payment')
            @endif
            <span class="arrow"></span>
        </button>
    </div>
</div>
