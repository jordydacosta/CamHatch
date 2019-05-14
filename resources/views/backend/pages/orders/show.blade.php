@extends('backend.layouts.default')

@include('backend.partials.title')

@section('content')
    @yield('page-header')

    <form action="{{ route('order_edit', $order->id) }}" method="POST" accept-charset="utf-8">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
        <!-- ./ csrf token -->

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

        <div class="row">
            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="uppercase">
                            <b>General Details - @lang('backend.order_status.'.$order->orderstatus_id)</b>
                        </h3>
                        <br>
                        <p>
                            Order number: #{{ $order->orderId }}<br>
                            Customer IP: {{ $order->customer_ip }}
                        </p>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label>Order date:</label>
                                    <p>{{ $order->created_at }}</p>

                                    <br>

                                    <label>Customer:</label>
                                    <p>{{ $order->firstname." ".$order->lastname }}</p>

                                    <br>
                                    <label>Shipping plan:</label>
                                    <p>@lang("backend.shipping_plan.". $order->shipping_plan)</p>

                                    <br>

                                    @if($order->comment)
                                        <label>Comment:</label>
                                        <p>{{  $order->comment  }}</p>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label>Billing Details:</label>
                                    <br>
                                    <br>
                                    <span>Address:</span>
                                    <ul class="order_details_list">
                                        @if($order->company)
                                            <li>{{ $order->company }}</li>
                                        @endif
                                        <li>{{ $order->firstname." ".$order->lastname }}</li>
                                        <li>{{ $order->address }}</li>
                                        <li>{{ $order->zipcode." ".$order->city }}</li>
                                        <li>{{ $country->country_en }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <label>Shipping Details:</label>
                                    <br>
                                    <br>
                                    <span>Address:</span>

                                    @if($order->same_as_billing_address == 1)
                                        <ul class="order_details_list">
                                            @if($order->company)
                                                <li>{{ $order->company }}</li>
                                            @endif
                                            <li>{{ $order->firstname." ".$order->lastname }}</li>
                                            <li>{{ $order->address }}</li>
                                            <li>{{ $order->zipcode." ".$order->city }}</li>
                                            <li>{{ $country->country_en }}</li>
                                        </ul>
                                    @else
                                        <ul class="order_details_list">
                                            @if($order->shipping_company)
                                                <li><b>{{ $order->shipping_company }}</b></li>
                                            @endif
                                            <li>{{ $order->shipping_firstname." ".$order->shipping_lastname }}</li>
                                            <li>{{ $order->shipping_address }}</li>
                                            <li>{{ $order->shipping_zipcode." ".$order->shipping_city }}</li>
                                            <li>{{ $country->country_en }}</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3" id="order_menu">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="uppercase"><b>Order Actions</b></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">

                                <select name="order-status" id="order-status" class="form-control">
                                    @foreach(config('config.order_status') as $value)
                                        <option value="{{ $value }}"
                                                @if($order->orderstatus_id == $value) selected="true" @endif>@lang('backend.order_status.'.$value)</option>
                                    @endforeach
                                </select>
                                <br>
                                <button type="button" class="btn btn-small btn-danger pull-left" id="remove-order"><i
                                            class="icon-trash"></i> Move to trash
                                </button>
                                <span>&nbsp</span>
                                <button type="submit" class="btn btn-small btn-primary pull-right ladda-button"
                                        data-style="expand-right" id="save-order"
                                        @if($order->orderstatus_id == config('config.order_status.completed')) disabled="true" @endif >
                                    Save order
                                </button>
                                <a class="btn btn small btn-primary ladda-button" data-style="expands-right" href="{{route('order_change',$order->id)  }}">Edit order</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if($invoice != null)
                        <h3 class="uppercase">
                            <b>Invoice items</b>
                        </h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Invoice</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>@lang('general.brand')</td>
                                <td>{{ $invoice->invoice_id }}</td>
                                <td>{{ $order->quantity}}</td>
                                <td>{{number_format(sprintf('%0.2f', $order->price),2,',','.') }}</td>
                                <td>
                                    <a href="{{route('order_pdf',$invoice->id)}}" target="_blank" class="btn btn-primary"> View PDF</a>
                                </td>
                                <td>
                                    <a href="{{route('download_pdf',$invoice->id)}}"target="_blank" class="btn btn-primary"> Download PDF</a>
                                </td>
                                <td>
                                    <a href="{{route('upload_Pdf',$invoice->id)}}" class="btn btn-primary">Save PDF</a>
                                </td>
                                <td>
                                    <a href="{{route('send_Pdf',$invoice->id)}}" class="btn btn-primary">Send PDF to customer</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                            @endif
                    </div>
                </div>
            <div>
            </div>
            </div>
        </div>
    </form>

    <!-- Modal HTML -->
    {!! \Helpers::showModal("You are about to delete this order, are you sure you want to do this?", "Everything concerning this order will be lost!", 'delete_modal') !!}
@stop

@section('javascript')
    <script type="text/javascript">
        var order_id = {{{ $order->id }}}
        ;

        $(document).ready(function() {
            Ladda.bind('#save-order');

            $('#remove-order').on('click', function() {
                $("#delete_modal").modal('show');
            });

            $('#order-status').change(function() {

                if ($(this).val() == {{ $order->orderstatus_id }}) {
                    $('#save-order').prop('disabled', true);
                } else {
                    $('#save-order').prop('disabled', false);
                }
            });

            /**
             * Delete the selected order
             */
            $("#submit_modal_delete").click(function() {
                handleAjaxRequests("{{{ route('orders') }}}", {rows: [order_id]}, 'DELETE').done(function(data) {
                    if (data.deleted == 1) {
                        $(".modal").modal('hide');
                        window.location = "{{{ route('orders') }}}";
                    }
                });
            });
        });
    </script>
@stop