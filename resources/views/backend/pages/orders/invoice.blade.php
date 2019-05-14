<!DOCTYPE html>
<html xmlns:float="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
</head>
<style type="text/css">
    body {
        background-color:#FFF;
        margin-left:25%;
        margin-right:25%;
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

    .notbold{
        font-weight:normal
    }​
</style>
<body>
<div class="row" style="">
    <div id="content" class="col" style="float: left; margin-left: 5px;">
        <br>
        <br>
        <br>
        <h3>Factuur</h3>
        <br>
        <br>
        <p style="line-height: 12px;">{{$order->firstname}} {{$order->lastname}}</p>
        <p style="line-height: 12px;">{{$order->zipcode}} {{$order->city}}</p>
        <p style="line-height: 12px;">{{$order->address}}</p>
        <p style="line-height: 12px;"> @if(\App::isLocale('nl'))
                {{ $country->country_nl }}
            @else
                {{ $country->country_en }}
            @endif</p>

    </div>
    <br>
    <br>
    <div class="col-mg-4" style="float: right; margin-right: 5px;">
        <img src="/img/logopdf.png" style="height: 80px; margin-left: 60%;">
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
<br><br><br>
<table style="margin-left: 0px; margin-top: 280px; width: 100%;">
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
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td><br></td>
    </tr>
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
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>
    <tr><td><br></td></tr>


    <tbody style="background-color: #E70B3F;  border-style: solid; border-width: 5px; border-color: #E70B3F; color: white;">
    <tr style="line-height: 16px;">
        <th>Aantal</th>
        <th>Product</th>
        <th style="padding-left: 1%">Bedrag</th>
        <th style="padding-left: 7%">Subtotaal</th>
    </tr>
    </tbody>
    <tr style="line-height: 16px;">
        <td>{{$order->quantity}}</td>
        <td>CamHatch (zwart)</td>
        <td style="padding-left: 1%">€ {{number_format((double) $product->price_ex, 2, '.', '')}}</td>
        <td style="padding-left: 7%;">€ {{number_format((double) $product->price_ex * $order->quantity, 2, '.', '')}}</td>
    </tr>
</table>
<div class="row" style="margin-top: 50px;">
    <table style="text-align: right; border-top: solid; border-top-width: 1px; border-spacing: 100px;">
        <thead>
        <tr style="line-height: 16px;">
            <td style="padding-right: 5%;">21% btw</td>
            <td style="padding-right: 2%;"> €{{$order->price_btw}}</td>
        </tr>
        <tr style="line-height: 16px;">
            <td style="padding-right: 5%;">Subtotaal excl. btw</td>
            <td style="padding-right: 2%;">€{{$order->price_ex}}</td>
        </tr>
        <tr style="line-height: 16px;">
            <td style="padding-right: 5%;">Verzendkosten</td>
            @if($order->shipping_price != 0)
                <td style="padding-right: 2%;">€{{ $order->shipping_price }}</td>
            @else
                <td style="padding-right: 2%;">€{{ $country->shipment_rate }}</td>
            @endif
        </tr>
        <tr style="border: 1px solid black; line-height: 16px;">
            <td style="padding-right: 5%;">Totaal</td>
            <td style="padding-right: 2%;">€{{$order->price}}</td>
        </tr>
        </thead>
    </table>
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
