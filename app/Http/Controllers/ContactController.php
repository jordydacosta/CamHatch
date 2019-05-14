<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\ContactFormRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('site.pages.contact');
    }


    public function postForm(ContactFormRequest $request)
    {
        $form_data = \Input::all();

       \Mail::to($form_data['email'])->send(new OrderShipped());

//
//        \Mail::send('site.emails.contactform', $form_data, function ($message) use ($form_data) {
//
//            // if the app is in debug mode, send the email to the web designer
//            if (\Config::get('app.debug')) {
//                $message->to('smail@pegus-apps.com');
//            } else {
//                $message->to(['wendy.seys@pegusapps.com', 'info@camhatch.nl']);
//                $message->bcc('smail@pegus-apps.com');
//            }
//
//            $message->subject('CamHatch: Contact formulier');
//        });

        return \Redirect::to(\Request::segment(1) . '/contact/thanks');
    }

}
