@extends('site.layouts.default')

@section('title')
    @lang('general.shop_title')
@stop

@section('content')
    <div class="grey-bg">
        <div class="container">
            <div class="row shop">
                <div class="col-md-12">
                    @if(null !== Session::get('success') && Session::get('success') == true)
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            @lang('shop.success_review')
                        </div>
                    @elseif(null !== Session::get('success') && Session::get('success') == false)
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            @lang('shop.error_review')
                        </div>
                    @endif
                    <h1>
                        @lang('shop.shop_online')
                    </h1>
                    <br>
                </div>

                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <img src="/img/camhatch1.jpg" class="camhatch-image">
                        </div>

                        <div class="col-xs-12 mobile-buy">
                            <br>
                            <form action="{{ route('submit_shop') }}" method="POST" accept-charset="utf-8"
                                  autocomplete="off">
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

                                    <input type="text" name="quantity" id="quantity" class="quantity" value="1">
                                    <button type="submit" class="btn btn-yellow">@lang('general.buy_now')<span
                                                class="arrow"></span></button>
                            </form>
                        </div>

                        <div class="col-md-12 col-sm-6 col-xs-12 product-specs">
                            <p class="uppercase">@lang('shop.product_specs')</p>
                            <div class="light-grey uppercase">
                                <div class="row product-specs-measurement">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        @lang('shop.width')
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                                        {{ config('config.ch_specs.width.mm') }} mm
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-5 text-center">
                                        {{ config('config.ch_specs.width.inches') }} inches
                                    </div>
                                </div>

                                <div class="row product-specs-measurement">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        @lang('shop.height')
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                                        {{ config('config.ch_specs.height.mm') }} mm
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-5 text-center">
                                        {{ config('config.ch_specs.height.inches') }} inches
                                    </div>
                                </div>

                                <div class="row product-specs-measurement">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        @lang('shop.depth')
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                                        {{ config('config.ch_specs.depth.mm') }} mm
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-5 text-center">
                                        {{ config('config.ch_specs.depth.inches') }} inches
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-6">
                    <p class="product-title dark-grey">
                        @lang('general.brand')
                    </p>

                    @if(count($reviews_count) > 0)

                        <ul class="rating-stars">
                            <?php $total_stars = 5; ?>

                            {{-- calculate the full stars --}}
                            @for ($i = 0; $i < $avarage_review; $i++)
                                <li><img class="rating-normal" src="/img/rating.png" alt=""></li>
                                <?php $total_stars--; ?>
                            @endfor

                            {{-- calculate the empty stars --}}
                            @for ($i = 0; $i < $total_stars; $i++)
                                <li><img class="rating-off" src="/img/rating-off.png" alt=""></li>
                            @endfor

                            <li><span class="total-reviews">{{ count($reviews_count) }} @lang('shop.reviews')</span>
                            </li>
                        </ul>

                    @endif

                    <div class="row">
                        <div class="col-md-9">
                            <p class="product-description">
                                @lang('shop.product_description')
                            </p>

                            <div class="ch-color-container">
                                <span class="ch-color uppercase">@lang('shop.color'):</span>
                                <span class="ch-color-picker">@lang('shop.black')</span>
                                <div class="ch-color-black"></div>
                            </div>

                            <div class="ch-price-stock">
								<span class="euro">
					  				&euro;
					  			</span>
					  			<span class="price">
									{{ config('config.ch_price') }}
					  			</span>
					  			<span class="in-stock">
					  				@lang('shop.in_stock')
					  			</span>
                            </div>

                            <form action="{{ route('submit_shop') }}" class="normal-buy" method="POST"
                                  accept-charset="utf-8" autocomplete="off">
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

                                    <input type="text" name="quantity" id="quantity" class="quantity" value="1">
                                    <button type="submit" class="btn btn-yellow">@lang('general.buy_now')<span
                                                class="arrow"></span></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 satisfaction-warranty">
                    <p class="satisfaction-warranty-title dark-grey uppercase">@lang('shop.satisfaction_warranty')</p>
                    <p class="satisfaction-warranty-text">

                        @lang('shop.satisfaction_warranty_text', ['url' => route('faq', 'warranty')])
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="triangle"></div>

        <div class="row review-section">
            <div class="col-md-12">
                <a class="write-review fancybox.ajax btn btn-yellow" id="write-review"
                   href="{{ route('write_review') }}">
                    @lang('shop.write_review')<span class="arrow"></span>
                </a>

                <hr>
            </div>

            <a name="all-reviews" class="anchor"></a>
            <div class="col-md-12">
                <p class="review-title dark-grey uppercase">
                    @lang('shop.product_reviews')
                </p>

                <div id="review_overview">
                    {!! $reviews !!}
                </div>

                <br>
                <div class="row">
                    <div class="col-md-12">
                        @if(count($reviews_count) > 4)
                            <button type="button" id="show-more" class="btn btn-yellow ladda-button"
                                    data-style="zoom-in">@lang('shop.show_more')<span class="arrow"></span></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {

            @if(count($reviews_count) > 4)
                var l = Ladda.create(document.querySelector('#show-more'));

                $('#show-more').click(function() {

                    // start loading
                    l.start();

                    handleAjaxRequests('{{ route('load_reviews') }}',
                            {'last_id': $('ul.review-list > li').last().data('id')}, 'GET').done(function(data) {
                        // inject view in div
                        $('#review_overview').html(data.view);

                        // stop loading
                        l.stop();
                        $('#show-more').hide();
                    });
                });
            @endif

            $(".write-review").fancybox({
                padding: 0,
                fitToView: false,
                autoSize: true,
                closeClick: false,
                openEffect: 'none',
                closeEffect: 'none',
                closeBtn: false,
                openSpeed: 0,
                closeSpeed: 0
            });

            // animate scroll to about
            $('span.total-reviews').click(function() {
                // set active navigation element
                $('html,body').animate({scrollTop: $('a[name="all-reviews"]').offset().top}, 500);
            });

            $('#rating').barrating({
                theme: 'css-stars'
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