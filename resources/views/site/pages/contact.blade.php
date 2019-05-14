@extends('site.layouts.default')

@section('title')
    @lang('general.contact_title')
@stop

@section('content')

    <div class="container">

        <div class="row contact">

            <div class="col-md-6 col-sm-6">
                <h1>
                    @lang('general.ask_a_question')
                </h1>
                <br>
                <p>
                    @lang('contact.text', ['brand' => trans('general.brand')])
                </p>
                <br>

                <form class="form-horizontal contact-form" action="{{ URL::route('submit_contact_form') }}"
                      autocomplete="on" method="POST">
                    @if (count($errors) > 0)
                        <div class="errors">
                            @foreach($errors->all(':message') as $message)
                                <span>{{ $message }}</span>
                                <br>
                            @endforeach
                        </div>
                        <br>
                        @endif

                                <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                        <!-- ./ csrf token -->

                        <fieldset>
                            <!-- Name input-->
                            <div class="form-group {{ ($errors->has('name') ? 'has-error' :'') }}">
                                <div class="col-md-12">
                                    <input class="form-control" name="name" id="name" value="{{ Input::old('name') }}"
                                           placeholder="@lang('contact.your_name')">
                                </div>
                            </div>

                            <!-- Email input-->
                            <div class="form-group {{ ($errors->has('email') ? 'has-error' :'') }}">
                                <div class="col-md-12">
                                    <input class="form-control" type="email" name="email" id="email"
                                           value="{{ Input::old('email') }}" placeholder="@lang('contact.email')">
                                </div>
                            </div>

                            <!-- Description input-->
                            <div class="form-group {{ ($errors->has('contact-message') ? 'has-error' :'') }}">
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="6" name="contact-message"
                                              placeholder="@lang('contact.message')">{{ Input::old('contact-message') }}</textarea>
                                </div>
                            </div>

                            <!-- Description input -->
                            <div class="form-group">
                                <div class="col-md-12">
                                    {!! app('captcha')->display([env('NOCAPTCHA_SITEKEY')], App::getLocale()) !!}
                                </div>
                            </div>

                            <br>
                            <button type="submit" class="btn btn-yellow">@lang('general.submit')<span
                                        class="arrow"></span></button>
                        </fieldset>
                </form>
            </div>
            <div class="col-md-5 col-sm-5 col-md-offset-1 col-sm-offset-1">
                <h1>
                    @lang('general.contact_title')
                </h1>
                <br>
                <div class="row" style="font-size: 14px; line-height: 22px;">
                    <div class="col-md-6">
                        <h2 style="margin-top: 0;">Netherlands</h2>
                        CamHatch Netherlands B.V. <br>
                        Adriaen van der Doeslaan 115C <br>
                        3054 EB Rotterdam <br>
                        <strong>E&nbsp;</strong> <a href="mailto:info@camhatch.nl?subject=Contact">info@camhatch.nl</a><br><br>
                        CoC-number: 68452462 <br>
                        VAT-number: NL857450712B01 <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-127594093-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{env('G_ANALYTICS')}}');
</script>
@stop
