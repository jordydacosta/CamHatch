{{-- FOOTER --}}
<div class="footer">
    <div class="container">
        {{-- <div class="col-md-6 col-sm-5 col-xs-12">
            <a class="logo-footer" href="/"></a>
        </div> --}}

        <div class="col-md-3 col-sm-3 col-xs-4 col-md-offset-2">
            <h4 class="footer-title uppercase">faq</h4>
            <ul class="footer-list">
                <li><a href="{{ route('faq', 'shipping') }}">@lang('faq.shipping_title')</a></li>
                <li><a href="{{ route('faq', 'warranty') }}">@lang('faq.warranty_title')</a></li>
            </ul>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-4">
            <h4 class="footer-title uppercase">@lang('general.help_and_support')</h4>
            <ul class="footer-list">
                <li><a href="{{ route('contact') }}">@lang('general.ask_a_question')</a></li>
                <li><a href="mailto:info@camhatch.com?subject=Contact">@lang('general.contact_title')</a></li>
            </ul>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-4">
            <h4 class="footer-title uppercase">@lang('general.follow_us')</h4>
            <ul class="footer-list">
                <li><a href="https://www.facebook.com/CamHatch-623723047710131" target="_blank">Facebook</a></li>
                <li><a href="https://twitter.com/CamHatch" target="_blank">Twitter</a></li>
            </ul>
        </div>

        {{-- <div class="col-md-12" style="border: 1px solid #f00; color: none; margin-top: 20px;"></div> --}}


        <div class="col-md-12 col-sm-12 col-xs-12 text-left row" style="border-top: 1px solid #555; margin-top: 20px;">
            <p class="copyright">
                <a class="logo-footer pull-left" href="/"></a> &nbsp;
                @lang('general.copyright', ['date' => date('Y'), 'brand' => trans('general.brand')])
            </p>
        </div>
    </div>
</div>
{{-- END FOOTER --}}
