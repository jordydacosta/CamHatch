@extends('backend.layouts.default')

@section('content')
    <div class=" container">
        <form action="{{ route('order_store') }}" id="place_order_form" method="POST" accept-charset="utf-8"
              class="checkout-form">
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
            <!-- ./ csrf token -->
            <div class="row">
                <div class="col-md-12">
                    @if(count($errors) > 0)
                        <div class="errors col-md-10" style="margin-bottom: 20px;">
                            @foreach($errors->all(':message') as $message)
                                <span>{{ $message }}</span>
                                <br>
                            @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <!-- input name section -->
                        <br>
                        <h3 class="checkout-form-title dark-grey col-md-10">Create Order</h3>
                        <br>
                        <br>
                        <div class="form-group col-md-5">
                            <label for="firstname">{{trans('checkout.firstname')}}</label>
                            <input type="text" class="form-control" name="firstname" value="{{old('firstname')}}" />
                        </div>
                        <div class="form-group col-md-5">
                            <label for="lastname">{{trans('checkout.lastname')}}</label>
                            <input type="text" class="form-control" name="lastname" value="{{old('lastname')}}" />
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="email">{{trans('checkout.email')}}</label>
                                <input type="text" class="form-control" name="email" value="{{old('email')}}" />
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="quantity">{{trans('checkout.quantity')}}</label>
                                <input type="text" class="form-control" name="quantity" value="{{old('Quantity')}}" />
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="phone">{{trans('checkout.phone')}}</label>
                                <input type="text" class="form-control" name="phone" value="{{old('phone')}}" />
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="company">{{trans('checkout.company')}}</label>
                                <input type="text" class="form-control" name="company" value="{{old('checkout.company')}}" />
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="address">{{trans('checkout.address')}}</label>
                                <input type="text" class="form-control" name="address" value="{{old('address')}}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="zipcode">{{trans('checkout.zipcode')}}</label>
                                <input type="text" class="form-control" name="zipcode" value="{{old('zipcode')}}" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="city">{{trans('checkout.city')}}</label>
                                <input type="text" class="form-control" name="city" value="{{old('city')}}" />
                            </div>
                        </div>

                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="reference">{{trans('checkout.reference')}}</label>
                                <input type="text" class="form-control" name="reference" value="{{old('reference')}}" />
                            </div>
                        </div>

                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="deliverydate">{{trans('checkout.delivery_date')}}</label>
                                <input type="text" class="form-control" placeholder="{{trans('general.date_placeholder')}}" name="deliverydate" value="{{old('delivery_date', '')}}" />
                            </div>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="country">Country</label>
                            <select name="country" id="country" class="form-control">
                                @if(count($country) <= 20)
                                    @foreach(trans('checkout.countries') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @elseif(\App::isLocale('nl'))
                                    @foreach( $country as $key )
                                        <option value="{{$key->isocode}}">{{$key->country_nl}}</option>
                                        {{$value = $key->county }}
                                    @endforeach
                                @else
                                    @foreach( $country as $key )
                                        <option value="{{$key->isocode}}">{{$key->country_en}}</option>
                                        {{$value = $key->county }}
                                    @endforeach
                                @endif
                            </select>
                        </div>
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
                        <div id="same-as-billing-container">
                        </div>
                        <!-- Description input-->
                        <div class="form-group">
                            <div class="col-md-10">
                                <textarea class="form-control" rows="6" name="comment"
                                          placeholder="@lang('checkout.additional_notes')">{{ old('comment') }}</textarea>
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
            <button type="submit" class="btn btn-primary">{{trans('general.save')}}</button>
        </form>
    </div>
@endsection
