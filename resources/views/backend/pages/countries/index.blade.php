@extends('backend.layouts.default')

@include('backend.partials.title')

@section('content')
    @if(session()->has('status'))
        <div class="row">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button>
                <strong>{{session()->get('status')}}</strong>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="btn-group pull-right">
                    <a class="btn btn-primary glyphicon-plus" href="{{route('create_country')}}"> {{trans('general.create_country')}}</a>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">{{trans('general.country_dutch')}}</th>
                                <th scope="col">{{trans('general.country_uk')}} </th>
                                <th scope="col">ISO code</th>
                                <th scope="col">{{trans('general.shipping_rate')}}</th>
                                <th scope="col">Continent</th>
                                <td scope="col" align="right">
                                    <strong>{{trans('general.edit')}}/ {{trans('general.delete')}}</strong>
                                </td>
                            </tr>
                        </thead>
                        @foreach($country as $c)
                            <tbody>
                                <tr>
                                    <td>{{ $c->country_nl}}</td>
                                    <td>{{ $c->country_en}}</td>
                                    <td>{{strtoupper($c->isocode) }}</td>
                                    <td>{{number_format((float)$c->shipment_rate, 2, ',', '.')}}</td>
                                    <td>{{strtoupper($c->continents) }}</td>
                                    <td align="right">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-small btn-primary" href="{{route('orders_country_edit',$c->id)}}">
                                                <i class="glyphicon-pencil"></i> {{trans('general.edit')}}
                                            </a>
                                            <a class="btn btn-small btn-danger" href="{{route('destroy_country', $c->id)}}">
                                                <i class="icon-trash"></i> {{trans('general.delete')}}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                           </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


@stop
