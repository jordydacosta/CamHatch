@extends('site.layouts.default')

@section('title')
  @lang('general.ch_slogan')
@stop

@section('content')
  <div id="carousel-example-generic" class="carousel slide banner" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img class="img-banner"
             src="@if(App::getLocale() == 'en') /img/slideshow1.jpg @elseif(App::getLocale() == 'nl') /img/slideshow1_nl.jpg @endif">
      </div>
      <div class="item">
        <img class="img-banner"
             src="@if(App::getLocale() == 'en') /img/slideshow2.jpg @elseif(App::getLocale() == 'nl') /img/slideshow2_nl.jpg @endif">
      </div>
    </div>
  </div>

  <div class="container">
    <div class="buy-now col-md-2">
      <a href="@if(count($cart) == 0){{ route('shop') }}@else{{ route('checkout') }}@endif" title="">
        <div class="amount">
	  				<span class="euro">
		  				&euro;
		  			</span>
          <span class="price">
						{{ config('config.ch_price') }}
		  			</span>
          <br>
          <span class="buy-now-text">
		  				@lang('general.buy_now')
		  			</span>
        </div>
      </a>
    </div>

    <div class="col-md-3 col-md-offset-9 col-xs-12 text-right play-btn">
      <a class="popup-youtube" href="https://www.youtube.com/watch?v=a4unSCQW2DA">
        <img src="/img/play.svg"><span class="semi-bold uppercase">@lang('home.watch_video')</span>
      </a>
    </div>
  </div>

  <div class="grey-bg">
    <div class="container">
      <div class="col-md-12 col-xs-12">
        <div class="row home-container-top">

          <div class="col-md-3 col-sm-3 col-xs-3 col-xs-offset-1 col-md-offset-1">
            <div class="hero text-center">
              <img src="img/hero.png" alt="CamHatch hero">
            </div>
          </div>

          <div class="col-md-7 col-sm-7 col-xs-12">
            <h1>
              @lang('home.title_1')
            </h1>
            <br>
            <p class="home-container-text">
              @lang('home.text_1', ['brand' => trans('general.brand')])
            </p>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="container solution">
    <div class="col-md-12 col-xs-12">
      <h1 class="text-center">
        @lang('home.title_2')
      </h1>
      <br>
      <br>

      <div class="col-md-3 col-sm-3 col-xs-3 col-xs-offset-1 col-md-offset-1 camhatch-container">
        <img src="/img/camhatch1.jpg" class="camhatch-image">
      </div>

      <div class="col-md-7 col-sm-7 col-xs-12 camhatch-text">
        <p class="solution-text">
          @lang('home.text_2')
        </p>
        <br>
        <p class="solution-text">
          @lang('home.text_2a', ['brand' => trans('general.brand')])
        </p>
      </div>
    </div>


    <div class="specifications col-md-12 col-xs-12">
      <a name="specifications" class="anchor"></a>
      <h3 class="text-center uppercase">
        @lang('general.specifications')
      </h3>

      <div class="col-md-12 col-sm-12 features-top">
        <div class="col-md-6 col-sm-6 text-center">
          <h2>@lang('home.specs_title_1')</h2>
          <hr class="features-line">
          <br>
          <br>
          <img src="@if(App::getLocale() == 'en') /img/feature3.jpg @elseif(App::getLocale() == 'nl') /img/feature3_nl.jpg @endif"
               class="features-image">
        </div>

        <div class="col-md-6 col-sm-6 text-center">
          <h2>@lang('home.specs_title_2')</h2>
          <hr class="features-line">
          <br>
          <br>
          <img src="/img/feature2.jpg" class="features-image">
          <br>
          <br>
          <p class="features-info">@lang('home.specs_text_2', ['brand' => trans('general.brand')])</p>
        </div>
      </div>

      <div class="col-md-12 col-sm-12 features-bottom">
        <div class="col-md-6 col-sm-6 text-center">
          <h2>@lang('home.specs_title_3')</h2>
          <hr class="features-line">
          <br>
          <br>
          <p class="features-text">@lang('home.specs_text_3', ['brand' => trans('general.brand')])</p>
          <br>
        </div>

        <div class="col-md-6 col-sm-6 text-center">
          <h2>@lang('home.specs_title_4')</h2>
          <hr class="features-line">
          <br>
          <br>
          <img src="/img/feature1.jpg" class="features-image">
          <br>
          <br>
          <p class="features-info">@lang('home.specs_text_4')</p>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="customer-reviews text-center col-md-12">
      @if(isset($reviews) && $reviews->count() > 0)
        <div class="customer-stars">
          <ul class="rating-stars">
            @for ($i = 0; $i < $reviews->rating; $i++)
              <li><img class="rating-large" src="/img/rating-large.png" alt=""></li>
            @endfor
          </ul>
        </div>
        <div class="customer-review">
          <p class="dark-grey">
            "
            @if (App::getLocale() == 'nl')
              {{ $reviews->description }}
            @elseif(App::getLocale() == 'en')
              {{ $reviews->description_en }}
            @endif
            " - {{ $reviews->name }}
          </p>
        </div>
        <a href="@if(count($cart) == 0){{ route('shop') }}@else{{ route('checkout') }}@endif" class="btn btn-yellow">
          @lang('general.buy_now') <span class="arrow"></span>
        </a>
      @else
        <div class="customer-review">
          <p class="dark-grey">
            @lang('general.no_reviews')
          </p>
        </div>
      @endif
    </div>
  </div>

@stop


@section('javascript')

  <script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
      $('.popup-youtube').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: true,
        fixedContentPos: false
      });

      // animate scroll to about
      $('#specifications-item').click(function () {
        // set active navigation element
        $('html,body').animate({scrollTop: $('a[name="specifications"]').offset().top}, 500);
      });
    });
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
