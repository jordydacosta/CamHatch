@extends('site.layouts.order_email')

@section('title')
    {{ Input::get('subject') }}
@stop

@section('content')

    <div style="background-color: #e20816; padding: 10px 30px;">
        <h1 style="color: #FFF; font-size: 30px;">@lang('orders.thankYouForYourOrder')</h1>
    </div>

    <div style="padding: 40px 30px;">
        <p>@lang('orders.nextSteps')</p>
        <br>
        <h2 style="color: #e20816">
            <b>@lang('orders.order') #{{ $orderId }}</b>
        </h2>
        <br>

        <table width="100%" style="border: 1px solid #7c7c7c;border-collapse: collapse;table-layout:fixed;">
            <thead>
            <tr align="left">
                <th style="border: 1px solid #7c7c7c; padding: 10px;">@lang('orders.product')</th>
                <th style="border: 1px solid #7c7c7c; padding: 10px;">@lang('orders.quantity')</th>
                <th style="border: 1px solid #7c7c7c; padding: 10px;">@lang('orders.price')</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="border: 1px solid #7c7c7c; padding: 10px;">CamHatch Black</td>
                <td style="border: 1px solid #7c7c7c; padding: 10px;">{{ $quantity }}</td>
                <td style="border: 1px solid #7c7c7c; padding: 10px;">€ {{ $quantity * config('config.ch_price') }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #7c7c7c; padding: 10px;" colspan="2">
                    @lang('orders.shipping')
                </td>
                <td style="border: 1px solid #7c7c7c; padding: 10px;" colspan="1">
                    @if($shipping_plan == config('config.shipping_plan.bpost'))
                        € {{ config('config.delivery_cost.bpost')  }}
                        <small>via Bpost</small>
                    @elseif($shipping_plan == config('config.shipping_plan.international'))
                        € {{ config('config.delivery_cost.international') }}
                        <small>via International Delivery</small>
                    @elseif($shipping_plan == config('config.shipping_plan.free'))
                        @lang('shop.shipping.types.free')
                    @endif
                </td>
            </tr>
            @if($comment)
                <tr>
                    <td style="border: 1px solid #7c7c7c; padding: 10px;" colspan="2">
                        @lang('orders.note'):
                    </td>
                    <td style="border: 1px solid #7c7c7c; padding: 10px;" colspan="1">
                        {{ $comment }}
                    </td>
                </tr>
            @endif
            <tr>
                <td style="border: 1px solid #7c7c7c; padding: 10px;" colspan="2">
                    @lang('orders.total'):
                </td>
                <td style="border: 1px solid #7c7c7c; padding: 10px;" colspan="1">
                    € {{ $price }}
                </td>
            </tr>
            </tbody>
        </table>

        <br>
        <h2 style="color: #e20816">
            <b>@lang('orders.yourDetails')</b>
        </h2>
        <br>
        <p>
            <b>@lang('orders.email'):</b> <a href="mailto:{{ $email }}?subject=Order">{{ $email }}</a>
        </p>
        <p>
            <b>@lang('orders.phoneNumber'):</b> {{ $phone }}
        </p>
        <br>

        <table id="shipping-billing-table" width="100%">
            <tbody>
            <tr align="left">
                <td align="left">
                    <h2 style="color: #e20816">
                        <b>@lang('orders.billingAddress')</b>
                    </h2>
                    <ul style="margin: 0; padding: 0;">
                        @if($company)
                            <li style="list-style-type: none; margin: 0; padding: 0;">{{ $company }}</li>
                        @endif
                        <li style="list-style-type: none; margin: 0; padding: 0;">{{ $firstname." ".$lastname }}</li>
                        <li style="list-style-type: none; margin: 0; padding: 0;">{{ $address }}</li>
                        <li style="list-style-type: none; margin: 0; padding: 0;">{{ $zipcode." ".$city }}</li>
                        <li style="list-style-type: none; margin: 0; padding: 0;">@if(\App::isLocale('nl'))
                            {{ $country->country_nl }}
                            @else
                            {{ $country->country_en }}
                            @endif</li>
                    </ul>
                </td>
                <td>
                    <h2 style="color: #e20816">
                        <b>@lang('orders.shippingAddress')</b>
                    </h2>
                    <ul style="margin: 0; padding: 0;">
                        @if($shipping_company)
                            <li style="list-style-type: none; margin: 0; padding: 0;">{{ $shipping_company }}</li>
                        @endif
                        <li style="list-style-type: none; margin: 0; padding: 0;">{{ $shipping_firstname." ".$shipping_lastname }}</li>
                        <li style="list-style-type: none; margin: 0; padding: 0;">{{ $shipping_address }}</li>
                        <li style="list-style-type: none; margin: 0; padding: 0;">{{ $shipping_zipcode." ".$shipping_city }}</li>
                        <li style="list-style-type: none; margin: 0; padding: 0;">@if(\App::isLocale('nl'))
                                {{ $country->country_nl }}
                            @else
                                {{ $country->country_en }}
                            @endif</li>
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@stop
