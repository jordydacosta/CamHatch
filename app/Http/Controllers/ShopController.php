<?php

namespace App\Http\Controllers;

use function foo\func;
use Illuminate\Http\Request AS Httprequest;
use App\Molliepayment;
use App\Http\Requests\SubmitShopRequest;
use App\Http\Requests\SendOrderRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Product;
use Illuminate\Support\Carbon;
use Mollie\Laravel\Facades\Mollie;

use App\Order;
use App\Review;
use App\Voucher;
use App\Country;

use Cart, Config, URL, Session, Redirect, Input, Response, View, DB;
use phpDocumentor\Reflection\Types\Null_;

class ShopController extends Controller
{
    private $_api_context;
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // check if the URL has a token, if so, this means that the user cancelled the payment and we redirect him to the shop
        if (Input::get('token')) {
            Cart::destroy();
            Session::forget('orderId');
            return \Redirect::to(Config::get('app.locale') . '/shop');
        }

        // fetch the total reviews
        $reviews = Review::where('visible', 1)->orderBy('id', 'desc')->take(4)->get();

        // fetch 4 reviews
        $reviews_count = Review::where('visible', 1)->get();
        $average_review = 0;

        if (count($reviews_count) > 0) {
            // get the sum of all reviews together
            foreach ($reviews_count as $review) {
                $average_review += $review->rating;
            }

            // calculate the avarage ratings
            $avarage_review = round($average_review / count($reviews_count));
            return view('site.pages.shop', compact('avarage_review', 'reviews_count'))->nest('reviews', 'site.partials.reviews', compact('reviews'));

        }
        return view('site.pages.shop', compact('reviews_count'))->nest('reviews', 'site.partials.reviews', compact('reviews'));
    }

    public function getInstallation()
    {
        return view('site.pages.installation');
    }

    public function postReview()
    {
        $review = new Review;

        $review->name = Input::get('name');
        $review->rating = Input::get('review_rating');
        $review->description = Input::get('review');
        $review->description_en = Input::get('review');

        if (\Config::get('app.debug')) {
            $review->visible = 1;
        }

        if ($review->save()) {
            return redirect()->back()->with('success', true);
        } else {
            return redirect()->back()->with('success', false);
        }
    }

    /**
     * Display the write review page
     * @return [type] [description]
     */
    public function writeReview()
    {
        return view('site.pages.write_review');
    }

    /**
     * Load more reviews
     * @param  [type] $last_id [description]
     * @return [type]          [description]
     */
    public function loadReviews()
    {
        // fetch the total reviews
        $reviews = Review::where('visible', 1)->get();

        return [
            'view' => View::make('site.partials.reviews', compact('reviews'))->render(),
        ];
    }

    public function emptyCart()
    {
        Cart::destroy();
        return Redirect::to(Config::get('app.locale') . '/shop');
    }

    /**
     * Update the cart with the new quantity
     * @param  SubmitShopRequest $request [description]
     * @return [type]                     [description]
     */
    public function updateCart(SubmitShopRequest $request)
    {
        // first we empty the current cart
        Cart::destroy();

        // add item to the cart
        Cart::add('293ad', 'CamHatch', Input::get('quantity'), config('config.ch_price'), ['color' => trans('shop.black')]);

        return Response::json([
            'success'     => 1,
            'qty'         => Cart::count(),
            'total_price' => sprintf('%0.2f', Cart::total())
        ]);
    }

    /**
     * Calculate the new price
     * @return [type] [description]
     */
    public function calculatePrice(Httprequest $request)
    {
        // check if we want to update the cart
        //price moet komma gestal zij voor berekening/ afronden
        if (null !== Input::get('quantity')) {
            // validate the quanity
            $validator = \Validator::make(
                ['country' => Input::get('country')],
                ['quantity' => Input::get('quantity')],
                ['quantity' => 'required|numeric|min:1']
            );
            if ($validator->fails()) {
                return $validator->errors();
            }
            // first we empty the current cart
            Cart::destroy();
            // add item to the cart
            Cart::add('293ad', 'CamHatch', Input::get('quantity'), config('config.ch_price'), ['color' => trans('shop.black')]);
        }

        // Cart details
        $content = Cart::content();

        $percent = 0;
        $product = Product::where('name_en', 'CamHatch')->first();
        $shipping = $this->calculateDelivery(Input::get('country'));
        $price_ex = $product->price_ex * Cart::count();

        $price = $price_ex * 1.21;
        $total_price = $price + $shipping['cost'];

        $btw_include = number_format((double) $price - $price_ex, 2, '.', '');
        $btw_shipping = number_format((float)($shipping['cost'] / 121) * 21, 2, '.', '');
        $btw_include = $btw_include + $btw_shipping;

        $country = Country::where('isocode', '=' ,Input::get('country'))->first();
        $voucher = Voucher::where('vouchercode', '=' ,(Input::get('voucher')))->first();
        number_format($price ,2,'.' , '');

	if ($country && $country->continents != 'eu'){
	    $btw_include = 0.00;
 	    number_format($btw_include , 2, '.', ',');
	}
        if ($voucher != null){
            if($voucher->amount > 0) {
                $request->session()->put('voucher_code', $voucher->vouchercode);
                if ($voucher->minimum_order_quantity <= Cart::count()) {
                    if ($voucher->expires_at >= Carbon::today()->toDateString()) {

                        $total_price = $total_price - $shipping['cost'];

                        $percent = $voucher->discount_percent;
                        $percent = $percent / 100;
                        $percent = $percent * $total_price;

                        $total_price = $total_price - $percent;
                        $total_price = $total_price + $shipping['cost'];
                        $total_price = number_format($total_price, 2, '.', ',');

                        return [
                            'view'        => View::make('site.partials.order_overview', compact('content', 'shipping', 'percent', 'total_price', 'btw_include','voucher','price'))->render(),
                            'success'     => 1,
                            'qty'         => Cart::count(),
                            'total_price' => number_format($price, 2, '.', ',')
                        ];
                    }
                }
            }
            return [
                'view'        => View::make('site.partials.order_overview', compact('content', 'shipping', 'total_price',  'percent', 'btw_include','Voucher','price'))->render(),
                'success'     => 1,
                'qty'         => Cart::count(),
                'total_price' => number_format($price, 2, '.', ',')
            ];
        }
        else{
            return [
                'view'        => View::make('site.partials.order_overview', compact('content', 'shipping', 'total_price', 'btw_include','price'))->render(),
                'success'     => 1,
                'qty'         => Cart::count(),
                'total_price' => number_format($price, 2, '.', ',')
            ];
        }
    }

    /**
     * Calculate the new delivery price
     *
     * @param $country
     * @return array
     */
    public function calculateDelivery($country)
    {
        $shipment = Country::where('isocode','=',$country )->first();
        // calculate shipping cost
        if ($shipment != null) {
            {
                if ($shipment->isocode == 'nl') {
                    return $shipping = [
                        'type' => trans('shop.shipping.types.free'),
                        'cost' => $shipment->shipment_rate,
                        'plan' => config('config.shipping_plan.free')
                    ];
                } elseif ($shipment->isocode == 'be') {
                    return $shipping = [
                        'type' => trans('shop.shipping.types.bPost'),
                        'cost' => $shipment->shipment_rate,
                        'plan' => config('config.shipping_plan.bpost')
                    ];
                } else {
                    return $shipping = [
                        'type' => trans('shop.shipping.types.international'),
                        'cost' => $shipment->shipment_rate,
                        'plan' => config('config.shipping_plan.international')
                    ];
                }
            }
        }else{
            return $shipping = [
                'type' => trans('shop.shipping.types.bPost'),
                'cost' => 7.25,
                'plan' => config('config.shipping_plan.bpost')
            ];
        }
    }

    /**
     * Add items to the cart and redirect the user to the checkout page
     * @param  SubmitShopRequest $request [description]
     * @return [type]                     [description]
     */
    public function postShop(SubmitShopRequest $request)
    {
        // add item to the cart
        Cart::add('293ad', 'CamHatch', \Input::get('quantity'), config('config.ch_price'), ['color' => trans('shop.black')]);
        // redirect user to the checkout page
        return \Redirect::to(\Request::segment(1) . '/checkout');
    }
    /**
     * Return the checkout page
     * @return [type] [description]
     */
    public function getCheckout(Httprequest $request)
    {
        $content = Cart::content();
        $location = \GeoIP::getLocation(\Request::getClientIp());
        $country = Country::where('isocode', $location['isoCode'])->first();
        $product = Product::where('name_en', 'CamHatch')->first();
        $price = Cart::count() * $product->price;
        $discount_perc = 0;
        $discount = 0;

        // calculate shipping cost
        if ($country != null) {
            if($country->isocode == 'nl'){
                $shipping = [
                    'type' => trans('shop.shipping.types.free'),
                    'cost' => $country->shipment_rate,
                    'plan' => config('config.shipping_plan.free')
                ];
            }elseif($country->isocode == 'be'){
                $shipping = [
                    'type' => trans('shop.shipping.types.bPost'),
                    'cost' => $country->shipment_rate,
                    'plan' => config('config.shipping_plan.bpost')
                ];
            }else{
                $shipping = [
                    'type' => trans('shop.shipping.types.international'),
                    'cost' => $country->shipment_rate,
                    'plan' => config('config.shipping_plan.international')
                ];
	    }
        } else {
 	        $btw_include = 0.00;
            $shipping = [
                'type' => trans('shop.shipping.types.bPost'),
                'cost' => 7.25,
                'plan' => config('config.shipping_plan.bpost')
            ];
        }
        $v = $request->session()->get('voucher_code');
        $hasVoucher = false;
        $vouchercode = '';
        if (!empty($v)) {
            $vouchercode = $v;
            $voucher = Voucher::where('vouchercode', '=', $v)->first();
            if ($voucher != null) {
                $hasVoucher = true;
                if ($voucher->minimum_order_quantity <= Cart::count()) {
                    if ($voucher->amount > 0) {
                        if ($voucher->expires_at >= Carbon::today()->toDateString()) {
                            $discount = $price - ($price / 100 * $voucher->discount_percent);
                            $discount_perc = $voucher->discount_percent;
                        }
                    }
                }
            }
        }

        // calculate total price
        $total_price = Cart::count() * $product->price + $shipping['cost'];
        $btw_include = number_format((float)($price / 121) * 21, 2, '.', '');
        $btw_shipping = number_format((float)($shipping['cost'] / 121) * 21, 2, '.', '');
        $btw_include = $btw_include + $btw_shipping;
        $country = Country::all();

        $total_price = $total_price - $shipping['cost'];
        $percent = 0;
        if (!empty($voucher)) {
            $percent = $voucher->discount_percent;
            $percent = $percent / 100;
            $percent = $percent * $total_price;
        }

        $total_price = $total_price - $percent;
        $total_price = $total_price + $shipping['cost'];
        $total_price = number_format($total_price, 2, '.', ',');

    if(!$hasVoucher){
        return view('site.pages.checkout',
            compact('content', 'location', 'total_price','price','country', 'discount', 'vouchercode'))
            ->nest('order_overview', 'site.partials.order_overview',
                compact('content', 'shipping', 'total_price','price', 'btw_include',  'discount', 'percent'));
    }
        return view('site.pages.checkout',
            compact('content', 'location', 'total_price','price','country','voucher', 'discount', 'vouchercode'))
            ->nest('order_overview', 'site.partials.order_overview',
                compact('content', 'shipping', 'total_price','price', 'btw_include',  'discount', 'percent', 'voucher'));
    }

    /**
     * Finish the order and redirect user to the correct page
     * @return [type] [description] SendOrderRequest $request !! DONT FORGET TO ADD THE VALIDATION LATER !!
     */
    public function placeOrder(SendOrderRequest $request)
    {

        $shipping_cost = Input::get('shipping_cost');
        $shipping_plan = Input::get('shipping_plan');
        // get cart details
        foreach (Cart::content() as $content) {
            $item_qty = $content->qty;
        }
        // create new order
        $order = new Order;

        /**
         * Zoek naar vouch die gelijk aan input is
         * false niks
         * true krijg vouch
         * vouch->id in Order->id
         */
        $product = Product::where('name_en', 'CamHatch')->first();
        $voucher = Voucher::where('vouchercode',(Input::get('voucher')))->first();
        $total_price = Cart::count() * $product->price + $shipping_cost;
        if ($voucher != null){
            if ($voucher->minimum_order_quantity <= Cart::count()) {
                if ($voucher->amount > 0) {
                    if ($voucher->expires_at >= Carbon::today()->toDateString()) {
                        $order->voucher_id = $voucher->id;
                        $percent = $voucher->discount_percent;
                        $total_price = $total_price - $shipping_cost;
                        $percent = $percent / 100;
                        $percent = $percent * $total_price;
                        $total_price = $total_price - $percent;
                        $total_price = $total_price + $shipping_cost;
                    }
                }
            }
        }
        $total_price = number_format($total_price, 2, '.', ',');
        // check if the order is being paid via VISA or Bank transfer
        // we set different type of price and orderstatus according to the payment type
        $order->price = number_format($total_price, 2, '.', ',');
        $order->orderstatus_id = config('config.order_status.pending_payment');

        // Billing address
        $order->firstname = Input::get('firstname');
        $order->lastname = Input::get('lastname');
        $order->email = Input::get('email');
        $order->phone = Input::get('phone');
        $order->customer_ip = \Request::getClientIp();
        $order->company = (Input::get('company') ? Input::get('company') : null);
        $order->address = Input::get('address');
        $order->zipcode = Input::get('zipcode');
        $order->city = Input::get('city');
        $order->country = Input::get('country');


        if (Input::get('same-billing-addres') == 'on'){
            $order->same_as_billing_address = 1;
        }elseif(Input::get('same-billing-addres') == null){
            $order->same_as_billing_address = 0;
        }
        else{
            $order->same_as_billing_address = Input::get('same-billing-addres');
        }
        // Shipping address
        $order->shipping_firstname = !Input::get('same-billing-addres') ? Input::get('shipping_firstname') : Input::get('firstname');
        $order->shipping_lastname = !Input::get('same-billing-addres') ? Input::get('shipping_lastname') : Input::get('lastname');
        $order->shipping_company = !Input::get('same-billing-addres') ? (Input::get('shipping_company') ? Input::get('shipping_company') : null) : (Input::get('company') ? Input::get('company') : null);
        $order->shipping_address = !Input::get('same-billing-addres') ? Input::get('shipping_address') : Input::get('address');
        $order->shipping_zipcode = !Input::get('same-billing-addres') ? Input::get('shipping_zipcode') : Input::get('zipcode');
        $order->shipping_city = !Input::get('same-billing-addres') ? Input::get('shipping_city') : Input::get('city');
        $order->shipping_country = !Input::get('same-billing-addres') ? Input::get('shipping_country') : Input::get('country');

        $order->quantity = $item_qty;
        $order->comment = Input::get('comment');
        $order->shipping_plan = $shipping_plan;

        if ($order->save()) {
            // check the payment method
            $molliepayment = New Molliepayment();
            $molliepayment->payment_code = uniqid().uniqid().uniqid().uniqid();
            $molliepayment->status = 'NEW';

            $payment = Mollie::api()->payments()->create([
                'amount' => [
                    'currency' => 'EUR',
                    'value' => "$total_price",
                ],
                "description" => "CamHatch",
                "redirectUrl" => route('order_received', $molliepayment->payment_code),
            ]);

            $molliepayment->payment_id = $payment->id;
            $molliepayment->order_id = $order->id;
            $molliepayment->is_paid = false;
            $molliepayment->save();

            if($molliepayment->saveOrFail() == true){
                return redirect($payment->getCheckoutUrl(), 303);
            }else{
                echo "We could not redirect you to the payment provider";
            };
        }
    }

    /*
     * Send the an email to the customer
     * @param {Object} $order
     */
    private function sendMail($order)
    {
        $order->country = Country::where('isocode', $order->country)->first();
        if( $order == null ){
            $order = Country::where('country', $order->country )->first();
            dd($order);
        }

        $data = [
            'quantity'                => $order->quantity,
            'shipping_plan'           => $order->shipping_plan,
            'price'                   => $order->price,
            'email'                   => $order->email,
            'phone'                   => $order->phone,
            'same_as_billing_address' => $order->same_as_billing_address,
            'company'                 => $order->company,
            'firstname'               => $order->firstname,
            'lastname'                => $order->lastname,
            'address'                 => $order->address,
            'zipcode'                 => $order->zipcode,
            'city'                    => $order->city,
            'country'                 => $order->country,
            'shipping_company'        => $order->shipping_company,
            'shipping_firstname'      => $order->shipping_firstname,
            'shipping_lastname'       => $order->shipping_lastname,
            'shipping_address'        => $order->shipping_address,
            'shipping_zipcode'        => $order->shipping_zipcode,
            'shipping_city'           => $order->shipping_city,
            'shipping_country'        => $order->shipping_country,
            'orderId'                 => $order->orderId,
            'comment'                 => $order->comment,
            'voucher'                 => $order->voucher_id,
        ];

        \Mail::send('site.emails.order_received', $data, function ($message) use ($data, $order) {
            // if the app is in debug mode, send the email to the web designer
            if (\Config::get('app.debug')) {
                $message->to($order->email);
                $message->bcc('smail@pegus-apps.com');
            } else {
                $message->to($order->email);
                $message->bcc([
                    'info@camhatch.nl',
                    'wendy.seys@pegusapps.com',
                    'smail@pegus-apps.com'
                ]);
            }

            $message->subject(trans('orders.emailSubject') . $order->orderId);
        });

    }

    /**
     * Handles the actions after the order has been received successfully
     * @param null $orderId
     * @return View
     */
    public function orderReceived($code)
    {
        $molliepayment = Molliepayment::where('payment_code', '=', $code)->firstOrFail();
        // check if the cart contains data, if not redirect the user to the shop page, this is a security measurement
        // get the order
        $order = Order::where('id', $molliepayment->order_id)->first();
        $voucher = Voucher::where('id', $order->voucher_id)->first();
        $payment = Mollie::api()->payments()->get($molliepayment->payment_id);
        //status??
        if ($payment->status == "paid") { // payment made
            $order->orderstatus_id = config('config.order_status.processing');
            // save the order with the new status

            if ($voucher != null) {
                if ($voucher->amount > 0) {
                    $voucher->amount = $voucher->amount - 1;
                    $voucher->update();
                }
            }

            $country = Country::where('isocode', $order->country)->first();

            if ($country == null) {
                $country = Country::where(function($query) use ($order){
                    $query->where('country_en','=',$order->country)
                          ->orWhere('country_nl','=',$order->country);
                })->get()->first();

                if ($voucher && $voucher->amount > 0) {
                    $voucher->amount = $voucher->amount - 1;
                    $voucher->update();
                }
            }

            $voucher = Voucher::where('id', $order->voucher_id)->first();
            $order->save();

            // send mail
            $this->sendMail($order);
            return view('site.pages.order_received', compact('order', 'country', 'voucher'));

        } elseif ($payment->status == "expired") {
            return Redirect::route('checkout')->with(['order' => $order, 'voucher' => $voucher]);
            //Redirect::back()->withInput(Input::all());
        } elseif ($payment->status == "cancelled") {
            return Redirect::route('checkout')->with(['order' => $order, 'voucher' => $voucher]);
        }

        $content = Cart::content();
        $location = \GeoIP::getLocation(\Request::getClientIp());
        $country = Country::where('isocode', $order->country)->first();
        $product = Product::where('name_en', 'CamHatch')->first();
        if ($order->voucher_id != null) {
            $voucher = Voucher::where('id', $order->voucher_id)->first();
        } else {
            $voucher = null;
        }

        // calculate total price
        $price = $order->price;

        if ($country != null) {
            if ($country->isocode == 'nl') {
                $shipping = [
                    'type' => trans('shop.shipping.types.free'),
                    'cost' => $country->shipment_rate,
                    'plan' => config('config.shipping_plan.free')
                ];
            } elseif ($country->isocode == 'be') {
                $shipping = [
                    'type' => trans('shop.shipping.types.bPost'),
                    'cost' => $country->shipment_rate,
                    'plan' => config('config.shipping_plan.bpost')
                ];
            } else {
                $shipping = [
                    'type' => trans('shop.shipping.types.international'),
                    'cost' => $country->shipment_rate,
                    'plan' => config('config.shipping_plan.international')
                ];
            }
        } else {
            $btw_include = 0.00;
            $shipping = [
                'type' => trans('shop.shipping.types.bPost'),
                'cost' => 7.25,
                'plan' => config('config.shipping_plan.bpost')
            ];
        }



        $total_price = $price - $country->shipping_rate;
        $btw_include = number_format((float)($price / 121) * 21, 2, '.', '');
        $btw_shipping = number_format((float)($shipping['cost'] / 121) * 21, 2, '.', '');
        $btw_include = $btw_include + $btw_shipping;
        $price = $price - $country->shipment_rate;
        $country = Country::all();


        if($voucher != null){

            $price = $order->quantity * $product->price;
            $percent = $voucher->discount_percent;
            $percent = $percent / 100;
            $percent = $percent * $price;

            return view('site.pages.checkout', compact('content', 'location', 'total_price', 'price', 'country', 'order', 'voucher'))->
            nest('order_overview', 'site.partials.order_overview',  compact('content', 'shipping', 'percent', 'total_price', 'btw_include', 'voucher', 'price'));

        }else{

            return view('site.pages.checkout', compact('content', 'location', 'total_price', 'price', 'country', 'order', 'voucher'))->
            nest('order_overview', 'site.partials.order_overview', compact('content', 'shipping', 'total_price', 'price', 'btw_include'));
        }

    }
}
