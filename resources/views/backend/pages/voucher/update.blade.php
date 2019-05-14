@extends('backend.layouts.default')

@section('content')
    <div class=" container">
        <form action="{{route('update_voucher', $voucher->id)}}" id="place_order_form" method="POST" accept-charset="utf-8"
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
                    <div>
                        <br>
                        <p class="checkout-form-title dark-grey col-md-10">Edit voucher</p>
                        <br>
                        <br>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="vouchercode">Vouchercode</label>
                                <input type="text" class="form-control" name="vouchercode" value="{{old('vouchercode', $voucher->vouchercode)}}" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="discount_percent">Discount percent</label>
                                <input type="text" class="form-control" name="discount_percent" value="{{old('discount_percent', $voucher->discount_percent)}}" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" name="amount" value="{{old('amount', $voucher->amount)}}" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="minimum_order_quantity">Minimum order quantity</label>
                                <input type="text" class="form-control" name="minimum_order_quantity" value="{{old('minimum_order_quantity', $voucher->minimum_order_quantity)}}" />
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="expires_at">Expires at</label>
                                <input type="date" class="form-control" name="expires_at" value="{{old('expires_at', $voucher->expires_at)}}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <button type="submit">Save</button>
        </form>
    </div>
@endsection
