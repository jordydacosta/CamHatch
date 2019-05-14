<!DOCTYPE html>
<html xmlns:float="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
</head>
<style type="text/css">
    body {
        background-color:#FFF;
        margin-left:10%;
        margin-right:10%;
        font-family:verdana, arial, sans-serif;
        font-size:14px;
        line-height:12px;
        color:#000
    }

    table {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
    }
</style>
<body>
<div style = "display: none;"> {{ $price = $invoice->price - $country->shipment_rate }}</div>
<div class="row" style="">
    <div id="content" class="col" style="float: left; margin-left: 5px;">
        <br>
        <br>
        <br>
        <h3>Factuur</h3>
        <br>
        <br>
        <p style="line-height: 10px;">{{$order->firstname}} {{$order->lastname}}</p>
        <p style="line-height: 10px;">{{$order->zipcode}} {{$order->city}}</p>
        <p style="line-height: 10px;">{{$order->address}}</p>
        <p style="line-height: 10px;"> @if(\App::isLocale('nl'))
                            {{ $country->country_nl }}
                        @else
                            {{ $country->country_en }}
                        @endif</p>
    </div>
    <br>
    <br>
    <div class="col-mg-4" style="float: right;">
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAAGQCAYAAACAvzbMAAAgAElEQVR4Xu3dCZgkVZnu8S8ys6qyqnqp
        rm4ahEZhQIHBURhRBxBQEZVF1IsyLuio4Pi44KCjDCq4jkgzg+KozAVxVBwRR+V6da77dRkU2ssysogiCLIv3V3dtVfu93wnIqqzgqqsrJMRWZFZ
        /18+8XR1LhGRkRHnjRMn4oT30Mbn1wQAgCXKRJ8AAKAZBAgAwAkBAgBwQoAAAJwQIAAAJwQIAMAJAQIAcEKAAACcECAAACcECADACQECAHBCgAAA
        nBAgAAAnBAgAwAkBAgBwQoAAAJwQIAAAJwQIAMAJAQIAcEKAAACcECAAACcECADACQECAHBCgAAAnBAgAAAnBAgAwAkBAgBwQoAAAJwQIAAAJwQI
        AMAJAQIAcEKAAACcECAAACcECADACQECAHBCgAAAnBAgAAAnBAgAwAkBAgBwQoAAAJwQIAAAJwQIAMAJAQIAcEKAAACcECAAACcECADACQECAHBC
        gAAAnBAgAAAnBAgAwAkBAgBwQoAAAJwQIAAAJwQIAMAJAQIAcEKAAACcECAAACcECADACQECAHBCgAAAnBAgAAAnBAgAwAkBAgBwQoAAAJwQIAAA
        JwQIAMAJAQIAcEKAAACcECAAACcECADACQECAHBCgAAAnBAgAAAnBAgAwAkBAgBwQoAAAJwQIAAAJwQIAMAJAQIAcEKAAACcECAAACcECADACQEC
        AHBCgAAAnBAgAAAnBAgAwAkBAgBwQoAAAJwQIAAAJwQIAMAJAQIAcEKAAACcECAAACcECADACQECAHBCgAAAnBAgAAAnBAgAwAkBAgBwQoAAAJwQ
        IAAAJwQIAMAJAQIAcEKAAACcECAAACcECADACQECAHBCgAAAnBAgAAAnBAgAwAkBAgBwQoAAAJwQIAAAJwQIAMCJ99DG59WiTwIAsBhqIAAAJwQI
        AMAJAQIAcEKAAACcECAAACcECADACQGCzud5Zk02q3JWh6xIboFBX9P36Hv1MwBawnUg6Dxa+IdDzay+5bLUyhWRSlWk6g81fV6H4P1eJGS8MFSU
        vq3+/QCaQoAg3cKaQljAazhoWJihZoLDy/dJ9gkbJbNhnWTXD0lmzYDIqgHxenvF6+s1nzcfmymaoSAyOS2VnWNS3Toq1ce2SeWRbf44ezRMcuJp
        DSUTBFM4TQALaj1AOBTQnZa78NSagmZGsWjDwuvJ2RpEZvfdpPfQA6X36QdI7ulPluym3cTrz5uhzwRGnwkDEwQaCBk9XBWsm1WtpWjgVPzxaaBM
        F6Q2NimlO+6V8o2/k8INt5u/7xYpmOeLZRskNoA0ULRWs8yLIzXY3ruT4/beWoDYwwjRJ9EVtNBdDhocZr3Swt3+d48Nkttvb+l77jMlf/wRkj1w
        3yAgYm6+M+FS2bZTij/cItPf/6WUb7lDyg+bGkqpJN6aQbEreqUS/VTy9HCbhlhCauFhv2bobBAg3Sk8jLtErQWI2aBquu45TBgppm0GuXY3NJtp
        mWnWJqZMYV6V3sMOlt5jDpP+k4+RnsMOir7ZZw9rBX/PO6vhk/Osn/Wfm+d7Vu55UKb+4ydS+L9bpLjlVvNMVbzVgzZo2kmXhz38poGZwHbmDWjt
        LR99en5mp8IePkR30e1dd1J0522Jlh4g4cZmVqbBN58iPc84yN+oHCaOFNKah/ktJzZ/UUp33iteb08iBdccuk5VK1I1tY6+I/5SBl53oqltPEcy
        ewz7r9s95KC2O09hHyvbzuIvA/vfHeMy/Z/XyNS/fVsKv75FMqv6/deSrKHpdzTzYTZr6Tv22ZJ72lNEpmb8w2lxMrWb4pZb7PeyJxUs9Dub71sb
        n5JeUwsc/JuT/d9B3xrz7GAZ6KZl1qvir34jU//+3SVvX+4BUqnJ8FWbzQr+zLmvoytsf8nfSeEXN5o91L6FC5ZW2faFmm2PyO21u6z6+9dL/qSj
        Z4OjViqLF5522246X5Wg7UX/++iI2cC+JxMXf1Wq4+NBA71f0MdudryerLv0g5J/2THRd8Rm8pNXyujH/tX/Pgt9FxMu1W07ZNXbXiVrP/We6Kvo
        AjNX/0x2vOWjS95JaWnLtMeptfYx4zd0MnTBUCz5/5rCO9E9TLP3WysU7R7Q4KtPlA0/vlQGzniZHx46fVPrCBvOl4U2ouv0gwb4zO7DJuBOkw0/
        +lfJH/ccM+8Fv2aUcM3bLiNte9HfJThFOZZBx6ntHzreZmi7lG7npWA90fUjuu4wdN6gJ4yYf7WG6aK1tV83nujFWgzdMSyxKrskZvx6bD+7+wYZ
        +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" style="height: 80px; margin-left: 40%;">
        <div style="margin-left: 10%;">
            <p>CamHatch Netherlands B.V.</p>
            <p>Adriaen van der Doeslaan 115C</p>
            <p>3054 EB Rotterdam</p>
            <p>Nederland</p>
        <br>
            <p><b>KvK</b>: 68452462</p>
            <p><b>Btw</b>: NL857450712B01</p>
            <p><b>IBAN</b>: NL19 INGB 0007 8171 99</p>
        </div>
    </div>
