<!DOCTYPE html>
<html xmlns:float="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
    </head>
    <style type="text/css">
        body {
            background-color:#FFF;
            font-family:verdana, arial, sans-serif;
            font-size:14px;
            line-height:12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: left;
        }

        td,th
        {
            padding: 8px;
        }

        th
        {
            background-color: #cc3333;
            color: white;
        }

        tr:nth-child(even) {background-color: #f2f2f2;}

    </style>
    <body>
    <table style="width: 100%;">
        <tr>
            <th><b>Order ID</b></th>
            <th>Status</th>
            <th>Country</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Shipping rate</th>
            <th>BTW</th>
            <th>Ex. BTW</th>
        </tr>
        @foreach($order as $o)
            <tr>
                <td>{{$o->orderId}}</td>

                @if($o->orderstatus_id == 1)
                    <td>new</td>
                @elseif($o->orderstatus_id == 2)
                    <td>"pending_payment"</td>
                @elseif($o->orderstatus_id == 3)
                    <td>"processing"</td>
                @elseif($o->orderstatus_id == 4)
                    <td>"in progress"</td>
                @elseif($o->orderstatus_id == 5)
                    <td>"on hold"</td>
                @elseif($o->orderstatus_id == 6)
                    <td>"cancelled"</td>
                @elseif($o->orderstatus_id == 7)
                    <td>"completed"</td>
                @endif
                <td>{{$country->country_en}}</td>
                <td>{{$product->name_en}}</td>
                <td align="right">{{$o->quantity}}</td>
                <td align="right"{{$o->price}}</td>
                <td align="right"{{$country->shipment_rate}}</td>
                <td align="right"{{$o->price_btw}}</td>
                <td align="right"{{$o->price_ex}}</td>
            </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$order->sum('quantity')}}</td>
            <td>{{$order->sum('price') }}</td>
            <td>{{$country->shipment_rate * $order->sum('quantity')}}</td>
            <td>{{$order->sum('price_btw')}}</td>
            <td>{{$order->sum('price_ex')}}</td>
        </tr>
    </table>
    </body>
</html>
