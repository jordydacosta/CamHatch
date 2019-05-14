@foreach($content as $row)
    <div class="row">
        <div class="form-group col-md-10">
            <p class="checkout-form-title dark-grey">Your order</p>
            <br>
            <input type="text" name="quantity" id="quantity" class="quantity" value="{{ $row->qty }}"
                   autocomplete="off">
            <label> x {{ $row->name }} ({{ $row->options->color }})</label>
            <label class="pull-right">€ <span
                        class="product_total">{{ sprintf('%0.2f', $row->subtotal) }}</span></label>
            <br>
            <br>
            <button type="button" class="btn btn-yellow" id="update-cart">update<span class="arrow"></span></button>

            <div style="display: none" id="qty-error">
                <br>
                <div class="errors col-md-10">
                    <span></span>
                    <br>
                </div>
            </div>

        </div>
    </div>
@endforeach		