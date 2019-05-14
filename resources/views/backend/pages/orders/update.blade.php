@extends('backend.layouts.default')

@section('content')
    <div class=" container">
        <form action="{{ route('order.update',$order) }}" id="place_order_form" method="POST" accept-charset="utf-8"
              class="checkout-form">
            <!--route voorbeeld  route('question.update', $question)-->
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
                <!-- input name section -->
                    <div class="row">
                        <br>
                        <h1>Edit Order:{{$order->orderId}}</h1>
                        <h3 class="checkout-form-title dark-grey col-md-10">Edit Order</h3>
                        <br>
                        <br>
                        <div class="form-group col-md-5">
                            <label for="firstname">{{trans('checkout.firstname')}}</label>
                            <input type="text" class="form-control" name="firstname" value="{{old('firstname',$order->firstname)}}" />
                        </div>
                        <div class="form-group col-md-5">
                            <label for="lastname">{{trans('checkout.lastname')}}</label>
                            <input type="text" class="form-control" name="lastname" value="{{old('lastname', $order->lastname)}}" />
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="email">{{trans('checkout.email')}}</label>
                                <input type="text" class="form-control" name="email" value="{{old('email', $order->email)}}" />
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="quantity">{{trans('checkout.quantity')}}</label>
                                <input type="text" class="form-control" name="quantity" value="{{old('Quantity', $order->quantity)}}" />
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="phone">{{trans('checkout.phone')}}</label>
                                <input type="text" class="form-control" name="phone" value="{{old('phone', $order->phone)}}" />
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="company">{{trans('checkout.company')}}</label>
                                <input type="text" class="form-control" name="company" value="{{old('checkout.company', $order->company)}}" />
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="address">{{trans('checkout.address')}}</label>
                                <input type="text" class="form-control" name="address" value="{{old('address', $order->address)}}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="zipcode">{{trans('checkout.zipcode')}}</label>
                                <input type="text" class="form-control" name="zipcode" value="{{old('zipcode', $order->zipcode)}}" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="city">{{trans('checkout.city')}}</label>
                                <input type="text" class="form-control" name="city" value="{{old('city', $order->city)}}" />
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="reference">{{trans('checkout.reference')}}</label>
                                <input type="text" class="form-control" name="reference" value="{{old('reference', $order->reference)}}" />
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="delivery_date">{{trans('checkout.delivery_date')}}</label>
                                <input type="text" class="form-control" placeholder="dd-mm-yyyy" name="delivery_date" value="{{old('delivery_date', $order->delivery_date->format('d-m-Y'))}}" />
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="orderId">{{trans('checkout.order_id')}}</label>
                                <input type="text" class="form-control" name="orderId" value="{{old('orderId', $order->orderId)}}" />
                            </div>
                        </div>

                        <div class="form-group col-md-10">
                            <label for="country">{{trans('checkout.country')}}</label>
                            <select name="country" id="country" class="form-control">
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
                        <!-- Description input-->
                        <div class="form-group">
                            <div class="col-md-10">
                                <textarea class="form-control" rows="6" name="comment"
                                          placeholder="{{'comment'}}">{{ Input::old('phone',$order->comment) }}</textarea>
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
            <button type="submit">Save</button>
        </form>
    </div>
@endsection
