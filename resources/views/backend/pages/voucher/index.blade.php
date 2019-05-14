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
    @if(session()->has('alert'))
        <div class="row">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button>
                <strong>{{session()->get('alert')}}</strong>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="btn-group pull-right">
                    <a class="btn btn-primary glyphicon-plus" href="{{route('create_voucher')}}"><i class="glyphicon-plus"></i> {{trans('general.new_voucher')}}</a>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">{{trans('general.voucher_code')}}</th>
                                <th scope="col">{{trans('general.amount')}}</th>
                                <th scope="col">{{trans('general.discount_perc')}}</th>
                                <th scope="col">{{trans('general.minimum_order')}}</th>
                                <th scope="col">{{trans('general.created_at')}}</th>
                                <th scope="col">{{trans('general.expires')}}</th>
                                <td scope="col" align="center"><strong>{{trans('general.actions')}}</strong></td>
                            </tr>
                        </thead>
                        @foreach($voucher as $c)
                            <tbody>
                                <tr>
                                    <td>{{ $c->vouchercode}}</td>
                                    <td align="right">{{ $c->amount}}</td>
                                    <td align="right">{{ $c->discount_percent }}</td>
                                    <td align="right">{{ $c->minimum_order_quantity }}</td>
                                    <td align="right">{{ $c->created_at->format('d-m-Y H:i')}}</td>
                                    <td align="right">
                                        @if (!empty($c->expires_at)) {{ $c->expires_at->format('d-m-Y H:i') }} @else {{trans("general.never")}} @endif
                                    </td>
                                    <td align="right">
                                        <div class="btn-group">
                                            <a class="btn btn-small btn-primary" href="{{route('edit_voucher',$c->id)}}">
                                                <i class="icon-edit"></i> {{trans('general.edit')}}
                                            </a>
                                            <a class="btn btn-small btn-danger" href="{{route('destroy_voucher', $c->id)}}">
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