</div>
<br><br><br>

<table style="margin-right: 40px; margin-top: 280px; width: 107%;">
    <thead>
    <tr>
        <th><b>Besteldatum</b></th>
        <th class="notbold">{{$order_short = substr($order->created_at, 0, -8)}}</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <td><b>Ordernummer</b></td>
        <td>{{$order->orderId}}</td>
        <td></td>
        <td></td>
    </tr>
    </thead>
    <tbody style="margin-top: 50px;">
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
    </tbody>
    <tr>
        <th><b>Factuurnummer</b></th>
        <th><b>Referentie</b></th>
        <th><b>Factuurdatum</b></th>
        <th><b>Leverdatum</b></th>
    </tr>
    <tr>
        <td>{{$invoice->invoice_id}}</td>
        <td>{{$order->reference}}</td>
        <td>{{$order_short = substr($invoice->created_at, 0, -8)}}</td>
        <td>{{$order->delivery_date}}</td>
    </tr>
</table>
<br><br>
    <div style="background-color: #E70B3F; color: white; width: 100%; height: 25px;">
            <p style="margin-left: 2px; padding-top: 7px;">Aantal</p>
            <p style="margin-left: 169px; padding-top: -26px;">Product</p>
            <p style="margin-left: 315px; padding-top: -26px;">Bedrag</p>
            <p style="margin-left: 515px; padding-top: -26px;">Subtotaal</p>
    </div>
    <div style="margin-top: -25px;">
            <p style="margin-left: 2px;">{{$order->quantity}}</p>
            <p style="margin-left: 169px; padding-top: -26px;">CamHatch (zwart)</p>
            <p style="margin-left: 315px; padding-top: -26px;">€ {{number_format((double) $product->price_ex, 2, '.', '')}}</p>
            <p style="margin-left: 515px; padding-top: -26px;">€ {{number_format((double) $product->price_ex * $order->quantity, 2, '.', '')}}</p>
    </div>

<div class="row" style="margin-top: 50px;">
    <div style="text-align: left; border-top: solid; border-top-width: 1px; border-spacing: 100px;">
            <p style="margin-left: 315px;">21% btw</p>
            <p style="margin-left: 515px; padding-top: -26px; text-align: right;"> €{{$order->price_btw}}</td>
            <p style="margin-left: 315px;">Subtotaal excl. btw</p>
            <p style="margin-left: 515px; padding-top: -26px; text-align: right;">€{{$order->price_ex}}</p>
            <p style="margin-left: 315px;">Verzendkosten</p>
            @if($order->shipping_price != 0)
                <p style="margin-left: 515px; padding-top: -26px; text-align: right;">€{{ $order->shipping_price }}</p>
            @else
                <p style="margin-left: 515px; padding-top: -26px; text-align: right;">€{{ $country->shipment_rate }}</p>
            @endif
            <p style="margin-left: 315px;">Totaal</p>
            <p style="margin-left: 515px; padding-top: -26px; text-align: right;">€{{ $invoice->price }}</p>
    </div>
    <br><br>
    <div>
    <br><br>
    <div>
        <p style="text-align: center; line-height: 16px;">
            Wij verzoeken u vriendelijk om het verschuldigde bedrag binnen 14 dagen na factuurdatum over te maken onder vermelding van het ordernummer.
            Indien u het openstaande bedrag reeds heeft betaald, kunt u deze factuur beschouwen als een kopie voor uw eigen administratie.
            Uw bestelling wordt binnen twee werk dagen na ontvangst van de betaling verzonden.<br><br>Op al onze diensten, producten, offertes en facturen zijn onze
            algemene voorwaarden van toepassing. Deze zijn kosteloos op te vragen en raadpleegbaar op www.camhatch.nl
        </p>
    </div>
</div>
</body>
</html>
