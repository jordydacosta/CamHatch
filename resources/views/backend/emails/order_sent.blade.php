@extends('site.layouts.order_email')

@section('title')
    {{ Input::get('subject') }}
@stop

@section('content')

    <div style="background-color: #e20816; padding: 10px 30px;">
        <h1 style="color: #FFF; font-size: 30px;">Your order has been shipped!</h1>
    </div>

    <div style="padding: 40px 30px;">
        <p>Hi {{ $firstname.' '.$lastname }}!</p>
        <br>
        <p>Thank you for your order with ordernumber <b>#{{ $orderId }}</b>.</p>
        <br>
        <p>Your order has been sent by mail on {{ date('d-m-Y') }}. You will receive a letter within 4 workdays.</p>
        <br>
        <p>If you didn’t receive the letter by that time, please contact us on <a
                    href="mailto:info@camhatch.com?subject=Contact" "info@camhatch.com">info@camhatch.com</a></p>
        <br>
        <p>We hope you enjoy the CamHatch.</p>
        <br>

        <p>
            Kind regards,
            <br>
            CamHatch team
        </p>
    </div>
@stop
