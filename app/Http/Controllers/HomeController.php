<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use App\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Review as Review;

use Cookie;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // get a random review to display on the home page
        $reviews = Review::where('visible', 1)->orderByRaw("RAND()")->first();

        return view('site.pages.index', compact('reviews'));
    }

    public function setLang($lang)
    {
        // save the langauge in a cookie
        Cookie::queue('language', $lang, 99999);

        // set the locale
        \App::setLocale($lang);

        // redirect the user back to the current page
        return redirect()->back();
    }

    public function ship(Request $request){

        $order = Order::findOrFail(7);

        // Ship order...

        \Mail::to($request->user())->send(new OrderShipped($order));

    }

}
