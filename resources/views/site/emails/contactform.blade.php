@extends('site.layouts.emails')

@section('title')
@stop

@section('content')

    <h1>Contactformulier CamHatch</h1>

    <b>Naam</b>: {{ Input::get('name') }}<br/>
    <b>Email</b>: {{ Input::get('email') }}<br/>
    <b>Bericht</b>: {{ Input::get('contact-message') }}<br/>
@stop
