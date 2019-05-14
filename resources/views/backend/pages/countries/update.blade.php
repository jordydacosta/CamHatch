@extends('backend.layouts.default')

@section('content')
    <div class=" container">
        <form action="{{route('country_update', $country->id)}}" id="place_order_form" method="POST" accept-charset="utf-8"
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
                <!-- input name section -->
                    <div class="row">
                        <br>
                        <p class="checkout-form-title dark-grey col-md-10">country list</p>
                        <br>
                        <br>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="country_nl">{{trans('general.country_dutch')}}</label>
                                <input type="text" class="form-control" name="country_name_nl"  value="{{old('country_nl', $country->country_nl)}}"/>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="country_en">{{trans('general.country_uk')}}</label>
                                <input type="text" class="form-control" name="country_name_en"  value="{{old('country_en', $country->country_en)}}"/>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="isocode">ISOcode</label>
                                <input type="text" class="form-control" name="iso_code"  value="{{old('isocode', $country->isocode)}}"/>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="continents">Continent</label>
                                <select name="continents" id="continents" class="form-control">
                                    <option value="nl" @if($country->continent == 'nl') selected @endif>NL</option>
                                    <option value="eu" @if($country->continent == 'eu') selected @endif>EU</option>
                                    <option value="n_eu" @if($country->continent == 'n_eu') selected @endif>Outside EU</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="shipment_rate">{{trans('general.shipping_rate')}}</label>
                                <input type="number" min="0" step="0.01" class="form-control" name="shipment_rate"  value="{{old('shipment_rate', $country->shipment_rate)}}"/>
                            </div>
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
                <div class="col-md-11">
                    <hr class="order-overview-seperation">
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="icon-check"></i> {{trans('general.save')}}</button>
        </form>
    </div>
@endsection
