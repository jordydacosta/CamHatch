@extends('site.layouts.default')

@section('title')
    @lang('general.installation')
@stop

@section('content')

    <div class="container">
        <div class="row text-center installation">
            <iframe width="720" height="480" src="https://www.youtube.com/embed/TgHzDss6Izc" frameborder="0"
                    allowfullscreen theme="dark"></iframe>
        </div>
    </div>
@stop

@section('javascript')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127594093-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{env('G_ANALYTICS')}}');
    </script>
@stop