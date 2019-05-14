@extends('backend.layouts.default')

@section('content')
    @if(session()->has('status'))
        <div class="row">
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button>
                <strong>{{session()->get('status')}}</strong>
            </div>
        </div>
    @endif
    <div class=" container">

        <form action="{{route('orders_save_country')}}" id="place_order_form" method="POST" accept-charset="utf-8"
              class="checkout-form">

            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
            <!-- ./ csrf token -->

            <div class="row">
                <div class="col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- input name section -->
                    <div class="row">
                        <br>
                        <p class="checkout-form-title dark-grey col-md-10"></p>
                        <br>
                        <br>
                    @if(Session::get('status') !== null)
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="country_nl">{{trans('general.country_dutch')}}</label>
                                <input type="text" class="form-control" name="country_name_nl"  value="{{old('country_nl',$data['country_name_nl'])}}"/>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="country_en">{{trans('general.country_uk')}}</label>
                                <input type="text" class="form-control" name="country_name_en"  value="{{old('country_en',$data['country_name_en'])}}"/>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="isocode">ISOcode</label>
                                <input type="text" class="form-control" name="iso_code"  value="{{old('isocode',$data['iso_code'])}}"/>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="continents">Continent</label>
                                <select name="continents" id="continents" class="form-control">
                                    <option value="nl">NL</option>
                                    <option value="eu">EU</option>
                                    <option value="n_eu">Outside EU</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="shipment_rate">{{trans('general.shipping_rate')}}</label>
                                <input placeholder="Ex. 1.00" type="number" min="0" step="0.01" class="form-control" name="shipment_rate"  value="{{old('shipment_rate',$data['shipment_rate'])}}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="country_nl">{{trans('general.country_dutch')}}</label>
                        <input type="text" class="form-control" name="country_name_nl"  value="{{old('country_nl')}}"/>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="country_en">{{trans('general.country_uk')}}</label>
                        <input type="text" class="form-control" name="country_name_en"  value="{{old('country_en')}}"/>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="isocode">ISOcode</label>
                        <input type="text" class="form-control" name="iso_code"  value="{{old('isocode')}}"/>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="continents">Continent</label>
                        <select name="continents" id="continents" class="form-control">
                            <option value="nl">NL</option>
                            <option value="eu">EU</option>
                            <option value="n_eu">Outside EU</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="shipment_rate">{{trans('general.shipping_rate')}}</label>
                        <input placeholder="0,00" type="number" min="0" step="0.01" class="form-control" name="shipment_rate"  value="{{old('shipment_rate')}}"/>
                    </div>
                </div>
            @endif
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
            <button class="btn btn-primary" type="submit"><i class="glyphicon-floppy-save"></i> {{trans('general.save')}}</button>
        </form>
    </div>
@endsection
