@extends('site.layouts.default')

@section('title')
    @lang('checkout.checkout')
@stop

@section('content')
    <div class="container">
        <div class="row shop">

            <div class="col-md-12">
                <h1>
                    @lang('checkout.checkout')
                </h1>
                <br>
            </div>

            @if(count($content) == 0)
                <div class="col-md-12">
                    <h2>@lang('checkout.empty_cart')</h2>
                    <br>

                    <a href="{{route('shop')}}" class="btn btn-yellow">@lang('checkout.return_shop')<span class="arrow"></span></a>
                </div>
            @else
                <div class="col-md-12">
                    @foreach($content as $row)
                        <div class="row">
                            <div class="form-group col-md-10">
                                <p class="checkout-form-title dark-grey">@lang('checkout.your_order')</p>
                                <br>
                                <input type="text" name="quantity" id="quantity" class="quantity"
                                       value="{{ $row->qty }}" autocomplete="off">
                                <label> x {{ $row->name }} ({{ $row->options->color }})</label>
                                <label class="pull-right">€<span
                                            class="product_total">{{ $price }}</span></label>
                                <br>
                                <div>   </div>
                                <br>

                                <button type="button" class="btn btn-yellow pull-left"
                                        id="update-cart">@lang('checkout.update_basket')<span class="arrow"></span>
                                </button>

                                <div style="display: none" id="qty-error">
                                    <br>
                                    <br>
                                    <div class="errors col-md-12">
                                        <span></span>
                                        <br>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                    <div class="row">
                        <div class="col-md-11">
                            <hr class="order-overview-seperation">
                        </div>
                    </div>

                    <form action="{{ route('place_order') }}" id="place_order_form" method="POST" accept-charset="utf-8"
                          class="checkout-form">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                        <!-- ./ csrf token -->

                        <div class="row">
                            <div class="col-md-12">
                                @if (count($errors) > 0)
                                    <div class="errors col-md-10" style="margin-bottom: 20px;">
                                        @foreach($errors->all(':message') as $message)
                                            <span>{{ $message }}</span>
                                            <br>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="row">
                                    <br>
                                    <p class="checkout-form-title dark-grey col-md-10">@lang('checkout.billing_address')</p>
                                    <br>
                                    <br>
                                    @if(isset($order))
                                        {{-- Firstname --}}
                                        {!! \Helpers::formInput("col-md-5 ".($errors->has('firstname') ? 'has-error' :''), 'firstname', 'text', trans('checkout.firstname'), Input::old('firstname',$order->firstname)) !!}
                                        {{-- Lastname --}}
                                        {!! \Helpers::formInput('col-md-5 '.($errors->has('lastname') ? 'has-error' :''), 'lastname', 'text', trans('checkout.lastname'), Input::old('lastname',$order->lastname)) !!}
                                        {{-- Email --}}
                                        {!! \Helpers::formInput('col-md-10 '.($errors->has('email') ? 'has-error' :''), 'email', 'email', trans('checkout.email'), Input::old('email',$order->email)) !!}
                                        {{-- Phone --}}
                                        {!! \Helpers::formInput('col-md-10 '.($errors->has('phone') ? 'has-error' :''), 'phone', 'text', trans('checkout.phone'), Input::old('phone',$order->phone)) !!}
                                        {{-- Company --}}
                                        {!! \Helpers::formInput('col-md-10 ', 'company', 'text', trans('checkout.company'), Input::old('company',$order->company)) !!}
                                        {{-- Address --}}
                                        {!! \Helpers::formInput('col-md-10 '.($errors->has('address') ? 'has-error' :''), 'address', 'text', trans('checkout.address'), Input::old('address',$order->address)) !!}
                                        {{-- Zipcode --}}
                                        {!! \Helpers::formInput('col-md-3 '.($errors->has('zipcode') ? 'has-error' :''), 'zipcode', 'text', trans('checkout.zipcode'), Input::old('zipcode',$order->zipcode)) !!}
                                        {{-- City --}}
                                        {!! \Helpers::formInput('col-md-7 '.($errors->has('city') ? 'has-error' :''), 'city', 'text', trans('checkout.city'), Input::old('city',$order->city)) !!}
                                        {{-- Country.php selection --}}
                                        <div class="form-group col-md-10">
                                            <select name="country" id="country" class="form-control">
                                                <option value="">{{trans('checkout.choose')}}</option>
                                                @if(count($country) > 20)
                                                    @foreach(trans('countries') as $key => $value)
                                                        @if($order->country == $key )
                                                            <option value="{{ $key }}" selected>{{ $value}}</option>
                                                            @else
                                                            <option value="{{ $key }}">{{$value}}</option>
                                                        @endif
                                                    @endforeach
                                                @elseif(\App::isLocale('nl'))
                                                    @foreach( $country as $key )
                                                        <option value="{{$key->isocode}}">{{$key->country_nl}}</option>
                                                        {{$value = $key->country }}
                                                    @endforeach
                                                @else
                                                    @foreach( $country as $key )
                                                        <option value="{{$key->isocode}}">{{$key->country_en}}</option>
                                                        {{$value = $key->country }}
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        {{-- Vouchercode --}}
                                        @if(isset($voucher))
                                            {!! \Helpers::formInput('col-md-3 '.($errors->has('vouchercode') ? 'has-error' :''), 'voucher', 'text', trans('checkout.voucher'), Input::old('voucher',$voucher->vouchercode)) !!}
                                            <br>
                                        @else
                                            {!! \Helpers::formInput('col-md-3 ', 'voucher', 'text', trans('checkout.voucher'), Input::old('voucher', $vouchercode)) !!}
                                            <br>
                                        @endif
                                        <button type="button" class="btn btn-yellow pull-left"
                                                id="voucher-Update">@lang('checkout.check_voucher')<span class="arrow"></span>
                                        </button>
                                        <div style="margin-left: 1.5%;">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <hr class="order-overview-seperation">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <br>
                                                    <p class="checkout-form-title dark-grey">@lang('checkout.shipping_details')</p>
                                                    <div class="row">
                                                        {{-- Is company --}}
                                                        <div class="form-group col-md-12">
                                                            <input type="checkbox" name="same-billing-addres" id="same-billing-addres"
                                                                   @if(!Input::old('same-billing-addres'))checked="true"@endif>
                                                            <label for="same-billing-addres"
                                                                   class="dark-grey is-company">@lang('checkout.same_billing_address')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Firstname --}}
                                        {!! \Helpers::formInput("col-md-5 ".($errors->has('firstname') ? 'has-error' :''), 'firstname', 'text', trans('checkout.firstname'), Input::old('firstname')) !!}
                                        {{-- Lastname --}}
                                        {!! \Helpers::formInput('col-md-5 '.($errors->has('lastname') ? 'has-error' :''), 'lastname', 'text', trans('checkout.lastname'), Input::old('lastname')) !!}
                                        {{-- Email --}}
                                        {!! \Helpers::formInput('col-md-10 '.($errors->has('email') ? 'has-error' :''), 'email', 'email', trans('checkout.email'), Input::old('email')) !!}
                                        {{-- Phone --}}
                                        {!! \Helpers::formInput('col-md-10 '.($errors->has('phone') ? 'has-error' :''), 'phone', 'text', trans('checkout.phone'), Input::old('phone')) !!}
                                        {{-- Company --}}
                                        {!! \Helpers::formInput('col-md-10 ', 'company', 'text', trans('checkout.company'), Input::old('company')) !!}
                                        {{-- Address --}}
                                        {!! \Helpers::formInput('col-md-10 '.($errors->has('address') ? 'has-error' :''), 'address', 'text', trans('checkout.address'), Input::old('address')) !!}
                                        {{-- Zipcode --}}
                                        {!! \Helpers::formInput('col-md-3 '.($errors->has('zipcode') ? 'has-error' :''), 'zipcode', 'text', trans('checkout.zipcode'), Input::old('zipcode')) !!}
                                        {{-- City --}}
                                        {!! \Helpers::formInput('col-md-7 '.($errors->has('city') ? 'has-error' :''), 'city', 'text', trans('checkout.city'), Input::old('city')) !!}
                                        {{-- Country.php selection --}}
                                        <div class="form-group col-md-10">
                                            <select name="country" id="country" class="form-control">
                                                <option value="">{{trans('general.choose')}}</option>
                                                @if(count($country) <= 20)
                                                    @foreach(trans('countries') as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                @elseif(\App::isLocale('nl'))
                                                    @foreach( $country as $key )
                                                        <option value="{{$key->isocode}}">{{$key->country_nl}}</option>
                                                        {{$value = $key->country }}
                                                    @endforeach
                                                @else
                                                    @foreach( $country as $key )
                                                        <option value="{{$key->isocode}}">{{$key->country_en}}</option>
                                                        {{$value = $key->country }}
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        {{-- Voucher --}}
                                        {!! \Helpers::formInput('col-md-3 ', 'voucher', 'text', trans('checkout.voucher'), Input::old('voucher', $vouchercode)) !!}
                                        <br>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-yellow pull-left"
                                                id="voucher-Update" style=" width: 255px;">@lang('checkout.check_voucher')<span class="arrow"></span>
                                        </button>
                                    </div>
                                        <br>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-11">
                                <hr class="order-overview-seperation">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <p class="checkout-form-title dark-grey">@lang('checkout.shipping_details')</p>
                                <div class="row">
                                    {{-- Is company --}}
                                    <div class="form-group col-md-12">
                                        <input type="checkbox" name="same-billing-addres" id="same-billing-addres"
                                               @if(!Input::old('same-billing-addres'))checked="true"@endif>
                                        <label for="same-billing-addres"
                                               class="dark-grey is-company">@lang('checkout.same_billing_address')</label>
                                    </div>
                                    <div id="same-as-billing-container"
                                         @if(!Input::old('same-billing-addres'))style="display:none;"@endif>
                                        {{-- Billing Firstname --}}
                                        {!! \Helpers::formInput("col-md-5 ".($errors->has('shipping_firstname') ? 'has-error' :''), 'shipping_firstname', 'text', trans('checkout.firstname'), Input::old('shipping_firstname')) !!}

                                        {!! \Helpers::formInput("col-md-5 ".($errors->has('shipping_lastname') ? 'has-error' :''), 'shipping_lastname', 'text', trans('checkout.lastname'), Input::old('shipping_lastname')) !!}
                                        {{-- Billing Lastname --}}

                                        {{-- Billing Company --}}
                                        {!! \Helpers::formInput("col-md-10 ".($errors->has('shipping_company') ? 'has-error' :''), 'shipping_company', 'text', trans('checkout.company'), Input::old('shipping_company')) !!}

                                        {{-- Billing Address --}}
                                        {!! \Helpers::formInput("col-md-10 ".($errors->has('shipping_address') ? 'has-error' :''), 'shipping_address', 'text', trans('checkout.address'), Input::old('shipping_address')) !!}

                                        {{-- Billing Zipcode --}}
                                        {!! \Helpers::formInput("col-md-3 ".($errors->has('shipping_zipcode') ? 'has-error' :''), 'shipping_zipcode', 'text', trans('checkout.zipcode'), Input::old('shipping_zipcode')) !!}

                                        {{-- Billing City --}}
                                        {!! \Helpers::formInput("col-md-7 ".($errors->has('shipping_city') ? 'has-error' :''), 'shipping_city', 'text', trans('checkout.city'), Input::old('shipping_city')) !!}

                                        {{-- Billing Country.php selection --}}
                                        <div class="form-group col-md-10">
                                            <select name="shipping_country" id="shipping_country" class="form-control"
                                                    @if($value != null )checked="true"@endif>
                                                @foreach(trans('countries') as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Description input-->
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <textarea class="form-control" rows="6" name="comment"
                                                      placeholder="@lang('checkout.additional_notes')">{{ Input::old('comment') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-11">
                                <hr class="order-overview-seperation">
                            </div>
                        </div>
                        <div id="order_overview">
                            {!! $order_overview !!}
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@stop
@section('styles')
    <style type="text/css" media="screen">
        .error_message {
            color: #C61212 !important;
            font-size: 12px !important;
        }
    </style>
@stop
@section('javascript')
    @if(count($content) != 0)
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {

                // bind Ladda to the
                Ladda.bind('#place-order');

                // get the current quantity
                var $current_qty = {{ Cart::count() }};
                // set the total price
                var $total_price = {{ $total_price }};
                // set the option "same as billing address"
                var shipping_address = 0;

                // set the current country where the user resides
                $('#country option[value="{{ $location["isoCode"] }}"], #shipping_country option[value="{{ $location["isoCode"] }}"]')
                    .attr("selected", "selected");

                $('#empty-cart').on('click', function() {
                    if (confirm("{{ trans('checkout.areYouSure')  }}")) {
                        window.location.replace('{{ route('empty_cart') }}');
                    } else {
                        return false;
                    }
                });

                /**
                 * Validate the form
                 * @type {[type]}
                 */
                $('#place_order_form').validate({
                    rules: {
                        firstname: "required",
                        lastname: "required",
                        email: {
                            required: true,
                            email: true
                        },
                        phone: "required",
                        address: "required",
                        zipcode: "required",
                        city: "required",
                        shipping_firstname: {
                            required: {
                                depends: function() {
                                    return $('#same-billing-addres').not(':checked')
                                }
                            }
                        },
                        shipping_lastname: {
                            required: {
                                depends: function() {
                                    return $('#same-billing-addres').not(':checked')
                                }
                            }
                        },
                        shipping_address: {
                            required: {
                                depends: function() {
                                    return $('#same-billing-addres').not(':checked')
                                }
                            }
                        },
                        shipping_zipcode: {
                            required: {
                                depends: function() {
                                    return $('#same-billing-addres').not(':checked')
                                }
                            }
                        },
                        shipping_city: {
                            required: {
                                depends: function() {
                                    return $('#same-billing-addres').not(':checked')
                                }
                            }
                        },
                    },
                    messages: {
                        firstname: {
                            required: "{!! trans('validation.custom.firstname') !!}",
                        },
                        lastname: {
                            required: "{!! trans('validation.custom.lastname') !!}",
                        },
                        email: {
                            required: "{!! trans('validation.custom.email') !!}",
                            email: "{!! trans('validation.email') !!}"
                        },
                        phone: {
                            required: "{!! trans('validation.custom.phone') !!}",
                        },
                        company: {
                            required: "{!! trans('validation.custom.company') !!}",
                        },
                        address: {
                            required: "{!! trans('validation.custom.address') !!}",
                        },
                        zipcode: {
                            required: "{!! trans('validation.custom.zipcode') !!}",
                        },
                        city: {
                            required: "{!! trans('validation.custom.city') !!}",
                        },
                        voucher: {
                            required: "{!! trans('validation.custom.voucher') !!}",
                        },

                        shipping_firstname: {
                            required: "{!! trans('validation.custom.firstname') !!}",
                        },
                        shipping_lastname: {
                            required: "{!! trans('validation.custom.lastname') !!}",
                        },
                        shipping_phone: {
                            required: "{!! trans('validation.custom.phone') !!}",
                        },
                        shipping_company: {
                            required: "{!! trans('validation.custom.company') !!}",
                        },
                        shipping_address: {
                            required: "{!! trans('validation.custom.address') !!}",
                        },
                        shipping_zipcode: {
                            required: "{!! trans('validation.custom.zipcode') !!}",
                        },
                        shipping_city: {
                            required: "{!! trans('validation.custom.city') !!}",
                        },
                    },
                    invalidHandler: function(event, validator) {
                        var errors = validator.numberOfInvalids();
                        Ladda.stopAll();
                    },

                    errorPlacement: function(error, element) {
                        offset = element.offset();
                        error.insertAfter(element);

                        error.addClass('error_message');
                    },
                    submitHandler: function(form) {
                        // do other things for a valid form
                        form.submit();
                    }
                });

                $('#same-billing-addres').change(function() {
                    var country;

                    if ($(this).is(":checked")) {
                        $("#same-as-billing-container").slideUp('fast');
                        country = $('#country').val();
                    } else {
                        $("#same-as-billing-container").slideDown('fast');
                        country = $('#shipping_country').val();
                    }

                    reloadOverview(country, $('input[name="options-payment"]:checked').val());
                });

                $('#update-cart').click(function() {
                    $('#place-order').prop('disabled', true);

                    var data = {
                        'quantity': parseInt($('#quantity').val()),
                        'country': $('#country').val(),
                        'voucher': $('#voucher').val(),
                    };

                    handleAjaxRequests('{{ route('calculate_price') }}', data, 'GET').done(function(data) {
                        if (data.success != 1) {
                            $('#qty-error').show();
                            $('#qty-error span').text(data.quantity[0]);
                        } else {

                            $('#qty-error').hide();
                            $('#qty-error span').text('');

                            $current_qty = data.qty;

                            // set the product total
                            $('.product_total').text(data.total_price);
                            $('.product_quantity').text(data.qty);

                            $("#place_order_form :input").attr("disabled", false);
                            $('#place_order_form').css('opacity', 1);

                            $('#order_overview').html(data.view);
                            Ladda.bind('#place-order');
                        }

                        $('#place-order').prop('disabled', false);
                    });
                })

                $('#voucher-Update').click(function() {
                    $('#place-order').prop('disabled', true);

                    var data = {
                        'quantity': parseInt($('#quantity').val()),
                        'country': $('#country').val(),
                        'voucher': $('#voucher').val(),
                    };

                    handleAjaxRequests('{{ route('calculate_price') }}', data, 'GET').done(function(data) {
                        if (data.success != 1) {
                            $('#qty-error').show();
                            $('#qty-error span').text(data.quantity[0]);
                        } else {

                            $('#qty-error').hide();
                            $('#qty-error span').text('');

                            $current_qty = data.qty;

                            // set the product total
                            $('.product_total').text(data.total_price);
                            $('.product_quantity').text(data.qty);

                            $("#place_order_form :input").attr("disabled", false);
                            $('#place_order_form').css('opacity', 1);

                            $('#order_overview').html(data.view);
                            Ladda.bind('#place-order');
                        }

                        $('#place-order').prop('disabled', false);
                    });
                })

                $('input[name="options-payment"]').change(function() {
                    reloadOverview($('#country').val(), $(this).val());
                });

                /**
                 * Get the selected country
                 */
                $('#country').change(function() {
                    if ($('#same-billing-addres').is(':checked')) {
                        reloadOverview($(this).val(), $('input[name="options-payment"]:checked').val());
                    }
                });

                $('#shipping_country').change(function() {
                    if (!$('#same-billing-addres').is(':checked')) {
                        reloadOverview($(this).val(), $('input[name="options-payment"]:checked').val());
                    }
                });
            });

            function reloadOverview(country) {
                //TODO get voucher code and send with form
                let vouchercode = $('#voucher').val();

                $('#order_overview').css('opacity', .2);
                $('#place-order').prop('disabled', true);

                handleAjaxRequests('{{ route('calculate_price') }}', {'country': country, 'voucher' : vouchercode},
                    'GET').done(function(data) {
                    $('#order_overview').html(data.view);
                    $('#place-order').prop('disabled', false);
                    Ladda.bind('#place-order');

                    $('#order_overview').css('opacity', 1);

//                    $( "#empty-cart" ).bind("click");

                    $('#empty-cart').on('click', function() {
                        if (confirm("{{ trans('checkout.areYouSure')  }}")) {
                            window.location.replace('{{ route('empty_cart') }}');
                        } else {
                            return false;
                        }
                    });
                });
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
    @endif
@stop
