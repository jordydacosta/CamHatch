<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/* /////////////////////////////////////////////////////////////////////// LANGUAGES */
$langs_arr = Config::get('app.languages');
$url_lang = Request::segment(1);
$cookie_lang = Cookie::get('language');
$browser_lang = substr(Request::server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

// url:
if(!empty($url_lang) && in_array($url_lang, $langs_arr)){
	App::setLocale($url_lang);
// cookie:
}else if(!empty($cookie_lang) && in_array($cookie_lang, $langs_arr)){
	App::setLocale($cookie_lang);
// browser language:
}else if(!empty($browser_lang) && in_array($browser_lang, $langs_arr)){
	App::setLocale($browser_lang);
// default:
}else{
	App::setLocale(Config::get('app.locale'));
}
$locale = Config::get('app.locale');

// REDIRECT to default lang (eg. /nl):
Route::get('/', function(){
	return Redirect::to(Config::get('app.locale'));
});

// SET LANGUAGE URL:
Route::get('/setlang/{lang}/{routename}', function($lang, $routename){
	Cookie::queue('language', $lang, 99999);
	App::setLocale($lang);

	if($routename == "home"){
		$routename = "/";
	}

	return Redirect::to($lang.'/'.$routename);
});

# Empty cart
Route::get('/empty', ['as' => 'empty_cart', 'uses' => 'ShopController@emptyCart']);

# Website
Route::group(['prefix' => $locale], function () {

	# Home page
	Route::get('/', 		                        ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('emails/contactform', 		        ['as' => 'home_ship', 'uses' => 'HomeController@ship']);

	# Shop page
	Route::get(trans('general.shop'),			['as' => 'shop', 'uses' => 'ShopController@index']);
	Route::get('/checkout', 	 					['as' => 'checkout', 'uses' => 'ShopController@getCheckout']);
	Route::get('/checkout/order-received/{code}', 	['as' => 'order_received', 'uses' => 'ShopController@orderReceived']);
	Route::post('/update-cart', 					['as' => 'update_cart', 'uses' => 'ShopController@updateCart']);
	Route::get('/calculate-price', 					['as' => 'calculate_price', 'uses' => 'ShopController@calculatePrice']);
    Route::get('/calculate-voucher', 		        ['as' => 'calculate_voucher', 'uses' => 'ShopController@calculateVoucher']);
	Route::post('/submitShop', 						['as' => 'submit_shop', 'uses' => 'ShopController@postShop']);
	Route::post('/place-order', 					['as' => 'place_order', 'uses' => 'ShopController@placeOrder']);
	Route::get('/write-review', 		 			['as' => 'write_review', 'uses' => 'ShopController@writeReview']);
	Route::get('/load-reviews', 		 			['as' => 'load_reviews', 'uses' => 'ShopController@loadReviews']);
	Route::post('/submitReview', 					['as' => 'submit_review', 'uses' => 'ShopController@postReview']);
	Route::get('/installation', 		 			['as' => 'installation', 'uses' => 'ShopController@getInstallation']);

	if(\Config::get('app.debug')){

	    Route::get('/thanks', function(){
			$order = App\Order::find(2);
			return view('site.pages.order_received', compact('order'));
		});

		Route::get('/email', function(){
			$order = App\Order::find(2);

			$data = [
				'quantity' 			=> $order->quantity,
				'shipping_plan'		=> $order->shipping_plan,
				'price'				=> $order->price,
				'email'				=> $order->email,
				'phone'				=> $order->phone,
				'same_as_billing_address' => $order->same_as_billing_address,
				'company'			=> $order->company,
				'firstname'			=> $order->firstname,
				'lastname'			=> $order->lastname,
				'address'			=> $order->address,
				'zipcode'			=> $order->zipcode,
				'city'				=> $order->city,
				'shipping_company'  => $order->shipping_company,
				'shipping_firstname' => $order->shipping_firstname,
				'shipping_lastname'  => $order->shipping_lastname,
				'shipping_address'   => $order->shipping_address,
				'shipping_zipcode'   => $order->shipping_zipcode,
				'shipping_city'		 => $order->shipping_city,
                'voucher'            => $order->voucher_id
			];

	        \Mail::send('site.emails.order_received', $data, function($message) use($data){

	            $message->to('smail@pegus-apps.com');

	            // if the app is in debug mode, send the email to the webdesigner
	            if(\Config::get('app.debug')){
	                $message->to('smail@pegus-apps.com');
	            }else{
	                $message->to('info@camhatch.com');
	                $message->bcc('smail@pegus-apps.com');
	            }

	            $message->subject('Your order receipt for order 8623');
	        });
		});
	}

	# FAQ page
	Route::get('/faq/{type?}', 		['as' => 'faq', 'uses' => 'FaqController@index']);

	# Contact page
	Route::get(trans('general.contact'), 		['as' => 'contact', 'uses' => 'ContactController@index']);
	Route::post('/contactForm', ['as' => 'submit_contact_form', 'uses' => 'ContactController@postForm']);
	Route::get('/contact/thanks', function(){	return View::make('site.pages.contact_mailsent'); });

	# Sitemap
	Route::get('sitemap.xml', 'PagesController@index');

});


# Backend
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function(){

	# Dashboard
	Route::get('/', function(){
		return redirect()->route('dashboard');
	});

	# Dashboard
	Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'AdminDashboardController@index']);

	# Orders
	Route::get('orders',                    ['as' => 'orders', 'uses' => 'OrderController@index']);
	Route::get('order/editor',              ['as' => 'order.editor', 'uses' => 'OrderController@editor']);
	Route::get('orders/{id}/change',        ['as' => 'order_change', 'uses' => 'OrderController@change']);
	Route::get('orders/data/{status?}',     ['as' => 'orders_data', 'uses' => 'OrderController@getData']);
	Route::get('orders/status',             ['as' => 'order_status_count', 'uses' => 'OrderController@getOrderStatusCounts']);
	Route::get('orders/order/{id}',         ['as' => 'orders_show', 'uses' => 'OrderController@show']);
    Route::get('orders/{id}/ship',          ['as' => 'orders_ship', 'uses' => 'OrderController@ship']);
	Route::get('orders/export/{type}',      ['as' => 'orders_export', 'uses' => 'OrderController@export']);
    Route::post('orders/{id}/update',       ['as' => 'order.update', 'uses' => 'OrderController@overtake']);
	Route::post('orders/{id}/edit',         ['as' => 'order_edit', 'uses' => 'OrderController@edit']);
    Route::post('order/store', 			    ['as' => 'order_store', 'uses' => 'OrderController@store']);
	Route::post('orders/updateOrderStatus', ['as' => 'order_update_status', 'uses' => 'OrderController@updateOrderStatus']);
	Route::put('orders/{id}',               ['as' => 'orders_update', 'uses' => 'OrderController@update']);
	Route::delete('orders',                 ['as' => 'orders_delete', 'uses' => 'OrderController@destroy']);

	# new link
    Route::get('orders/{id}/ship',              ['as' => 'orders_ship', 'uses' => 'OrderController@ship']);
    Route::get('order/editor',                  ['as' => 'order.editor', 'uses' => 'OrderController@editor']);
    Route::get('orders/pdf/{id}',               ['as' => 'order_pdf', 'uses' => 'OrderController@getPdf']);
    Route::get('orders/downloadPdf/{id}',       ['as' => 'download_pdf', 'uses' =>'OrderController@downloadPdf']);
    Route::get('orders/opslaan/{id}',           ['as' => 'upload_Pdf', 'uses' =>'OrderController@uploadPdf']);
    Route::get('orders/verzendpdf/{id}',        ['as' => 'send_Pdf', 'uses' =>'OrderController@sendPdf']);

    #new links to country page
    Route::get('country',                       ['as' => 'country', 'uses' => 'OrderController@country']);
    Route::get('country/add',                   ['as' => 'create_country', 'uses' => 'OrderController@countryCreate']);
    Route::get('country/{id}/edit' ,            ['as' => 'orders_country_edit', 'uses' => 'OrderController@countryEdit']);
    Route::get('country/{id}/destroy',          ['as' => 'destroy_country', 'uses' => 'OrderController@deleteCountry']);
    Route::post('country/Succesful' ,           ['as' => 'orders_save_country', 'uses' => 'OrderController@saveCountry']);
    Route::post('orders/country/{id}/updated',  ['as' => 'country_update', 'uses' => 'OrderController@updateCountry']);

    #overzicht
    Route::get('orders/report',                  ['as' => 'overview', 'uses' => 'OverzichtController@report']);
    Route::post('orders/report',                 ['as' => 'filter', 'uses' => 'OverzichtController@filterReport']);
    Route::get('orders/report/export/{type}',    ['as' => 'report_export', 'uses' => 'OverzichtController@export']);
    route::get('orders/report/getpdf/{country}', ['as' => 'export_pdf', 'uses' => 'OverzichtController@getPdf']);

	# User
	Route::get('user/profile',                   ['as' => 'profile', 'uses' => 'UserController@index']);
	Route::put('user/profile/{id}',              ['as' => 'profile_update', 'uses' => 'UserController@update']);

	# Reviews
	Route::get('reviews',                        ['as' => 'reviews', 'uses' => 'ReviewController@index']);
	Route::get('reviews/data',                   ['as' => 'reviews_data', 'uses' => 'ReviewController@getData']);
	Route::put('reviews/state/{id}',             ['as' => 'reviews_state', 'uses' => 'ReviewController@changeState']);
	Route::delete('reviews/{id}',                ['as' => 'reviews_delete', 'uses' => 'ReviewController@destroy']);

	# Profiles
    Route::get('profiles',                     ['as' => 'profiles', 'uses' => 'ProfilesController@index']);
    Route::get('profiles/create',              ['as' => 'profiles.create', 'uses' => 'ProfilesController@create']);
    Route::get('profiles/edit/{id}',           ['as' => 'profiles.edit', 'uses' => 'ProfilesController@edit']);
    Route::post('profiles/update/{id}',         ['as' => 'profiles.update', 'uses' => 'ProfilesController@update']);
    Route::get('profiles/delete/{id}',         ['as' => 'profiles.delete', 'uses' => 'ProfilesController@destroy']);
    Route::post('profiles/store',              ['as' => 'profiles.store', 'uses' => 'ProfilesController@store']);


    # Settings


	# Kortingscodes
    Route::get('voucher',                  ['as' => 'voucher', 'uses' => 'OrderController@voucher']);
    Route::get('voucher/add',              ['as' => 'create_voucher', 'uses' => 'OrderController@voucherCreate']);
    Route::get('voucher/{id}/edit',        ['as' => 'edit_voucher', 'uses' => 'OrderController@voucherEdit']);
    Route::get('voucher/{id}/destroy',     ['as' => 'destroy_voucher', 'uses' => 'OrderController@voucherDelete']);
    Route::post('voucher/{id}/updated',    ['as' => 'update_voucher', 'uses' => 'OrderController@voucherUpdate']);
    Route::post('voucher/successful',      ['as' => 'save_voucher', 'uses' => 'OrderController@voucherSave']);

});

Auth::routes();
