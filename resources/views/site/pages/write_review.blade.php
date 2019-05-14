@extends('site.layouts.modal')

@section('content')
    {{-- <h1>Write review</h1> --}}

    <div class="col-md-12 modal-header text-center">
        <h4 class="uppercase">
            @lang('shop.write_review')
            <button type="button" class="close" onClick="javascript:parent.$.fancybox.close();">
                <span aria-hidden="true">&times;</span>
            </button>
        </h4>
    </div>
    <div class="col-md-12 modal_content">
        <form class="form-horizontal contact-form" id="review-form" action="{{ route('submit_review') }}"
              autocomplete="off" method="POST">
            @if (count($errors) > 0)
                <div class="errors">
                    @foreach($errors->all(':message') as $message)
                        <span>{{ $message }}</span>
                        <br>
                    @endforeach
                </div>
                <br>
            @endif

            <div class="form-group">
                <div class="col-md-12">
                    <label class="pull-left"
                           style="margin-right: 10px; font-size: 18px; font-weight: lighter">@lang('shop.rating'):
                    </label>
                    <select id="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>

                    <input type="hidden" id="review_rating" name="review_rating" value="5">
                </div>
            </div>

            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
            <!-- ./ csrf token -->
            <!-- Name input-->
            <div class="form-group {{ ($errors->has('name') ? 'has-error' :'') }}">
                <div class="col-md-12">
                    <input class="form-control" name="name" id="name" placeholder="@lang('contact.your_name')"
                           autofocus>
                </div>
            </div>

            <!-- Description input-->
            <div class="form-group {{ ($errors->has('contact-message') ? 'has-error' :'') }}">
                <div class="col-md-12">
                    <textarea class="form-control" rows="6" name="review" placeholder="@lang('shop.review')"></textarea>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-yellow">@lang('general.submit')<span class="arrow"></span></button>
        </form>
    </div>
@stop

@section('styles')
    <style type="text/css" media="screen">
        .error_message {
            color: #C61212 !important;
            font-size: 12px !important;
            font-weight: normal;
            margin: 0 !important;
        }
    </style>
@stop

@section('javascript')
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {

            $('#rating').barrating({
                theme: 'css-stars',
                fastClicks: true,
                initialRating: 5,
                onSelect: function(value, text) {
                    $('#review_rating').val(value);
                }
            });

            /**
             * Validate the form
             */
            $('#review-form').validate({
                rules: {
                    name: "required",
                    review: "required",
                },
                messages: {
                    name: {
                        required: "{!! trans('validation.custom.name') !!}",
                    },
                    review: {
                        required: "{!! trans('validation.custom.review') !!}",
                    }
                },
                errorPlacement: function(error, element) {
                    offset = element.offset();
                    error.insertAfter(element);

                    error.addClass('error_message');
                }
            });
        });
    </script>
@stop