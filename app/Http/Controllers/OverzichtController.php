<?php

namespace App\Http\Controllers;

use App\Product;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Order;
use App\Country;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Nullable;
use Illuminate\Support\Facades\Response;

class OverzichtController extends Controller
{

    public function report(){

        // fetch the new orders
        $country = Country::all();
        $start_point = null;
        $daan = null;
        $end_date = null;
        $simple= null;
        $shipping_rates = null;
        $nummers = null;
        $continents = ['nl', 'eu', 'n_eu'];
        $status = "NULL";

        $orders = Order::groupBy('country')->get();

        foreach ($orders as $o) {

            $cost = Order::where('country', $o->country)->sum('price');
            $quantity = Order::where('country', $o->country)->sum('quantity');
            $order = Order::where('country', $o->country)->count();

            if (Country::where('isocode', $o->country)->first() != null) {
                $country = Country::where('isocode', $o->country)->first();
                $shipping_rate = $country->shipment_rate;
                $shipping_rates[$o->country] = $shipping_rate;
            }
            $daan[$o->country] = $order;
            $nummers[$o->country] = $quantity;
            $simple[$o->country] = $cost;
        }

        $sales_current_month = 0;
        // get the total order of the current month
        $orders_current_month = Order::whereRaw('MONTH(created_at) = ?', [date('m')])->get();

        foreach ($orders_current_month as $order_current_month) {
            $sales_current_month += $order_current_month->price;
        }

        return view('backend.pages.orders.overview', [
            'title'               => 'Overview',
            'orders'              => $orders,
            'country'             => $country,
            'continent'          => '',
            'test'                => $simple,
            'status'              => $status,
            'earning'             => $cost,
            'cijfer'              => $daan,
            'shipping_rates'      => $shipping_rates,
            'nummer'              => $nummers,
            'startdate'           => $start_point,
            'enddate'             => $end_date,

        ]);
    }
    public function filterSystem(Request $request){

        $orders = App\Orders::get();

        return view('backend.pages.orders.overzicht')->with('Orders', '$orders');
    }
    public function filterReport(Request $request){
        $total_earnings = 0;
        $cost = 0;
        $simple= null;
        $daan = null;
        $nummers = null;
        $start_point = null;
        $end_date = null;
        $shipping_rates = null;
        $country = Country::all();

        $data = $request->validate([
            'start_point' => 'nullable',
            'end_point' =>  'nullable',
            'continents' => 'nullable',
            'status'    =>'nullable',
        ]);

        //get orders
        $data['status'] = intval($data['status']) ;
        $continent = $data['continents'];
        $status = $data['status']  ;
        $start_point = $data['start_point'];
        $end_date = $data['end_point'];

        if($continent != "NULL") {
            //There are 3 codes: nl (Dutch countries only), eu (European countries only) and n_eu (Outside EU)
            switch ($continent) {
                case 'nl':
                    $orders = Order::where('country', '=', 'nl');
                    break;
                case 'eu':
                    $orders = Order::whereIn('country', function ($q) {
                        $q->select('isocode')
                            ->from('countries')
                            ->where('continents', '=', 'eu');
                    });
                    break;
                case 'n_eu':
                    $orders = Order::whereIn('country', function ($q) {
                        $q->select('isocode')
                            ->from('countries')
                            ->where('continents', '!=', 'eu');
                    });
                    break;
            }
            $orders = $orders->groupBy('country')->get();
        } else {
            $orders = Order::groupBy('country')->get();
        }

        if($data['status'] != "NULL"){
            foreach ($orders as $o) {
                $cost = Order::where('orderstatus_id', '=' ,$data['status'])->where('country', $o->country)->sum('price');
                $quantity = Order::where('orderstatus_id', '=' ,$data['status'])->where('country', $o->country)->sum('quantity');
                $order = Order::where('orderstatus_id', '=' ,$data['status'])->where('country', $o->country)->count();

                if( Country::where('isocode', $o->country)->first() != null) {
                    $country = Country::where('isocode', $o->country)->first();
                    $shipping_rate = $country->shipment_rate;
                } else {
                    $shipping_rate = 0;
                }

                $shipping_rates[$o->country] = $shipping_rate;
                $daan[$o->country] = $order;
                $nummers[$o->country] = $quantity;
                $simple[$o->country] = $cost;
            }
        } else {
            foreach ($orders as $o) {
                $cost = Order::where('country', $o->country)->sum('price');
                $quantity = Order::where('country', $o->country)->sum('quantity');
                $order = Order::where('country', $o->country)->count();

                if (Country::where('isocode', $o->country)->first() != null) {
                    $country = Country::where('isocode', $o->country)->first();
                    $shipping_rate = $country->shipment_rate;
                } else {
                    $shipping_rate = 0;
                }
                $shipping_rates[$o->country] = $shipping_rate;
                $daan[$o->country] = $order;
                $nummers[$o->country] = $quantity;
                $simple[$o->country] = $cost;
            }
        }

        // total camhatch's sold
        return view('backend.pages.orders.overview', [
            'title'               => 'Overview',
            'orders'              => $orders,
            'country'             => $country,
            'test'                => $simple,
            'nummer'              => $nummers,
            'continent'          => $data['continents'],
            'shipping_rates'      => $shipping_rates,
            'earning'             => $cost,
            'cijfer'              => $daan,
            'status'              => $status,
            'startdate'           => $start_point,
            'enddate'             => $end_date,
            'total_earnings'      => $total_earnings,
        ]);
    }

