@extends('backend.layouts.default')

@include('backend.partials.title')

@section('content')
    @if(session()->has('status'))
        <div class="row">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button>
                <strong>Notification</strong>{{session()->get('status')}}
            </div>
        </div>
    @endif
    @yield('page-header')

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="{{route('filter')}}" id="place_order_form" method="POST" accept-charset="utf-8"
                          class="checkout-form">
                        <div class="form-group">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                            <div class="col-md-2">

                                <label for="amount">{{trans('general.from')}}:</label>
                                @if($startdate != null)
                                    <input type="date" placeholder="{{trans('general.date_placeholder')}}" class="form-control" name="start_point" value="{{old('start_from',$startdate)}}"/>
                                @else
                                    <input type="date" placeholder="{{trans('general.date_placeholder')}}" class="form-control" name="start_point" value="{{old('start_from')}}"/>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <label for="amount">{{trans('general.to')}}:</label>
                                @if($enddate != null)
                                    <input type="date" placeholder="{{trans('general.date_placeholder')}}" class="form-control" name="end_point" value="{{old('expires_at',$enddate)}}"/>
                                @else
                                    <input type="date" placeholder="{{trans('general.date_placeholder')}}" class="form-control" name="end_point" value="{{old('expires_at')}}"/>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <label for="continents">{{trans('checkout.countries')}}:</label>
                                <select name="continents" id="continents" class="form-control">
                                    <option value="NULL">- None -</option>
                                    <option value="nl" @if($continent == 'nl') selected @endif>NL</option>
                                    <option value="eu" @if($continent == 'eu') selected @endif>EU</option>
                                    <option value="n_eu" @if($continent == 'n_eu') selected @endif>outside EU</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="status">{{trans('general.status')}}:</label>
                                <select name="status" id="status" class="form-control">
                                    @if($status == 'NULL')
                                        <option value="NULL" selected>None</option>
                                        @foreach(config('config.order_status') as $value)
                                            <option value="{{ $value }}">@lang('backend.order_status.'.$value)</option>
                                        @endforeach
                                    @else
                                        <option value="NULL">None</option>
                                        @foreach(config('config.order_status') as $value)
                                            <option value="{{ $value }}"@if($status == $value) selected="true" @endif>
                                                @lang('backend.order_status.'.$value)
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                                <button class="btn btn-primary" type="submit" style="margin-top: 24px;">
                                    <i class="icon-eye"></i> {{trans('general.search')}}
                                </button>
                        </div>
                    </form>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: right">{{trans('checkout.country')}}</th>
                            <th style="text-align: right">{{trans('general.count')}}</th>
                            <th scope="col" style="text-align: right">{{trans('checkout.quantity')}}</th>
                            <th scope="col" style="text-align: right">{{trans('general.price')}}</th>
                            <th scope="col" style="text-align: right">{{trans('general.ex_tax')}}</th>
                            <th scope="col" style="text-align: right">{{trans('general.total_ship_rate')}}</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $o)
                            @if($cijfer[$o->country] != 0)
                            <tr>
                                @if($country->where('isocode', $o->country)->first() != null)
                                    <td style="text-align: right">{{$country->where('isocode', $o->country)->first()->country_en}}</td>
                                @else
                                    <td style="text-align: right"> - </td>
                                @endif
                                    <td style="text-align: right">{{$cijfer[$o->country]}}</td>

                                    <td style="text-align: right">{{$nummer[$o->country]}}</td>
                                    <td style="text-align: right">&euro; {{ number_format(sprintf('%0.2f', $test[$o->country]),2,',','.')}}</td>

                                    @if($country->where('isocode', $o->country)->first() != null)
                                        <td style="text-align: right">&euro; {{number_format(sprintf('%0.2f',$test[$o->country] - $shipping_rates[$o->country] * $cijfer[$o->country]/1.21),2,',','.')}}</td>
                                        <td style="text-align: right">&euro; {{number_format(sprintf('%0.2f',$shipping_rates[$o->country] * $cijfer[$o->country]),2,',','.') }}</td>
                                    @else
                                        <td style="text-align: right"> - </td>
                                        <td style="text-align: right"> - </td>
                                    @endif
                                    <td style="text-align: right">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-small btn-primary ladda-button btn-group" href="{{route('report_export',$o->country)}}" target="_blank">
                                                <i class="icon-export"></i>Get CSV
                                            </a>
                                            <a class="btn btn-small btn-primary ladda-button btn-group" href="{{route('export_pdf',$o->country)}}" target="_blank">
                                                <i class="icon-export"></i> Get PDF
                                            </a>
                                        </div>
                                    </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

@endsection
