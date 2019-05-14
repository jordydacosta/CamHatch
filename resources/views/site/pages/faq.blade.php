@extends('site.layouts.default')

@section('title')
    @lang('general.faq')
@stop

@section('content')
    <div class="container">

        <div class="row faq">

            <div class="col-md-12">
                <h1>
                    FAQ
                </h1>
                <br>
            </div>

            <div class="col-md-3 col-sm-4">
                <ul class="faq-sidebar">
                    <li>
                        <span class="btn @if($type == 'shipping' || !isset($type)) btn-yellow @elseif($type == 'warranty') btn-grey @endif"
                              id="shipping">@lang('faq.shipping_title')</span></li>
                    <li>
                        <span class="btn @if($type == 'warranty') btn-yellow @elseif($type == 'shipping' || !isset($type)) btn-grey @endif"
                              id="warranty">@lang('faq.warranty_title')</span></li>
                </ul>
            </div>
            <br>

            <div class="col-md-9 col-sm-8">
                <p class="faq-title uppercase dark-grey">
                    @if($type == 'shipping' || !isset($type))
                        {!! trans('faq.shipping_title') !!}
                    @elseif($type == 'warranty')
                        {!! trans('faq.warranty_title') !!}
                    @endif
                </p>
                <br>

                <div class="faq-text">
                    @if($type == 'shipping' || !isset($type))
                        {!! trans('faq.shipping_text', [
                            'brand' => trans('general.brand'),
                            'ch_bankaccount' => config('config.ch_bankaccount.IBAN'),
                            'ch_bankaccount_nl' => config('config.ch_bankaccount_nl.IBAN')
                        ]) !!}
                    @elseif($type == 'warranty')
                        {!! trans('faq.warranty_text', ['brand' => trans('general.brand')]) !!}
                    @else

                    @endif
                </div>
            </div>
        </div>

    </div>
@stop

@section('javascript')

    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#shipping').click(function() {
                // set the active button
                setActive('#shipping', '#warranty, #stores');
                // set the text
                setText('{!! trans('faq.shipping_title') !!}',
                        '{!! trans('faq.shipping_text', ['brand' => trans('general.brand')]) !!}');
            });

            $('#warranty').click(function() {
                setActive('#warranty', '#shipping, #stores');
                setText('{!! trans('faq.warranty_title') !!}',
                        '{!! trans('faq.warranty_text', ['brand' => trans('general.brand')]) !!}');
            });
        });

        function setText(title, text) {
            $('.faq-title').html(title);
            $('.faq-text').html(text);
        }

        /**
         * Set the active element
         * @param {[type]} active   [description]
         * @param {[type]} inactive [description]
         */
        function setActive(active, inactive) {
            $(active).removeClass('btn-grey').addClass('btn-yellow');
            $(inactive).removeClass('btn-yellow').addClass('btn-grey');
        }

    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127594093-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{env('G_ANALYTICS')}}');
    </script>
@stop