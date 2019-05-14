<nav class="navbar navbar-default header_nav">
    <div class="container-fluid container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            {{-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" id="collapse_navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button> --}}

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="logo" href="{{ route('home') }}"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse text-center" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right uppercase">
                <li>
                    <a href="{{ route('home') }}"
                       class='@if(Route::currentRouteName() == "home") active-nav @endif'>@lang('general.home')</a>
                </li>
                <li>
                    <a id="specifications-item"
                       href="{{ route('home') }}#specifications">@lang('general.specifications')</a>
                </li>
                <li>
                  {{--<a href="https://www.kickstarter.com/projects/179395903/camhatch-award-winning-webcam-cover-redefine-your?ref=d2hzbq">
                    @lang('general.shop')
                  </a>--}}
                  <a href="@if(count($cart) == 0){{ route('shop') }}@else{{ route('checkout') }}@endif"
                     class='@if(Route::currentRouteName() == "shop" || Route::currentRouteName() == "checkout") active-nav @endif shop-nav'>
                    @lang('general.shop')

                    @if(count($cart) != 0)
                      @foreach($cart as $row)
                        <span class="badge product_quantity">{{ $row->qty }}</span>
                      @endforeach
                    @endif
                  </a>
                </li>
                <li>
                    <a href="{{ route('faq') }}"
                       class='@if(Route::currentRouteName() == "faq") active-nav @endif'>@lang('general.faq')</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}"
                       class='@if(Route::currentRouteName() == "contact") active-nav @endif'>@lang('general.contact_title')</a>
                </li>

                @foreach (Config::get('languages') as $lang => $language)
                    @if ($lang != App::getLocale())
                        <li>
                            {{-- <a class="language-item" href="{{ route('lang.switch', $lang) }}" title="{{ $language }}">{{ $lang }}</a> --}}

                            <a class="language-item" href="/setlang/{{ $lang }}/{{ Route::currentRouteName() }}"
                               title="{{ $language }}">{{ $lang }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>