    public function export($type)
    {
        // check the type that needs to be downloaded
        $order = Order::Where('country', $type);


            $filename = "orders_".$type.".csv";

            $data = $order->select('orderId','firstname','lastname','quantity', 'price','price_ex','price_btw' ,'country', 'shipping_continent')
                ->get()
                ->toArray();
            $c_headers = array('orderId','firstname','lastname','quantity', 'price','price_ex','BTW' ,'country', 'shipping_continent');
        // set the headers
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0'
            , 'Content-Encoding' => 'UTF-8'
            , 'Content-type' => 'text/csv; charset=UTF-8'
            , 'Content-Disposition' => 'attachment; filename=' . $filename
            , 'Expires' => '0'
            , 'Pragma' => 'public'
        ];
        // add headers for each column in the CSV download
        array_unshift($data, $c_headers);
        $callback = function () use ($data) {
            $FH = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };
        // download the file
        return Response::stream($callback, 200, $headers);
    }

    private function filtercountry($data){

        if ($data['start_point'] !=null){
            if($data['end_point'] !=null){
                if($data['status']!="NULL"){
                    $code=
                        Country::where('continents', '=',$data['continents'])->with(['order'=> function ($query) use($data){
                            $query->where('created_at', '>=', $data['start_point'])->
                            where('created_at', '<=' , $data['end_point'])->
                            where('orderstatus_id', '=' , $data['status'])->
                            groupBy('country');}])->get();
                }else{
                    $code=Country::where('continents', '=',$data['continents'])->with(['order'=> function ($query) use($data){
                        $query->where('created_at', '>=', $data['start_point'])->
                        where('created_at', '<=' , $data['end_point'])->
                        groupBy('country');}])->get();
                }

            }else{
                $code=Country::where('continents', '=',$data['continents'])->with(['order'=> function ($query) use($data){
                    $query->where('created_at', '>=', $data['start_point'])->
                    groupBy('country');}])->get();
            }
        //End_point if statements
        }elseif($data['end_point'] !=null){
            $code=
                Country::where('continents', '=',$data['continents'])->with(['order'=> function ($query) use($data){
                $query->where('created_at', '>=', $data['end_point'])->
                groupBy('country');}])->get();

            if($data['status']!="NULL") {
                $code=
                    Country::where('continents', '=',$data['continents'])->with(['order'=> function ($query) use($data){
                    $query->where('created_at', '>=', $data['end_point'])->
                    where('orderstatus_id', '=' , $data['status'])->
                    groupBy('country');}])->get();
            }
        //Status if statements
        }elseif($data['status']!="NULL"){

            $code=
                Country::where('continents', '=',$data['continents'])->with(['order'=> function ($query) use($data){
                $query->where('orderstatus_id', '=' , $data['status'])->
                groupBy('country');}])->get();
        }else{
            $code=
                Country::where('continents', '=',$data['continents'])->with(['order'=> function ($query) use($data){
                $query->groupBy('country');}])->get();
        }

        return $code;
    }

    private function filtertime($data){

        if ($data['start_point'] != null){
            $orders = Order::Where('created_at', '>=', $data['start_point'])->groupBy('country')->get();

            if ($data['end_point'] != null) {
                $orders = Order::Where('created_at', '>=', $data['start_point'])->
                where('created_at', '<=', $data['end_point'])->
                groupBy('country')->get();
            }

        }elseif($data['end_point'] != null){
            $orders = Order::Where('created_at', '<=', $data['end_point'])->groupBy('country')->get();

        } else {
            $orders = Order::groupBy('country')->get();
        }

        return $orders;
    }

    private function FilterStatus($data){
        if ($data['continents'] != 'NULL') {
            if ($data['start_point'] != null) {
                if ($data['end_point'] != null) {
                    $orders =
                        Country::where('continents', '=', $data['continents'])->with(['order' => function ($query) use ($data) {
                            $query->where('created_at', '>=', $data['start_point'])->
                            where('created_at', '<=', $data['end_point'])->
                            where('orderstatus_id', '=', $data['status'])->
                            groupBy('country');
                        }])->get();

                } else {
                    $orders =
                        Country::where('continents', '=', $data['continents'])->with(['order' => function ($query) use ($data) {
                            $query->where('created_at', '>=', $data['start_point'])->
                            where('orderstatus_id', '=', $data['status'])->
                            groupBy('country');
                        }])->get();
                }
            } elseif ($data['end_point'] != null) {
                $orders =
                    Country::where('continents', '=', $data['continents'])->with(['order' => function ($query) use ($data) {
                        $query->where('created_at', '>=', $data['end_point'])->
                        where('orderstatus_id', '=', $data['status'])->
                        groupBy('country');
                    }])->get();

            } else {
                $orders =
                Country::where('continents', '=', $data['continents'])->with(['order' => function ($query) use ($data) {
                    $query->where('orderstatus_id', '=', $data['status'])->
                    groupBy('country');
                }])->get();

            }
        } elseif ($data['start_point'] != null){

            if ($data['end_point'] != null) {
                $orders = Order::Where('created_at', '>=', $data['start_point'])->
                where('orderstatus_id', '=' , $data['status'])->
                where('created_at', '<=', $data['end_point'])->
                groupBy('country')->get();
            }else {
                $orders = Order::Where('created_at', '>=', $data['start_point'])->
                where('orderstatus_id', '=', $data['status'])->groupBy('country')->get();
            }

        } elseif ($data['end_point'] != null){
            $orders = Order::Where('created_at', '<=', $data['end_point'])->
            where('orderstatus_id', '=' , $data['status'])->
            groupBy('country')->get();

        } else {
            dump('check else else');
            $orders = Order::where('orderstatus_id' , $data['status'])->groupBy('country')->get();
        }

        return $orders;
    }

    public function getPdf($country){

        $orders = Order::Where('country', '=', $country)->groupBy('id')->get();
        $isocode = Country::where('isocode', $country)->first();

        $product = Product::where('id', 1)->first();
        $product->price_ex = $product->price / 1.21;
        $product->BTW = $product->price - $product->price_ex;
        $product->update();

        $pdf = PDF::loadView('backend.pages.orders.pdf_overview', ['order' => $orders, 'product' => $product, 'country' => $isocode]);
        return $pdf->download('Order_'.$isocode->isocode.'.pdf');
    }
}
