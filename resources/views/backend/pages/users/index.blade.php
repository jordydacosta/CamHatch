@extends('backend.layouts.default')

@include('backend.partials.title')

@section('content')
    @yield('page-header')

    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">Edit your profile</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="panel panel-red">
                            <div class="panel-body">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <form class="form-horizontal" action="{{ URL::route('profile_update', Auth::user()->id) }}"
                          autocomplete="off" method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="_method" value="PUT">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                        <!-- ./ csrf token -->

                        <fieldset>

                            <!-- Name input-->
                            <div class="form-group {{ ($errors->has('name') ? 'has-error' :'') }}">
                                <label class="col-md-3 control-label" for="name">Name <span
                                            class="required_field"></span></label>
                                <div class="col-md-9">
                                    <input class="form-control" name="name" id="name"
                                           value="@if(!Input::old('name')){{ Auth::user()->name }}@else{{ Input::old('name') }}@endif">
                                </div>
                            </div>

                            <!-- Email input-->
                            <div class="form-group {{ ($errors->has('email') ? 'has-error' :'') }}">
                                <label class="col-md-3 control-label" for="email">Email <span
                                            class="required_field"></span></label>
                                <div class="col-md-9">
                                    <input class="form-control" type="email" name="email" id="email"
                                           value="@if(!Input::old('email')){{ Auth::user()->email }}@else{{ Input::old('email') }}@endif"
                                           autocomplete="off">
                                </div>
                            </div>

                            <!-- Password input-->
                            <div class="form-group {{ ($errors->has('password') ? 'has-error' :'') }}">
                                <label class="col-md-3 control-label" for="password">Password <span
                                            class="required_field"></span></label>
                                <div class="col-md-9">
                                    <input class="form-control" type="password" name="password" id="password"
                                           value="{{ Input::old('password') }}">
                                </div>
                            </div>

                            <!-- Password input-->
                            <div class="form-group {{ ($errors->has('password_confirmation') ? 'has-error' :'') }}">
                                <label class="col-md-3 control-label" for="password_confirmation">Password confirmation
                                    <span class="required_field"></span></label>
                                <div class="col-md-9">
                                    <input class="form-control" type="password" name="password_confirmation"
                                           id="password_confirmation" value="{{ Input::old('password_confirmation') }}">
                                </div>
                            </div>

                            <!-- Form actions -->
                            {!! \Helpers::formActions(route('dashboard')) !!}
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop