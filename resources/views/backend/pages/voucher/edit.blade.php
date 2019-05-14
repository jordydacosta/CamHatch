@extends('backend.layouts.default')

@section('content')
    <div class=" container">
        <form action="{{route('save_voucher')}}" id="place_order_form" method="POST" accept-charset="utf-8"
              class="checkout-form">
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>

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
                        <p class="checkout-form-title dark-grey col-md-10">{{trans('general.new_voucher')}}</p>
                        <br>
                        <br>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="vouchercode">{{trans('general.voucher_code')}}</label>
                                <input type="text" class="form-control" name="vouchercode" value="<?php echo htmlspecialchars($randomvoucher); ?>"/>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="discount_percent">{{trans('general.discount_perc')}}</label>
                                <input type="text" class="form-control" name="discount_percent" value="{{old('discount_percent')}}" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="amount">{{trans('general.amount')}}</label>
                                <input type="text" class="form-control" name="amount" value="{{old('amount')}}" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="minimum_order_quantity">{{trans('general.minimum_order')}}</label>
                                <input type="text" class="form-control" name="minimum_order_quantity" value="{{old('minimum_order_quantity')}}" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="amount">{{trans('general.expires')}}</label>
                                <input type="date" placeholder="{{trans('general.date_placeholder')}}" class="form-control" name="expires_at" value="{{old('expires_at')}}" />
                            </div>
                        </div>
                        </div>
                    <br>
                <button type="submit" class="btn btn-info"><i class="icon-check"></i> {{trans('general.save')}}</button>
            </div>
        </form>
    </div>
@endsection
