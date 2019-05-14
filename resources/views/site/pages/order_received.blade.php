@extends('site.layouts.default')

@section('title')
    @lang('orders.placedOrder')
@stop

@section('content')
    <div class="container">
        <div class="row order-received">
            <div class="col-md-12">
                <h1>
                    @lang('orders.thankYou')
                </h1>
                <br>

                <p class="order-placed dark-grey">
                    @lang('orders.placedOrder')
                </p>

                <br>
                <table class="table table-striped table-bordered">
                    <tbody>
                    <tr>
                        <td>@lang('orders.orderNr'): <label>{{ $order->orderId }}</label></td>
                    </tr>
                    <tr>
                        <td>@lang('orders.date'): <label>{{ date("F d, Y", strtotime($order->created_at)) }}</label>
                        </td>
                    </tr>
                    <tr>
                        <td>@lang('orders.voucher_id'): <label>
                                @if($voucher != null)
                                {{ $voucher->vouchercode }}
                            @endif
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>@lang('orders.total'): <label>€ {{ $order->price }}</label></td>
                    </tr>
                    </tbody>
                </table>
                <br>
                <p class="order-placed dark-grey">
                    @lang('orders.orderDetails')
                </p>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="col-md-6">@lang('orders.product')</th>
                        <th class="col-md-6">@lang('orders.total')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><label>CamHatch Black x {{ $order->quantity }}</label></td>
                        <td>€ {{ $order->quantity * config('config.ch_price') }}</td>
                    </tr>
                    <tr>
                        <td><label>@lang('orders.shipping')</label></td>
                        <td>
                            € {{$country->shipment_rate}}
                        </td>
                    </tr>
                    <tr>
                        <td><label>@lang('orders.total')</label></td>
                        <td>€ {{ $order->price }}</td>
                    </tr>
                    <tr>
                        <td><label>@lang('orders.note')</label></td>
                        <td>{{ $order->comment }}</td>
                    </tr>
                    </tbody>
                </table>
                <br>
                <p class="order-placed dark-grey">
                    @lang('orders.customerDetails')
                </p>

                <table class="table table-striped table-bordered">
                    <tbody>
                    <tr>
                        <td class="col-md-6"><label>@lang('orders.email')</label></td>
                        <td class="col-md-6">{{ $order->email }}</td>
                    </tr>
                    <tr>
                        <td class="col-md-6"><label>@lang('orders.phoneNumber')</label></td>
                        <td class="col-md-6">{{ $order->phone }}</td>
                    </tr>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-6">
                        @lang('orders.billingAddress')
                        <ul class="billing-shipping-address">
                            @if($order->company)
                                <li>{{ $order->company }}</li>
                            @endif
                            <li>{{ $order->firstname." ".$order->lastname }}</li>
                            <li>{{ $order->address }}</li>
                            <li>{{ $order->zipcode." ".$order->city }}</li>
                                @if(\App::isLocale('nl'))
                                    <li>{{ $country->country_nl }}</li>
                                @else
                                    <li>{{ $country->country_en }}</li>
                                @endif
                        </ul>
                    </div>

                    <div class="col-md-6">
                        @lang('orders.shippingAddress')
                        <ul class="billing-shipping-address">
                            @if($order->shipping_company)
                                <li>{{ $order->shipping_company }}</li>
                            @endif
                            <li>{{ $order->shipping_firstname." ".$order->shipping_lastname }}</li>
                            <li>{{ $order->shipping_address }}</li>
                            <li>{{ $order->shipping_zipcode." ".$order->shipping_city }}</li>
                                @if(\App::isLocale('nl'))
                                    <li>{{ $country->country_nl }}</li>
                                @else
                                    <li>{{ $country->country_en }}</li>
                                @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
